<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login_model extends CI_Model{
	private $tableVisiteur = "visiteur";
    private $tableTravailler = "travailler";
	
	public function loginExist($login, $pwd){
		$query = $this->db->get_where($this->tableVisiteur, array('VIS_NOM' => $login, "VIS_DATEEMBAUCHE"=>$pwd));
		return $query;
	}
    public function GetTravaillerByNom($matricule){
        $queri = $this->db->get_where($this->tableTravailler, array('VIS_MATRICULE' => $matricule));
        return $queri;
    }
}
/* End of file login_model.php */
/* Location: ./application/models/login_model.php */
?>