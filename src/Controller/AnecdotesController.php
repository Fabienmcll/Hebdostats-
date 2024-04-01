<?php

namespace App\Controller;

use App\Entity\Anecdote;
use App\Repository\AnecdoteRepository;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnecdotesController extends AbstractController
{
    private EntityManagerInterface $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em=$em;
    }

    /**
     * 
     * @throws Exception
     */
    #[Route("/anecdotes", name:"anecdotes")]
    public function index(AnecdoteRepository $anecdotesRepository): Response
    {
        //$this->persistAnecdotes();
        $anecdotes = $anecdotesRepository->findBy([],['id'=> 'ASC']);

        return $this->render('anecdotes/index.html.twig', compact('anecdotes'));
    }

    /**
     * @throws Exception
     */
    private function persistAnecdotes(): void
    {
        $connection = $this->em->getConnection();
        $platform = $connection->getDatabasePlatform();
        $connection->executeQuery($platform->getTruncateTableSQL('anecdotes', true));
        $lesAnecdotes = array(
            'La weekly Smash au Meltdown de Lyon est une institution de la scène smash lyonnaise qui a été créée sur Smash 4.
            Elle s\'appelle "la Saucismash" en référence au célèbre saucisson brioché de Lyon mais les joueurs ont commencé à
            appeler ce tournoi "la Saucisse" pour une raison que j\'ignore. Les vainqueurs de la Saucismash s\'appellent donc 
            "Les teneurs de Saucisse".',
            'La toute première Saucismash sur Ultimate a été remportée par Foaya à l\'époque de nos grands frères.',
            'En voyant le nom de "Francis" certains ont lâché une larme de nostalgie.',
            'Qui de mieux placé que le Lyonnais de cœur et de sang Lil Marty pour avoir remporté la symbolique 
            69ème Saucismash ?',
            'Le plus grand nombre de victoires consécutives à la Saucismash est de 3. Les seuls y étant parvenus
             sont Pandaroux, ALtek, Francis et Slacker. Pandaroux ayant égalé le record 2 fois (Saucismash 6,7,8 & 15,16,17).',
            'La 4ème Saucismash détient le record du plus grand nombre de participants avec 72 joueurs. Remportée par 
            le légendaire Yoyod face à Flynn (le TO) en grande finale.',
            //'Tenir une saucisse est devenu hype uniquement grâce à l\'alliance BAB/MSF.',
            'Seules 2 Saucismash n\'ont pas de vainqueur, la 28ème annulée car il n\'y avait pas assez de joueurs et la 
            44ème car elle a eu lieu juste avant le deuxième confinement à cause du Covid et le format bracket a été écarté 
            pour favoriser une "session".',
            'Au vu du faible nombre de joueurs inscrits à la Saucismash #28, il a été décidé que la Saucismash deviendra une monthly 
            avec 100 euros de Cashprize. On a appelé ça la Super Saucismash. 44 joueurs sont venus et c\'est Pandaroux qui l\'a emporté.
            Malheureusement la Super Saucismash n\'a connu qu\'une seule édition, et il a fallu attendre 6 mois pour voir un retour de la 
            Saucismash après le premier confinement.',
            'Pendant la 1ère année du jeu Flynn était TO de 3 weeklies en même temps ce fou. #FlynnReviensStp',
            'L\'un des gagnants d\'une Saucismash a tenté de frapper un TO après avoir perdu. Heureusement ce dernier 
            ayant connu la banlieue, la misère et l\'immigration s\'en est sorti sans aucune blessure.',
            'La Saucismash et le seul tournoi du monde où tu peux être bousculé en plein match de bracket contre 
            "porte-fenêtre" ou encore "ImSoFat" car il y a une table de beer-pong à 20 cm de toi.',
            'Si tu n\'as pas déjà tenu une saucisse, tu ne peux pas t\'assoir à la table des OGs.',
            'Avant il y avait du CP à la saucisse, on appellait ça la Golden Sausage. Y\'a même une chaise Gaming qui a
             été remportée par Mocra !',
            'Une édition de la Saucismash a pris tellement de retard que le top 8 s\'est joué en BO1.',
            'Mocra a dû DQ d\'une Saucismash car il n\'y avait aucun adaptateur dans la venue et sur les setups.',
            'Oxydion a un jour sauvé le sac d\'un saucismasheur en repérant de vilains garnements qui tentaient de le 
            subtiliser. Depuis Oxydion tient un barbecue avec une bonne flopée de saucisses.',
            'Le bar offre des verres d\'eau gratuitement ce qui est déjà mieux que le bar de S.Etienne ptdrrrr.',
            'La playlist du bar est validée par Gin.',
            'Des joueurs jettent leur manette en Round 1 de Saucismash et ceci m\'empêche de dormir.',
            'Le joueur ayant fait le plus de Saucismash est Hazmat avec 51 participations à son actif à date du 
            15/02/2022 (et j\'updaterai pas cette stat car j\'ai la flemme). Le 2ème est Shiko avec 49.',
            'Le tout premier tournoi Smash sur Ultimate organisé au Meltdown a été remporté par Nonocolors à la sortie
             du jeu. Le tournoi ne s\'appelait même pas encore la Saucismash ce qui fait de Nonocolors le seul et 
             unique teneur de chipo.',
            'Un certain joueur dont nous respecterons l\'anonymat a DQ d\'une grande finale car son adversaire je cite 
            "bourrait trop c\'est pas intéressant". La source de cette anecdote a préféré rester anonyme (Lil Marty).',
            'JO2LY a battu Matth10 mdrrrrrrrrr',
            'La Saucismash #67 a marqué la dernière sauci de Lyord. Il finira 2ème battu par BenJ ce qui l\'empêchera 
            de partir sur une victoire et de quoi rajouter du tragique à son départ... Quelle tristesse Alexa joue la kiffance de Naps.',
            'Il y a pas vraiment de TO à la Saucismash, enfin si, enfin non, en fait on ne sait pas trop...',
            'Aspifouette gagne la Saucismash 91 sur une DQ de Zequar en Grande Finale. 7 éditions plus tard à la 
            Saucisse 98 Yoyo, le meilleur ami d\'Aspifouette, gagnera également sur une DQ de Nerraw.',
            'La Saucisse est un tournoi international : le Colombien Reridse a remporté la 87ème Saucisse tandis que Her a 
            ramené la 86ème aux Etats-Unis. La 76ème a même été remportée par un mec de Limoges.',
            'Un vainqueur de la Saucismash a déjà insulté un TO parce que ce dernier a pris la décision de passer le bracket en BO3 pour que les 
            finalistes puissent avoir le dernier métro.',
            'Saucismash 110, Shiko vs Sfar. Coup d\'envoi 21h. Après une game 1 très longue et très serrée Shiko place un Back air en last hit,
            pense gagner la game et pop-off si fort que tout le bar l\'entend. Malheureusement pour lui Sfar ne meurt pas, revient sur le stage,
            et remporte la game... et tout le bar pop-off pour se moquer de Shiko.',
            'Tu peux accéder à la fiche de joueur de n\'importe quel·le Saucismasheur·euse simplement en cliquant sur son pseudo dans le hall of Fame ou dans une fiche de tournoi.
            Tu pourras y trouver ses stats personnelles et les titres qu\'iel a remporté. Sauf si la personne concernée a supp son compte pour changer d\'identité, la je peux rien faire sorry',
            'Semaine du 13 mars 2023 : Spectral, récemment sacré 8ème joueur de France, décide de passer toute la semaine à Lyon et participer à toutes
            les weeklies en vue de la Dose2Sucre. Il remporte toutes les weeklies la main dans le slip... sauf la Saucismash #120 où il sera vaincu par Slacker,
            un vrai saucismasheur bien de chez nous !',
            'Saucismash 133, 23h55. Underkowe et Sfar décident de faire la course sur 50 mètres devant le bar... Underkowe fait une chute terrible à mi-parcours mais arrive quand même à remporter la course. Bûch > S&B.',
            'Le Trophée Abe Froman du Roi de la Saucisse récompense lae smasheur·euse qui a remporté le plus de Saucismash sur une année civile. Qui remportera l\'édition 
            cette année ? La bataille fait rage... RDV le 1er janvier pour le résultat !',
            'Si vous ne savez pas qui est Abe Froman, allez voir le chef d\'oeuvre cinématographique La Folle Journée de Ferris Bueller ou demandez directement à JO2LY.',
            'Le Trophée de la Seringue récompense lae Saucismasheur·euse qui a le plus de participations sur une année civile. En 2022 le trophée est partagé entre Baskoy, Deskwam et Hazmat 
            qui sont arrivés ex-aequo avec 34 participations chacun sur 47 éditions ! Bravo les seringués...',
            'Deux saucismasheurs ont un jour interrompu leur match de bracket en plein milieu pour aller voir en direct un penalty de Karim à la télé... Et le TO ne leur a rien dit parce qu\'il regardait avec eux !',
            'En Juillet 2023 le Meltdown de Lyon annonce sa fermeture. Cette nouvelle est déjà bien triste mais en plus ça veut dire que Sorbexos va devoir rester sur ses 11 défaites d\'affilée en Grande Finale 
            avec 0 victoire... Il pleut...',
            'Mais c\'était sans compter sur l\'immense abnégation des saucismasheurs et de Sorbexos qui a trouvé un nouveau bar encore mieux, ressuscité la Saucismash, puis est retournée en grande finale, a reperdu, y est retourné encore, a re-re-perdu... 
            Et dans la nuit du 6 mars 2024 à minuit 10, Sorbexos remporte ENFIN la Saucismash #162 !! Moi je dis "GRANDE !"'
        );
        foreach ($lesAnecdotes as $anec)
        {
            $anecdote = new Anecdote();
            $anecdote->setBody($anec);
            $this->em->persist($anecdote);
        }

        $this->em->flush();

    }
}
