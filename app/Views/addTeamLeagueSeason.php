<?php
$this->extend("layout/master");

$this->section("content");

echo heading("Přidat tým do sezóny", 1);


$hidden = array(

);
//'soutez/sezona/'.$sezona->id_league_season
echo form_open('soutez/sezona/teams');
$value = $sezona->start."-".$sezona->finish;
$data = array(
    'disabled' => 'disabled',
    'value' => $value,
    'name' => 'season',
    'id' => 'season' 
);

echo form_input_bs($data, 'mb-3 mt-3 col-4', 'Sezóna', 'season');
var_dump($sezona);
$data = array(
    'disabled' => 'disabled',
    'value' => $sezona->league_name_in_season,
    'name' => 'league',
    'id' => 'league' 
);

echo form_input_bs($data, 'mb-3 mt-3 col-4', 'Soutěž', 'league');

$disabled = array('');
$attributes = array(
    'id' => 'teamSeason',
    'class' => 'form-control teamSeason',
    'multiple' => 'multiple'
    
);


echo form_dropdown_bs_class('teamSeason[]', $tymyAvailable, 'mb-3 mt-3 col-4', 'Vybrat týmy', 'teamSeason', '', $disabled, $attributes);
$data = array(
    'name' => 'send',
    'id' => 'send',
    'type' => 'submit',
    'class' => 'btn btn-primary',
    'content' => 'Odeslat'
);
echo form_hidden('id_league_season', $idSezona);
echo form_button($data);
echo form_close();
?>
<script>
    $(document).ready(function() {
    $('.teamSeason').select2();
    });

</script>
<?php
$this->endSection();