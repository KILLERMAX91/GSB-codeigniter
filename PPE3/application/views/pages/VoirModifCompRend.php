<html>
<head>
    <title>formulaire VISITEUR</title>
    <link rel="stylesheet" href="<?php echo base_url("asset/css/pagesCss.css"); ?>" />
</head>
<body>
    
    <div name="droite" style="float:left;width:100%;">
        <div name="bas" style="margin : 10 2 2 2;clear:left;background-color:33b5e5;color:white;height:100%;">
            <h1> Visiteurs </h1>
            <form name="formListeRecherche" method="post" action="VoirModifCompRend">
                <select name="lstVisiteur" class="zone"><option value="a131">Villechalane</option></select>
                <input type="submit" value="chercher" />
            </form>

            <form name="formVISITEUR" method="post" action="formVISITEUR.php">
                <label class="titre">NOM :</label><input type="text" size="25" name="VIS_NOM" class="zone" />
                <label class="titre">PRENOM :</label><input type="text" size="50" name="Vis_PRENOM" class="zone" />
                <label class="titre">ADRESSE :</label><input type="text" size="50" name="VIS_ADRESSE" class="zone" />
                <label class="titre">CP :</label><input type="text" size="5" name="VIS_CP" class="zone" />
                <label class="titre">VILLE :</label><input type="text" size="30" name="VIS_VILLE" class="zone" />
                <label class="titre">SECTEUR :</label><input type="text" size="1" name="SEC_CODE" class="zone" />
                <label class="titre">&nbsp;</label><input class="zone" type="button" value="&lt;"></input><input class="zone" type="button" value="&gt;"></input>
            </form>
        </div>
    </div>
</body>
</html>