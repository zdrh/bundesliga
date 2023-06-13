<?php

$this->extend("layout/master");

$this->section("content");

$sezona = $ligaSezona->start."-".$ligaSezona->finish;
echo heading("Přidat novou skupinu soutěže ".$ligaSezona->league_name_in_season." v sezóně ".$sezona, 1);
echo form_open('soutez/sezona/skupina/create');

$data = array(
    'name' => 'name',
    'id' => 'name',
    'required' => 'required'
);

echo form_input_bs($data, 'mb-3 mt-3 col-4', 'Název skupiny', 'name');

$data = array(
    'name' => 'send',
    'id' => 'send',
    'type' => 'submit',
    'class' => 'btn btn-primary',
    'content' => 'Odeslat'
);
echo form_button($data);
echo form_hidden('id_league_season', $ligaSezona->id_league_season);
echo form_close();

$this->endSection();