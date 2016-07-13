<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Accueil extends CI_Controller {
    public function __construct(){
		parent::__construct();
                header('Content-Type: text/html; charset=utf-8');
		$this->load->library('session');
		if( $this->session->userdata('num')==""){
			redirect("login/index");
			exit;
		}
               
               
    }
    
}

?>

