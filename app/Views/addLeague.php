
<?php

$this->extend("layout/master");

$this->section("content");
    
   
    echo heading('Přidat ligu', 1);
    echo form_open('liga/create');
    $data = array(
        'name' => 'name',
        'id' => 'name',
        'required' => 'required'
    );
   
    echo form_input_bs($data, 'mb-3 mt-3 col-4', 'Obecný název', 'level');
    $data = array(
        'name' => 'level',
        'required' => 'required',
        'id' => 'level',
        'min' => 0,
        'max' => 4,
        'step' => 1
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
    echo form_dropdown_bs('active', $active, 'mb-3 mt-3 col-4', 'Aktivní soutěž','active','', '' , $data);
    $data = array(
        'id' => 'id_association'
    );
    $disabled = array(
        ''
    );
    echo form_dropdown_bs('id_association', $svazy, 'mb-3 mt-3 col-4', 'Název svazu','id_association','', '' , $data);

    $data = array(
        'name' => 'send',
        'id' => 'send',
        'type' => 'submit',
        'class' => 'btn btn-primary',
        'content' => 'Odeslat'
    );
    echo form_button($data);
    echo form_close();

$this->endSection();

?>
