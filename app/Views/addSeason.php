
<?php

$this->extend("layout/master");

$this->section("content");
    
   
    echo heading('Přidat sezónu', 1);
    echo form_open('sezona/create');
    $data = array(
        'name' => 'start',
        'id' => 'start',
        'min' => $year['league_season_min'],
        'max' => $year['league_season_max'],
        'step' => 1,
        'required' => 'required',
        'oninput' => 'startFinishSeason()'
    );
    $js = array(
        'oninput' => 'startFinishSeason()'
    );
    echo form_input_bs($data, 'mb-3 mt-3 col-4', 'Začátek', 'start', 'number');
    $data = array(
        'name' => 'finish',
        'id' => 'finish',
        'min' => $year['league_season_min'],
        'max' => $year['league_season_max'],
        'step' => 1,
        'required' => 'required'
        
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
    echo form_close();

$this->endSection();

?>
