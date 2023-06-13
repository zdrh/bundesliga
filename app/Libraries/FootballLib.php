<?php
namespace App\Libraries;

use App\Models\League as lModel;
use App\Models\LeagueSeason as lsModel;
use App\Models\LeagueSeasonGroup as lsgModel;


class FootballLib {

    var $lModel;
    var $lsModel;
    var $lsgModel;
    function __construct() {
        $this->lModel = new lModel();
        $this->lsModel = new lsModel();
        $this->lsgModel = new lsgModel();
    }
/**
 *  vypíše pouze ty soutěže dané asociace, které nemají pro danou sezonu vytvořený záznam
 */

    function getFreeLeaguesForSeason($idAssociation, $idSeason) {
        $result = array();
        $leagues = $this->lModel->where('id_association', $idAssociation)->orderBy('level', 'asc')->findAll();
        $leagueSeason = $this->lsModel->join('association_season', 'league_season.id_assoc_season=association_season.id_assoc_season', 'inner')->where('id_season', $idSeason)->where('association_season.id_association', $idAssociation)->findAll();
        
        $result = array();
        foreach($leagues as $row) {
            if(!$this->findValue($leagueSeason, 'id_league', $row->id_league)) {
                $result[] = $row;
            }
        }
        
        return $result;
        
    }
    /**
     * hledá jestli v daném poli objektů existuje hodnota prodaný atribut. vrací true/false
     */
    private function findValue($array, $attribute, $value) {
        $result = false;
        foreach($array as $row) {
            if($row->$attribute == $value) {
                $result = true;
            }
        }
        
        return $result;

    }

    function fixGroups($data, $groups) {
        
        if($data->groups != $groups) {
            $this->lsgModel->where('id_league_season', $data->id_league_season)->delete();
            if($data->groups > $groups) {
                //je v DB 2 (má skupiny) ale po změně má být 1 (nemá skupiny) => přidám 1 obecnou ligu do skupin
                $db = array(
                    "id_league_season" => $data->id_league_season
                    
                );
                var_dump($db);
                $this->lsgModel->save($db);
            } else {
                //V DB je 1 ale po změně má být 2 -> nejsou skupiny a všechny je smažu, musím ale přidat jednu univerzální bez názvu.
                $this->lsgModel->where('id_league_season', $data->id_league_season)->delete();
                $db2 = array(
                    "id_league_season" => $data->id_league_season,
                    "groupname" => "Ligagruppe"
                );
                var_dump($db2);
                $this->lsgModel->save($db2);
            }
        }
    }


}