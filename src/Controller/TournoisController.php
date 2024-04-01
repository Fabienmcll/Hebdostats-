<?php

namespace App\Controller;

use App\Entity\Tournoi;
use App\Repository\SmasheurRepository;
use App\Repository\TournoiRepository;
use App\Service\CallApiService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use function Amp\Iterator\toArray;

class TournoisController extends AbstractController
{
    private $callApiService;
    public function __construct(CallApiService $callApiService)
    {
        $this->callApiService = $callApiService;
    }
    /**
     * @Route("/teneurs", name="app_tournois")
     */
    #[Route("/teneurs", name:"app_tournois")]
    public function index(TournoiRepository $tournoiRepository, SmasheurRepository $smasheurRepository,LoggerInterface $logger): Response
    {
        $tournois = $tournoiRepository->findBy([],['id' => 'desc']);
        $smasheurs = $smasheurRepository->findByNbTournois($logger);
        $data = $this->callApiService->getAllSaucisses()['data'];
        //Si le tournoi le plus récent n'est pas fini on le vire
        if(time() < $data['tournaments']['nodes'][0]['endAt'])
        {
            unset($data['tournaments']['nodes'][0]);
        }
        $Bilel = $this->callApiService->getArimaAccount()['data'];
        $tabInfo = $this->tabInfoTeneurs($data,$tournois,$Bilel);

        //dump($tabInfo);
        //return $this->render('layouts/_loading.html.twig');
        return $this->render('tournois/index.html.twig', compact('tournois') + compact('smasheurs')+ compact('data')+ compact('tabInfo'));
    }
    /**
     * @Route("/", name="app_home")
     */
    #[Route("/", name:"app_home")]
    public function loading(): Response
    {
        return $this->render('layouts/_loading.html.twig');
    }
    /**
     * @Route("/tournois/{id<[0-9]+>}", name="app_tournois_show", methods="GET")
     */
    #[Route("/tournois/{id<[0-9]+>}", name:"app_tournois_show", methods:"GET")]
    public function show(int $id): Response
    {
        $tournament = $this->callApiService->getSaucisse($id)['data']['tournament'];
        try {
            $tournament = $this->addInfoPersonnages($tournament);
        } catch (ClientExceptionInterface $e) {
        } catch (DecodingExceptionInterface $e) {
        } catch (RedirectionExceptionInterface $e) {
        } catch (ServerExceptionInterface $e) {
        } catch (TransportExceptionInterface $e) {
        }
        //dump($tournament);
        return $this->render('tournois/show.html.twig',compact('tournament'));
    }
    /**
     * @Route("/vieille_saucisse/{id<[0-9]+>}", name="app_tournois_show_non_api", methods="GET")
     */
    #[Route("/vieille_saucisse/{id<[0-9]+>}", name:"app_tournois_show_non_api", methods:"GET")]
    public function showNonApi(Tournoi $tournoi): Response
    {
        $AllCharacters = $this->callApiService->getAllCharactersWithImages();
        $lesPersos = explode(',',$tournoi->getSmasheur()->getPersonnages());
        $images = [];
        foreach ($AllCharacters['data']['videogame']['characters'] as $char)
        {
            if(in_array($char['name'],$lesPersos))
            {
                $images[$char['name']] = $char['images'][1]['url'];
                if(count($images) == count($lesPersos)) break;
            }
        }
        //dump($AllCharacters,$images);
        return $this->render('tournois/show.html.twig',compact('tournoi')+compact('images'));
    }
    private function tabInfoTeneurs(array $apiData, $sqlData, array $Bilel):array
    {
        $tabInfo = array();
        if(!is_null($Bilel['player']) && !is_null($Bilel['player']['user'])
            && array_key_exists(0,$Bilel['player']['user']['images'])){
            $picture = $Bilel['player']['user']['images'][0]['url'];
        }else{
            $picture = null;
        }
        $tabInfo[$Bilel['player']['id']] = [
            'gamerTag' => $Bilel['player']['gamerTag'],
            'prefix' => $Bilel['player']['prefix'],
            'picture' => $picture,
            'listSaucisses'=> []
        ];

        foreach($apiData['tournaments']['nodes'] as $tournoi)
        {
            $numEventMain = $this->getNumEventMain($tournoi);
            if(!empty($tournoi['events'][$numEventMain]['standings']['nodes'])){
                $idPlayerApi = $this->getMainAccount($tournoi['events'][$numEventMain]['standings']['nodes'][0]['player']['id']);
                if( !is_null($tournoi['events'][$numEventMain]['standings']['nodes'][0]['player']['user'])
                    && array_key_exists(0,$tournoi['events'][$numEventMain]['standings']['nodes'][0]['player']['user']['images'])){
                    $picture = $tournoi['events'][$numEventMain]['standings']['nodes'][0]['player']['user']['images'][0]['url'];
                }else{
                    $picture = null;
                }

                if(!array_key_exists($idPlayerApi,$tabInfo))
                {
                    $tabInfo[$idPlayerApi] = [
                        'gamerTag' => $tournoi['events'][$numEventMain]['standings']['nodes'][0]['player']['gamerTag'],
                        'prefix' => $tournoi['events'][$numEventMain]['standings']['nodes'][0]['player']['prefix'],
                        'picture' => $picture,
                        'listSaucisses'=> [
                            0 => [
                                'id' => $tournoi['id'],
                                'name' => $tournoi['name'],
                                'date' => $tournoi['startAt'],
                                'numSaucisse' => $this->getNumSaucisseFromName($tournoi['name'])
                            ]
                        ]
                    ];
                } else{
                    $tabInfo[$idPlayerApi]['listSaucisses'][] = [
                        'id' => $tournoi['id'],
                        'name' => $tournoi['name'],
                        'date' => $tournoi['startAt'],
                        'numSaucisse' => $this->getNumSaucisseFromName($tournoi['name'])
                    ];
                }
            }
        }

        foreach ($sqlData as $tournoi)
        {
            $idPlayerApi = $tournoi->getSmasheur()->getIdPlayerAPI();
            if(!array_key_exists($idPlayerApi,$tabInfo))
            {
                $smasheur = $this->callApiService->getSaucismasheur($idPlayerApi)['data']['player'];
                if( !is_null($smasheur['user']['images'][0]['url'])
                    && array_key_exists(0,$smasheur['user']['images'])){
                    $picture = $smasheur['user']['images'][0]['url'];
                }else{
                    $picture = null;
                }
                $tabInfo[$idPlayerApi] = [
                    'gamerTag' => $smasheur['gamerTag'],
                    'prefix' => $smasheur['prefix'],
                    'picture' => $picture,
                    'listSaucisses'=> [
                        0 => [
                            'id' => $tournoi->getId(),
                            'name' => 'Saucismash #'.$tournoi->getNumSaucisse(),
                            'numSaucisse' => $tournoi->getNumSaucisse()
                        ]
                    ]
                ];
            } else{
                $tabInfo[$idPlayerApi]['listSaucisses'][] = [
                    'id' => $tournoi->getId(),
                    'name' => 'Saucismash #'.$tournoi->getNumSaucisse(),
                    'numSaucisse' => $tournoi->getNumSaucisse()
                ];
            }
        }
        return $tabInfo;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    private function addInfoPersonnages(array $apiData):array
    {
        $tabInfo = array();
        $numEventMain = $this->getNumEventMain($apiData);
        $tabIdEntrants = [];
        foreach ($apiData['events'][$numEventMain]['standings']['nodes'] as $standing)
        {
            $tabIdEntrants[] = $standing['entrant']['id'];
            $tabInfo[$standing['entrant']['id']] = [
                'persos' => []
            ];
        }
        $persos = $this->callApiService->getAllSetsFromSaucisse($apiData['id']);
        //dd($persos);
        $allPersos = $this->callApiService->getAllCharactersWithImages();
        foreach ($persos['data']['tournament']['events'][$numEventMain]['sets']['nodes'] as $set)
        {
            if(!is_null($set['games']))
            {
                foreach ($set['games'] as $game)
                {
                    if(!is_null($game['selections'])){
                        foreach ($game['selections'] as $sel)
                        {
                            $tabInfo[$sel['entrant']['id']]['persos'][] = $sel['selectionValue'];
                        }
                    }
                }
            }

        }
        foreach ($tabInfo as $key=>$value)
        {
            $lesPersos = array_count_values($value['persos']);
            arsort($lesPersos);
            $tabInfo[$key]['idMainCharacter'] = array_key_first($lesPersos);
            $tabInfo[$key]['persos'] = array_unique($value['persos']);
            $tabInfo[$key]['ImgURL']=[];

            foreach ($allPersos['data']['videogame']['characters'] as $character)
            {
                if(in_array($character['id'],$value['persos']))
                {
                    $tabInfo[$key]['ImgURL'][$character['id']] = $character['images'];
                }
            }
        }
        foreach ($apiData['events'][$numEventMain]['standings']['nodes'] as $key=>$standing){
            $apiData['events'][$numEventMain]['standings']['nodes'][$key]['persos'] = $tabInfo[$standing['entrant']['id']];
        }
        
        return $apiData;
    }

    public function getNumSaucisseFromName(string $name): int|string
    {
        if($name == 'Super Saucismash') return '28.5';
        return intval(preg_replace('/[^0-9]+/', '', $name,1));
    }
    private function getMainAccount($idPlayerApi)
    {
        $tabAccounts = $this->tabMultipleAccounts();

        if(array_key_exists($idPlayerApi,$tabAccounts))
        {
            return $tabAccounts[$idPlayerApi];
        } else{
            return $idPlayerApi;
        }
    }
    public function getNumEventMain($tournoi): int
    {
        if(count($tournoi['events'])>1){
            $numEventMain = 1;
            //dump($tournoi['events']);
            foreach ($tournoi['events'] as $numEvent=>$event)
            {
                if($numEvent!=$numEventMain && $event['numEntrants'] > $tournoi['events'][$numEventMain]['numEntrants'])
                    $numEventMain = $numEvent;
            }
        } else{
            return 0;
        }
        return $numEventMain;
    }
    public function tabMultipleAccounts():array
    {
        $tabAccounts = array();
        //Liberez Bilel
        $tabAccounts[2433781] = 1387694;//TA | Arsène
        $tabAccounts[2483027] = 1387694;//PaluEnjoyer
        $tabAccounts[2788738] = 1387694;//LeCadenaDeAnas
        //Baskoy
        $tabAccounts[2771860] = 2186864;
        $tabAccounts[3140768] = 2186864;

        return $tabAccounts;
    }
}
