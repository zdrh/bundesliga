<?php
$this->extend("layout/master");

$this->section("content");
//var_dump($ligaSezona);
echo heading('Editace soutěže ' . $ligaSezona->league_name_in_season . " v sezóně " . $ligaSezona->start . "-" . $ligaSezona->finish, 1);
echo form_open_multipart('soutez/sezona/update');


$value = $ligaSezona->start . "-" . $ligaSezona->finish;
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
    'name' => 'logoDiv',
    'id' => 'logoDiv',
    'accept' => '.jpg, .png'
);

$imgAtr = array(
    'width' => 150
);
echo div(img(base_url($uploadPath . $ligaSezona->logo), '', $imgAtr), $data);


$data = array(
    'name' => 'logo',
    'id' => 'logo',
    'accept' => '.jpg, .png'
);
echo form_upload_bs($data, 'mb-3 mt-3 col-4', 'Logo soutěže', 'logo', 'file');
$data = array(
    'class' => 'mb-3 mt-3 col-4'
);

$selected = array($ligaSezona->groups);

$data = array(
    'id' => 'groups',
    'required' => 'required'
);
$skupiny = array(1 => "nemá skupiny", 2 => "má skupiny");

echo form_dropdown_bs('groups', $skupiny, 'mb-3 mt-3 col-4', 'Skupiny', 'groups', $selected, '', $data);

$data_group = array(
    'name' => 'group_name[]',

    'required' => 'required'
);

echo "<div id='groups_form'>";
// pokud má skupiny, tak je vypíšu
if ($ligaSezona->groups == 2) {
    $atr = array('class' => 'newdiv');

    foreach ($groups as $group) {
        $data_group['value'] = $group->groupname;
        $data_group['id'] = $group->id_league_season_group;
        echo div(form_input_bs($data_group, 'mb-3 mt-3 col-6', 'Název skupiny', 'group_name[]', 'text'), $atr);
    }
}
echo "</div>\n";
$data_button_add = array(
    'name' => 'add_group',
    'id' => 'add_group',
    'type' => 'button',
    'class' => 'btn btn-primary me-3',
    'content' => 'Přidat další skupinu'
);
if ($ligaSezona->groups == 1) {
    $data_button_add = array(
        'hidden' => 'hidden'
    );
}

echo form_button($data_button_add);


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


?>
<script>
    let counter = 0;
    document.getElementById('groups').addEventListener('change', function() {
        //zobrazím tlačítko přidat
        elem = document.getElementById('add_group');
        elem.hidden = false;
        //najdu si rozbalovací nabídku, zjistím její hodnotu a pokud bude rovna "má skupiny", tak vytvořím políčko pro další skupiny
        element = document.getElementById('groups');
        div = document.getElementById('groups_form');
        groups = element.options[element.selectedIndex].value;
        if (groups == 2) {
            value = "<?php echo form_input_bs($data_group, 'mb-3 mt-3 col-6', 'Název skupiny', 'group_name[]', 'text', false); ?>";

            newdiv = document.createElement('div');
            newdiv.innerHTML = value;
            document.getElementById('groups_form').appendChild(newdiv);
            newdiv.setAttribute('class', 'newdiv');
        } else {
            elem.hidden = true;
            divGroups = document.getElementById('groups_form');
            count = divGroups.children.length;
            for (let i = 0; i < count; i++) {
                divGroups.children[0].remove();
            }
        }
    });
    document.getElementById('add_group').addEventListener('click', function() {
        value = "<?php echo form_input_bs($data_group, 'mb-3 mt-3 col-6', 'Název skupiny', 'group_name[]', 'text', false); ?>";
        newdiv = document.createElement('div');
        newdiv.innerHTML = value;
        document.getElementById('groups_form').appendChild(newdiv);
        newdiv.setAttribute('class', 'newdiv');


    });


    function addValue(value, elementId) {
        const elem = document.getElementById(elementId);
        elem.setAttribute("value", value);


    }
</script>
<?php
echo form_close();



$this->endSection();
