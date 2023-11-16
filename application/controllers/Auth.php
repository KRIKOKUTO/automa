<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('auth_model');
        $this->load->model('gestorDB');
        $this->load->library('session');
        $footer_data['footer_content'] = 'Contenido específico para TI';
        $this->load->view('footer', $footer_data);

        
    }

    public function registro() {
        $this->load->library('form_validation');

        $this->form_validation->set_message('required', 'El campo {field} es obligatorio.');
        $this->form_validation->set_message('min_length', 'La {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('is_unique', 'El usuario ya existe.');
        $this->form_validation->set_message('regex_match', 'Se requiere almenos una mayuscula');
        $this->form_validation->set_message('matches', 'La confirmacion no coincide con la contraseña.');
        $this->form_validation->set_message('valid_email', 'Ingrese un correo valido.');
    

        if ($this->input->post()) {
            
            // Realiza la validación de longitud mínima de contraseña
            $this->form_validation->set_rules('pass', 'Contraseña', 'required|min_length[8]');
            $this->form_validation->set_rules('pass', 'Contraseña', 'required|min_length[8]|regex_match[/[A-Z]/]'); // Verifica que el nombre de usuario sea único
            $this->form_validation->set_rules('correo', 'Correo electrónico', 'trim|required|valid_email');
            $this->form_validation->set_rules('usuario', 'Nombre de usuario', 'is_unique[usuarios.usuario]');
            $this->form_validation->set_rules('confirm_pass', 'Confirmar Contraseña', 'required|matches[pass]');
            $usuario = $this->input->post('usuario');
            $correo = $this->input->post('correo');
            $us_unico = $this->gestorDB->is_unique($usuario,'usuario');
            $co_unico = $this->gestorDB->is_unique($correo,'correo');
            
            
            if ($us_unico == true && $co_unico == true){
                if ($this->form_validation->run() == TRUE) {
                    $numTIS = $this->auth_model->obtenerTIS();
                    echo $this->input->post('departamento').'<br>';
                    if ($this->input->post('departamento') == 'TI'){
                        if ($numTIS == 0){
                            $estado = 'activo';
                        }else{
                            $estado = 'inactivo';
                        }
                    }else{
                        $estado = 'inactivo';
                    }
                    //$correo = $this->input->post('correo');
                    $usuario_ = $this->input->post('usuario');
                    
                    $data = array(
                        'nombre' => $this->input->post('nombre'),
                        'usuario' => $this->input->post('usuario'),
                        'rol' => $this->input->post('departamento'),
                        'pass' => password_hash($this->input->post('pass'), PASSWORD_BCRYPT),
                        'estado' => $estado,
                        'correo' => $correo
                    );
    
                    $this->auth_model->insertardb('usuarios', $data);
                    if ($numTIS == 0){
                        redirect('auth/login');
                    }else{
                        $this->session->set_flashdata('usuario', $usuario_);
                        redirect('correo/enviarc'); 
                    }
    
                    
                }
            }else{
                $data["mensaje"] = 'El nombre de usuario o el correo ya estan en uso';
                
                
                $this->form_validation->set_message('is_unique', 'El nombre de usuario ya está en uso.');
                
            }
            

            
        }
        if (isset($data)) {
            $this->load->view('registro_',$data);
        }else{
            $this->load->view('registro_');
        }
        
        
    }

    public function login() {
        //$this->load->library('session');
        $this->load->library('form_validation');

        //inicio de sesión
        if ($this->input->post()) {
            $user = $this->input->post('usuario');
            $password = $this->input->post('pass');

            $usuario = $this->auth_model->obtener_usuario($user);

            
            if ($usuario && password_verify($password, $usuario[0]['pass'])) {

                $this->session->set_userdata($usuario[0]);
                isset($_SESSION['user']);

                redirect('automatizado');
                //redirect('inicio');
            } else {
                
                ?> <br/> <?php
                echo 'fallo autenticacion'; ?> <br/> <?php
                echo 'Usuario o contraseña incorrectas';
            }
        }
        $mensaje = $this->input->get('mensaje');

        // Verificar si hay un mensaje y mostrarlo
        if ($mensaje) {
            $data["mensaje"] = urldecode($mensaje);;
            $this->load->view('login',$data);
        }else{
            $this->load->view('login');
        }

    }

    public function cerrar_sesion() {
        
        $this->session->sess_destroy();
    
        // Redirige a la página de inicio de sesión
        redirect('auth/login');
    }
    

    
    
}
