<?php

$this->extend("layout/master");

$this->section("content");

echo heading ('Přidat novou sezónu ligy',1);


echo form_open_multipart('sezona/liga/create');
$value = $svazSezona->start."-".$svazSezona->finish;
$data = array(
    'name' => 'season',
    'id' => 'season',
    'disabled' => 'disabled',
    'value' => $value
);


echo form_input_bs($data, 'mb-3 mt-3 col-4', 'Sezóna', 'season', 'text');
$value = $svazSezona->associationName." (".$svazSezona->general_name."-".$svazSezona->short_name.")";
$data = array(
    'name' => 'association',
    'id' => 'association',
    'disabled' => 'disabled',
    'value' => $value
);

echo form_input_bs($data, 'mb-3 mt-3 col-6', 'Svaz', 'association', 'text');

if($ligyDispozici == 1) {
    echo "<p>Všechny ligy tohoto svazu pro tuto sezónu jsou už založeny.</p>";
    echo "<p>".anchor('svaz/zobrazit/'.$svazSezona->id_association, 'Sezony pro svaz '.$svazSezona->associationName);

} else {



    $data = array(
    'id' => 'id_league',
     'required' => 'required'
    );
    $disabled = array(
     ''
    );
    echo form_dropdown_bs('id_league', $liga, 'mb-3 mt-3 col-6', 'Obecný název ligy','id_league','', $disabled , $data);

    $data = array(
        'name' => 'league_name',
        'id' => 'league_name',
        'required' => 'required'
    );

    echo form_input_bs($data, 'mb-3 mt-3 col-6', 'Název ligy v sezóně', 'league_name', 'text');


    $data = array(
        'id' => 'general_button',
        'type' => 'button',
        'class' => 'btn btn-primary',
        'content' => 'Použít obecný název'
    );    
    //$button = '<button id=\'general_button\' type=\'button\' class=\'btn btn-primary\'>Použít obecný název ligy</button>';
    echo form_button($data)."\n";

    $groups = array(
        0 => '--- Vyber ---',
        1 => 'nemá',
        2 => 'má'
    );
    $data = array(
        'id' => 'groups',
        'required' => 'required'
    );
    $disabled = array(
        0
    );
    echo form_dropdown_bs('groups', $groups, 'mb-3 mt-3 col-6', 'Má skupiny?','groups','', $disabled, $data);
    echo "<div id='groups_form'></div>\n";


    $data_button_add = array(
        'name' => 'add_group',
        'id' => 'add_group',
        'type' => 'button',
        'class' => 'btn btn-primary',
        'content' => 'Přidat další skupinu',
        'hidden' => 'hidden'
    );
    echo form_button($data_button_add);
    $data = array(
        'name' => 'logo_league',
        'id' => 'logo_league',
        'required' => 'required',
        'accept' => '.jpg, .png'
    );

  
    echo form_upload_bs($data, 'mb-3 mt-3 col-6', 'Logo ligy', 'logo_league');


    $data = array(
        'name' => 'send',
        'id' => 'send',
        'type' => 'submit',
        'class' => 'btn btn-primary',
        'content' => 'Odeslat'
    );
    echo form_button($data);
    echo form_hidden('id_assoc_season', $svazSezona->id_assoc_season);

}
echo form_close();
$data_group = array(
    'name' => 'group_name[]',
    'id' => 'group_name',
    'required' => 'required'
);




?>
<script>
    
    
    document.getElementById('general_button').addEventListener('click', function(){
                
                element = document.getElementById('id_league');
                
                idLeague = element.options[element.selectedIndex].value;
                nameLeague = element.options[element.selectedIndex].text;
                if(idLeague == '') {
                    nameLeague = '';
                }
                
                addValue(nameLeague, 'league_name');
            });

    document.getElementById('groups').addEventListener('change', function(){
       
       //zobrazím tlačítko přidat
        elem = document.getElementById('add_group');
        elem.hidden = false;
        //najdu si rozbalovací nabídku, zjistím její hodnotu a pokud bude rovna "má skupiny", tak vytvořím políčko pro další skupiny
        element = document.getElementById('groups');
        div = document.getElementById('groups_form');
        groups = element.options[element.selectedIndex].value;
        if(groups == 2) {
            value = "<?php echo form_input_bs($data_group,'mb-3 mt-3 col-6', 'Název skupiny', 'group_name[]','text', false); ?>";
            
            newdiv = document.createElement('div');
            newdiv.innerHTML = value;
            document.getElementById('groups_form').appendChild(newdiv);
            newdiv.setAttribute('id', 'newdiv');
           
            
            
        }
    });
    document.getElementById('add_group').addEventListener('click', function(){
            value = "<?php echo form_input_bs($data_group,'mb-3 mt-3 col-6', 'Název skupiny', 'group_name[]','text', false); ?>";
            newdiv = document.createElement('div');
            newdiv.innerHTML = value;
            document.getElementById('groups_form').appendChild(newdiv);
            newdiv.setAttribute('id', 'newdiv');
         
           
    });


    function addValue(value, elementId) {
        const elem = document.getElementById(elementId);
        elem.setAttribute("value", value);
   
    
}
</script>

<?php
$this->endSection();