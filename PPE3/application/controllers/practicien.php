<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

      class Practicien extends CI_Controller {

          public function __construct(){
              parent::__construct();
		$this->load->library('session');
		if( $this->session->userdata('num')==""){
			redirect("login/index");
			exit;
		}
          }
          public function jsonPracticien(){
              $this->load->model('practicien_model');
              
              $PRACTITIEN = $this->input->post('PRA_NUM');
              if($PRACTITIEN!=""){
                $resultat = $this->practicien_model->unPracticien($PRACTITIEN);
                if(isset($resultat[0])){
                    echo json_encode($resultat[0]);
                }
              }
            
          }
          public function index() {
              $this->load->model('practicien_model');
              //$this->load->database();

              $this->load->helper('html');
              $this->load->helper('url');

              $this->load->helper('form');

              //$data = array();
              $data = array();
              $data["titre"] = "practicien";
              $this->load->helper('form');
              $this->load->view('Connect/include/barreHaut.php', $data);

              $data['query'] = $this->practicien_model->get_practicien();
              $this->load->view('pages/ConsulPrac.php', $data);
              $this->load->view('Connect/include/barreBas.php');

          }

          //public function afficher() {
          //    $this->load->model('practicien_model');
          //    //$this->load->database();

          //    $this->load->helper('html');
          //    $this->load->helper('url');

          //    $this->load->helper('form');

          //    //$data = array();
          //    $data = array();
          //    $data["titre"] = "practicien";
          //    $this->load->helper('form');
          //    $this->load->view('Connect/include/barreHaut.php', $data);

          //    $data['query'] = $this->practicien_model->get_practicie_next();
          //    $this->load->view('pages/ConsulPrac.php', $data);
          //    $this->load->view('Connect/include/barreBas.php');

          //}

      }
      /* End of file practicien.php */
      /* Location: ./application/controllers/practicien.php */