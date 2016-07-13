<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(count($listeCompteRendue)!=0){
$attributForm = array('class' => 'form-horizontal', 'id' => 'FormNouveauRendue');
        echo form_open('menu/modifierModifCompRend', $attributForm);
        echo form_fieldset("A finir d'urgence les comptes rendues");
?>
<div class="control-group">
    <label class="control-label" for="inputEmail">Compte Rendue</label>
    <div class="controls">
               <?php 
               
       echo form_dropdown('Rendue', $listeCompteRendue, '', 'class="large" id="selectPrac"'); ?> <button class="btn btn-warning"><i class="icon-warning-sign icon-white"></i> finir</button>
    </div>
</div>
        <?php
        echo form_fieldset_close(); 
        echo form_close();
}
    
if(count($listeCompteRendueValide)!=0){
$attributForm = array('class' => 'form-horizontal', 'id' => 'FormNouveauRendue');
        echo form_open('menu/modifierModifCompRend', $attributForm);
        echo form_fieldset("Voir vos comptes rendues ou les comptes rendues de votre r&eacute;gion");
?>
<div class="control-group">
    <label class="control-label" for="inputEmail">Compte Rendue finie</label>
    <div class="controls">
               <?php 
               
       echo form_dropdown('Rendue', $listeCompteRendueValide, '', 'class="large" id="selectPrac"'); ?> <button class="btn btn-info"><i class="icon-info-sign icon-white"></i> info</button>
    </div>
</div>
        <?php
        echo form_fieldset_close(); 
        echo form_close();
}
    ?>
