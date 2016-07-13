<?php
?>
<html>
	<head>
	<link rel="stylesheet" href="<?php echo base_url("asset/css/include.css"); ?>" />
	<link rel="stylesheet" href="<?php echo base_url("asset/css/pagesCss.css"); ?>" />
        <link rel="stylesheet" href="<?php echo base_url("asset/bootstrap/css/bootstrap.min.css"); ?>">
	<link rel="stylesheet" href="<?php echo base_url("asset/jquery-ui-1.11.4.custom/jquery-ui.structure.min.css"); ?>" />
	<link rel="stylesheet" href="<?php echo base_url("asset/jquery-ui-1.11.4.custom/jquery-ui.min.css"); ?>" />
	<link rel="stylesheet" href="<?php echo base_url("asset/jquery-ui-1.11.4.custom/jquery-ui.theme.min.css"); ?>" />
	
        <script src="<?php echo base_url("asset/js/jquery.js"); ?>"></script>
        <script src="<?php echo base_url("asset/js/jqueryUI.js"); ?>"></script>
        <script src="<?php echo base_url("asset/bootstrap/js/bootstrap.min.js"); ?>"></script>
	<title><?php echo $titre;?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	</head>
	<body>
            <!--<style>
                body {

background-image:url(<?php echo base_url("asset/img/gsb.png"); ?>);
}
            </style>-->
	<div class="barreHaut">
		
		<?php 
		/*
		$attributes = array('class' => 'login', 'id' => 'login');
		echo form_open('menu/deconnect', $attributes);
		$data = array(
                                'class' => 'btn btn-small',
				'value' => 'Déconnexion'
				);
		echo form_submit($data);
		echo form_close();*/
		?>
                <a id="lienDeconnect" class='btn btn-inverse btn-small' href="<?php echo base_url("menu/deconnect"); ?>">Déconnexion <i class="icon-off icon-white"></i></a>
                <span id='infoUtilisateur' style="top:60px;">
                <h2>Bienvenue <?php echo $this->session->userdata('nom')." ".$this->session->userdata('prenom')." ( ".$this->session->userdata('titre')." )";?></h2>
                </span>
        
        
       

                <span>
            <ul style='position: relative;left:200px;bottom:10px;' class="nav nav-pills">
                <li><a href="<?php echo site_url('menu/index') ?>">Accueil <i class=" icon-home"></i></a></li>
                <?php 
	                $tab = $this->session->userdata("arrayRole");
	                $i=0;
	                while($i<count($tab) && $tab[$i]!="Visiteur"){
	                	$i++;
	                }
	                $visiteur = false;
	                if($i<count($tab)){
	                	$visiteur = true;
	                }
                if($visiteur){ ?>
                	<li><a href="<?php echo site_url('menu/NouvCompRend') ?>">Nouveau Compte-Rendu</a></li>
                <?php } ?>
                <li><a href="<?php echo site_url('menu/VoirModifCompRend') ?>">Consulter/Modifier Compte-Rendu</a></li>
                <li><a href="<?php echo site_url('practicien/index') ?>">Consulter Practicien</a></li>
                <li><a href="<?php echo site_url('medoc/index') ?>">Consulter Médicament</a></li>
            <?php if($this->session->userdata('titre') == "Délégué") : ?>
                <li><a href="<?php echo site_url('menu/ConsulNouv') ?>">Consulter Nouveau CR</a></li>
                <li><a href="<?php echo site_url('menu/ConsulHisto') ?>">Consulter Historique</a></li>
            <?php endif; ?>
            </ul>
                </span>

	</div>
            <script>
            var refreshIntervalId = null;
            //BOUCLE DE COULEUR
            function megaSalade(){
                var i=0;
                refreshIntervalId = setInterval(function(){ 
	
                   
                        switch(i%5){
                                case 0:
                                        $("body").css("backgroundColor", "#FF55FF");
                                break;
                                case 1:
                                        $("body").css("backgroundColor", "#3498DB");
                                break;
                                case 2:
                                        $("body").css("backgroundColor", "#FF0000");
                                break;
                                case 3:
                                        $("body").css("backgroundColor", "#00FF00");
                                break;
                                case 4:
                                        $("body").css("backgroundColor", "#FFFF00");
                                break;
                        }
                        i=i+1;
                    
                }, 40);
                
            }
         $( document ).ready(function() {
            var tabEnter = []; //tableau de touche
            
            var vert = [[86,69,82,84],"#00FF00"];
            var jaune = [[74,65,85,78,69],"#FFFF00"];
            var noir = [[78,79,73,82],"#000000"];
            var rouge = [[82,79,85,71,69],"#FF0000"];
            var rose = [[82,79,83,69],"#FF22FF"];
            var blanc = [[66,76,65,78, 67],"#FFFFFF"];
            var bleu = [[66,76,69,85],"#0000FF"];
            var salade = [[83,65,76,65, 68, 69], "salade"]; //LA SALADE DE LA MORT QUI TUE
            var gsb = [[71, 83, 66], "gsb"];
            var puissance = [[80, 85, 73, 83, 83, 65, 78, 67, 69], "puissance"];
            var tab = [vert, rouge, rose, blanc, salade, bleu, jaune, noir, gsb, puissance];
            $(this).keydown(function( event ) {
               tabEnter.push(event.keyCode);
               console.log(event.keyCode);
               $.each( tab, function( index, value ){
                    var couleur = value[0].length;
                    var tabTotal = tabEnter.length;
                   
                    var i = couleur-1;
                    var x = 1;
                    
                    if(tabTotal>=couleur){
                        
                        while(i>=0 && value[0][i]===tabEnter[tabTotal-x]){
                            i = i - 1;
                            x = x + 1;
                        }
                        
                        if(i===-1){
                            switch(value[1]){
                                case "salade":
                                    megaSalade();
                                     $("body").css('background-image', 'none');
                                break;
                            case "gsb":
                                $("body").css('background-color', '#FFFFFF');
                                $('body').css("background-image", "url(<?php echo base_url("asset/img/puissance.png"); ?>)");
                               
                                break;
                            case "puissance":
                                $("body").css('background-color', '#FFFFFF');
                                $('body').css("background-image", "url(<?php echo base_url("asset/img/puissance.gif"); ?>)");
                            break;
                            default:
                                clearInterval(refreshIntervalId);
                                $('body').css("background-color", value[1]);
                                $("body").css('background-image', 'none');
                            }
                            /*if(value[1]!=="salade"){
                                clearInterval(refreshIntervalId);
                                $('body').css("background-color", value[1]);
                            }else{
                                megaSalade();
                            }*/
                            
                            tabEnter = [];
                        }   
                    }
               });
            });
         });
    </script>
	<div id='espace-barreHaut'></div>
	<div id="millieuBarre"></div>


	