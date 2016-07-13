<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Option extends CI_Controller {
	
	public function erreur404(){
		$this->load->helper('url');
		$this->load->view('erreur/error_404');
	}
}
/* End of file option.php */
/* Location: ./application/controllers/option.php */
?>