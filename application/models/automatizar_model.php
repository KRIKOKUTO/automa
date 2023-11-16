<?php
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
class Automatizar_model extends CI_Model{

    function __construct()
    {
        
        parent::__construct();
    }

    public function guardar_q($folio, $q) {
        $data = array('q' => $q);

        $this->db->where('folio', $folio);
        $this->db->update('foas', $data);
    }

    public function obtenerzona($folio, $columna) {
        
        $this->db->select($columna);
        $this->db->from('foas');
        $this->db->where('folio', $folio);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->$columna;
        } else {
            return null;
        }
    }
    public function geozon($fecha,$worksheet1,$worksheet2,$spreadsheet2){

        $row1 = 2; // La segunda fila para omitir encabezados
        $row2 = 3;

        //$celdasllenadas = 1;

        while (!empty($worksheet1->getCell('A' . $row1)->getValue())) {
            $folio = $worksheet1->getCell('A' . $row1)->getValue();
            $latitud = $worksheet1->getCell('B' . $row1)->getValue();
            $longitud = $worksheet1->getCell('C' . $row1)->getValue();
            $zona = $worksheet1->getCell('D' . $row1)->getValue();
            
            $query = $this->db->get_where('foas', array('folio' => $folio));

            if ($query->num_rows() > 0) {
                $row = $query->result();
                $folio1 = $row[0]->foa;
            } else {
                $folio1 = null; // El folio no se encontró en la tabla
            }
            
            $col = 'idZonaImpulso';
            $query = $this->db->get_where('cZonasImpulso', array('nombre' => $zona));

            if ($query->num_rows() > 0) {
                $row = $query->row();
                $idzona = $row-> $col;
            } else {
                $idzona = null; 
            }
            
            $folio1 = "'".$folio1;
            while (!empty($worksheet2->getCell('A' . $row2)->getValue())) {
                $folio2 = $worksheet2->getCell('A' . $row2)->getValue();
                //echo "\n".$folio1.'->'.$folio2;
                $folioSinComilla = str_replace("'", "", $folio2);
                $folioNumerico = intval($folioSinComilla);
                
                //echo '<br>'.$folio1.'->'.$folio2;
                if ($folio1 === $folio2) {
                    //echo '<br>match';
                    //die();
                    $folioSinComilla = str_replace("'", "", $folio1);
                    $folioNumerico = intval($folioSinComilla);
                    $data = array(
                        'lat' => $latitud,
                        'lon' => $longitud,
                        'zon' => $idzona,
                    );
                    $this->db->where('foa', $folioNumerico);
                    $this->db->update('foas', $data);

                    // Ejecuta la consulta
                    $this->db->select('q');
                    $this->db->from('foas');
                    $this->db->where('foa', $folioNumerico);
                    $query_ = $this->db->get();
                    $row_ = $query_->row();
                    $qValue = $row_->q;
                    
                    if ($qValue == 'QC3164'){
                        $worksheet2->setCellValue('Q' . $row2, $latitud);
                        $worksheet2->setCellValue('R' . $row2, $longitud);
                        $worksheet2->setCellValue('AE' . $row2, $idzona);
                        //$celdasllenadas++;
                        $row2++;
                        $worksheet2->setCellValue('Q' . $row2, $latitud);
                        $worksheet2->setCellValue('R' . $row2, $longitud);
                        $worksheet2->setCellValue('AE' . $row2, $idzona);
                        $row2++;
                        $worksheet2->setCellValue('Q' . $row2, $latitud);
                        $worksheet2->setCellValue('R' . $row2, $longitud);
                        $worksheet2->setCellValue('AE' . $row2, $idzona);
                    }else if ($qValue == 'QC3767'){
                        $worksheet2->setCellValue('Q' . $row2, $latitud);
                        $worksheet2->setCellValue('R' . $row2, $longitud);
                        $worksheet2->setCellValue('AE' . $row2, $idzona);
                        //$celdasllenadas++;
                        $row2++;
                        $worksheet2->setCellValue('Q' . $row2, $latitud);
                        $worksheet2->setCellValue('R' . $row2, $longitud);
                        $worksheet2->setCellValue('AE' . $row2, $idzona);
                    }else{
                        $worksheet2->setCellValue('Q' . $row2, $latitud);
                        $worksheet2->setCellValue('R' . $row2, $longitud);
                        $worksheet2->setCellValue('AE' . $row2, $idzona);
                    }

                    
                    break;
                }
                $row2++;
                
            }

            $row1++;
        }

        // Guardar iGTO+
        $writer = IOFactory::createWriter($spreadsheet2, 'Xlsx');
        $writer->save('Generados/iGTO+/iGTO_'.$fecha.'.xlsx');

        return 'Generados/iGTO+/iGTO_'.$fecha.'.xlsx';
        
        //echo 'Celdas llenadas:  '.$celdasllenadas.'<br>';
    }
    
    public function vaciarCarpeta($carpeta) {
        // Verificar que la carpeta exista
        if (is_dir($carpeta)) {
            
            $archivos = scandir($carpeta);
    
            
            foreach ($archivos as $archivo) {
                if ($archivo != "." && $archivo != "..") {
                    $ruta = $carpeta . DIRECTORY_SEPARATOR . $archivo;
    
                    
                    if (is_file($ruta)) {
                        unlink($ruta);
                    } elseif (is_dir($ruta)) {
                        
                        $this->vaciarCarpeta($ruta);
                        
                        rmdir($ruta);
                    }
                }
            }
            echo "Carpeta vaciada correctamente.";
        } else {
            echo "La carpeta no existe.";
        }
    }
    
    public function extractZipFile_($zipFilePath,$destinationPath) {

    
        
        if (file_exists($zipFilePath)) {
            $zip = zip_open($zipFilePath);
    
            if ($zip) {
                
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
    
                
                while ($zip_entry = zip_read($zip)) {
                    $entry_name = zip_entry_name($zip_entry);
                    $entry_size = zip_entry_filesize($zip_entry);
    
                    
                    if (zip_entry_open($zip, $zip_entry, "r")) {
                        $content = zip_entry_read($zip_entry, $entry_size);
                        $file_path = $destinationPath . $entry_name;
                        file_put_contents($file_path, $content);
                        zip_entry_close($zip_entry);
                    }
                }
    
                zip_close($zip);
                echo "Archivo ZIP extraído correctamente.";
            } else {
                echo "No se pudo abrir el archivo ZIP.";
            }
        } else {
            echo "El archivo ZIP no existe.";
        }
    }
    

    public function extractZipFile($zipFilePath,$destinationPath) {
        
    
        // Verificar si existe
        if (file_exists($zipFilePath)) {
            $zip = zip_open($zipFilePath);
    
            if ($zip) {
                // Crear la carpeta  si no existe
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
    
                // Iterar sobre los archivos
                while ($zip_entry = zip_read($zip)) {
                    $entry_name = zip_entry_name($zip_entry);
                    $entry_size = zip_entry_filesize($zip_entry);
    
                    // Ruta completa 
                    $file_path = $destinationPath . $entry_name;
    
                    
                    if (file_exists($file_path)) {
                        file_put_contents($file_path, zip_entry_read($zip_entry, $entry_size), FILE_BINARY | FILE_APPEND);
                    } else {
                        // Extraer 
                        if (zip_entry_open($zip, $zip_entry, "r")) {
                            file_put_contents($file_path, zip_entry_read($zip_entry, $entry_size), FILE_BINARY);
                            zip_entry_close($zip_entry);
                        }
                    }
                }
    
                zip_close($zip);
                echo "Archivo ZIP extraído correctamente.";
            } else {
                echo "No se pudo abrir el archivo ZIP.";
            }
        } else {
            echo "El archivo ZIP no existe.";
        }
    }
    
    public function getLastDataRow($worksheet) {
        $lastRow = $worksheet->getHighestDataRow();
        while (empty(trim($worksheet->getCell('C' . $lastRow)->getValue()))) {
            $lastRow--;
        }
        return $lastRow;
    }
    public function getLastFoa($worksheet) {
        $lastRow = $worksheet->getHighestDataRow();
        while (empty(trim($worksheet->getCell('B' . $lastRow)->getValue()))) {
            $lastRow--;
        }
        return $lastRow;
    }

    

    public function getLastDataColumn($worksheet) {
        $lastColumn = $worksheet->getHighestDataColumn();
        return $lastColumn;
    }

    public function escribir($spreadsheetiGto,$worksheet,$indiceFila,$valores){//yahoja

        
        $columnaInicial = 1; 
        foreach ($valores as $valor) {
            $worksheet->setCellValueByColumnAndRow($columnaInicial, $indiceFila, $valor);
            $columnaInicial++; 
        }
        
        //echo 'yeah';
    }

    public function escribir_($worksheet,$valores){//yahoja

        //$worksheet = $spreadsheetiGto->getSheetByName('Hoja2');
        $columnaInicial = 1; 
        $indiceFila = 2;
        foreach ($valores as $valor) {
            $worksheet->setCellValueByColumnAndRow($columnaInicial, $indiceFila, $valor);
            $columnaInicial++; 
        }
        
        echo 'yeah';
    }

    public function encabezadosEI(){

        $datos1 = array('nvarchar (14) NOT NULL','[int] NOT NULL','varchar( 1000) NULL');
        $datos2 = array('FolioObraAccion','idVistaInstrumentoPlaneacion','ComoAbona','Folio');
        return array($datos1,$datos2);

    }

    public function encabezadosmPro(){

        $datos1 = array();
        $datos2 = array('FolioObraAccion','Ejercicio','Q','idMetaSED','idDependencia','DescripcionObraAccion','EmpleosPermanentesMujeres','EmpleosEventualesMujeres','EmpleosPermanentesHombres','EmpleosEventualesHombres','EmpleosProtegidosMujeres','EmpleosProtegidosHombres','NombreSimplificadoObraAccion','idCategoria','idSubCategoria','FechaEntrega','Latitud','Longitud','idEstado','idMunicipio','idLocalidad','idMunicipioUbica','idLocalidadUbica','idTipoAsentamiento','NombreAsentamiento','idTipoVialidad','NombreVialidad','NumeroExterior','NumeroInterior','CodigoPostal','idZonaImpulso','MontoEstatal','MontoDeuda','MontoRecursoPropio','MontoFederal','MontoMunicipal','MontoOtro','MontoBeneficiario','EsRefrendo','AnioRefrendo','FolioRelacionado','idTipoObraAccion','idTipo','idStatusObraAccion','idStatusAvance','ObservacionesStatusAvance','ObservacionesGenerales','BenefTotal','BenefMujeres','BenefHombres','idCCT','idInformeGobierno','idSituacion','CifrasEstimadas','Folio');
        return array($datos1,$datos2);

    }

    public function encabezadosEn(){

        $datos1 = array('Nvarchar (14)','smallint','Nvarchar (1000)');
        $datos2 = array('FolioObraAccion','idEnfoque','Justificacion','Folio');
        return array($datos1,$datos2);

    }

    public function encabezadosAFM(){

        $datos1 = array('Nvarchar (14)','smallint','smallint','money','money','money','money','money','money','money','Nvarchar(500)','smallint','decimal (12,2)','Nvarchar (500)');
        $datos2 = array('FolioObraAccion','Ejercicio','idMesFinanciero','MontoEstatal','MontoDeuda','MontoRecursoPropio','MontoFederal','MontoMunicipal','MontoOtro','MontoBeneficiario','ObservacionAvanceFinanciero','idMesFisico	AvanceFisico','ObservacionAvanceFisico','AvanceFisico','Folio');
        return array($datos1,$datos2);

    }

    public function encabezadosTP(){

        $datos1 = array('Nvarchar(14)','smallint','smallint');
        $datos2 = array('FolioObraAccion','idTipoBeneficiario','cantidad','Folio');
        return array($datos1,$datos2);

    }

    public function encabezadosMetproyectos(){

        $datos1 = array('Nvarchar (14)'   ,'Decimal (18,2)'   ,'Nvarchar (1000)');
        $datos2 = array('FolioObraAccion' ,'Cantidad'         ,'DetalladoMeta','Folio');
        return array($datos1,$datos2);
        
    }
    public function numeroFilas($worksheetBeneficiarios){ //yahoja
        
		//$totalHojas = $documento->getSheetCount();
        //$worksheet = $spreadsheetBeneficiarios->getSheetByName('Beneficiarios');
		//$worksheet = $documento->getSheet(0);
		//$nFilas = $hojaActual->getHighestDataRow();
        $nFilas = $this->getLastDataRow($worksheetBeneficiarios);
        return $nFilas;
    }

    public function obtenerFilaBeneficiario($worksheetBeneficiarios,$colInicial,$filaInicial,$colFinal,$filaFinal){//yahoja
        
        //$worksheet = $spreadsheetBeneficiarios->getSheetByName('Beneficiarios');
        //$rowNumber_ = 469;
        $rowData = $worksheetBeneficiarios->rangeToArray($colInicial . $filaInicial.":" . $colFinal . $filaFinal, null, true, false, true);
        //$rowData = $worksheet->rangeToArray('A3:DD3', null, true, false, true);
        return $rowData;
    }

    public function coincidirfolioEnDB($folio)
    {
        
        $query = $this->db->get_where('foas', array('folio' => $folio));

        if ($query->num_rows() > 0) {
            //$row = $query->row();
            return true; 
        } else {
            return false; // Folio no se encontró
        }
    }


    public function coincidirFolioEnExcel($worksheetBeneficiarios){//yahoja
        
		//$totalHojas = $documento->getSheetCount();
		//$worksheet = $spreadsheetBeneficiarios->getSheetByName('Beneficiarios');
		//$nFilas = $hojaActual->getHighestDataRow();
        $nFilas = $this->getLastDataRow($worksheetBeneficiarios);

        $valorBuscado = 864651; 
        $columna = 'B'; 

        $highestRow = $worksheetBeneficiarios->getHighestRow(); // última fila

        for ($row = 1; $row <= $highestRow; $row++) {
            $celda = $worksheetBeneficiarios->getCell($columna . $row);
            if ($celda->getValue() == $valorBuscado) {
                //echo "El valor $valorBuscado se encuentra en la fila $row.";
                return $row;
                // Puedes detener la búsqueda si ya encontraste el valor
            }
        }

    }

    public function sacarCatalogo($catalogo,$datoIncial,$columnaInicial,$columnaDeseada){

        //$catalogo = 'cMeses';
        //datoInicial = 'JUNIO'
        //$columnaInicial = 'mes'
        //$columnaDeseada = 'idMes';
        $this->db->select($columnaDeseada); 
        $this->db->where($columnaInicial, $datoIncial); 
        $query = $this->db->get($catalogo);
        
        if ($query->num_rows() > 0) {
            return $query->row()->$columnaDeseada; 
        } else {
            return null; 
        }
    }


    public function AFM_idMesFisico($mes){
        
        //obtener catalogo
        $col = 'idMes';
        $this->db->select($col); 
        $this->db->where('Mes', $mes); 
        $query = $this->db->get('cMeses');
        
        if ($query->num_rows() > 0) {
            return $query->row()->idMes; 
        } else {
            return null; 
        }
    }


    public function AFM_Ejercio($FilaB){


    }

    function get(){
        $query  = $this->db->get('cMeses');
        return $query->result();
    }

}
?>