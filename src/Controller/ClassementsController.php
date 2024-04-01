<?php

namespace App\Controller;

use App\Entity\Classement;
use App\Repository\ClassementRepository;
use App\Service\CallApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassementsController extends AbstractController
{
    private EntityManagerInterface $em;
    private CallApiService $callApiService;
    private TournoisController $tournoisController;
    public function __construct(EntityManagerInterface $em, CallApiService $callApiService, TournoisController $tournoisController)
    {
        $this->em=$em;
        $this->callApiService = $callApiService;
        $this->tournoisController = $tournoisController;
    }

    #[Route('/classements', name: 'classements')]
    public function index(ClassementRepository $classementRepository): Response
    {
        /*$connection = $this->em->getConnection();
        $platform = $connection->getDatabasePlatform();
        $connection->executeQuery($platform->getTruncateTableSQL('classement', true));
        
        $classement = new Classement();
        $classement->setNom('Hiver-Printemps 2024');
        $classement->setDebut('1st January 2024');
        $classement->setFin('1st July 2024');
        $this->em->persist($classement);
        

        $this->em->flush();
        */
    
        //$classements = $classementRepository->findBy([],['id'=> 'ASC']);
        $saison = $classementRepository->find(1);
        $classement = $this->getClassement($saison);
        return $this->render('classements/index.html.twig', compact('classement') + compact('saison'));

    }

    public function getClassement(Classement $classement){
        $infos = $this->callApiService->getAllParticipantsByPeriod($classement->getDebut(),$classement->getFin());
        $tabClassement = array();
        $classBefore = array();
        foreach($infos as $num=>$tournoi){
            $numEventMain = $this->tournoisController->getNumEventMain($tournoi);
            foreach($tournoi['events'][$numEventMain]['standings']['nodes'] as $participant){
                if(array_key_exists($participant['player']['id'],$tabClassement)){
                    $tabClassement[$participant['player']['id']]['nbPoints'] += $this->getNbPoints($participant['placement']);
                    /*if(array_key_exists($participant['player']['id'],$classBefore) && $num>0){
                        $classBefore[$participant['player']['id']]['nbPoints'] += $this->getNbPoints($participant['placement']);
                    }*/
                } else{
                    $smasheur = array(
                        //$tabClassement[$participant['player']['id']] => 
                        'pseudo' => $participant['player']['gamerTag'],
                        'prefix' => $participant['player']['prefix'],
                        'nbPoints' => $this->getNbPoints($participant['placement'])
                    );
                    if(!empty($participant['player']['user']['images'])){
                        $smasheur['picture'] = $participant['player']['user']['images'][0]['url'];
                    }
                    $tabClassement[$participant['player']['id']] = $smasheur;
                    /*if($num>0 && !array_key_exists($participant['player']['id'],$classBefore)){
                        $classBefore[$participant['player']['id']] = $smasheur;
                    }*/
                }
            }
        }
        //dump($classBefore,$tabClassement);
        //return $classBefore;
        return $tabClassement;
    }

    public function getBareme(/*$nbEntrants = 48*/){
        //if($nbEntrants == 48){}
        return array(
            //placement => nbPoints
            49 => 1,
            33 => 1,
            25 => 2,
            17 => 3,
            13 => 4,
            9 => 5,
            7 => 6,
            5 => 7,
            4 => 8,
            3 => 9,
            2 => 10,
            1 => 11
        );
    }

    public function getNbPoints(int $placement){
        $bareme = $this->getBareme();
        if($placement > 33){
            $placement = 49;
        }
        return $bareme[$placement];
    }
}
