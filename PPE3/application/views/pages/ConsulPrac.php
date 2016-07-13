<html> 
<head>
	<title>formulaire PRATICIEN</title>
	<link rel="stylesheet" href="<?php echo base_url("asset/css/pagesCss.css"); ?>" />
</head>
<body>	
	

        <form method="post" action='index' class="form-horizontal">
            <fieldset>
                <legend>Praticiens</legend>
                <label class="control-label">Practics : </label>
            <select name="pract">
                <?php foreach($query as $item) :?>


                <option>
                    <?php echo $item->PRA_NOM.' '.$item->PRA_PRENOM?>
                </option>

                <?php endforeach; ?>
            </select>
            <input class="btn" type="submit" value="Choisir" />
        </form>
        <?php if(isset($_POST['pract'])):
            foreach($query as $item) :
                $testo = $item->PRA_NOM.' '.$item->PRA_PRENOM;
                   if($testo == $_POST['pract']) : ?>
		                <form id="formPraticien">
			                <label class="titre">NUMERO :</label><label size="5" name="PRA_NUM"  ><?php echo $item->PRA_NUM ?></label>
			                <label class="titre">NOM :</label><label size="25" name="PRA_NOM" class="zonee" ><?php echo $item->PRA_NOM ?></label>
			                <label class="titre">PRENOM :</label><label size="30" name="PRA_PRENOM" class="zonee" ><?php echo $item->PRA_PRENOM ?></label>
			                <label class="titre">ADRESSE :</label><label size="50" name="PRA_ADRESSE" class="zonee" ><?php echo $item->PRA_ADRESSE ?></label>
			                <label class="titre">CP :</label><label size="5" name="PRA_CP" class="zonee" ><?php echo $item->PRA_CP ?></label>
			                <label class="titre">COEFF. NOTORIETE :</label><label size="7" name="PRA_COEFNOTORIETE" class="zonee" ><?php echo $item->PRA_COEFNOTORIETE ?></label>
			                <label class="titre">TYPE :</label><label size="3" name="TYP_CODE" class="zonee" ><?php echo $item->TYP_CODE ?></label>
			                <label class="titre">&nbsp;</label><div class="zone">
		                </form>		
                <?php endif;
                    endforeach;
                    endif;?>	

                    </fieldset>

		<!--<form name="formPrecedent" action="afficher" method="POST">
			<input type="hidden" name="lstPrat" value="'.$precedent.'" />
			<input type="submit" value="&lt;" />
		</form>
		<form name="formSuivant" action="afficher" method="POST">
			<input type="hidden" name="lstPrat" value="'.$suivant.'" />
			<input type="submit" value="&gt;" />
		</form>-->
		
	</div>
</div>
</body>
</html>