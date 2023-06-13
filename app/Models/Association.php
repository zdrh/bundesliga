<?php

namespace App\Models;
use CodeIgniter\Model;

class Association extends Model {
    //název tabulky, na kterou se model vztahuje    
    protected $table      = 'association';
// primární klíč tabulky, podle něj se vyhledává v metodě find
    protected $primaryKey = 'id_association';
// jestli se při vkládání používá autoinkrementace, pokud nebudeme používat vkládání, nemá to význam
    protected $useAutoIncrement = true;
// v jaké datové strutuře se budou vracet výsledky, object znamená, že se bude vracet pole objektů
    protected $returnType     = 'object';
//jestli se místo opravdového mazání bude pouze nastavovat hodnota ve sloupci označeném v proměnném deleted_at. To bude v případě true, v příapdě false se bude reálně mazat.
    protected $useSoftDeletes = true;
//sloupce v tabulce, se kterými budu dělat databázové operace (vkládání, mazání apod.). Ostatní sloupce měnit nepůjdou
    protected $allowedFields = ['general_name', 'founded', 'short_name'];

// do sloupců s datem vytvoření záznamu, editace nebo smazání se budou vkládat timestampy (true) nebo jiný formát data psecifikovaný v proměnné $DateFormat
    protected $useTimestamps = true;
    protected $dateFormat = 'int';
//název sloupce, kde bude uloženo datum vytvoření záznamu
    protected $createdField  = 'created_at';
// název sloupce s datem poslední editace záznamu
    protected $updatedField  = 'updated_at';
//název sloupce s datem smazání záznamu (pouze pokud $useSoftDeletes je true)
    protected $deletedField  = 'deleted_at';
//validační pravidla sloupců
    protected $validationRules    = [
    'general_name'     => 'required',
    'short_name'        => 'required',
    'founded'     => 'required|greater_than[1895]|less_than[2002]',
    ];
//validační hlášky pro jednotlivá pravidla
    protected $validationMessages = [
        'founded' => [
            'greater_than[1895]' => 'Rok založení musí být po roce 1895.',
            'less_than[2002]' => 'Rok založení musí být před rokem 2002'
        ],
    ];
// jestli se má přeskočit validace při insertech a updatech
    protected $skipValidation     = false;
} 
