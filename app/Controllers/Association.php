<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Menu as MenuModel;
use App\Models\Association as aModel;
use App\Models\League as lModel;
use App\Models\AssociationSeason as asModel;
use Config\Config;

class Association extends BaseController
{
    var $menu;
    var $aModel;
    var $lModel;
    var $asModel;
    var $config;
    

    function __construct() {
        $model = new MenuModel();
        $this->aModel = new aModel();
        $this->lModel = new lModel();
        $this->asModel = new asModel();
        $this->config = new Config();
        $this->menu = $model->orderBy('priority', 'desc')->findAll();
    }
    //vytvoří přidávací formulář
    function new() {
        $data["title"] = "Přidat svaz";
        $data['menu'] = $this->menu;
        $data['year'] = $this->config->year;
        echo view('addAssociation', $data);
    }
    //vloží nový prvek podle přidávacího formuláře do db
    function create() {
        $name = $this->request->getPost('name');
        $founded = $this->request->getPost('founded');
        $short_name = $this->request->getPost('short_name');
        $data = array(
            'general_name' => $name,
            'founded' => $founded,
            'short_name' => $short_name
        );
        $this->aModel->save($data);
        return redirect()->route('seznam-svazu');

        //
    }
    //vypíše seznam všech prvků 
    function index() {
        $data["title"] = "Seznam svazů";
        $data['menu'] = $this->menu;
        $svazy = $this->aModel->findAll();
        $data['svazy'] = $svazy;
        $data['config'] = $this->config->crudForm;
        
        echo view('associationList', $data);

    }
    //zobrazí jeden prvek
    function show($id) {
        $data["title"] = "Svaz";
        $data['menu'] = $this->menu;
        $data['svaz'] = $this->aModel->find($id);
        $data['sezona'] = $this->asModel->getSeasonsByAssociation($id)->findAll();
        $data['liga'] = $this->lModel->where('id_association', $id)->orderBy('level', 'asc')->findAll();
        $data['uploadPath'] = $this->config->uploadPath;
        $data['config'] = $this->config->crudForm;
        echo view('showAssociation', $data);
    }

    //zobazí editační formulář pro jeden prvek
    function edit($id) {
        $data["title"] = "Editovat svaz";
        $data['menu'] = $this->menu;
        $data['year'] = $this->config->year;
        $data['svaz'] = $this->aModel->find($id);
        echo view('editAssociation', $data);
    }

    //provede editaci
    function update() {
        $name = $this->request->getPost('name');
        $founded = $this->request->getPost('founded');
        $id_association = $this->request->getPost('id_association');
        $short_name = $this->request->getPost('short_name');
        $data = array(
            'general_name' => $name,
            'founded' => $founded,
            'id_association' => $id_association,
            'short_name' => $short_name
        );
        
        $this->aModel->save($data);
        return redirect()->route('seznam-svazu'); 
    }

    //provede smazání
    function delete($id_association) {
        $this->aModel->delete($id_association);
        return redirect()->route('seznam-svazu'); 
    }
}
