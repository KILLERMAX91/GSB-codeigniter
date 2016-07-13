<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menu extends CI_Controller {
	public function __construct(){
		parent::__construct();
                header('Content-Type: text/html; charset=utf-8');
		$this->load->library('session');
		if( $this->session->userdata('num')==""){
			redirect("login/index");
			exit;
		}
               
               
	}
	public function index(){
            $data = array();
            $this->load->model('visiteur_model');
            $data["titre"] = "menu";
            $liste = $this->visiteur_model->regionVisiteur($this->session->userdata("num"));
            $tab = array();
               
            foreach ($liste as $row){
                    $tab[$row->code] = $row->REG_NOM." (".$row->arrayRole.")";
                }
            $data["lesRegions"] = $tab;
            $this->load->helper('form');
            $this->load->view('Connect/include/barreHaut.php', $data);
            $this->load->view('Connect/menu.php');
		
            $this->load->view('pages/Accueil.php');
            $this->load->view('Connect/include/barreBas.php');
	}
   public function regionChoisie(){
       $this->load->model('visiteur_model');
       $this->load->helper('form');
       $region = strval(set_value('Region')); //post + veroification du string
       $resutat = $this->visiteur_model->regionChoisie($this->session->userdata("num"), $region)[0]; //CALL requte
       $chaineScinder = explode(",", $resutat->arrayRole); //retourne un tableu de role
       /*
        * MODIFIER SESSION
        */
       $this->session->set_userdata('titre', $resutat->REG_NOM." ".$resutat->arrayRole);
       $this->session->set_userdata('numReg', $resutat->code);
       $this->session->set_userdata('arrayRole', $chaineScinder);
       redirect("menu/index");
   }
   private function selectPracticient(){
       $this->load->model('Practicien_model');
       $requete = $this->Practicien_model->get_practicien();
       $tab = array();
       foreach ($requete as $row){
           $tab[$row->PRA_NUM] = $row->PRA_NOM;
       }
       return $tab;
   }
   /**
    * 
    */
    public function NouvCompRend(){
                $this->load->model('medoc_model');
                $this->load->model('rapport_model');
                $this->load->helper('form');
                $tab = $this->session->userdata("arrayRole");
                $i=0;
                while($i<count($tab) && $tab[$i]!="Visiteur"){
                	$i++;
                }
                $data = array();
                $data["visiteur"] = false;
                if($i<count($tab)){
                	$data["visiteur"] = true;
                }
                
                $numeroRapport = 1;
                if(isset($this->rapport_model->get_rapport()[0])){
                    $numeroRapport = $this->rapport_model->get_rapport()[0]->RAP_NUM+1;
                }
                $liste=$this->rapport_model->get_rapportNonValidee();
                $tab = array();
               
                foreach ($liste as $row){
                    $tab[$row->RAP_NUM] = $row->VIS_NOM." - ".$row->RAP_NUM;
                }
                
                $data["listeCompteRendue"] = $tab;
		
		$data["titre"] = "menu";
                $data["numRapport"] = $numeroRapport;
                $data["get_medoc"] = $this->medoc_model->get_medoc();
                $data["lesPracticiens"] = $this->selectPracticient();
		$this->load->helper('form');
		$this->load->view('Connect/include/barreHaut.php', $data);
		$this->load->view('Connect/menu.php');
                $this->load->view('pages/NouvCompRend.php');
		$this->load->view('Connect/include/barreBas.php');
        
    }
    
   public function NouvCompRendInscrit(){
       $this->load->model('rapport_model');
       $this->load->helper('form');
       //LES POST DE FORMULAIRE
       $PRACTITIEN = strval(set_value('PRACTITIEN'));
       $DateRapport = strval(set_value('DateRapport'));
       $RAP_MOTIF = strval(set_value('RAP_MOTIF'));
       $Motif = strval(set_value('Motif'));
       $Bilan = strval(set_value('Bilan'));
       $fini = intval(set_value('fini'));
       //array TABLEAU MEDOC
       $medoc = set_value('medoc');
       $qtMedoc = set_value('qtMedoc');
        $ok = true;
       if(is_array($medoc) and is_array($qtMedoc)){
          
           
           $i=0;
           if(count($medoc)!=count($qtMedoc)){
               $ok=false;
           }
           
           while($i<count($medoc) and $ok){
               if(!is_string($medoc[$i])){
                   $ok=false;
               }
               $qtMedoc[$i] = intval($qtMedoc[$i]);
               if(!isset($qtMedoc[$i]) or !is_int($qtMedoc[$i])){
                   $ok=false;
               }
               
               $i++;
           }
           
           $date = explode("/", $DateRapport);
           
           if(3==count($date)){
               //checkdate verifier si la date est valide
               if(!checkdate( $date[1] , $date[0] , $date[2] )){
                  $ok=false; 
               }
               $DateRapport = $date[2]."-".$date[1]."-".$date[0];
           }else{
               $ok=false;
               echo $DateRapport;
           }
           
           if($ok){
               
               //si c'est different de autre
               if($RAP_MOTIF!="AUT"){
                   $Motif = $RAP_MOTIF;
               }
               $numeroRapport = 1;
                if(isset($this->rapport_model->get_rapport()[0])){
                    $numeroRapport = $this->rapport_model->get_rapport()[0]->RAP_NUM+1;
                }
               $tab = array();
               $tab["PRACTITIEN"] = $PRACTITIEN;
               $tab["DateRapport"] = $DateRapport;
               $tab["Motif"] = $Motif;
               $tab["Bilan"] = $Bilan;
               $tab["fini"] = $fini;
               $tab["medoc"] = $medoc;
               $tab["qtMedoc"] = $qtMedoc;
               $tab["numRapport"] = $numeroRapport;
               $tab["numUtili"] = $this->session->userdata('num');
               $this->rapport_model->insererRaport($tab);
           }
       }else{
          $date = explode("/", $DateRapport);
           
           if(3==count($date)){
               //checkdate verifier si la date est valide
               if(!checkdate( $date[1] , $date[0] , $date[2] )){
                  $ok=false; 
               }
               $DateRapport = $date[2]."-".$date[1]."-".$date[0];
           }else{
               $ok=false;
               echo $DateRapport;
           }
           if($ok){
               
               //si c'est different de autre
               if($RAP_MOTIF!="AUT"){
                   $Motif = $RAP_MOTIF;
               }
               $numeroRapport = 1;
                if(isset($this->rapport_model->get_rapport()[0])){
                    $numeroRapport = $this->rapport_model->get_rapport()[0]->RAP_NUM+1;
                }
               $tab = array();
               $tab["PRACTITIEN"] = $PRACTITIEN;
               $tab["DateRapport"] = $DateRapport;
               $tab["Motif"] = $Motif;
               $tab["Bilan"] = $Bilan;
               $tab["fini"] = $fini;
               $tab["medoc"] = array();
               $tab["qtMedoc"] = array();
               $tab["numRapport"] = $numeroRapport;
               $tab["numUtili"] = $this->session->userdata('num');
               $this->rapport_model->insererRaport($tab);
           }
       }
       
       //set_value('Rendue') = $numeroRapport;
       $this->session->set_userdata("numeroRapport", $numeroRapport);
       redirect("menu/modifierModifCompRend");
   } 
    
    
    public function VoirModifCompRend(){
		$data = array();
                $this->load->model('rapport_model');
                 $this->load->helper('form');
		$data["titre"] = "Naruto Uzumaki";
                $listeNonValidee = $this->rapport_model->get_rapportNonValidee();
                $listeValidee = $this->rapport_model->get_rapportValidee();
                $tab = array();
                $tabValidee = array();
                foreach ($listeNonValidee as $row){
                    $tab[$row->RAP_NUM] = $row->VIS_NOM." - ".$row->RAP_NUM;
                }
                foreach ($listeValidee as $row){
                    $tabValidee[$row->RAP_NUM] = $row->VIS_NOM." - ".$row->RAP_NUM;
                }
                $data["listeCompteRendue"] = $tab;
                $data["listeCompteRendueValide"] = $tabValidee;
		$this->load->helper('form');
		$this->load->view('Connect/include/barreHaut.php', $data);
                $this->load->view('pages/include/listeRendue.php');
		
		$this->load->view('Connect/include/barreBas.php');
               
	}
     public function modifierModifCompRend(){
         $data = array();
         $data["titre"] = "Miranda Kerr";
         $this->load->model('medoc_model');
         $this->load->model('rapport_model');
         $this->load->helper('form');
         $Rendue = intval(set_value('Rendue'));
         if($Rendue==0 or $Rendue==""){
             $Rendue = intval($this->session->userdata("numeroRapport"));
            
         }
         
         $requete = $this->rapport_model->compteRendueExiste($Rendue);
         $tabMotif = array("PRD"=>"Périodicité", "ACT"=>"Actualisation", "REL"=>"Relance", "SOL"=>"Sollicitation praticien", "AUT"=>"Autre");
         
         if(isset($requete[0])){
            $selected = "AUT";
            foreach($tabMotif as $cle=>$value){
                if($cle==$requete[0]->RAP_MOTIF){
                    $selected = $cle;
                }
            }
            $liste=$this->rapport_model->get_rapportNonValidee();
            $tab = array();

            foreach ($liste as $row){
                   $tab[$row->RAP_NUM] = $row->VIS_NOM." - ".$row->RAP_NUM;
             }
            $data["tabMotif"] = $tabMotif;
            $data["selected"] = $selected;
            $data["listeCompteRendue"] = $tab;
            $data["rapport"] = $requete[0];
            $data["lesMedocs"] = $this->rapport_model->lesoffres(array("RAP_NUM"=>$data["rapport"]->RAP_NUM));
            $data["rapport"]->RAP_DATE = $this->dateFR(explode(" ", $data["rapport"]->RAP_DATE)[0]);
            $data["get_medoc"] = $this->medoc_model->get_medoc();
            
            $data["lesPracticiens"] = $this->selectPracticient();
            
           $this->load->view('Connect/include/barreHaut.php', $data);
           $this->load->view('pages/modifierRendue.php');
            $this->load->view('Connect/include/barreBas.php');
        }else{
            redirect("menu/VoirModifCompRend");
        }
     }
     public function modifierModifCompRendUpdate(){
         $this->load->model('rapport_model');
       $this->load->helper('form');
       //LES POST DE FORMULAIRE
       //numero Rapport
       $numRapport = intval(set_value('numRapport'));
       $numVisiteur = strval(set_value('numMatricule'));
       if(isset($this->rapport_model->compteRendueExiste($numRapport, $numVisiteur)[0])){
        $PRACTITIEN = strval(set_value('PRACTITIEN'));
        $DateRapport = strval(set_value('DateRapport'));
        $RAP_MOTIF = strval(set_value('RAP_MOTIF'));
        $Motif = strval(set_value('Motif'));
        $Bilan = strval(set_value('Bilan'));
        $fini = intval(set_value('fini'));
        //array TABLEAU MEDOC
        $medoc = set_value('medoc');
        $qtMedoc = set_value('qtMedoc');
        $ok = true;
        if(is_array($medoc) and is_array($qtMedoc)){

            $i=0;
            if(count($medoc)!=count($qtMedoc)){
                $ok=false;
            }

            while($i<count($medoc) and $ok){
                if(!is_string($medoc[$i])){
                    $ok=false;
                }
                $qtMedoc[$i] = intval($qtMedoc[$i]);
                if(!isset($qtMedoc[$i]) or !is_int($qtMedoc[$i])){
                    $ok=false;
                }

                $i++;
            }

            $date = explode("/", $DateRapport);

            if(3==count($date)){
                //checkdate verifier si la date est valide
                if(!checkdate( $date[1] , $date[0] , $date[2] )){
                   $ok=false; 
                }
                $DateRapport = $date[2]."-".$date[1]."-".$date[0];
            }else{
                $ok=false;
                echo $DateRapport;
            }

            if($ok){

                //si c'est different de autre
                if($RAP_MOTIF!="AUT"){
                    $Motif = $RAP_MOTIF;
                }
               
                $tab = array();
                $tab["PRACTITIEN"] = $PRACTITIEN;
                $tab["DateRapport"] = $DateRapport;
                $tab["Motif"] = $Motif;
                $tab["Bilan"] = $Bilan;
                $tab["fini"] = $fini;
                $tab["medoc"] = $medoc;
                $tab["qtMedoc"] = $qtMedoc;
                $tab["numRapport"] = $numRapport;
                $tab["numUtili"] = $numVisiteur;
                //$this->rapport_model->insererRaport($tab);
                $this->rapport_model->modifRaport($tab);
            }
        }else{
            $date = explode("/", $DateRapport);

            if(3==count($date)){
                //checkdate verifier si la date est valide
                if(!checkdate( $date[1] , $date[0] , $date[2] )){
                   $ok=false; 
                }
                $DateRapport = $date[2]."-".$date[1]."-".$date[0];
            }else{
                $ok=false;
                echo $DateRapport;
            }

            if($ok){

                //si c'est different de autre
                if($RAP_MOTIF!="AUT"){
                    $Motif = $RAP_MOTIF;
                }
               
                $tab = array();
                $tab["PRACTITIEN"] = $PRACTITIEN;
                $tab["DateRapport"] = $DateRapport;
                $tab["Motif"] = $Motif;
                $tab["Bilan"] = $Bilan;
                $tab["fini"] = $fini;
                $tab["medoc"] = array();
                $tab["qtMedoc"] = array();
                $tab["numRapport"] = $numRapport;
                $tab["numUtili"] = $this->session->userdata('num');
                //$this->rapport_model->insererRaport($tab);
                $this->rapport_model->modifRaport($tab);
            }
          }
          $this->session->set_userdata("numeroRapport", $numRapport);
            redirect("menu/modifierModifCompRend");
       }
     }
     public function dateFR($date){
         $tab = explode("-", $date);
         return $tab[2]."/".$tab[1]."/".$tab[0];
     }
    public function ConsulPrac(){
		$data = array();
		$data["titre"] = "menu";
		$this->load->helper('form');
		$this->load->view('Connect/include/barreHaut.php', $data);
		$this->load->view('Connect/menu.php');
		$this->load->view('Connect/include/barreBas.php');
        $this->load->view('pages/ConsulPrac.php');
	}

    public function ConsulMedic(){
		$data = array();
		$data["titre"] = "menu";
		$this->load->helper('form');
		$this->load->view('Connect/include/barreHaut.php', $data);
		$this->load->view('Connect/menu.php');
		$this->load->view('Connect/include/barreBas.php');
        $this->load->view('pages/ConsulMedic.php');
	}

    public function ConsulNouv(){
		$data = array();
		$data["titre"] = "menu";
		$this->load->helper('form');
		$this->load->view('Connect/include/barreHaut.php', $data);
		$this->load->view('Connect/menu.php');
		$this->load->view('Connect/include/barreBas.php');
        $this->load->view('pages/ConsultNouvReg.php');
	}

    public function ConsulHisto(){
		$data = array();
		$data["titre"] = "menu";
		$this->load->helper('form');
		$this->load->view('Connect/include/barreHaut.php', $data);
		$this->load->view('Connect/menu.php');
		$this->load->view('Connect/include/barreBas.php');
        $this->load->view('pages/ConsultHistoReg.php');
    }

	public function deconnect(){
		$this->session->sess_destroy();
		redirect("login/index");
	}
}
/* End of file menu.php */
/* Location: ./application/controllers/menu.php */
?>