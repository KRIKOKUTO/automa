<?php
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
class GestorDB extends CI_Model{
    function __construct()
    {

        parent::__construct();
    }

    public function getLastDataRow($worksheet) {
        $lastRow = $worksheet->getHighestDataRow();
        while (empty(trim($worksheet->getCell('A' . $lastRow)->getValue()))) {
            $lastRow--;
        }
        return $lastRow;
    }

    

    public function getLastDataColumn($worksheet) {
        $lastColumn = $worksheet->getHighestDataColumn();
        return $lastColumn;
    }

    public function obtenerTabla() {
        $this->db->order_by('fecha', 'desc');
        return $this->db->get('archivos')->result();
    }

    public function obtenerTabla_() {
        //$this->db->order_by('fecha', 'desc');
        return $this->db->get('usuarios')->result();
    }

    public function actualizar_estado($usuario_id, $nuevo_estado) {
        
        $data = array('estado' => $nuevo_estado);
        $this->db->where('id', $usuario_id);
        $this->db->update('usuarios', $data);
    }

    function insertardb($tabla,$data){
        $this->db->insert($tabla, $data);
    }

    public function numFIl($tabla){
        $totalRegistros = $this->db->count_all($tabla);
        return $totalRegistros;
    }

    function insertardbwhere($tabla,$columna,$valor,$data){
        $this->db->set($data);
        $this->db->where($columna, $valor); 
        $this->db->update($tabla);
    }

    function deletedb($tabla){
        $totalRegistros = $this->db->count_all($tabla);
    
        if ($totalRegistros > 0) {
            $this->db->empty_table($tabla);
        }
    }

    

    public function getFoaByFolio($folio)
    {
        $query = $this->db->get_where('foas', array('folio' => $folio));

        if ($query->num_rows() > 0) {
            $row = $query->result();
            return $row[0]->foa;
        } else {
            return null; // El folio no se encontró en la tabla
        }
    }

    public function actualizarPass($usuario, $pass) {
        $this->db->where('usuario', $usuario);
        $this->db->update('usuarios', array('pass' => $pass));
    }

    public function actualizarCodigo($usuario, $codigo) {
        $this->db->where('usuario', $usuario);
        $this->db->update('usuarios', array('codigo' => $codigo));
    }
    
    function generarCodigo() {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyz';
        $longitudCodigo = 10;
        $codigo = '';
    
        for ($i = 0; $i < $longitudCodigo; $i++) {
            $codigo .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }
    
        return $codigo;
    }
    
