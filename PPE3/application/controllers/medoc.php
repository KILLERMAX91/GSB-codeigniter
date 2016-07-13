<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

      class Medoc extends CI_Controller
      {
          public function __construct()
          {
              parent::__construct();
              $this->load->model('medoc_model');
              $this->load->helper('form');
              $this->load->library('form_validation');
              $this->load->library('session');
          }
          public function unMedicament(){
              $this->load->model('medoc_model');
              $medoc = $this->input->post('medoc');
              $resultat = $this->medoc_model->getUn_medoc($medoc);
              if(isset($resultat[0])){
                    echo json_encode($resultat[0]);
              }
              //echo json_encode($this->medoc_model->getUn_medoc($medoc));
          }
          public function index()
          {
              $this->load->model('medoc_model');
              //$this->load->database();

              $this->load->helper('html');
              $this->load->helper('url');

               //$data = array();
             $data = array();
		$data["titre"] = "médicament";
                $data['query'] = $this->medoc_model->get_medoc();
		$this->load->helper('form');
		$this->load->view('Connect/include/barreHaut.php', $data);
              

              $this->load->view('pages/ConsulMedic.php');
              $this->load->view('Connect/include/barreBas.php');
          }
      }
?>