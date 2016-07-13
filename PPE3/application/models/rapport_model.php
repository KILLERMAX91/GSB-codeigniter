<?php 
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class Rapport_model extends CI_Model {

        function get_offrirUneLigne($tab = array()){
            
             $this->db->select('OFF_QTE');

            $this->db->from('offrir');
            if(isset($tab["VIS_MATRICULE"])){
              $this->db->where('VIS_MATRICULE', $tab["VIS_MATRICULE"]);  
            }
            
            if(isset($tab["RAP_NUM"])){
                $this->db->where('RAP_NUM', $tab["RAP_NUM"]);
            }
            
            if(isset($tab["MED_DEPOTLEGAL"])){
                 $this->db->where('MED_DEPOTLEGAL', $tab["MED_DEPOTLEGAL"]);
            }
           

            $query_user = $this->db->get();

            return $query_user->result();
        }
        public function compteRendueExiste($num = 0, $numVisiteur = 0){
            $this->db->select('*');
            $this->db->from('rapport_visite');
            $this->db->where('RAP_NUM', $num);
            $this->db->where('VIS_MATRICULE', $numVisiteur);
            $query_user = $this->db->get();

            return $query_user->result();
        }
        /**
         * va ajouter
         * @param type $tab
         * @return type
         */
         function modifier_offrirUneLigne($tab){
            
             $this->db->select('OFF_QTE');

            $this->db->from('offrir');
            if(isset($tab["VIS_MATRICULE"])){
              $this->db->where('VIS_MATRICULE', $tab["VIS_MATRICULE"]);  
            }
            
            if(isset($tab["RAP_NUM"])){
                $this->db->where('RAP_NUM', $tab["RAP_NUM"]);
            }
            
            if(isset($tab["MED_DEPOTLEGAL"])){
                 $this->db->where('MED_DEPOTLEGAL', $tab["MED_DEPOTLEGAL"]);
            }
           
           
            $this->db->set('OFF_QTE', 'OFF_QTE+'.$tab["OFF_QTE"], FALSE);
            $this->db->update('offrir'); 

        }
        function get_rapport() {
              $sql = "SELECT * FROM rapport_visite ORDER BY RAP_NUM DESC";

              $query = $this->db->query($sql);
              //$query = $this->db->get_where("visiteur");
              return $query->result();
        }
        public function get_rapportNonValidee() {
        	$this->load->library('session');
              $sql = "SELECT VIS_NOM, RAP_NUM 
                      FROM rapport_visite, visiteur 
                      WHERE visiteur.VIS_MATRICULE = rapport_visite.VIS_MATRICULE 
              			AND visiteur.VIS_MATRICULE = '".$this->session->userdata('num')."'
              			AND rapport_visite.REG_CODE = '".$this->session->userdata('numReg')."'
                      AND saisieDefinitif=0";

              $query = $this->db->query($sql);
              
              return $query->result();
        }
        
        public function get_rapportValidee() {
        	$this->load->library('session');
        	$tab = $this->session->userdata("arrayRole");
        	$i = 0;
        	while($i<count($tab) && $tab[$i][0]!="D"){
        		$i++;
        	}
        	if($i<count($tab)){
        		$chaine = "";
        	}else{
        		$chaine = "AND (visiteur.VIS_MATRICULE = '".$this->session->userdata('num')."')";
        	}
        	
        	
             $sql = "	SELECT VIS_NOM, RAP_NUM 
                      	FROM rapport_visite, visiteur, travailler
                      	WHERE visiteur.VIS_MATRICULE = rapport_visite.VIS_MATRICULE
              			AND visiteur.VIS_MATRICULE = travailler.VIS_MATRICULE
              			AND rapport_visite.REG_CODE = '".$this->session->userdata('numReg')."'
              			".$chaine."
                      	AND saisieDefinitif=1";

              $query = $this->db->query($sql);
              
              return $query->result();
        }
        public function get_rapportValideeDelegue() {
        	$this->load->library('session');
        	
        }
        public function insererRaport($tab = array()){
        	$this->load->library('session');
            $data = array();
            if(isset($tab["numUtili"])){
               $data["VIS_MATRICULE"] = $tab["numUtili"];
            }
            if(isset($tab["numRapport"])){
               $data["RAP_NUM"] = $tab["numRapport"];
            }
            if(isset($tab["PRACTITIEN"])){
               $data["PRA_NUM"] = $tab["PRACTITIEN"];
            }
            if(isset($tab["DateRapport"])){
               $data["RAP_DATE"] = $tab["DateRapport"];
            }
            if(isset($tab["Bilan"])){
               $data["RAP_BILAN"] = $tab["Bilan"];
            }
            if(isset($tab["Motif"])){
               $data["RAP_MOTIF"] = $tab["Motif"];
            }
            if(isset($tab["fini"])){
               $data["saisieDefinitif"] = $tab["fini"];
            }
            $data["REG_CODE"] = $this->session->userdata('numReg');
            
            $this->db->insert('rapport_visite', $data);
            if(isset($tab["medoc"]) and isset($tab["qtMedoc"]) and isset($tab["numRapport"]) and isset($tab["numUtili"])){
                for($i=0;$i<count($tab["medoc"]);$i++){
                    $dataMedoc = array();
                     $dataMedoc["VIS_MATRICULE"] = $tab["numUtili"];
                     $dataMedoc["RAP_NUM"] = $tab["numRapport"];
                     $dataMedoc["MED_DEPOTLEGAL"] = $tab["medoc"][$i];
                    $dataMedoc["OFF_QTE"] = $tab["qtMedoc"][$i];
                    if(isset($this->get_offrirUneLigne($dataMedoc)[0])){
                        $this->modifier_offrirUneLigne($dataMedoc);
                    }else{
                        $this->db->insert('offrir', $dataMedoc);
                    }
                    
                }
            }
        }
        public function modifRaport($tab = array()){
            $data = array();
            if(isset($tab["numUtili"])){
               $data["VIS_MATRICULE"] = $tab["numUtili"];
            }
            if(isset($tab["PRACTITIEN"])){
               $data["PRA_NUM"] = $tab["PRACTITIEN"];
            }
            if(isset($tab["DateRapport"])){
               $data["RAP_DATE"] = $tab["DateRapport"];
            }
            if(isset($tab["Bilan"])){
               $data["RAP_BILAN"] = $tab["Bilan"];
            }
            if(isset($tab["Motif"])){
               $data["RAP_MOTIF"] = $tab["Motif"];
            }
            if(isset($tab["fini"])){
               $data["saisieDefinitif"] = $tab["fini"];
            }
            $data["DER_CONSUL"] = null;
            $this->db->where('RAP_NUM', $tab["numRapport"]);
            $this->db->update('rapport_visite', $data);
            $this->db->where('RAP_NUM', $tab["numRapport"]);
            $this->db->delete('offrir'); 
            if(isset($tab["medoc"]) and isset($tab["qtMedoc"]) and isset($tab["numRapport"]) and isset($tab["numUtili"])){
                for($i=0;$i<count($tab["medoc"]);$i++){
                    $dataMedoc = array();
                     $dataMedoc["VIS_MATRICULE"] = $tab["numUtili"];
                     $dataMedoc["RAP_NUM"] = $tab["numRapport"];
                     $dataMedoc["MED_DEPOTLEGAL"] = $tab["medoc"][$i];
                    $dataMedoc["OFF_QTE"] = $tab["qtMedoc"][$i];
                    if(isset($this->get_offrirUneLigne($dataMedoc)[0])){
                        $this->modifier_offrirUneLigne($dataMedoc);
                    }else{
                        $this->db->insert('offrir', $dataMedoc);
                    }
                    
                }
            }
        }
        public function lesoffres($tab){
            $this->db->select('OFF_QTE, MED_DEPOTLEGAL');
            $this->db->from('offrir');
            
            
            if(isset($tab["RAP_NUM"])){
                $this->db->where('RAP_NUM', $tab["RAP_NUM"]);
            }
            $query_user = $this->db->get();

            return $query_user->result();
        }
        function get_practicien() {
            $sql = "SELECT * FROM praticien order by 2";

            $query = $this->db->query($sql);
            //$query = $this->db->get_where("praticien");
            return $query->result();
        }
    }


?>