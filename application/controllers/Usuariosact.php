<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class usuariosact extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("gestorDB");
        
        $this->load->model('auth_model');
        $this->load->library('session');
        $this->load->helper('url');

        if ($this->session->userdata()['rol'] == 'planeacion'){
            redirect('automatizar');
        } else if($this->session->userdata()['rol'] == 'TI'){
            $navbar_data['title'] = 'Barra de Navegación';
            $this->load->view('navbarti', $navbar_data);
        } else if($this->session->userdata()['rol'] == null){
            redirect('auth/login');
        }

    }
    public function index(){
        
        
        //$data['rol'] = $this->session->userdata()['rol'];
        $data['filas'] = $this->gestorDB->obtenerTabla_(); 

        $this->load->view('Usuariosact_view', $data);
        
    }
    public function cambiar_estado() {
    
        $id = $this->input->post('usuario_id');
        $nestado = $this->input->post('nuevo_estado');
    
        
        $this->gestorDB->actualizar_estado($id, $nestado);
    
        
        redirect('usuariosact');
    }
}
?>