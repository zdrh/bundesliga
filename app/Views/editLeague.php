
<?php

$this->extend("layout/master");

$this->section("content");
    
   
    echo heading('Editovat ligu', 1);
    echo form_open('liga/update');
    $data = array(
        'name' => 'name',
        'id' => 'name',
        'value' => $liga->name,
        'required' => 'required'
    );
   
    echo form_input_bs($data, 'mb-3 mt-3 col-4', 'Obecný název', 'level');
    $data = array(
        'name' => 'level',
        'id' => 'level',
        'min' => 0,
        'max' => 4,
        'step' => 1,
        'value' => $liga->level,
        'required' => 'required'
    );
    echo form_input_bs($data, 'mb-3 mt-3 col-4', 'Úroveň', 'level', 'number');

    $active = array(
        '' => '--- Vyber ---',
        0 => 'neaktivní',
        1 => 'aktivní'
    );
    $data = array(
        'id' => 'active',
        'required' => 'required'
    );
    $disabled = array(
        ''
    );
    echo form_dropdown_bs('active', $active, 'mb-3 mt-3 col-4', 'Aktivní soutěž','active',$liga->active, '' , $data);
    $data = array(
        'id' => 'id_association',
        'required' => 'required'
    );
    $disabled = array(
        ''
    );
    echo form_dropdown_bs('id_association', $svazy, 'mb-3 mt-3 col-4', 'Název svazu','id_association',$liga->id_association, '' , $data);

    $data = array(
        'name' => 'send',
        'id' => 'send',
        'type' => 'submit',
        'class' => 'btn btn-primary',
        'content' => 'Odeslat'
    );
    echo form_button($data);
    echo form_hidden('id_league', $liga->id_league);
    echo form_hidden('_method', 'PUT');
    echo form_close();

$this->endSection();

?>
