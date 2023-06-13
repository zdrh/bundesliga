<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Menu as MenuModel;
use App\Models\League as lModel;
use App\Models\Association as aModel;
use App\Models\LeagueSeason as lsModel;
use App\Libraries\ArrayLib;
class League extends BaseController {

    var $menu;
    var $lModel;
    var $aModel;
    var $lsModel;
    var $arrayLib;

    function __construct()
    {
        $model = new MenuModel();
        $this->menu = $model->orderBy('priority', 'desc');
        
        $this->menu = $this->menu->findAll();
        $this->lModel = new lModel();
        $this->aModel = new aModel();
        $this->lsModel = new lsModel();
        $this->arrayLib = new ArrayLib();

    }

    function index() {
        $data["title"] = "Seznam lig";
        $data['menu'] = $this->menu;
        $data['ligy'] = $this->lModel->getLeaguesWithAssociation()->findAll();
        $data['config'] = $this->config->crudForm;
        
        echo view('leagueList', $data);
    }

    function new() {
        $data["title"] = "Přidat ligu";
        $data['menu'] = $this->menu;
        $data['svazy'] = $this->arrayLib->dataForDropdown($this->aModel->orderBy('general_name', 'asc')->findAll(), 'id_association', 'general_name'); 
        
        echo view('addLeague', $data);
    }

    function create() {
        $name = $this->request->getPost('name');
        $level = $this->request->getPost('level');
        $active = $this->request->getPost('active');
        $id_association = $this->request->getPost('id_association');
        $data = array(
            'name' => $name,
            'level' => $level,
            'id_association' => $id_association,
            'active' => $active
        );
        $this->lModel->save($data);
        return redirect()->route('seznam-lig');
    }

    function edit($id) {
        $data["title"] = "Editovat ligu";
        $data['menu'] = $this->menu;
        $data['liga'] = $this->lModel->find($id);
        $data['svazy'] = $this->arrayLib->dataForDropdown($this->aModel->orderBy('general_name', 'asc')->findAll(), 'id_association', 'general_name'); 
        echo view('editLeague', $data);
    }

    //provede editaci
    function update() {
        $name = $this->request->getPost('name');
        $level = $this->request->getPost('level');
        $active = $this->request->getPost('active');
        $id_association = $this->request->getPost('id_association');
        $id_league = $this->request->getPost('id_league');
        $data = array(
            'name' => $name,
            'level' => $level,
            'id_association' => $id_association,
            'active' => $active,
            'id_league' => $id_league
        );
        
        $this->lModel->save($data);
        return redirect()->route('seznam-lig'); 
    }

    function delete($id_league) {
        $this->lModel->delete($id_league);
        return redirect()->route('seznam-lig'); 
    }

    function show($id) {
        $data["title"] = "Liga";
        $data['menu'] = $this->menu;
        $data['liga'] = $this->lModel->getLeagueWithAssociation()->find($id);
        $data['sezony'] = $this->lsModel->join('association_season', 'association_season.id_assoc_season=league_season.id_assoc_season', 'inner')->join('season', 'association_season.id_season=season.id_season', 'inner')->where('id_league', $id)->orderBy('season.start', 'asc')->findAll();
        $data['pocet_sezon'] = Count($data['sezony']);
        echo view('showLeague', $data);
    }
}