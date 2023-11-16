<?php
class Pruebamodelo extends CI_Model{
    function __construct()
    {
        //llamando al constructor del modelo
        parent::__construct();
    }

    function insertardb($catalogo,$data){
        $this->db->insert($catalogo, $data);
    }

    function getcEstados(){
        $query  = $this->db->get('cEstados');
        return $query->result();
    }

    function getp(){
        $query = $this->db->get('ptb');
        $result = $query->result_array();
        return $result;
    }



    function borrarTodosDatos(){
        $this->db->empty_table('cEstados');
    }
    function deletedb($catalogo){
        $totalRegistros = $this->db->count_all($catalogo);
    
        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }
    }
    public function getFoaByFolio($folio)
    {
        // Realiza la consulta a la base de datos para obtener el valor de "oa
        $query = $this->db->get_where('foas', array('folio' => $folio));

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->foa;
        } else {
            return null; // El folio no se encontró en la tabla
        }
    }

    public function getFoaByFolio_($tabla,$col,$i)
    {
        // Realiza la consulta a la base de datos para obtener el valor de foa
        $query = $this->db->get_where($tabla, array($col => $i));

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->idTipoBeneficiario;
        } else {
            return null; // El folio no se encontró en la tabla
        }
    }
    
}
?>