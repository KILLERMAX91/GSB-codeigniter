<?php if(count($listeCompteRendue)!=0){
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
    ?>
<!--  <title>formulaire RAPPORT_VISITE</title>-->
	
    
        
    <script language="javascript">
		function selectionne(pValeur, pSelection,  pObjet) {
			//active l'objet du formulaire si la valeur sélectionnée (pSelection) est égale à la valeur attendue (pValeur)
			if (pSelection==pValeur) { 

                            $("#disabledInput").prop('disabled', false);
			}
			else { 
                            
                            $("#disabledInput").prop('disabled', true);
                        }
		}
                
	</script>
    <script language="javascript">
       
        //genere la liste des medicament sous forme JSON;
        var json = {
                "Medicament":[
                    <?php
                    foreach ($get_medoc->result() as $row){
                        echo '{"MED_DEPOTLEGAL":"'.$row->MED_DEPOTLEGAL.'", "MED_NOMCOMMERCIAL":"'.$row->MED_NOMCOMMERCIAL.'"},';
                    }
                     ?>
              
                ]
            }
            
        //recupere select
        function getSelect(){
            var chaine = "<select class='medocTab medicamentTab' name='medoc[]'>"; //plusieur select
            //recupere object Medicament
            $.each(json, function (key, medoc) {
                
                $.each(medoc, function (index, data) {
                    
                    chaine = chaine + "<option value='"+data.MED_DEPOTLEGAL+"'>"+data.MED_NOMCOMMERCIAL+"</option>";
                });
            })
            chaine = chaine + "</select>";
            return chaine;
        }
        //une Ligne de la table tableMedoc 
        function getTr(){
            var chaine = "<tr class='ligneTr'>";
            chaine = chaine + "<td>"+getSelect()+" <span class='btn btn-info medoc'><i class='icon-info-sign icon-white'></i></span></td>";
            chaine = chaine + '<td><input class="qtMedocTab" style="position:relative;height:25px;" name="qtMedoc[]" type="number" id="replyNumber" min="0" data-bind="value:replyNumber" /></td>';
            chaine = chaine + '<td><span style="width:50px;" class="btn btn-inverse suppTr"> <i class="icon-trash icon-white"></i> </span></td>';
            chaine = chaine + "</tr>";
            return chaine;
        }
        
        $( document ).ready(function() {
            $( ".datepicker" ).datepicker({
                changeMonth: true,
                changeYear: true,
                dayNames: ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi" ],
                dayNamesMin: ["Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa" ],
                dayNamesShort: ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam" ],
                gotoCurrent: true,
                monthNames: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Decembre" ],
                monthNamesShort: ["Jan", "Fev", "Mar", "Avr", "Mai", "Juin", "Juil", "Aoû", "Sep", "Oct", "Nov", "Dec" ],
                prevText: "Préc",
                nextText: "Suiv",
                dateFormat: 'dd/mm/yy',
                showOn: "button",
                buttonText: '<i class="icon-calendar"></i>'
            }).next(".ui-datepicker-trigger").addClass("btn");
            
            /*$("#date").datepicker({
                showOn: "button",
                dateFormat: 'dd/mm/yy'
            });*/
            //Premiere ligne TR des medoc
            
            //Ajout Ligne TR des medoc
            $( "#ajout" ).click(function() {
                
                if($( ".suppTr" ).length==0){
                    $('#tableMedoc thead:last').after("<tbody>"+getTr()+"</tbody>");
                }else{
                    $('#tableMedoc tr:last').after(getTr());
                }
                $( ".suppTr" ).click(function() {
                
                   
                    suppLigne($( ".suppTr" ).index(this));
                    //le probleme il faut reactualiser a chaque fois
                    event.stopPropagation();
                });
                $( ".medoc" ).click(function(e) {
                    var ind = $( ".medoc" ).index(this);
                    var element = $(".medicamentTab:eq("+ind+")");
                    $.ajax({
                    type: 'POST',
                    data: { medoc: element.val() },
                    dataType: 'json',
                    url: "../medoc/unMedicament",
                    timeout: 5000,
                    success: function(data, textStatus ){
                       console.log(data);
                       
                       $("#medicamentModalTitre").html(data.MED_NOMCOMMERCIAL);
                       
                       $("#MED_DEPOTLEGAL").html(data.MED_DEPOTLEGAL);
                       $("#MED_NOMCOMMERCIAL").html(data.MED_NOMCOMMERCIAL);
                       $("#MED_COMPOSITION").html(data.MED_COMPOSITION);
                       $("#MED_EFFETS").html(data.MED_EFFETS);
                       $("#MED_CONTREINDIC").html(data.MED_CONTREINDIC);
                       $("#MED_PRIXECHANTILLON").html(data.MED_PRIXECHANTILLON);
                       $("#FAM_LIBELLE").html(data.FAM_LIBELLE);
                       
                       $("#medicamentModal").modal("show");
                    },
                    error: function(xhr, textStatus, errorThrown){
                       console.log(errorThrown);
                    }
                  });
                    event.stopPropagation();
                });
            });
            
            //$('#tableMedoc thead:last').after("<tbody>"+getTr()+"</tbody>");
            $( ".suppTr" ).click(function() {
                
                
                suppLigne($( ".suppTr" ).index(this));
                //le probleme il faut reactualiser a chaque fois
                
            });
            
        });
        //suppresion Ligne
        function suppLigne(i){
            var item1 = $( ".ligneTr" )[i];
           
            $( item1).find('*').slideUp(800, function() {
                //Delete the old row
                $(item1).remove();
            });
        }
    </script>
    <div id="medicamentModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="medicamentModalTitre">Modal header</h3>
        </div>
        <div class="modal-body">
          <table class="table table-striped">
                <tr><td>Depot legal</td><td id="MED_DEPOTLEGAL"></td></tr>
                <tr><td>NOM COMMERCIAL</td><td id="MED_NOMCOMMERCIAL"></td></tr>   
                <tr><td>COMPOSITION</td><td id="MED_COMPOSITION"></td></tr>  
                <tr><td>effets</td><td id='MED_EFFETS'></td></tr>
                <tr class='error'><td>Contre indication</td><td id="MED_CONTREINDIC"></td> </tr>
                <tr><td>prix echantillons </td><td id="MED_PRIXECHANTILLON"></td> </tr> 
                <tr class='info'><td>libelle </td><td id="FAM_LIBELLE"></td> </tr> 
          </table>
        </div>
        <div class="modal-footer">
          <button class="btn" data-dismiss="modal" aria-hidden="true">Fermer</button>
          
        </div>
    </div>
    <script language="javascript">
        
        $( document ).ready(function() {
            $("#infoPract").click(function() {
                var PRA_NUM = $( "#selectPracticiens" ).val();
                
                
                 $.ajax({
                    type: 'POST',
                    data: { PRA_NUM: PRA_NUM },
                    dataType: 'json',
                    url: "../practicien/jsonPracticien",
                    timeout: 5000,
                    success: function(data, textStatus ){
                       console.log(data);
                       $("#myModalLabel").html(data.PRA_NOM);
                       
                       $("#PRA_PRENOM").html(data.PRA_PRENOM);
                       $("#PRA_NOM").html(data.PRA_NOM);
                       $("#PRA_VILLE").html(data.PRA_VILLE);
                       $("#PRA_ADRESSE").html(data.PRA_ADRESSE);
                       $("#PRA_CP").html(data.PRA_CP);
                       $("#PRA_COEFNOTORIETE").html(data.PRA_COEFNOTORIETE);
                       
                       $('#myModal').modal('show');
                    },
                    error: function(xhr, textStatus, errorThrown){
                       console.log(errorThrown);
                    }
                  });
                
            });
        });
    </script>
<div id="espace-barreHaut"></div>
    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="myModalLabel">Titre</h3>
        </div>
        <div class="modal-body">
            <table class="table table-striped">
                <tr><td>Prenom</td><td id="PRA_PRENOM"></td></tr>
                <tr><td>Nom</td><td id="PRA_NOM"></td></tr>   
                <tr><td>Ville</td><td id="PRA_VILLE"></td></tr>  
                <tr><td>Adresse</td><td id='PRA_ADRESSE'></td></tr>
                <tr><td>CP</td><td id="PRA_CP"></td> </tr>
                <tr><td>Coeff notoriete</td><td id="PRA_COEFNOTORIETE"></td> </tr> 
                
            </table>
        </div>
        <div class="modal-footer">
          <button class="btn" data-dismiss="modal" aria-hidden="true">Fermer</button>
        </div>
    </div>
<div id="millieuBarre">
    
    <?php
        $attributForm = array('class' => 'form-horizontal', 'id' => 'FormNouveauRendue');
        if($visiteur){
        	echo form_open('menu/NouvCompRendInscrit', $attributForm);
        }else{
        	echo "<div class='form-horizontal' id='FormNouveauRendue'>";
        }
        echo form_fieldset('Nouveau compte Rendue');
        ?>
        <div class="control-group">
            <label class="control-label" for="inputEmail">Numéro rapport: </label>
            <div class="controls">
            <?php $data = array(
             
              'class'   => 'input-large',
              'value' => $numRapport,
              'style' => 'position:relative;height:25px;',
                'disabled'=>true
            );

            echo form_input($data); ?> 
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputEmail">PRATICIEN</label>
            <div class="controls">
               <?php 
               
               echo form_dropdown('PRACTITIEN', $lesPracticiens, '', 'class="large" id="selectPracticiens"'); ?> <span id='infoPract' class="btn btn-info"><i class="icon-info-sign icon-white"></i> plus d'information</span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputDate">Date Rapport</label>
            <div class="controls">
                
                <div class="input-append">
               <?php 
               $date = new DateTime();
            
               $data = array(
              'name'    => 'DateRapport',
              "id" => "DateRapport",
              'class'   => 'datepicker input-large',
              
               "readonly"=>true,
                'value' => $date->format('d/m/Y'),
                'style' => 'position:relative;height:25px;'
            );

               echo form_input($data); ?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputMotif">Motif Visite</label>
            <div class="controls">
                <select id='RAP_MOTIF' name="RAP_MOTIF" class="zone" onClick="selectionne('AUT',this.value,'RAP_MOTIFAUTRE');">
                    <option value="PRD">Périodicité</option>
                    <option value="ACT">Actualisation</option>
                    <option value="REL">Relance</option>
                    <option value="SOL">Sollicitation praticien</option>
                    <option value="AUT">Autre</option>
		</select>
               <?php $data = array(
              'name'    => 'Motif',
               'id' => "disabledInput",
              'class'   => 'input-xlarge span3',
              'disabled' => 'disabled',
              'style' => 'position:relative;left:10px;height:25px;'
            );

            echo form_input($data); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputBilan">Bilan</label>
            <div class="controls">
               <?php $data = array(
              'name'    => 'Bilan',
              'id' => 'Bilan',
              'rows' => "5",
              'style' => "resize:none;width:300px;"
            );

            echo form_textarea($data); ?>
            </div>
        </div>
         <div class="control-group">
       <label class="control-label" for="inputFinaliser">saisie définitive:  </label>
          <div class="controls"> 
           <?php
            
            $data = array(
              'name'        => 'fini',
                'value' => "1"
              
            );
           echo form_checkbox($data);
           ?><span class="icon-floppy-disk"></span>
          </div>
        </div>
        <div id='tableauMedicament' class="control-group">
            <table id='tableMedoc' class="table table-striped table-bordered">
                
                <thead style='position:relative;text-align:center;'>
                <tr  style='font-weight:bold;'>
                    <td>
                        Médicament
                    </td>
                    <td>
                       Nb Echantillons 
                    </td>
                    <td>
                       supp
                    </td>
                </tr>
                </thead>
                
            </table>
            <span id='ajout' class='btn'><i class="icon-plus"></i> ajouter un médicament</span>
           
        </div>
       <div class="control-group">
           <div class="controls"> 
           <input type="reset" class='btn' value="Annuler">
            <?php
            $data = array(
              'name'        => 'save',
              
              'value'       => 'envoyer',
              'class' => 'btn btn-primary btn-large'
            );

            //echo  form_submit($data)." ";
           
            
           ?>
           <script language="javascript">
               //verifier si la date est valide
               function parseDMY(value) {
                    var date = value.split("/");
                    var d = parseInt(date[0], 10),
                        m = parseInt(date[1], 10),
                        y = parseInt(date[2], 10);
                    return new Date(y, m - 1, d);
                }
                var intRegex = /[0-9 -()+]+$/;  
            $( document ).ready(function() {
                $("#validerFormulaire").click(function() {
                    var ok = [];
                    var medocTab = [];
                    var validMedocTab = true;
                    $(".medocTab").each(function(){
                            medocTab.push($(this).val());
                            
                            if($(this).val()===""){
                               validMedocTab = false; 
                            }
                    });
                    if(!validMedocTab){
                        ok.push(["le compte rendu ne posséde pas de medicament", "warning"]);
                    }else{
                        if(medocTab.length===0){
                            ok.push(["le compte rendu ne posséde pas de medicament", "warning"]);
                        }
                    }
                    var qtMedocTab = [];
                    var validQtMedocTab = true;
                    $(".qtMedocTab").each(function(){
                            qtMedocTab.push($(this).val());
                            
                            if(!intRegex.test($(this).val())){
                               validQtMedocTab = false; 
                            }
                    });
                    if(!validQtMedocTab){
                        
                        ok.push(["la quantité est vide", "erreur"]);
                    }
                    var DateRapport = $( "#DateRapport" ).val();
                    if(parseDMY(DateRapport).toString()==="Invalid Date"){
                       
                       ok.push(["la date n'est pas valide", "erreur"]);
                    }
                    //BILAN
                    var Bilan = $( "#Bilan" ).val();
                    if(Bilan===""){
                       
                       ok.push(["Le bilan est vide.", "erreur"]);
                    }
                    //MOTIF VISITE
                    var RAP_MOTIF = $( "#RAP_MOTIF" ).val();
                    
                    if(RAP_MOTIF==="AUT"){
                        var disabledInput = $("#disabledInput").val();
                        
                        if(disabledInput===""){
                            
                            ok.push(["Le motif de visite est vide.", "erreur"]);
                        }
                    }
                    var chaine="";
                    var boutonActif = true;
                    
                    //affiche tous les message d'erreur
                    for(var i=0;i<ok.length;i++){
                        if(ok[i][1]==="erreur"){
                            boutonActif = false;
                            chaine+="<div class='alert alert-error'>";
                            chaine+=ok[i][0];
                            chaine+="</div>";
                        }else{
                            chaine+="<div class='alert alert-warning'>";
                            chaine+=ok[i][0];
                            chaine+="</div>";
                        }
                            
                    }
                    
                    if(boutonActif){
                        chaine+="<div class='alert alert-success'>";
                        chaine+="Tous les champs principales sont remplies correctements.";
                        chaine+="</div>";
                        $("#boutonConfirme").removeClass("disabled");
                        $('#boutonConfirme').prop('disabled', false);
                    }else{
                        $("#boutonConfirme").addClass("disabled");
                        $('#boutonConfirme').prop('disabled', true);
                    }
                    $("#lesMessagesErreurs").html(chaine);
                    $('#validationGenerale').modal('show');
                });
            });
            </script>
            <div id="validationGenerale" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  <h2 id="titre">Confirmation</h2>
                </div>
                <div class="modal-body">
                    <h4>Confirmer votre nouveau compte rendue</h4>
                    <div id="lesMessagesErreurs">
                        
                    </div>
                </div>
                <div class="modal-footer">
                    
                  <button class="btn" data-dismiss="modal" aria-hidden="true">Fermer</button>
                  <?php $data = array(
                    'name'        => 'save',
                      "id" => "boutonConfirme",
                    'value'       => 'sauver',
                    'class' => 'btn btn-primary'
                  );

                echo  form_submit($data)." "; ?>
                </div>
            </div>
           <?php  if($visiteur){ ?>
           		<span id="validerFormulaire" class='btn btn-primary btn-large'>envoyer</span>
           <?php  } ?>
           </div>
        </div>
        
        <?php
        echo form_fieldset_close(); 
        if($visiteur){
        	echo form_close();
        }else{
        	echo "</div>";
        }
    ?>
</div>
