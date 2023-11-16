<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class correo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('gestorDB');
        $this->load->library('session');
        
        

        $navbar_data['title'] = 'Barra de Navegación';
        $this->load->view('navbar', $navbar_data);
        $this->load->model('auth_model');
        $this->load->library('session');
        $this->load->helper('url');
        
    }
    
    public function enviarc()
    {
        $usuario = $this->session->flashdata('usuario');
        //echo $correo;
        $correosti = $this->gestorDB->obtenerUsuariosTI();
        
        $correosti_ = json_decode(json_encode($correosti), true);
        //print_r($correosti_);
        //print_r($correosti);
        $direcciones = [];
        foreach ($correosti_ as $correoArray) {
            if (isset($correoArray['correo'])) {
                $direcciones[] = $correoArray['correo'];
            }
        }
        $direccionesString = implode(',', $direcciones);
        //echo $direccionesString;
        //print_r($direcciones);
        //echo $direccionesString;
        

        $data["addresses"] = $direccionesString;
        $data["usuario"] = $usuario;
        //echo $data_["addresses"];
        $this->load->view('correo_view', $data);
        
    }

}




?>