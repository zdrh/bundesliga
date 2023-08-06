<?php
namespace App\Libraries;

use CodeIgniter\Model;
use stdClass;

class TransactionLib {

    var $db;
    var $trans;
    function __construct() {
        $this->db = new Model();
        $this->db->setTable('league');
        $this->trans = new stdClass();
    }
    /**
     * $data - pole, které obsahuje sql kod transakcí
     */
    function doTransactions($data) {
        $this->db->transStart();

        foreach($data as $sql) {
            $this->db->query($sql);
        }

        $this->db->transComplete();

    }

    function prepareTransactions($data, $model, $type, $where = array()) {
        $this->trans->data = $data;
        $this->trans->model = $model;
        $this->trans->type = $type;
        $this->trans->where = $where;

        return $this->trans;
        
        
    }

    function doTransactions2($dataForTransaction) {
        $this->db->transStart();
       
        if(is_array($dataForTransaction)){
            foreach($dataForTransaction as $data) {
                $this->makeQuery($data);
            }
        } else {
            $this->makeQuery($dataForTransaction);
        }
        $this->db->transComplete();
        $vysledek = $this->db->transStatus();
        var_dump($vysledek);
        return $vysledek;

    }

    function makeQuery($data) {
        switch ($data->type) {
            case 1:
                //insert
                foreach($data->data as $data) {
                    var_dump($data->model);
                }
                
                break;
            case 2:
                //update
                foreach($data->data as $data) {
                    $data->model->save($data);
                }
                break;
            case 3:
                //delete
                foreach($data->where as $where)
                $data->model->delete($where);
                break;
            default:
                break;
        }
    }
}