    public function actualizarFechaPorFolio($folio, $nuevaFecha) {

        $datos = array(
            'fecha' => $nuevaFecha
        );
        $this->db->where('folio', $folio);
        $this->db->update('foas', $datos);
        return $this->db->affected_rows();
    }
    public function obtenerFechaPorFolio($folio) {

        $query = $this->db->get_where('foas', array('folio' => $folio));

        if ($query->num_rows() > 0) {

            $fila = $query->row();


            $fecha = $fila->fecha;

            return $fecha;
        } else {

            return null;
        }
    }
    public function usuarioExiste($Usuario) {
        $this->db->from('usuarios');
        $this->db->where('usuario', $Usuario);

        $query = $this->db->get();

        return ($query->num_rows() > 0);
    }
    public function obtenerCorreoUsuario($Usuario) {
        $this->db->select('correo');
        $this->db->from('usuarios');
        $this->db->where('usuario', $Usuario);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {

            $resultado = $query->row();
            return $resultado->correo;
        } else {
            return false;
        }
    }
    public function getId($catalogo,$colDato,$dato,$nId)
    {
        $query = $this->db->get_where($catalogo, array($colDato => $dato));

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->$nId;
        } else {
            return null; // El folio no se encontró en la tabla
        }
    }
    public function obtenerUsuariosTI() {
        $this->db->select('correo');
        $this->db->where('rol', 'TI');
        $this->db->where('estado', 'activo');
        $query = $this->db->get('usuarios');
        return $query->result();
    }
    public function obtenercolumna($usuario) {
        $this->db->select('codigo');
        $this->db->where('usuario', $usuario);
        $query = $this->db->get('usuarios');
        return $query->result();
    }

    function is_unique($dato,$columna) {
        $this->db->where($columna, $dato);
        $query = $this->db->get('usuarios');
        
        return $query->num_rows() == 0;
    }
    

    public function obtener_filas($tabla,$mes) {
        $this->db->select('*');
        $this->db->from($tabla); 
        $this->db->where('mes', $mes);

        // Ejecutar 
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result(); // Devolvuelve las filas 
        } else {
            return array(); 
        }
    }


    public function getId_($catalogo, $colDato1, $dato1, $colDato2, $dato2, $nId)
    {
        
        $query = $this->db->get_where($catalogo, array($colDato1 => $dato1, $colDato2 => $dato2));

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->$nId;
        } else {
            return null; // Los datos no se encontraron en la tabla
        }
    }

    public function emptyfoa(){
        $totalRegistros = $this->db->count_all('foas');
        
        if ($totalRegistros > 0) {
            $this->db->empty_table('foas');
        }
        

    }

    public function vaciartabla($tabla){
        $totalRegistros = $this->db->count_all($tabla);
        
        if ($totalRegistros > 0) {
            $this->db->empty_table($tabla);
        }
    }

    public function obtenerDatos() {
        $query = $this->db->get('foas');


        if ($query->num_rows() > 0) {
            return $query->result(); 
        } else {
            return array(); 
        }
    }

    

    //Genrerar FolioObraAccion

    public function foa($ejecicio,$fijo,$consecutivo){
        
        $A = $ejecicio;
        $B = $fijo;

        //$inicioConsecutivo = $inicialConsecutivo; // Valor inicial del consecutivo
        $numerosAGenerar = 5;   

        $tabla = 'foas';
		$nArch = 'Obtenidos/Beneficiarios.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		//$nFilas = $hojaActual->getHighestDataRow();
        $nFilas = $this->getLastDataRow($hojaActual);
        
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		
        $totalRegistros = $this->db->count_all($tabla);
        $i = 0;



        if ($totalRegistros == 0) {
            $inicioConsecutivo = $consecutivo;
        }else{
            $this->db->select('foa');
            $this->db->from('foas');
            $this->db->order_by('foa', 'DESC'); 
            $this->db->limit(1);

            $query = $this->db->get();

            $row = $query->row();
            $ultimoRegistro = $row->foa;
            $ultimos_10_digitos = substr($ultimoRegistro, -10);
            $cons = intval($ultimos_10_digitos);
            $inicioConsecutivo = $cons+1;
        }
        

		for($indiceFila = 2; $indiceFila<=$nFilas; $indiceFila++){
			$folio = $hojaActual->getCellByColumnAndRow(2,$indiceFila);
            $valorCelda = $folio->getValue();
            //
			$valorAi = intval($valorCelda);
            



            $consecutivo = $inicioConsecutivo + $i;

            // Rellena con ceros para ajustar a 10 dígitos
            $consecutivoPadded = str_pad($consecutivo, 10, "0", STR_PAD_LEFT);

            // Genera el número de 18 dígitos
            $numeroCompleto = $A . $B . $consecutivoPadded;
				$valorBi = intval($numeroCompleto);
				
                $data = array(
					'folio' => $valorAi,
                    'foa' => $valorBi
				);
				
                $this->db->insert($tabla, $data);

				//echo $valorAi.'     '.$valorBi;
			//}
			//echo '<br/>';
			$i++;
        }

    }


    public function foa_($ejecicio,$fijo,$consecutivo,$folio){
        
        $A = $ejecicio;
        $B = $fijo;

        //$inicioConsecutivo = $inicialConsecutivo; // Valor inicial del consecutivo
        $numerosAGenerar = 5;   

        $tabla = 'foas';

		$this->load->helper('url');
		
        $totalRegistros = $this->db->count_all($tabla);
        $i = 0;

        if ($totalRegistros == 0) {
            $inicioConsecutivo = $consecutivo;
        }else{
            //Ordenar los registros 
            $this->db->select('foa');
            $this->db->from('foas');
            $this->db->order_by('foa', 'DESC'); 
            $this->db->limit(1);

            $query = $this->db->get();

            $row = $query->row();
            $ultimoRegistro = $row->foa;
            $ultimos_10_digitos = substr($ultimoRegistro, -10);
            $cons = intval($ultimos_10_digitos);
            $inicioConsecutivo = $cons+1;
        }
        
            $valorCelda = $folio;
			$valorAi = intval($valorCelda);
            
            $this->db->where('folio', $valorCelda);
            $query = $this->db->get('foas');

            // Verificar si hay resultados
            if ($query->num_rows() > 0) {
                
            } else {
                $consecutivo = $inicioConsecutivo + $i;

                $consecutivoPadded = str_pad($consecutivo, 10, "0", STR_PAD_LEFT);

                $numeroCompleto = $A . $B . $consecutivoPadded;
                    $valorBi = intval($numeroCompleto);
                    
                    $data = array(
                        'folio' => $valorAi,
                        'foa' => $valorBi
                    );
                    
                    $this->db->insert($tabla, $data);
                
            }



            
    }

    
    
    
    public function generarFoa($inicioConsecutivo){

            $A = "2023";
            $B = "3025";
            //$inicioConsecutivo = 1;
            $i = 0;
            $consecutivo = $inicioConsecutivo + $i;

            $consecutivoPadded = str_pad($consecutivo, 10, "0", STR_PAD_LEFT);

            $numeroCompleto = $A . $B . $consecutivoPadded;
            $valorBi = intval($numeroCompleto);

            return $valorBi;
    }

    function getp(){
        $query = $this->db->get('ptb');
        $result = $query->result_array();
        return $result;
    }

    public function escribirExcel($dato,$columnas,$filas){
        
        $spreadsheet = IOFactory::load('Generados/IGTO_JUVENTUDESGTO.xlsx');

        
        $worksheet = $spreadsheet->getSheet(0);
        

        

        $row = 3; // Fila inicial
        foreach ($dato as $data) {
            $col = 1; // Columna inicial
            foreach ($data as $value) {

                $worksheet->setCellValueByColumnAndRow($col, $row, $value);
                $col++;

            }
            $row++;
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('Generados/IGTO_JUVENTUDESGTO.xlsx');
        echo 'yeah';
    }

} 



?>