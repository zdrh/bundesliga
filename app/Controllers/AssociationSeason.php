<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Menu as MenuModel;
use App\Models\Association as aModel;
use App\Models\Season as sModel;
use App\Models\AssociationSeason as asModel;
use App\Libraries\ArrayLib;
use Config\Config;

class AssociationSeason extends BaseController {

    var $menu;
    var $aModel;
    var $asModel;
    var $sModel;
    var $arrayLib;
    var $config;

    function __construct() {
        $model = new MenuModel();
        $this->menu = $model->orderBy('priority', 'desc');
        $this->menu = $this->menu->findAll();
        $this->aModel = new aModel();
        $this->asModel = new asModel();
        $this->sModel = new sModel();
        $this->arrayLib = new ArrayLib();
        $this->config = new Config();
        
    }

    function index() {
        $data["title"] = "Seznam sezon";
        $data['menu'] = $this->menu;
       
        
        
        echo view('leagueList', $data);
    }

   

    function new($id_association) {
        $data["title"] = "Přidat sezonu asociace";
        $data['menu'] = $this->menu;
        $data['svaz'] = $this->aModel->find($id_association);
        $vysledek = array('start', 'finish');
        $data['sezony'] = $this->arrayLib->dataForDropdown($this->sModel->orderBy('start', 'asc')->findAll(), 'id_season', $vysledek,true, '-');
        $sezonySvazu = $this->arrayLib->dataForDropdown($this->asModel->where('id_association', $id_association)->findAll(),'id_season','id_assoc_season');
        $extra = array('');
        $data['sezonySvazu'] = $this->arrayLib->addExtraForDropdown($data['sezony'], $sezonySvazu, $extra);
       
        echo view('addAssociationSeason', $data);
    }

    function create() {
        $name = $this->request->getPost('name');
        $logo = $this->request->getFile('logo');
       
        $id_season = $this->request->getPost('id_season');
        $id_association = $this->request->getPost('id_association');
        $svaz = $this->aModel->find($id_association);
        
        $uploadPath = $this->config->uploadPath;
        $ext = $logo->getClientExtension();
        $newName = 'logo_'.$svaz->short_name.'_'.$id_association.'_'.$id_season.'.'.$ext;
        $logo->move($uploadPath, $newName);

        $data = array(
            'id_season' => $id_season,
            'id_association' => $id_association,
            'name' => $name,
            'logo' => $newName
        );
        $this->asModel->save($data);
        
        return redirect()->to('svaz/zobrazit/'.$id_association);
        
    }

    function edit($id_assoc_season) {
        $data["title"] = "Editovat sezonu asociace";
        $data['menu'] = $this->menu;
        $data['uploadPath'] = $this->config->uploadPath;
        $id_association = $this->asModel->find($id_assoc_season)->id_association;
        $data["aktualniSezona"] = $this->asModel->getSeasonsByAssociation($id_association)->find($id_assoc_season);
        $vysledek = array('start', 'finish');
        $data['sezony'] = $this->arrayLib->dataForDropdown($this->sModel->orderBy('start', 'asc')->findAll(), 'id_season', $vysledek,true, '-');
        $sezonySvazu = $this->arrayLib->dataForDropdown($this->asModel->where('id_association', $id_association)->findAll(),'id_season','id_assoc_season');
        $remove = array($data['aktualniSezona']->id_season);
        $data['sezonySvazu'] = $this->arrayLib->addExtraForDropdown($data['sezony'], $sezonySvazu, [], $remove);
        echo view('editAssociationSeason', $data);
    }

    function update() {
        
        $name = $this->request->getPost('name');
        $logo = $this->request->getFile('logo');
        
        
        $id_season = $this->request->getPost('id_season');
        $id_association = $this->request->getPost('id_association');
        $id_assoc_season = $this->request->getPost('id_assoc_season');
        $data =  array(
            'id_season' => $id_season,
            'id_association' => $id_association,
            'name' => $name,
            'id_assoc_season' => $id_assoc_season
        );
        //pokud proběhl při updatu i upload nového loga
        if($logo->isValid()) {
            $uploadPath = $this->config->uploadPath;
            $ext = $logo->getClientExtension();
            $shortName = $this->aModel->find($id_association)->short_name;
            $newName = 'logo_'.$shortName.'_'.$id_association.'_'.$id_season.'.'.$ext;
            $logo->move($uploadPath, $newName);
            $data['logo'] = $newName;
        }

        $this->asModel->save($data);
     
        return redirect()->to('svaz/zobrazit/'.$id_association);

    }

    function delete($id_assoc_season) {
        $id_association = $this->asModel->find($id_assoc_season);
        $this->asModel->delete($id_assoc_season);
       
       
        $id = $id_association->id_association;
        
        return redirect()->to('svaz/zobrazit/'.$id); 
    }


}
