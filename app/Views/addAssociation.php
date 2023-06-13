
<?php

$this->extend("layout/master");

$this->section("content");
    
    
    echo heading('Přidat svaz', 1);
   
    echo form_open('svaz/create');
    $data = array(
        'name' => 'name',
        'id' => 'name',
        'required' => 'required'
    );
   
    echo form_input_bs($data, 'mb-3 mt-3 col-4', 'Obecný název', 'name');
    $data = array(
        'name' => 'short_name',
        'id' => 'short_name',
        'required' => 'required'
    );
   
    echo form_input_bs($data, 'mb-3 mt-3 col-4', 'Zkratka', 'short_name');
    $data = array(
        'name' => 'founded',
        'required' => 'required',
        'id' => 'founded',
        'min' => $year['assoc_foundation_min'],
        'max' => $year['assoc_foundation_max'],
        'step' => 1
    );
    echo form_input_bs($data, 'mb-3 mt-3 col-4', 'Založení', 'founded', 'number');
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
