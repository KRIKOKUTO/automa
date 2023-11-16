<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

    public function insertardb($tabla, $data) {
        $this->db->insert($tabla, $data);
    }

    public function obtener_usuario($user) {
        $this->db->where('usuario', $user);
        return $this->db->get('usuarios')->result_array();
    }

    public function obtenerTIS() {
        $this->db->where('rol', 'TI');
        $query = $this->db->get('usuarios');
    
        
        if ($query && $query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0; 
        }
    }


}
?>