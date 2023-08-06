<?php

namespace App\Controllers;

use Config\Config;
use App\Libraries\ArrayLib;
use App\Models\Menu as MenuModel;
use App\Models\TeamLeagueSeason as tmsModel;
use App\Models\Team as tModel;
use App\Models\LeagueSeason as lsModel;
use App\Models\LeagueSeasonGroup as lsgModel;

class TeamLeagueSeason extends BaseController {

    var $config;
    var $menu;
    var $arrayLib;
    var $tlsModel;
    var $tModel;
    var $lsModel;
    var $lsgModel;

    function __construct() {
        $this->config = new Config();
        $model = new MenuModel();
        $this->menu = $model->orderBy('priority', 'desc')->findAll();
        $this->arrayLib = new ArrayLib();
        $this->tlsModel = new tmsModel();
        $this->tModel = new tModel();
        $this->lsModel = new lsModel();
        $this->lsgModel = new lsgModel();
    }

   
    function add($idLeagueSeason) {
        $data["title"] = "Přidat týmy do sezóny";
        $data['menu'] = $this->menu;
        $data['config'] = $this->config->crudForm;
        $data['idSezona'] = $idLeagueSeason;
        $idLeagueSeasonGroup = $this->lsgModel->where('id_league_season', $idLeagueSeason)->findAll();
        
        $data['sezona'] = $this->lsModel->join('association_season', 'association_season.id_assoc_season=league_season.id_assoc_season', 'inner')->join('league', 'league_season.id_league=league.id_league', 'inner')->join('season','season.id_season=association_season.id_season', 'inner')->find($idLeagueSeason);
        $tymyAvailable = $this->tModel->getTeamsWithoutLeague($idLeagueSeason)->findAll();
        $disabled = array('');
        $data['tymyAvailable'] = $this->arrayLib->dataForDropdown($tymyAvailable, 'id_team', 'general_name', false, '', $disabled);
        echo view('addTeamLeagueSeason', $data);
    }

    function create() {
        $teamSeason = $this->request->getPost('teamSeason');
        $idLeagueSeasonGroup = $this->request->getPost('id_league_season');
        var_dump($teamSeason);
        
    }

    function delete($idTeamLeagueSeason) {

    }


    
}

//
//