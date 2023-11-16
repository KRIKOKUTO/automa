<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpParser\Node\Expr\FuncCall;
class pruebafoa extends CI_Model{

    public function getLastDataRow($worksheet) {
        $lastRow = $worksheet->getHighestDataRow();
    
        while (empty(trim($worksheet->getCell('A' . $lastRow)->getValue()))) {
            $lastRow--;
        }
    
        return $lastRow;
        
    }
    public function prueba_(){
        $tabla = 'foas';
		$nArch = 'Generados/01. BENEFICIARIOS QCXXXX.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		//$nFilas = $hojaActual->getHighestDataRow();

        $lastDataRow = $this->getLastDataRow($hojaActual);
        echo $lastDataRow;
		$letra = $hojaActual->getHighestColumn();

        //echo $nFilas;
    }
    public function foa_(){
        
        $A = "2023";
        $B = "3025";

        // Supongamos que $consecutivo es el valor autoincrementable obtenido desde una fuente de datos
        $inicioConsecutivo = 1; // Valor inicial del consecutivo
        $numerosAGenerar = 5;   // Número de números a generar

        $tabla = 'foas';
		$nArch = 'Generados/01. BENEFICIARIOS QCXXXX.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		//$nFilas = $hojaActual->getHighestDataRow();
        $nFilas = $this->getLastDataRow($hojaActual);
        
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);
        $totalRegistros = $this->db->count_all($tabla);

        if ($totalRegistros > 0) {
            $this->db->empty_table($tabla);
        }
        
        $i = 0;
		for($indiceFila = 2; $indiceFila<=$nFilas; $indiceFila++){
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$folio = $hojaActual->getCellByColumnAndRow(2,$indiceFila);
				
                $valorCelda = $folio->getValue();
				$valorAi = intval($valorCelda);

                $consecutivo = $inicioConsecutivo + $i;

            // Rellenar con ceros para ajustar a 10 dígitos
            $consecutivoPadded = str_pad($consecutivo, 10, "0", STR_PAD_LEFT);

            // Generar el número completo de 18 dígitos
            $numeroCompleto = $A . $B . $consecutivoPadded;
				$valorBi = intval($numeroCompleto);
				
                $data = array(
					'folio' => $valorAi,
                    'foa' => $valorBi
				);
				
                $this->db->insert($tabla, $data);

				echo $valorAi.'     '.$valorBi;
			//}
			echo '<br/>';
			$i++;
    }

    }

}
    

