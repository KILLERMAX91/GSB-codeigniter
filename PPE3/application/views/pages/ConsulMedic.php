<html>
<head>
    <title>Médicaments</title>
    <link rel="stylesheet" href="<?php echo base_url("asset/css/pagesCss.css"); ?>" />
</head>
<body>

    <div name="droite" style="float:left;width:100%;">
        
            
            <form method="post" action='index' class="form-horizontal">
            <fieldset>
            <legend> M&eacute;dicaments </legend>
            <label class="control-label">Medocs : </label>
            <div class="controls">
                <select name="test">
                    
                    <?php foreach($query->result() as $item) :?>


                    <option>
                        <?php echo $item->MED_NOMCOMMERCIAL;?>
                    </option>

                    <?php endforeach; ?>
                </select>
                <input class="btn" type="submit" value="Choisir" />
            </form>
            
           
           <?php if(isset($_POST['test'])) :
                     
               foreach($query->result() as $item) :
                
                   $testo = $item->MED_NOMCOMMERCIAL;
                   if($testo == $_POST['test']) :?>
                       </br>
                       <form id="formPraticien" class="form-horizontal">
                           <label class="titre"><br />DEPOT LEGAL :</label><label size="5" name="MED_DEPOTLEGAL" ><br /><?php echo $item->MED_DEPOTLEGAL ?></label>
			                <label class="titre"><br />NOM :</label><label size="25" name="MED_NOMCOMMERCIAL" ><br /><?php echo $item->MED_NOMCOMMERCIAL ?></label>
			                <label class="titre"><br />CODE :</label><label size="30" name="FAM_CODE" ><br /><?php echo $item->FAM_CODE ?></label>
			                <label class="titre"><br />COMPOSITION :</label><label size="50" name="MED_COMPOSITION" ><br /><?php echo $item->MED_COMPOSITION ?></label>
			                <label class="titre"><br />EFFETS :</label><label size="19" name="MED_EFFETS" ><br /><?php echo $item->MED_EFFETS ?></label>
			                <label class="titre"><br />CONTRE INDICATION :</label><label size="100" name="MED_CONTREINDIC"  ><br /><?php echo $item->MED_CONTREINDIC ?></label>
			                <!--<label class="titre"><br />PRIX ECHANTILLON :</label><label size="3" name="MED_PRIXECHANTILLON" class="zone" ><br /><?php echo $item->MED_PRIXECHANTILLON ?></label>-->
			                <label class="titre">&nbsp;</label>
		                </form>	
                  <?php endif;
                    endforeach;

                    endif;?>
            
                                        </div>
        </fieldset>
    </div>
</body>
</html>
