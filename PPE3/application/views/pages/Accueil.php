
    <div name="droite" style="float:left;width:100%;">
        <div id="titre">GSB Compte-Rendu & Cie!</div>
    </div>
    <?php
    $attributForm = array('class' => 'form-horizontal', 'style' => 'position:relative;left:35%;top:50px;width:600px;');
        echo form_open('menu/regionChoisie', $attributForm);
       
?>
<div style="position:relative;" class="control-group">
    <label class="control-label" for="inputEmail">Choisissez votre regions</label>
    <div class="controls">
               <?php 
               
       echo form_dropdown('Region', $lesRegions, '', 'class="large" id="selectPrac"'); ?> <button class="btn">envoyer</button>
    </div>
</div>
<?php
    
    echo form_close();
?>
