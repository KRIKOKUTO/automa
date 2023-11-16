<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pinactivo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $navbar_data['title'] = 'Barra de Navegación';
        $this->load->view('navbar', $navbar_data);
        $this->load->model('auth_model');
        $this->load->library('session');
        $this->load->helper('url');
        
        


    }
    public function redirigir(){
        $this->load->view('pactivacion');
    }
}
?>