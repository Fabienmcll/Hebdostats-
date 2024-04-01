<?php

namespace App\Controller;

use App\Entity\Smasheur;
use App\Entity\Tournoi;
use App\Repository\SmasheurRepository;
use App\Repository\TropheeRepository;
use App\Service\CallApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class SmasheursController extends AbstractController
{
    private CallApiService $callApiService;
    private EntityManagerInterface $em;
    private SmasheurRepository $smasheurRepository;
    private TropheeRepository $tropheeRepository;
    private TournoisController $tournoisController;
    private ChartBuilderInterface $chartBuilder;
    public function __construct(CallApiService $callApiService,EntityManagerInterface $em,
    TournoisController $tournoisController,SmasheurRepository $smasheurRepository,ChartBuilderInterface $chartBuilder,
    TropheeRepository $tropheeRepository)
    {
        $this->em = $em;
        $this->callApiService = $callApiService;
        $this->tournoisController=$tournoisController;
        $this->smasheurRepository = $smasheurRepository;
        $this->chartBuilder = $chartBuilder;
        $this->tropheeRepository = $tropheeRepository;
    }
    /**
     * @Route("/smasheurs", name="smasheurs")
     */
    #[Route("/smasheurs", name:"smasheurs")]
    public function index(): Response
    {
        /*$connection = $this->em->getConnection();
        $platform = $connection->getDatabasePlatform();
        //$connection->executeUpdate($platform->getTruncateTableSQL('tournoi', true));
        $connection->executeUpdate($platform->getTruncateTableSQL('smasheur', true));
        $this->createSmasheursPionniers();
        $this->createTournoisChallonge($this->smasheurRepository);*/
        return $this->redirectToRoute('app_home');
        /*return $this->render('smasheurs/index.html.twig', [
            'controller_name' => 'SmasheursController',
        ]);*/
    }
    /**
     * @Route("/saucismasheur/{id<[0-9]+>}", name="app_smasheurs_show", methods="GET")
     */
    #[Route("/saucismasheur/{id<[0-9]+>}", name:"app_smasheurs_show", methods:"GET")]
    public function show(int $id): Response
    {
        $smasheur = $this->callApiService->getSaucismasheur($id)['data']['player'];
        
        if(is_null($smasheur['user'])){
            $tabAccounts = $this->tournoisController->tabMultipleAccounts();
            if(array_key_exists($smasheur['id'],$tabAccounts)){
                //$smasheur = $this->callApiService->getSaucismasheur($tabAccounts[$smasheur['id']])['data']['player'];
                return $this->redirectToRoute('app_smasheurs_show',array('id'=> $tabAccounts[$smasheur['id']]));
            } else{
                throw $this->createNotFoundException('Utilisateur supprimé');
            }
        }
        $smasheur = $this->removeDoublons($smasheur,$id);
        $tabInfo = $this->tabInfoSaucismasheur($smasheur);
        //dump($tabInfo);
        $tabAccounts = $this->tournoisController->tabMultipleAccounts();
        $chart = $this->chartBuilder->createChart(Chart::TYPE_LINE);
        $top8chart = $this->chartBuilder->createChart(Chart::TYPE_PIE);
        $chart->setData([
            'labels' => $tabInfo['tournoisList'],
            'datasets' => [
                [
                    'label' => 'Position',
                    'backgroundColor' => 'rgb(102,255,25)',
                    'borderColor' => 'rgb(102,255,25)',
                    'data' => $tabInfo['placementsList'],
                    'pointStyle' => false,
                    'pointBackgroundColor' => 'rgb(0, 0, 0)',
                    'clip' => [
                        'top' => 5,
                        'bottom' => false,
                        'left' => false,
                        'right' => false,
                    ],
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'min' => 1,
                    'reverse' => true,
                    'grid' => [
                        'lineWidth' => 2, 
                    ],
                    'ticks' => [
                        'includeBounds' => true,
                        'precision' => 0,
                        'maxTicksLimit' => 13,
                        'major' => [
                            'enabled'=> true
                        ]
                    ],
                ],
                'x' => [
                    'grid' => [
                        'lineWidth' => 2
                    ],
                    'title' => [
                        'display' => true,
                        'text' => '# Saucisse',
                        'align' => 'center',

                    ]
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
                'title' => [
                    'display' => true,
                    'text' => 'Tous les résultats',
                ]
            ],
            'layout' => [
                'padding' => [
                    'bottom' => 30,
                ]
            ]
        ]);
        $top8chart->setData([
            'labels' => ['Top 8','Pas top 8'],
            'datasets' => [
                [
                    'label' => 'Taux de Top 8',
                    'backgroundColor' => ['rgb(0,153,0)','rgb(153,0,0)'],
                    'data' => [$tabInfo['nbTop1'] + $tabInfo['nbTop2'] + $tabInfo['nbTop3'] + $tabInfo['nbTop8'],$tabInfo['nbHorsTop8']],
                    //'backgroundColor' => ['rgb(255,215,0)','rgb(192,192,192)','rgb(150,116,68)','rgb(0,153,0)','rgb(153,0,0)'],
                    //'data' => [$tabInfo['nbTop1'],$tabInfo['nbTop2'] , $tabInfo['nbTop3'] , $tabInfo['nbTop8'],$tabInfo['nbHorsTop8']],
                    'hoverOffset' => 4
                ],
            ],
        ]);
        return $this->render('smasheurs/show.html.twig',compact('smasheur')+compact('tabInfo')+compact('tabAccounts')+compact('chart')+compact('top8chart'));
    }

    private function removeDoublons(array $smasheur, int $id):array
    {
        foreach ($smasheur['user']['tournaments']['nodes'] as $tournoiKey => $tournoi)
        {
            //dump ($tournoiKey);
            $numMainEvent = $this->tournoisController->getNumEventMain($tournoi);
            if($tournoi['events'][$numMainEvent]['standings'] != null && !empty($tournoi['events'][$numMainEvent]['standings']['nodes']))
            {
                $idFound = false;
                foreach ($tournoi['events'][$numMainEvent]['standings']['nodes'] as $key => $standing) {
                    if($standing['player']['id'] == $id){
                        $idFound = true;
                    } else{
                        unset($smasheur['user']['tournaments']['nodes'][$tournoiKey]['events'][$numMainEvent]['standings']['nodes'][$key]);
                    }
                }
                if(!$idFound){
                    unset($smasheur['user']['tournaments']['nodes'][$tournoiKey]);
                }
            } else{
                unset($smasheur['user']['tournaments']['nodes'][$tournoiKey]);
            }
        }
        return $smasheur;
    }
    private function tabInfoSaucismasheur(array $data):array
    {
        $smasheur = $this->smasheurRepository->findOneBy(['IdPlayerAPI' => $data['id']]);
        //dump($smasheur);
        if(!is_null($smasheur)){
            $nbSaucissesChallonge = $smasheur->getTournois()->count();
            $titresChallonge = ['Glorieux·se Ancien‧ne' => 'Tu as remporté une Saucismash à l\'époque de Challonge !'];
        } else{
            $nbSaucissesChallonge = 0;
            $titresChallonge = [];
        }
        
        $tabInfo = [
            'CashPrize' => [],
            'nbParticipations' => 0,
            'nbTop1' => 0,
            'nbTop1DeLepoque' => $nbSaucissesChallonge, //De l'époque = + de deux ans avant aujourd'hui
            'nbTop2' => 0,
            'nbGFPerdues' => 0,
            'nbTop3' => 0,
            'nbTop8' => 0,
            'nb9emePlace' => 0,
            'nbHorsTop8' => 0,
            'nbTop16'=> 0,
            'nbTop32'=> 0,
            'nbWorst' => 0,
            'nbMitronnages' => 0,
            'nbZeroDeux' => 0,
            //'nbDQ'=> 0,
            'tauxTop8' => null,
            'nbSaucissesChallonge' => $nbSaucissesChallonge,
            'persos' => [],
            'imgURL' => [],
            'tournoisList' => [],
            'placementsList' => [],
            'titres' => $titresChallonge
        ];
        if($data['user']['authorizations'] !=null){
            foreach ($data['user']['authorizations'] as $auth)
            {
                if($auth['url'] && ($auth['type'] == 'TWITTER' || $auth['type'] == 'TWITCH')){
                    $tabInfo[$auth['type']] = $auth['url'];
                }
            }
        }
        
        foreach ($data['user']['tournaments']['nodes'] as $tournoi)
        {
            if(time() < $tournoi['endAt'])
            {
                continue;
            }

            $numMainEvent = $this->tournoisController->getNumEventMain($tournoi);
            //dd($tournoi);
            if($tournoi['events'][$numMainEvent]['standings'] != null && !empty($tournoi['events'][$numMainEvent]['standings']['nodes'])
/*&& $tournoi['events'][$numMainEvent]['standings']['nodes'][0]['player']['id'] == $data['id']*/)
            {
            $numSaucisse = $this->tournoisController->getNumSaucisseFromName($tournoi['name'])/*.' - '.date( "d/m/Y", $tournoi['startAt'])*/;
            $tabInfo['tournoisList'][]= $numSaucisse;
            $tabInfo['nbParticipations']++;
            if(count($tournoi['events'][$numMainEvent]['standings']['nodes'])>1){
                foreach ($tournoi['events'][$numMainEvent]['standings']['nodes'] as $standing)
                {
                    if($standing['player']['id'] == $data['id'])
                    {
                        $placement = $standing['placement'];
                        break;
                    }
                }
            }else{
                $placement = $tournoi['events'][$numMainEvent]['standings']['nodes'][0]['placement'];
            }
            $tabInfo['placementsList'][$this->tournoisController->getNumSaucisseFromName($tournoi['name'])] = $placement;
            if($placement>8){
                $tabInfo['nbHorsTop8']++;
                if($placement<=16)
                {
                    if($placement == 9){
                        $tabInfo['nb9emePlace']++;
                    }else{
                        $tabInfo['nbTop16']++;
                    }
                }
                elseif ($placement<=32)
                {
                    $tabInfo['nbTop32']++;
                }
                else
                {
                    $tabInfo['nbWorst']++;
                }
            }
            else
            {
                if($placement==3) {
                    $tabInfo['nbTop3']++;
                    if ($numSaucisse == '28.5') {
                        if(array_key_exists('euros',$tabInfo['CashPrize']))
                        {
                            $tabInfo['CashPrize']['euros'] += 20;
                        } else {
                            $tabInfo['CashPrize']['euros'] = 20;
                        }
                    }
                }
                elseif($placement==2)
                {
                    $tabInfo['nbTop2']++;
                    $tabInfo['nbGFPerdues']++;
                    if ($numSaucisse == '28.5') {
                        if(array_key_exists('euros',$tabInfo['CashPrize']))
                        {
                            $tabInfo['CashPrize']['euros'] += 30;
                        } else {
                            $tabInfo['CashPrize']['euros'] = 30;
                        }
                    }
                }
                elseif($placement==1) {
                    $tabInfo['nbTop1']++;
                    if($tournoi['startAt'] < strtotime("-2 years")){
                        $tabInfo['nbTop1DeLepoque']++;
                    }
                    /*Ajouter le CP Total :
                    1-30 : rien
                    31-43 : 20 balles
                    48-Now : 1m de shots
                    Super Saucismash (28.5) : 50-30-20
                    62 (Mocra) : Chaise Gaming */
                    if ($numSaucisse >= 48) {
                        if($numSaucisse == 62)
                        {
                            if(array_key_exists('chaise',$tabInfo['CashPrize']))
                            {
                                $tabInfo['CashPrize']['chaise'] += 1;
                            } else {
                                $tabInfo['CashPrize']['chaise'] = 1;
                            }
                        } else{
                            if(array_key_exists('shots',$tabInfo['CashPrize']))
                            {
                                $tabInfo['CashPrize']['shots'] += 10;
                            } else {
                                $tabInfo['CashPrize']['shots'] = 10;
                            }
                        }   
                    } elseif ($numSaucisse>=31 && $numSaucisse <=43)
                    {
                        if(array_key_exists('euros',$tabInfo['CashPrize']))
                        {
                            $tabInfo['CashPrize']['euros'] += 20;
                        } else {
                            $tabInfo['CashPrize']['euros'] = 20;
                        }
                    } elseif ($numSaucisse == '28.5') {
                        if(array_key_exists('euros',$tabInfo['CashPrize']))
                        {
                            $tabInfo['CashPrize']['euros'] += 50;
                        } else {
                            $tabInfo['CashPrize']['euros'] = 50;
                        }
                    }
                }else{
                    $tabInfo['nbTop8']++;
                }
            }
            $numEntrants = $tournoi['events'][$numMainEvent]['numEntrants'];
            //Faire du mitronnage = faire 2-2 en gros
            if($numEntrants>12)
            {
                if($numEntrants <= 32 && $placement == 9){
                    $tabInfo['nbMitronnages']++;
                    
                }
                if($numEntrants>16)
                {
                    if($numEntrants <= 64 && $placement == 13){
                        $tabInfo['nbMitronnages']++;
                    }
                    if($numEntrants>24)
                    {
                        if($placement == 17){
                            $tabInfo['nbMitronnages']++;
                        }
                        if($numEntrants>32)
                        {
                            if($placement == 25){
                                $tabInfo['nbMitronnages']++;
                            }
                            if($numEntrants>48)
                            {
                                if($placement == 33){
                                    $tabInfo['nbMitronnages']++;
                                }
                            }
                        }
                    }
                }
            }
            if($numEntrants > 8){
                if($numEntrants <= 12){
                    if($placement == 9){
                        $tabInfo['nbZeroDeux']++;
                    }
                } elseif ($numEntrants <= 16){
                    if($placement == 9 || $placement == 13){
                        $tabInfo['nbZeroDeux']++;
                    }
                } elseif($numEntrants <= 24){
                    if($placement == 13 || $placement == 17){
                        $tabInfo['nbZeroDeux']++;
                    }
                } elseif($numEntrants <= 32){
                    if($placement == 17 || $placement == 25){
                        $tabInfo['nbZeroDeux']++;
                    }
                } elseif($numEntrants <= 48){
                    if($placement == 25 || $placement == 33){
                        $tabInfo['nbZeroDeux']++;
                    }
                } elseif($numEntrants <= 64){
                    if($placement == 33 || $placement == 49){
                        $tabInfo['nbZeroDeux']++;
                    }
                    //Pas de Saucisse à 128+ de prévu
                } else{
                    if($placement == 49 || $placement == 65){
                        $tabInfo['nbZeroDeux']++;
                    }
                }
            }
            }

        }

        sort($tabInfo['tournoisList']);
        ksort($tabInfo['placementsList']);
        $tabInfo['placementsList'] = array_values($tabInfo['placementsList']);
        
        $persos = $this->callApiService->getPersosBySaucismasheur($data['id']);
        $allPersos = $this->callApiService->getAllCharactersWithImages()['data'];
        //dump($persos,$allPersos);
        if(array_key_exists('data',$persos) && !is_null($persos['data'])){
            foreach ($persos['data']['player']['user']['tournaments']['nodes'] as $tournament)
            {
                $numMainEvent = $this->tournoisController->getNumEventMain($tournament);
                foreach ($tournament['events'][$numMainEvent]['sets']['nodes'] as $set)
                {
                    if(!is_null($set['games']))
                    {
                        foreach ($set['games'] as $game)
                        {
                            if(!is_null($game['selections'])){
                                foreach ($game['selections'] as $sel)
                                {
                                    if($sel['entrant']['participants'][0]['player']['id'] == $data['id']){
                                        if(array_key_exists($sel['selectionValue'],$tabInfo['persos'])){
                                            $tabInfo['persos'][$sel['selectionValue']]++;
                                        }else{
                                            $tabInfo['persos'][$sel['selectionValue']]=1;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }


        arsort($tabInfo['persos']);
        foreach ($allPersos['videogame']['characters'] as $character)
        {
            if(array_key_exists($character['id'],$tabInfo['persos']))
            {
                foreach ($character['images'] as $image)
                {
                    if($image['type'] == 'stockIcon'){
                        $tabInfo['imgURL'][$character['id']] = $image['url'];
                        break;
                    }
                }
            }
        }
        if(!is_null($smasheur) && count($tabInfo['imgURL']) == 0){
            $lesPersos = explode(',',$smasheur->getPersonnages());
            $tabInfo['persos'] = $lesPersos;
            foreach ($allPersos['videogame']['characters'] as $char)
            {
                if(in_array($char['name'],$lesPersos))
                {
                    //dump($char['name']);
                    $tabInfo['imgURL'][] = $char['images'][1]['url'];
                    if(count($tabInfo['imgURL']) == count($lesPersos)) break;
                }
            }
        }

        $CPtotal = [];
        foreach ($tabInfo['CashPrize'] as $price => $nb) {
            if($price == 'chaise') $price = 'chaise gaming';
            if($price == 'euros') $price = 'balles';
            $CPtotal[] = $nb.' '.$price;
        }
        $tabInfo['CashPrize'] = $CPtotal;

        $trophees = $this->tropheeRepository->findBy(['idPlayerAPI' => $data['id']]);
        foreach ($trophees as $trophy) {
            $titre = ($trophy->getEmoji()? $trophy->getEmoji().' ' :'').'Trophée '.$trophy->getNom();
            if($trophy->getVersion() != null){
                $titre.= ' '.$trophy->getVersion();
            }
            if($trophy->getEmoji() != null){
                $titre.=' '. $trophy->getEmoji();
            }
            $tabInfo['titres'][$titre] = $trophy->getDescription();
        }
        
        if(($tabInfo['nbTop1'] + $nbSaucissesChallonge) >= 20){
            $tabInfo['titres']['Saucismasheur·euse Légendaire DORÉ·E'] = '🐐';
        }
        elseif($tabInfo['nbTop1DeLepoque'] >= 5 || ($tabInfo['nbTop1'] + $nbSaucissesChallonge) >= 10){
            $tabInfo['titres']['Saucismasheur·euse de LEGENDE'] = 'Tu es une légende de la Saucismash ! Bravo tes enfants seront fiers';
        }

        //Taux de top 8
        if($tabInfo['nbParticipations'] > 0){
            $nbTop8 = $tabInfo['nbTop1'] + $tabInfo['nbTop2'] + $tabInfo['nbTop3'] + $tabInfo['nbTop8'];
            $tabInfo['tauxTop8'] = $nbTop8 / $tabInfo['nbParticipations'];
        } 

        if($tabInfo['nbParticipations'] >= 5)
        {
            if($tabInfo['tauxTop8'] >= 0.5){
                $tabInfo['titres']['Saucismasheur·euse de Style'] = 'Tu as une majorité de top 8';
            } elseif($tabInfo['nbParticipations'] >= 20){
                $tabInfo['titres']['Saucismasheur·euse alcoolique'] = 'Tu viens souvent à la Saucisse mais avoue que t\'es pas la pour le Cashprize...';
            }

            if($tabInfo['nbZeroDeux'] / $tabInfo['nbParticipations'] >= 0.5)
            {
                $tabInfo['titres']['Fier·ère 0-2er'] = 'Tu as une majorité de 0-2 voire 1-2 max';
            }
            elseif($tabInfo['nbMitronnages'] / $tabInfo['nbParticipations'] >= 0.5)
            {
                $tabInfo['titres']['Mitron·ne de la Saucisse'] = 'Tu es officiellement éligible pour la prochaine Mitronnade ! Va glisser dans les DM de Gin';
            }
        }
        if($tabInfo['nbParticipations'] >= 150)
        {
            $tabInfo['titres']['Seringue de Nan mais Wesh achète toi une vie'] = 'Sérieux quoi';
        } 
        elseif($tabInfo['nbParticipations'] >= 100)
        {
            $tabInfo['titres']['Seringue de Platine'] = 'Tu as participé à 100 Saucisses !';//Je suis pas sur du nom
        } 
        elseif($tabInfo['nbParticipations'] >= 75)
        {
            $tabInfo['titres']['Seringue d\'or'] = 'Tu as participé à 75 Saucisses !';
        } 
        elseif($tabInfo['nbParticipations'] >= 50)
        {
            $tabInfo['titres']['Seringue de Titane'] = 'Tu as participé à 50 Saucisses !';
        } 
        if($tabInfo['nbTop1'] >= 1){
            $tabInfo['titres']['Teneur·euse de Saucisse'] = 'Tu as remporté une édition de la Saucismash !';
        } elseif ($tabInfo['nbParticipations'] < 5 && $tabInfo['nbParticipations'] > 0) {
            $tabInfo['titres']['Saucisse Novice'] = 'Tu as moins de cinq participations à la Saucismash.';
        }

        return $tabInfo;

    }

    private function createSmasheursPionniers(): void
    {
        $smasheur = new Smasheur();
        $smasheur->setPseudo('Flynn');
        $smasheur->setTag('IA');
        $smasheur->setIdPlayerAPI(936065);
        $smasheur->setPersonnages('Ike');
        $this->em->persist($smasheur);

        $smasheur = new Smasheur();
        $smasheur->setPseudo('Francis');
        $smasheur->setTag('S&B');
        $smasheur->setIdPlayerAPI(147144);
        $smasheur->setPersonnages('Fox,Mario,Mega Man');
        $this->em->persist($smasheur);

        $smasheur = new Smasheur();
        $smasheur->setPseudo('Pandaroux');
        $smasheur->setTag('UBI');
        $smasheur->setIdPlayerAPI(1079988);
        $smasheur->setPersonnages('Ness,Inkling');
        $this->em->persist($smasheur);

        $smasheur = new Smasheur();
        $smasheur->setPseudo('Vanaheim');
        $smasheur->setIdPlayerAPI(72152);
        $smasheur->setPersonnages('R.O.B');
        $this->em->persist($smasheur);

        $smasheur = new Smasheur();
        $smasheur->setPseudo('Foaya');
        $smasheur->setIdPlayerAPI(278459);
        $smasheur->setPersonnages('Fox');
        $this->em->persist($smasheur);

        $smasheur = new Smasheur();
        $smasheur->setPseudo('Aeron');
        $smasheur->setIdPlayerAPI(171762);
        $smasheur->setPersonnages('Snake');
        $this->em->persist($smasheur);

        $smasheur = new Smasheur();
        $smasheur->setPseudo('Yoyod');
        $smasheur->setIdPlayerAPI(257364);
        $smasheur->setPersonnages('Zero Suit Samus');
        $this->em->persist($smasheur);


        $this->em->flush();
    }
    private function createTournoisChallonge(SmasheurRepository $smasheurRepository)
    {
        $lesTournois = $this->getTabWinnerChallonge();
        foreach ($lesTournois as $numSaucisse=>$idSmasheur)
        {
            $tournoi = new Tournoi();
            $tournoi->setNumSaucisse($numSaucisse);
            $tournoi->setSmasheur($smasheurRepository->find($idSmasheur));
            $this->em->persist($tournoi);
        }
        $this->em->flush();

    }

    private function getTabWinnerChallonge():array
    {
        return array(
            1=>5, //Foaya
            2=>3, //Pandaroux
            3=>2, //Francis
            4=>7, //Yoyod
            5=>7, //Yoyod
            6=>3, //Pandaroux
            7=>3, //Pandaroux
            8=>3, //Pandaroux
            9=>6, //Aeron
            10=>2, //Francis
            11=>1, //Flynn
            12=>2, //Francis
            13=>2, //Francis
            14=>2, //Francis
            15=>3, //Pandaroux
            16=>3, //Pandaroux
            17=>3, //Pandaroux
            18=>1, //Flynn
            19=>4, //Vanaheim
        );
    }


}
