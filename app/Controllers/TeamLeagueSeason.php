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

    function index($idLeagueSeasonGroup) {
        $data["title"] = "Sezóna";
        $data['menu'] = $this->menu;
        $idLeagueSeason = $this->lsgModel->find($idLeagueSeasonGroup)->id_league_season;
        $data['tymyAvailable'] = $this->tModel->getTeamsWithoutLeague($idLeagueSeason)->findAll();
        $sezonaLiga = $this->lsgModel->join('league_season', 'league_season.id_league_season=league_season_group.id_league_season', 'inner')->join('association_season', 'association_season.id_assoc_season=league_season.id_assoc_season', 'inner')->join('season', 'season.id_season=association_season.id_season')->find($idLeagueSeasonGroup);
        //var_dump($sezonaLiga);
        $data['sezonaLiga'] = $this->arrayLib->links($sezonaLiga,'league_name_in_season', 'linkName', false);
        $data['tymyLiga'] = $this->tlsModel->join('team', 'team.id_team=team_league_season.id_team', 'inner')->where('id_league_season', $idLeagueSeason)->orderBy('team.general_name', 'asc')->findAll();
        $data['config'] = $this->config->crudForm;
        echo view('showSeasonLeague', $data);

    }

    function add($idLeagueSeasonGroup) {
        $data["title"] = "Přidat týmy do sezóny";
        $data['menu'] = $this->menu;
        $data['config'] = $this->config->crudForm;
        $data['idSezona'] = $idLeagueSeasonGroup;
        $idLeagueSeason = $this->lsgModel->find($idLeagueSeasonGroup)->id_league_season;
        $data['sezona'] = $this->lsModel->join('association_season', 'association_season.id_assoc_season=league_season.id_assoc_season', 'inner')->join('league', 'league_season.id_league=league.id_league', 'inner')->join('season','season.id_season=association_season.id_season', 'inner')->find($idLeagueSeason);
        $tymyAvailable = $this->tModel->getTeamsWithoutLeague($idLeagueSeason)->findAll();
        $disabled = array('');
        $data['tymyAvailable'] = $this->arrayLib->dataForDropdown($tymyAvailable, 'id_team', 'general_name', false, '', $disabled);
        echo view('addTeamLeagueSeason', $data);
    }

    function add2() {
        $teamSeason = $this->request->getPost('teamSeason');
        $idLeagueSeasonGroup = $this->request->getPost('id_league_season');
        var_dump($teamSeason);
        
    }

    function delete($idTeamLeagueSeason) {

    }


    
}

//
//