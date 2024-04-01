<?php

namespace App\Controller;

use App\Entity\Trophee;
use App\Repository\TournoiRepository;
use App\Service\CallApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Tournoi;
use App\Entity\Smasheur;
use App\Repository\TropheeRepository;

class TropheesController extends AbstractController
{
    private EntityManagerInterface $em;
    private CallApiService $callApiService;
    private TournoiRepository $tournoiRepository;
    private TropheeRepository $tropheeRepository;

    public function __construct(CallApiService $callApiService,EntityManagerInterface $em,TournoiRepository $tournoiRepository,TropheeRepository $tropheeRepository)
    {
        $this->callApiService = $callApiService;
        $this->em=$em;
        $this->tournoiRepository = $tournoiRepository;
        $this->tropheeRepository = $tropheeRepository;
    }

    #[Route('/trophees', name: 'app_trophees')]
    public function index(): Response
    {
        $tropheesDeLanneePassee = $this->tropheeRepository->findOneBy(['version' => date("Y")-1]);
        //dd($tropheesDeLanneePassee,date("Y")-1);
        if(is_null($tropheesDeLanneePassee)){
            $this->persistTrophees();
        }
        /*return $this->render('trophees/index.html.twig', [
            'controller_name' => 'TropheesController',
        ]);*/
        return $this->redirectToRoute('app_home');
    }

    private function persistTrophees(): void
    {
        $connection = $this->em->getConnection();
        $platform = $connection->getDatabasePlatform();
        $connection->executeQuery($platform->getTruncateTableSQL('trophee', true));
        
        for ($year=2019; $year < date("Y"); $year++) { 
            foreach($this->getWinnerAbeFroman($year) as $winner){
                $trophee = new Trophee();
                $trophee->setNom('Abe Froman du Roi de la Saucisse')
                ->setVersion($year)->setEmoji('🏆')
                ->setDescription('Tu détiens le record du nombre de Saucisses remportées sur l\'année '.$year)
                ->setIdPlayerAPI($winner);
                $this->em->persist($trophee);
            }
            if($year >= 2020){
                foreach($this->getWinnerSeringue($year) as $winner){
                    $tropheeSeringue = new Trophee();
                    $tropheeSeringue->setNom('de la Seringue de l\'année')
                    ->setVersion($year)->setEmoji('💉')
                    ->setDescription('Tu détiens le record du nombre de participations à la Saucisse sur l\'année '.$year)
                    ->setIdPlayerAPI($winner);
                    $this->em->persist($tropheeSeringue);
                }
            }
        }  
        $this->em->flush();
        //dd($this->callApiService->getAllParticipantsByYear(2022));

    }
    private function getWinnerAbeFroman(int $year=2019)
    {
        $tabWinners = [];
            $results = $this->callApiService->getAllTeneursByYear($year)['data']['tournaments']['nodes'];
            //dd($results);
            foreach ($results as $tournoi) {
                $numEventMain = 0;
                foreach($tournoi['events'] as $numEvent=>$event){
                    if($event['numEntrants'] > $tournoi['events'][$numEventMain]['numEntrants']){
                        $numEventMain = $numEvent;
                    }
                }
                //dump($tournoi);
                if(array_key_exists(0,$tournoi['events'][$numEventMain]['standings']['nodes'])){
                    $idWinner = $tournoi['events'][$numEventMain]['standings']['nodes'][0]['player']['id'];
                } else{
                    $idWinner = 0;
                }
                
                if(array_key_exists($idWinner,$tabWinners))
                {
                    $tabWinners[$idWinner]+=1;
                }else{
                    $tabWinners[$idWinner]=1;
                }
            }
            arsort($tabWinners);
            //dump($tabWinners);
            //En 2019 on a eu des tournois Challonge en plus de start gg
            if($year == 2019){
                $tournoisChallonge = $this->tournoiRepository->findAll();
                foreach($tournoisChallonge as $tournoi)
                {
                    //dd($tournoi);
                    $idWinner = $tournoi->getSmasheur()->getIdPlayerAPI();
                    if(array_key_exists($idWinner,$tabWinners))
                    {
                        $tabWinners[$idWinner]+=1;
                    }else{
                        $tabWinners[$idWinner]=1;
                    }
                }
                //dd($tabWinners);
            }
            $retour = [];
            $Record = reset($tabWinners);
            foreach($tabWinners as $idPlayer => $nbParticipations){
                if($nbParticipations == $Record){
                    $retour[] = $idPlayer;
                } else{
                    return $retour;
                }
            }
            return $retour;
            //return array_key_first($tabWinners);
            
    }
    private function getWinnerSeringue(int $year=2020)
    {
        $tabParticipations = [];
            $results = $this->callApiService->getAllParticipantsByYear($year);
            //dd($results);
            foreach ($results as $tournoi) {
                $numEventMain = 0;
                foreach($tournoi['events'] as $numEvent=>$event){
                    if($event['numEntrants'] > $tournoi['events'][$numEventMain]['numEntrants']){
                        $numEventMain = $numEvent;
                    }
                }
                //dump($tournoi);
                foreach($tournoi['events'][$numEventMain]['standings']['nodes'] as $participant){
                    $idPlayer = $participant['player']['id'];
                    if(array_key_exists($idPlayer,$tabParticipations))
                    {
                        $tabParticipations[$idPlayer]+=1;
                    }else{
                        $tabParticipations[$idPlayer]=1;
                    }
                }
            }
            arsort($tabParticipations);
            //dd($tabParticipations);
            $retour = [];
            $RecordParticipations = reset($tabParticipations);
            foreach($tabParticipations as $idPlayer => $nbParticipations){
                if($nbParticipations == $RecordParticipations){
                    $retour[] = $idPlayer;
                } else{
                    return $retour;
                }
            }
            return $retour;
            
    }
}
