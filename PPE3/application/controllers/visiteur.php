<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

      class Visiteur extends CI_Controller {

          public function __construct(){
              parent::__construct();
              $this->load->library('session');
              if( $this->session->userdata('num')==""){
                  redirect("login/index");
                  exit;
              }
          }

          public function index() {
              $this->load->model('visiteur_model');
              //$this->load->database();

              $this->load->helper('html');
              $this->load->helper('url');

              $this->load->helper('form');

              //$data = array();
              $data = array();
              $data["titre"] = "Voir Compte Rendu";
              $this->load->helper('form');
              $this->load->view('Connect/include/barreHaut.php', $data);

              $data['query'] = $this->visiteur_model->get_visiteur();
              $data['queri'] = $this->visiteur_model->get_rapport();
              $this->load->view('pages/VoirModifCompRend.php', $data);
              $this->load->view('Connect/include/barreBas.php');

          }

          public function indeax() {
              $this->load->model('visiteur_model');
              //$this->load->database();

              $this->load->helper('html');
              $this->load->helper('url');

              $this->load->helper('form');

              //$data = array();
              $data = array();
              $data["titre"] = "Voir Rapport";
              $this->load->helper('form');
              $this->load->view('Connect/include/barreHaut.php', $data);

              $data['query'] = $this->visiteur_model->get_visiteur();
              $data['queri'] = $this->visiteur_model->get_rapport();
              $this->load->view('pages/VoirModifCompRend.php', $data);
              $this->load->view('Connect/include/barreBas.php');

          }

      }
      /* End of file blog.php */
      /* Location: ./application/controllers/blog.php */