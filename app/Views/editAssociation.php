<?php

$this->extend("layout/master");

$this->section("content");
echo heading('Editace svazu', 1);

echo form_open('svaz/update');
    $data = array(
        'name' => 'name',
        'id' => 'name',
        'value' => $svaz->general_name,
        'required' => 'required'
    );
   
    echo form_input_bs($data, 'mb-3 mt-3 col-4', 'Obecný název', 'name');
    $data = array(
        'name' => 'short_name',
        'id' => 'short_name',
        'value' => $svaz->short_name,
        'required' => 'required'
    );
   
    echo form_input_bs($data, 'mb-3 mt-3 col-4', 'Zkratka', 'short_name');
    $data = array(
        'name' => 'founded',
        'id' => 'founded',
        'min' => $year['assoc_foundation_min'],
        'max' => $year['assoc_foundation_max'],
        'step' => 1,
        'value' => $svaz->founded,
        'required' => 'required'
    );
    echo form_input_bs($data, 'mb-3 mt-3 col-4', 'Založení', 'founded', 'number');
    $data = array(
        'name' => 'send',
        'id' => 'send',
        'type' => 'submit',
        'class' => 'btn btn-primary',
        'content' => 'Odeslat'
    );
    echo form_hidden('id_association', $svaz->id_association);
    echo form_hidden('_method', 'PUT');
    echo form_button($data);
    echo form_close();


$this->endSection();

?>