<?php

namespace App\Service;

use DateTime;
use Doctrine\DBAL\Types\DateType;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService
{
    private HttpClientInterface $client;
    private LoggerInterface $logger;
    public function __construct(HttpClientInterface $client, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->logger = $logger;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getAllSaucisses():array
    {
        $data = ['data'=>['tournaments'=>['nodes'=>[]]]];
        $page=1;
        $body = $this->buildBodyGetAllSaucisses();
        while ($this->getApiStartgg($body)['data']['tournaments']['nodes']){
            $data['data']['tournaments']['nodes'] = array_merge($data['data']['tournaments']['nodes'], $this->getApiStartgg($body)['data']['tournaments']['nodes']);
            $page++;
            $body = $this->buildBodyGetAllSaucisses($page);
        }
        return $data;
        //return $this->getApiStartgg($body);
    }
    private function buildBodyGetAllSaucisses(int $page=1): string
    {
        return '{"query":"query AllSaucisses($perPage: Int!,$page: Int!) {\\r\\n  tournaments(query: {\\r\\n    perPage: $perPage,\\r\\n    page: $page,\\r\\n    filter: {\\r\\n name : \\"hebdomadeh\\"\\r\\n      addrState : \\"Auvergne-Rhône-Alpes\\"\\r\\n    }\\r\\n  }) {\\r\\n    nodes {\\r\\n        id,\\r\\n      name,\\r\\n      startAt,endAt,\\r\\n      events(limit : 5){\\r\\n        name,\\r\\n        numEntrants,\\r\\n        standings(query:{perPage:1})\\r\\n        { \\r\\n          nodes{\\r\\n          placement,\\r\\n          player{\\r\\n    id,\\r\\n  prefix,\\r\\n  gamerTag,\\r\\n  user{\\r\\n  id,images(type:\\"profile\\"){\\r\\n          url          \\r\\n      }\\r\\n  }\\r\\n          }\\r\\n        }\\t\\r\\n      }\\r\\n      }\\r\\n      }\\r\\n    }\\r\\n  }","variables":{"perPage":100,"page":'.$page.'}}';
    }
    public function getAllTeneursByYear(int $year):array
    {
        $FirstDay = strtotime('1st January '.$year);
        $LastDay = strtotime('1st January '.$year+1);
        $body = '{"query":"query AllSaucisses($perPage: Int!,$page: Int!) {\\r\\n  tournaments(query: {\\r\\n    perPage: $perPage,\\r\\n    page: $page,\\r\\n    filter: {\\r\\n name : \\"hebdomadeh\\"\\r\\n      addrState : \\"Auvergne-Rhône-Alpes\\"\\r\\n , beforeDate: '.$LastDay.', afterDate: '.$FirstDay.'   }\\r\\n  }) {\\r\\n    nodes {\\r\\n        id,\\r\\n      name,\\r\\n      startAt,endAt,\\r\\n      events(limit : 5){\\r\\n        name,\\r\\n        numEntrants,\\r\\n        standings(query:{perPage:1})\\r\\n        { \\r\\n          nodes{\\r\\n          placement,\\r\\n          player{\\r\\n    id,\\r\\n  prefix,\\r\\n  gamerTag,\\r\\n  user{\\r\\n  id,images(type:\\"profile\\"){\\r\\n          url          \\r\\n      }\\r\\n  }\\r\\n          }\\r\\n        }\\t\\r\\n      }\\r\\n      }\\r\\n      }\\r\\n    }\\r\\n  }","variables":{"perPage":500,"page":1}}';
        
        return $this->getApiStartgg($body);
    }
    public function getAllParticipantsByYear(int $year):array
    {
        $FirstDay = strtotime('1st January '.$year);
        $LastDay = strtotime('1st January '.$year+1);
        $page =1;

        $body = '{"query":"query AllParticipants2022($perPage: Int!, $page: Int!) {\\r\\n  tournaments(\\r\\n    query: {perPage: $perPage, page: $page, filter: {name: \\"hebdomadeh\\", addrState: \\"Auvergne-Rhône-Alpes\\", beforeDate: '.$LastDay.', afterDate: '.$FirstDay.'   }}\\r\\n  ) {\\r\\n    nodes {\\r\\n      id\\r\\n      name\\r\\n      startAt\\r\\n      endAt\\r\\n      events(limit: 5) {\\r\\n        name\\r\\n        numEntrants\\r\\n        standings(query: {perPage: 500}) {\\r\\n          nodes {\\r\\n            placement\\r\\n            player {\\r\\n              id\\r\\n              prefix\\r\\n              gamerTag\\r\\n            }\\r\\n          }\\r\\n        }\\r\\n      }\\r\\n    }\\r\\n  }\\r\\n}\\r\\n","variables":{"perPage":8,"page":'.$page.'}}';
        $response = $this->getApiStartgg($body);
        $retour = [];
        while ($response['data']['tournaments']['nodes']){
            $retour = array_merge($retour,$response['data']['tournaments']['nodes']);
            $page++;
            $body = '{"query":"query AllParticipants2022($perPage: Int!, $page: Int!) {\\r\\n  tournaments(\\r\\n    query: {perPage: $perPage, page: $page, filter: {name: \\"hebdomadeh\\", addrState: \\"Auvergne-Rhône-Alpes\\", beforeDate: '.$LastDay.', afterDate: '.$FirstDay.'   }}\\r\\n  ) {\\r\\n    nodes {\\r\\n      id\\r\\n      name\\r\\n      startAt\\r\\n      endAt\\r\\n      events(limit: 5) {\\r\\n        name\\r\\n        numEntrants\\r\\n        standings(query: {perPage: 500}) {\\r\\n          nodes {\\r\\n            placement\\r\\n            player {\\r\\n              id\\r\\n              prefix\\r\\n              gamerTag\\r\\n            }\\r\\n          }\\r\\n        }\\r\\n      }\\r\\n    }\\r\\n  }\\r\\n}\\r\\n","variables":{"perPage":8,"page":'.$page.'}}';
            $response = $this->getApiStartgg($body);
        }
        return $retour;
    }
    public function getAllParticipantsByPeriod(string $datedeb, string $datefin):array
    {
        $FirstDay = strtotime($datedeb);
        $LastDay = strtotime($datefin);
        $page =1;

        $body = '{"query":"query AllParticipantsPeriod($perPage: Int!, $page: Int!) {\\r\\n  tournaments(\\r\\n    query: {perPage: $perPage, page: $page, filter: {name: \\"hebdomadeh\\", addrState: \\"Auvergne-Rhône-Alpes\\", beforeDate: '.$LastDay.', afterDate: '.$FirstDay.'   }}\\r\\n  ) {\\r\\n    nodes {\\r\\n      id\\r\\n      name\\r\\n      startAt\\r\\n      endAt\\r\\n      events(limit: 5) {\\r\\n        name\\r\\n        numEntrants\\r\\n        standings(query: {perPage: 500}) {\\r\\n          nodes {\\r\\n            placement\\r\\n            player {\\r\\n              id\\r\\n              prefix\\r\\n              gamerTag, user{ id, images(type:\\"profile\\"){ url }  }         }\\r\\n          }\\r\\n        }\\r\\n      }\\r\\n    }\\r\\n  }\\r\\n}\\r\\n","variables":{"perPage":5,"page":'.$page.'}}';
        $response = $this->getApiStartgg($body);
        $retour = [];
        while ($response['data']['tournaments']['nodes']){
            $retour = array_merge($retour,$response['data']['tournaments']['nodes']);
            $page++;
            $body = '{"query":"query AllParticipantsPeriod($perPage: Int!, $page: Int!) {\\r\\n  tournaments(\\r\\n    query: {perPage: $perPage, page: $page, filter: {name: \\"hebdomadeh\\", addrState: \\"Auvergne-Rhône-Alpes\\", beforeDate: '.$LastDay.', afterDate: '.$FirstDay.'   }}\\r\\n  ) {\\r\\n    nodes {\\r\\n      id\\r\\n      name\\r\\n      startAt\\r\\n      endAt\\r\\n      events(limit: 5) {\\r\\n        name\\r\\n        numEntrants\\r\\n        standings(query: {perPage: 500}) {\\r\\n          nodes {\\r\\n            placement\\r\\n            player {\\r\\n              id\\r\\n              prefix\\r\\n              gamerTag,  user{ id, images(type:\\"profile\\"){ url } }        }\\r\\n          }\\r\\n        }\\r\\n      }\\r\\n    }\\r\\n  }\\r\\n}\\r\\n","variables":{"perPage":5,"page":'.$page.'}}';
            $response = $this->getApiStartgg($body);
        }
        return $retour;
    }
    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getSaucisse(int $idTournoi):array
    {
        $body = '{"query":"query GetSaucisse($id: ID!) {\\r\\n  tournament(id: $id) {\\r\\n        id,\\r\\n      slug,name,\\r\\n      startAt,\\r\\n      events(limit : 5){\\r\\n        name,\\r\\n        numEntrants,\\r\\n        standings(query:{perPage:500})\\r\\n        { \\r\\n          nodes{\\r\\n          placement,\\r\\n          entrant{id}  \\r\\n          player{\\r\\n    id,\\r\\n  prefix,\\r\\n  gamerTag,\\r\\n  user{\\r\\n      id,\\r\\n      images(type:\\"profile\\"){\\r\\n          url          \\r\\n      }\\r\\n  }\\r\\n          }\\t\\r\\n      }\\r\\n      }\\r\\n      }\\r\\n    }\\r\\n  }","variables":{"id":'.$idTournoi.'}}';
        return $this->getApiStartgg($body);
    }

    public function getAllSetsFromSaucisse(int $idTournoi): array
    {
        $bodyPage1 = '{"query":"query GetAllSetsFromSaucisse($id: ID!) {\\r\\n  tournament(id: $id) {\\r\\n    name\\r\\n    events(limit: 5) {\\r\\n      name\\r\\n      numEntrants\\r\\n      sets(page: 1, perPage: 65, sortType: RECENT) {\\r\\n        nodes {\\r\\n          games {\\r\\n            selections {\\r\\n              selectionValue\\r\\n              entrant {\\r\\n                id\\r\\n              }\\r\\n            }\\r\\n          }\\r\\n        }\\r\\n      }\\r\\n    }\\r\\n  }\\r\\n}\\r\\n","variables":{"id":'.$idTournoi.'}}';
        $bodyPage2 = '{"query":"query GetAllSetsFromSaucisse($id: ID!) {\\r\\n  tournament(id: $id) {\\r\\n    name\\r\\n    events(limit: 5) {\\r\\n      name\\r\\n      numEntrants\\r\\n      sets(page: 2, perPage: 65, sortType: RECENT) {\\r\\n        nodes {\\r\\n          games {\\r\\n            selections {\\r\\n              selectionValue\\r\\n              entrant {\\r\\n                id\\r\\n              }\\r\\n            }\\r\\n          }\\r\\n        }\\r\\n      }\\r\\n    }\\r\\n  }\\r\\n}\\r\\n","variables":{"id":'.$idTournoi.'}}';
        return $this->getApiStartgg($bodyPage1) + $this->getApiStartgg($bodyPage2);
    }
    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getPersosByTournoi(int $idTournoi, array $tabIdEntrants): array
    {
        $var = '"id":'.$idTournoi;
        foreach ($tabIdEntrants as $key=>$idEntrant)
        {
            $var.=',"idEntrant'.$key.'":'.$idEntrant;
        }
        $body = '{"query":"query GetPersos($id: ID!,$idEntrant1:ID,$idEntrant2:ID,$idEntrant3:ID,$idEntrant4:ID,$idEntrant5:ID,$idEntrant6:ID,$idEntrant7:ID,$idEntrant0:ID) {\\r\\n  tournament(id: $id) {\\r\\n        id,\\r\\n      name,\\r\\n      startAt,\\r\\n      events(limit : 5){\\r\\n        name,\\r\\n        numEntrants,\\r\\n        videogame{id},\\r\\n      \\tsets(filters:{\\r\\n          entrantIds:[\\r\\n  $idEntrant1,\\r\\n  $idEntrant2,\\r\\n  $idEntrant3,\\r\\n  $idEntrant4,\\r\\n  $idEntrant5,\\r\\n  $idEntrant6,\\r\\n  $idEntrant7,\\r\\n  $idEntrant0\\r\\n          ]\\r\\n          \\r\\n        }){\\r\\n          nodes{\\r\\n  games{\\r\\n    selections{\\r\\n      entrant{id}\\r\\n      selectionValue\\r\\n    }\\r\\n  }\\r\\n          }\\r\\n        }\\r\\n      }\\r\\n    }\\r\\n  }","variables":{'.$var.'}}';
        return $this->getApiStartgg($body);
    }
    public function getPersosBySaucismasheur(int $idPlayer):array
    {
        $body = '{"query":"query GetSaucismasheur($id:ID!){\\r\\n  player(id:$id){\\r\\n    id,\\r\\n    gamerTag,\\r\\n    prefix,\\r\\n    user{\\r\\n      tournaments(query:{\\r\\n        perPage:8\\r\\n        sortBy:\\"startAt\\"\\r\\n        filter:{\\r\\n          past:true,\\r\\n          search:{fieldsToSearch:[\\"tournament.name\\"] \\r\\n  searchString:\\"Saucismash\\"}\\r\\n        }\\r\\n      }){\\r\\n    nodes {\\r\\n      name,\\r\\n      startAt,\\r\\n      events{\\r\\n        numEntrants,sets(perPage:4,filters:{playerIds:[$id]}){\\r\\n          nodes{games{selections{\\r\\n  selectionValue,\\r\\n  entrant{participants{\\r\\n    player{id}\\r\\n  }}\\r\\n          }}}\\r\\n        }\\r\\n      } \\r\\n      }\\r\\n    }\\r\\n    }\\r\\n  }\\r\\n}\\r\\n","variables":{"id":'.$idPlayer.'}}';
        return $this->getApiStartgg($body);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getSaucismasheur(int $idPlayer): array
    {
        $bodyGamerTag = '{"query":"query GetSaucismasheurGamerTag($id:ID!){player(id:$id){id,gamerTag}\\r\\n}","variables":{"id":'.$idPlayer.'}}';
        $gamerTag = $this->getApiStartgg($bodyGamerTag)['data']['player']['gamerTag'];
        $body = '{"query":"query GetSaucismasheur($id:ID!,$gamerTag:String){\\r\\n    player(id:$id){\\r\\n        id,\\r\\n        gamerTag,\\r\\n        prefix,\\r\\n        user{\\r\\n  authorizations{type,url}\\r\\n  genderPronoun,\\r\\n  location{country},\\r\\n  images(type:\\"profile\\"){url}\\r\\n  tournaments(query:{\\r\\n      perPage:500,\\r\\n      filter:{\\r\\n          search:{\\r\\n    fieldsToSearch:[\\"tournament.name\\"] searchString:\\"Saucismash\\"\\r\\n    }\\r\\n    }\\r\\n    }){\\r\\n        nodes {\\r\\n            name,\\r\\n            startAt,endAt,\\r\\n            events{\\r\\n      numEntrants,\\r\\n      standings(query:{perPage:500,\\r\\n      filter:{\\r\\n          search:{\\r\\n fieldsToSearch:[\\"standing.player.gamerTag\\"]  searchString:$gamerTag}\\r\\n }\\r\\n }){\\r\\n        nodes{\\r\\n player{gamerTag,id},\\r\\n placement\\r\\n }\\r\\n }\\r\\n }\\r\\n }\\r\\n }\\r\\n }}}\\r\\n","variables":{"id":'.$idPlayer.',"gamerTag":"'.$gamerTag.'"}}';
        
        return $this->getApiStartgg($body);
    }
    public function getAllCharactersWithImages():array
    {
        $body = '{"query":"query GetAllCharactersandImages{\\r\\n  videogame(id:1386){\\r\\n    id,\\r\\n    name,\\r\\n    characters{\\r\\n      id,\\r\\n      name\\r\\n      images{\\r\\n        type,\\r\\n        url\\r\\n      }\\r\\n    }\\r\\n  }\\r\\n}\\r\\n","variables":{}}';
        return $this->getApiStartgg($body);
    }
    public function getChallongeSaucisse():array
    {
        return $this->getApiChallonge();
    }
    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getArimaAccount():array
    {
        $body = '{"query":"query getBilel{\\r\\n  player(id: 1387694){\\r\\n    id,\\r\\n    prefix,\\r\\n    gamerTag,\\r\\n    user{\\r\\n        id,\\r\\n        images(type:\\"profile\\"){\\r\\n  url          \\r\\n        }\\r\\n  }\\r\\n  }\\r\\n}\\r\\n","variables":{}}';
        return $this->getApiStartgg($body);
    }
    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    private function getApiStartgg(string $body):array
    {
        $response = $this->client->request(
        'POST', 'https://api.start.gg/gql/alpha',[
            'headers' => [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer 45146c3a66696bc4e600a53110ddb425' // TOKEN
            ],
            'body' => $body
        ]);
        return $response->toArray();
    }

    private function getApiChallonge():array
    {
        $response = $this->client->request(
        'GET', 'https://api.challonge.com/v1/tournaments/saucismashultimate19.json',[
            'headers'=>[
                'api_key' => 'ym0QuPyvSwKLUQZtzWffHV3osbu5r7dhiI0wc462'
                ]
        ]
        );
        return $response->toArray();
    }
}