<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

      class Rapport extends CI_Controller {

          public function __construct(){
              parent::__construct();
              $this->load->library('session');
              if( $this->session->userdata('num')==""){
                  redirect("login/index");
                  exit;
              }
          }

          public function index() {
              $this->load->model('rapport_model');
              //$this->load->database();

              $this->load->helper('html');
              $this->load->helper('url');

              $this->load->helper('form');

              //$data = array();
              $data = array();
              $data["titre"] = "Nouveau Rapport";
              $this->load->helper('form');
              $this->load->view('Connect/include/barreHaut.php', $data);


              //$data['query'] = $this->rapport_model->insert_rapport();
              $data['queri'] = $this->rapport_model->get_practicien();
              $this->load->view('pages/NouvCompRend.php', $data);
              $this->load->view('Connect/include/barreBas.php');

          }

          public function ajouter(){
              $this->load->library('form_validation');
              $this->load->model('rapport_model');

              $this->form_validation->set_rules('RAP_NUM', 'Numero rapport', 'required');
              $this->form_validation->set_rules('PRA_NUM', 'Numero practicien', 'required');
              $this->form_validation->set_rules('RAP_DATE', 'Date', 'required');
              $this->form_validation->set_rules('RAP_BILAN', 'Bilan', 'required');
              $this->form_validation->set_rules('RAP_MOTIF', 'Motif', 'required');

              if ($this->form_validation->run() == TRUE){
                  $this->blog_model->add_contact(set_value('RAP_NUM'), set_value('PRA_NUM'), set_value('RAP_DATE'), set_value('RAP_BILAN'), set_value('RAP_MOTIF'));
                  $this->index();
              }
              else{
                  $this->index();
              }
          }

      }
      /* End of file blog.php */
      /* Location: ./application/controllers/blog.php */