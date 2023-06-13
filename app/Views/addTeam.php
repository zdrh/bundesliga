<?php
$this->extend("layout/master");

$this->section("content");
echo heading('Přidat klub', 1);
$data = array(
    'id' => 'addTeam'
);
echo form_open('tym/create', $data);
    $data = array(
        'name' => 'name[]',
        'id' => 'name',
        'required' => 'required'
    );
   
    echo form_input_bs($data, 'mb-3 mt-3 col-4', 'Obecný název klubu', 'name');
    $formForJS = form_input_bs($data, 'mb-3 mt-3 col-4', 'Obecný název klubu', 'name', 'text', false);
   
    $data = array(
        'name' => 'short_name[]',
        'id' => 'short_name',
        
    );
   
    echo form_input_bs($data, 'mb-3 mt-3 col-4', 'Krátký název klubu', 'short_name');
    $formForJS .= form_input_bs($data, 'mb-3 mt-3 col-4', 'Krátký název klubu', 'short_name','text', false);
    
    $data = array(
        'name' => 'founded[]',
        'required' => 'required',
        'id' => 'founded',
        'min' => $year['team_foundation_min'],
        'max' => $year['team_foundation_max'],
        'step' => 1
    );
    echo form_input_bs($data, 'mb-3 mt-3 col-4', 'Založení', 'founded', 'number');
    $formForJS .= form_input_bs($data,'mb-3 mt-3 col-4', 'Založení', 'founded', 'number', false);
    $data = array(
        'name' => 'dissolve[]',
        'id' => 'dissolve',
        'min' => $year['team_dissolve_min'],
        'max' => $year['team_dissolve_max'],
        'step' => 1,
        'class' => 'dissolve form-control'
    );
    echo form_input_bs_class($data, 'mb-3 mt-3 col-4', 'Rozpuštění', 'dissolve', 'number');
    $formForJS .= form_input_bs_class($data, 'mb-3 mt-3 col-4', 'Rozpuštění', 'dissolve', 'number', false);
    $data = array(
        'id' => 'follower',
        'disabled' => 'disabled'
       
    );
   
    echo form_dropdown_bs('follower[]', $tymy, 'mb-3 mt-3 col-4', 'Nástupce','follower','','', $data);
    $formForJS .= form_dropdown_bs('follower[]', $tymy, 'mb-3 mt-3 col-4', 'Nástupce','follower','','', $data, false);
    echo "<div id='div-next'></div>\n";

    $data = array(
        'name' => 'add-next',
        'id' => 'add-next',
        'type' => 'button',
        'class' => 'btn btn-primary me-3',
        'content' => 'Přidat další'
    );
    echo form_button($data);

    $data = array(
        'name' => 'send',
        'id' => 'send',
        'type' => 'submit',
        'class' => 'btn btn-primary',
        'content' => 'Odeslat'
    );
    echo form_button($data);

    echo form_close();



?>

<script>
    let inputs2;
    let inputs;
    inputs = document.querySelectorAll("input, select");
    let pocet = 0;
    const btn = document.getElementById('add-next');
    btn.addEventListener('click', function(){

        pocet++;
        newdiv = document.createElement('div');
        value = '<?= $formForJS; ?>';
        newdiv.innerHTML = '<hr>'+value;
        document.getElementById('div-next').appendChild(newdiv);
        divName = 'newdiv'+ pocet;
        newdiv.setAttribute('id', divName);
        const form = document.forms['addTeam'];

        let pocetPrvku = document.getElementById('addTeam').elements.length;
        for(i = 0; i<pocetPrvku; i++) {
            let poradi = Math.floor(i/5)+1;
            id = document.getElementById('addTeam').elements[i].getAttribute('id');



            if(id == 'dissolve') {
                newId = 'dissolve-'+poradi;
                document.getElementById('addTeam').elements[i].setAttribute('id', newId);
            }

            if(id == 'follower') {
                newId = 'follower-'+poradi;
                document.getElementById('addTeam').elements[i].setAttribute('id', newId);
            }

            
        };
        
        inputs2 = document.getElementsByTagName('input');
    });


  inputs2 = document.getElementsByTagName('input');
  console.log(inputs2.length);

  for(i=0;i<inputs.length-1;i++) {
    e = inputs2[i];
    
    e.addEventListener("click", display(e));
}

function display(e) {
    console.log(e.id);
}
 


  /*for(i=0; i<inputs2.length; i++) {
    e = inputs2.item(i);
    console.log(e.getAttribute('id'));
    e.addEventListener('keyup', function(){
            console.log(e.id);
    });*/
    /*inputs2.item(i).addEventListener('keyup', function(){
        console.log(inputs2.item(i).getAttribute('id'));
    }); */
  
  /*inputs2.forEach(function(node, index) {
    node.addEventListener('keyup', function() {
        console.log(node.id);
    });
   });*/


/*
    input.addEventListener('input', function(){
        document.getElementById('follower').disabled = false;
    });

 */

 

    
    

    
    


</script>

<?php

$this->endSection();