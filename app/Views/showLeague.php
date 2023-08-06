<?= $this->extend('layout/master'); ?>

<?= $this->section('content'); ?>

<?php

echo heading($liga->name, 1);


?>
<div class="row">
  <div class="col-4">
  <div class="card">
    
      <h3 class="card-header">Info o lize</h3>
   
    <div class="card-body">

      <p class="card-text"><b>Úroveň: </b><?= $liga->level; ?></p>
      <?php
      if ($liga->active) {
      ?>
        <p class="text-success fw-bold">Aktivní soutěž</p>
      <?php
      } else {
      ?>
        <p class="text-danger fw-bold">Neaktivní soutěž</p>
      <?php
      }
      ?>
      <p class="card-text"><b>Organizátor: </b><?= $liga->general_name; ?></p>
      <p class="card-text"><b>První sezóna: </b><?= $sezony[$pocet_sezon - 1]->start . "/" . $sezony[$pocet_sezon - 1]->finish; ?></p>
      <p class="card-text"><b>Poslední sezóna: </b><?= $sezony[0]->start . "/" . $sezony[0]->finish; ?></p>
    </div>
  </div>
  </div>
  <div class="offset-2 col-4">
  <div class="card">
      <h3 class="card-header">Sezóny ligy</h3>
   <div class="card-body">
    <?php
   
      foreach($sezony as $sezona) {
       echo anchor('soutez/'.$sezona->link_name.'//sezona/'.$sezona->start.'-'.$sezona->finish.'/'.$sezona->id_league_season, $sezona->start.'-'.$sezona->finish);
       echo " ";
      }
    ?>
   </div>

  </div>
</div>
</div>

<?= $this->endSection(); ?>