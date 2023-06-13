<?php

$this->extend("layout/master");

$this->section("content");

echo heading('Editovat sezona', 1);
echo form_open('sezona/update');
$data = array(
    'name' => 'start',
    'id' => 'start',
    'min' => 1945,
    'max' => 2025,
    'step' => 1,
    'value' => $sezona->start,
    'required' => 'required'
);
$js = array(
    
);
echo form_input_bs($data, 'mb-3 mt-3 col-4', 'Začátek', 'start', 'number');

$data = array(
    'name' => 'finish',
    'id' => 'finish',
    'min' => 1945,
    'max' => 2025,
    'step' => 1,
    'value' => $sezona->finish,
    'required' => 'required',
    'oninput' => 'startFinishSeason()'
);
echo form_input_bs($data, 'mb-3 mt-3 col-4', 'Konec', 'finish', 'number');

$data = array(
    'name' => 'send',
    'id' => 'send',
    'type' => 'submit',
    'class' => 'btn btn-primary',
    'content' => 'Odeslat'
);
echo form_button($data);


echo form_hidden('id_season', $sezona->id_season);
echo form_hidden('_method', 'PUT');
echo form_close();
$this->endSection();