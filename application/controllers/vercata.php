<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class vercata extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("gestorDB");
        
        $this->load->model('cat_update');
        $this->load->library('session');
        $this->load->helper('url');

        if ($this->session->userdata()['rol'] == 'planeacion'){
            $navbar_data['title'] = 'Barra de Navegación';
            $this->load->view('navbar', $navbar_data);
        } else if($this->session->userdata()['rol'] == 'TI'){
            $navbar_data['title'] = 'Barra de Navegación';
            $this->load->view('navbarti', $navbar_data);
        } else if($this->session->userdata()['rol'] == null){
            redirect('auth/login');
        }

    }
    public function index(){
        
        
        //$data['rol'] = $this->session->userdata()['rol'];
        $catalogo = $this->session->flashdata('opciones');
        $data['filas'] = $this->cat_update->vercatalogos($catalogo); 

        $this->load->view('vercata_view', $data);
        
    }
    public function cambiar_estado() {
    
        $id = $this->input->post('usuario_id');
        $nestado = $this->input->post('nuevo_estado');
    
        
        $this->gestorDB->actualizar_estado($id, $nestado);
    
        
        redirect('usuariosact');
    }
}
?>