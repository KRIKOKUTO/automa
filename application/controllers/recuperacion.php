<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class recuperacion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('gestorDB');
        $this->load->library('session');
        
        

        //$navbar_data['title'] = 'Barra de Navegación';
        //$this->load->view('navbar', $navbar_data);
        $this->load->model('auth_model');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('form_validation');
        
    }
    
    public function index()
    {
        
        $this->load->view('recuperacion_view');
        
        
        
    }
    public function generarrec(){
        $usuario = $this->input->post('usuario');
        $val = $this->gestorDB->usuarioExiste($usuario);
        if ($val != False){
            //echo $usuario.'<br>';
        $correo = $this->gestorDB->obtenerCorreoUsuario($usuario);
        //print_r($correo);
        //echo '<br>';
        //$correosti_ = json_decode(json_encode($correo), true);
        //print_r($correosti_);
        //print_r($correosti);
        

        $primerosTres = substr($correo, 0, 3);
        $correoOculto = $primerosTres . str_repeat('*', strlen($correo) - 3);

        $codigo = $this->gestorDB->generarCodigo();
        $this->gestorDB->actualizarCodigo($usuario, $codigo); 

        $data["usuario"] = $usuario;
        $data["correo"] = $correoOculto;
        $data["correo_"] = $correo;
        $data["codigo"] = $codigo;
        
        

        $this->load->view('recuperado_view', $data);
        //--------
        }else{
            echo 'EL usuario no existe';
        }
        
    }
    public function coincidirrec(){
        $codigo1 = $this->input->post('codigo');
        $usuario = $this->input->post('user');
        //echo $usuario;
        $codigo2 = $this->gestorDB->obtenercolumna($usuario);
        //print_r($codigo2);
        $correosti_ = json_decode(json_encode($codigo2), true);
        //print_r($correosti_);
        //print_r($correosti);
        $direcciones = [];
        foreach ($correosti_ as $correoArray) {
            if (isset($correoArray['codigo'])) {
                $direcciones[] = $correoArray['codigo'];
            }
        }
        $codigostring = implode(',', $direcciones);
        //echo $codigo1;
        //echo $codigostring;
        if ($codigo1 == $codigostring){
            $data["usuario"] = $usuario;
            $this->load->view('restablecerpas', $data);
        }else{
            $data["mensaje"] = 'Codigo incorrecto';
            $this->load->view('registro_',$data);
            
        }

    }
    public function restpass(){
        $this->form_validation->set_message('min_length', 'La {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('regex_match', 'Se requiere almenos una mayuscula');
        
        $this->form_validation->set_rules('pass', 'Contraseña', 'required|min_length[8]');
        $this->form_validation->set_rules('pass', 'Contraseña', 'required|min_length[8]|regex_match[/[A-Z]/]'); 

        if ($this->form_validation->run() == FALSE) {
            $data['usuario'] = $this->input->post('user');
            //$data['mensaje'] = 'La contraseña debe tener al menos una mayuscula y deben ser al menos 8 caracteres';
            $this->load->view('restablecerpas', $data);
            
        } else {
            $usuario = $this->input->post('user');
            $pass = password_hash($this->input->post('pass'), PASSWORD_BCRYPT);
            $this->gestorDB->actualizarPass($usuario, $pass);
            $data["mensaje"] = 'Contraseña restablecida';
            redirect('auth/login?mensaje=Contraseña+restablecida');
            //$this->load->view('login',$data);
        }
        
    }

}


    



?>