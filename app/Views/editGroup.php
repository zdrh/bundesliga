<?php

$this->extend("layout/master");

$this->section("content");

$sezona = $ligaSezona->start."-".$ligaSezona->finish;
echo heading("Editovat skupinu ".$group->groupname." soutěže ".$ligaSezona->league_name_in_season." v sezóně ".$sezona, 1);
echo form_open('soutez/sezona/skupina/update');

$data_group = array(
    'name' => 'group_name',
    'id' => 'name',
    'required' => 'required',
    'value' => $group->groupname
);

echo form_input_bs($data_group, 'mb-3 mt-3 col-4', 'Název skupiny', 'name');


$data = array(
    'name' => 'send',
    'id' => 'send',
    'type' => 'submit',
    'class' => 'btn btn-primary',
    'content' => 'Odeslat'
);
echo form_button($data);
echo form_hidden('id_league_season_group', $group->id_league_season_group);
echo form_hidden('_method', 'PUT');
echo form_close();

$this->endSection();