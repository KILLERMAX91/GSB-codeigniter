<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller {
	private $err;
	public function __construct(){
		parent::__construct();
		
		$this->load->library('session');
		$this->err = "";
		if($this->session->userdata('num')!=""){
			redirect("menu/index");
		}
	}
	/**
	 * affichage login
	 */
	public function index(){
		//$this->session->userdata('item');
		$this->load->helper('url');
		$this->load->helper('form');
		
		$data = array();
		$data["titre"] = "login";
		$data["erreur"] = $this->err;
		$this->load->view('login/login', $data);
		
	}
        
	/**
	 * methode priv�e qui permet de convertire le mot passe au format demand�e
	 * @param String $passe
	 * @return string
	 */
	private function convertirePasse($passe){
		$chaine=$passe;
		$tab = array("jan"=>"01", 
					"feb"=>"02",
					"mar"=>"03", 
					"apr"=>"04", 
					"may"=>"05", 
					"jun"=>"06", 
					"
					"=>"07", 
					"aug"=>"08", 
					"sep"=>"09", 
					"oct"=>"10", 
					"nov"=>"11", 
					"dec"=>"12" );
		$coupe = explode("-", $passe);
		if(count($coupe)==3){
			$i=0;
			$chaine=$coupe[2];
			$trouver=false; //la variable permet de savoir si la cle se trouve dans le tableau sinon il remplace la valeur par default
			foreach($tab as $key=>$val){
				if($coupe[1]==$key){
					$chaine.="-".$val;
					$trouver=true;
				}
			}
			if(!$trouver){
				$chaine.="-".$coupe[1];
			}
			$chaine.="-".$coupe[0];
		}
		return $chaine;
	}
	/**
	 * verification du login
	 */
	public function connect(){
		$this->load->model('login_model');
                $this->load->model('visiteur_model');
		$this->load->helper('form');
		
		
		$requete = $this->login_model->loginExist(set_value('login'), $this->convertirePasse(set_value('passe')))->result_array(); //retourne un resultat sous format array
		//echo print_r($requete);
		if($requete!=null){

                        //recupere region
                        $resutat = $this->visiteur_model->regionChoisie($requete[0]["VIS_MATRICULE"])[0];
			//session
			$tab = array();
			$chaineScinder = explode(",", $resutat->arrayRole);
			
			$newdata = array(
					'num'  => $requete[0]["VIS_MATRICULE"],
					'nom'  => $requete[0]["VIS_NOM"],
					'prenom'  => $requete[0]["Vis_PRENOM"],
                            'titre' => $resutat->REG_NOM." ".$resutat->arrayRole,
					'numReg' => $resutat->code,
					'arrayRole' => $chaineScinder
			);
			
			$this->session->set_userdata($newdata);
			
			redirect("menu/index");
		}else{
			if(set_value('login')=="" and set_value('passe')==""){
				$this->err = "<div id='faux'>Les champs sont vides.</div>";
			}else{
				$this->err = "<div id='faux'>Le login ou le mot de passe est faux.</div>";
			}
			$this->index();
		}
	}
}
/* End of file login.php */
/* Location: ./application/controllers/login.php */
?>