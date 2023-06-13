<?php
$this->extend("layout/master");

$this->section("content");
//var_dump($ligaSezona);
echo heading('Editace soutěže '.$ligaSezona->league_name_in_season." v sezóně ".$ligaSezona->start."-".$ligaSezona->finish, 1);
echo form_open_multipart('soutez/sezona/update');


    $value = $ligaSezona->start."-".$ligaSezona->finish;
    $data = array(
        'name' => 'season',
        'id' => 'season',
        'disabled' => 'disabled',
        'value' => $value
    );


echo form_input_bs($data, 'mb-3 mt-3 col-4', 'Sezóna', 'season', 'text');

    $data = array(
        'name' => 'league_name',
        'id' => 'league_name',
        'value' => $ligaSezona->league_name_in_season,
        'required' => 'required'
    );


echo form_input_bs($data, 'mb-3 mt-3 col-4', 'Soutěž', 'league_name', 'text');


    $data = array(
    'name' => 'logo',
    'id' => 'logo',
    'accept' => '.jpg, .png'
    );

echo form_upload_bs($data, 'mb-3 mt-3 col-4', 'Logo soutěže', 'logo', 'file', $extra);
    $data = array(
    'class' => 'mb-3 mt-3 col-4'
);
echo div($ligaSezona->logo, $data);

    $selected = array($ligaSezona->groups);

    $data = array(
    'id' => 'groups',
    'required' => 'required'
);
    $skupiny = array(1 => "nemá skupiny", 2 => "má skupiny");

echo form_dropdown_bs('groups', $skupiny, 'mb-3 mt-3 col-4', 'Skupiny','groups',$selected, $sezonySvazu , $data);
    
    $data = array(
        'name' => 'send',
        'id' => 'send',
        'type' => 'submit',
        'class' => 'btn btn-primary',
        'content' => 'Odeslat'
    );
echo form_button($data);

echo form_hidden('_method', 'PUT');
echo form_hidden('id_league_season', $ligaSezona->id_league_season);

/*$pocet = Count($liga);
foreach($liga as $key => $row) {
    if($key != 0) {
        echo "<hr>";
    }
    if($pocet != 1) {
        echo heading($row->groupname, 2);
        $data_group = array(
            'name' => 'group_name[]',
            'id' => 'group_name',
            'required' => 'required',
            'value' => $row->groupname
        );
        echo form_input_bs($data_group,'mb-3 mt-3 col-6', 'Název skupiny', 'group_name[]','text');
        $data = array(
            'name' => 'id_league_season_group[]',
            'value' => $row->id_league_season_group
        );
        echo form_hidden($data_group);
    } else {
        $data = array(
            'name' => 'league_name',
            'id' => 'league_name',
            'required' => 'required',
            ''
        );
    }

    
}
*/
echo form_close();
$this->endSection();