<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpParser\Node\Expr\FuncCall;
class Cat_update extends CI_Model{
    function __construct()
    {
        //llamando al constructor del modelo
        parent::__construct();
    }
    public function vercata($catalogo) {
		//echo $catalogo;
		//die();
		$this->db->select('*');
		$this->db->from($catalogo);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return array();
		}
	}
	public function vercatalogos($catalogo) {
		//echo $catalogo;
		//die();
		$this->db->select('*');
		$this->db->from($catalogo);
		$this->db->limit(1); // Limit to 1 row to get the structure
		$query = $this->db->get();
	
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$firstRow = reset($result); // Get the first row to determine column names
	
			// Get the first 5 columns or all columns if there are fewer than 5
			$columns = array_slice(array_keys($firstRow), 0, 5);
	
			// Construct a new SELECT query with only the selected columns
			$this->db->select(implode(',', $columns));
			$this->db->from($catalogo);
			$query = $this->db->get();
	
			if ($query->num_rows() > 0) {
				return $query->result_array();
			} else {
				return array();
			}
		} else {
			return array();
		}
	}
	
	
	public function cLocalidades($fn){
		$catalogo = 'cLocalidades_';
		$nArch = 'Catalogos/cLocalidades_.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);
        $totalRegistros = $this->db->count_all($catalogo);

        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }

		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++)
		{
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);
				
				
				$valorCelda = $valorA->getValue();
				$valorAi = intval($valorCelda);

				$valorCelda = $valorB->getValue();
				$valorBi = intval($valorCelda);


				$data = array(
					'idMunicipio' => $valorAi,
					'idLocalidad' => $valorB
					
				);
				/* 	CREATE TABLE cLocalidades_ (
					idLocalidad INT,
					idMunicipio INT)*/
					
				
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				//echo $valorAi.' '.$valorBi;
		
			//echo '<br/>';	
		}
	}


    //03.- cTiposObrasAcciones
	public function cids($fn){
		$catalogo = 'ids';
		$nArch = 'Catalogos/ids.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);
        $totalRegistros = $this->db->count_all($catalogo);

        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }

		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++)
		{
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);
				$valorC = $hojaActual->getCellByColumnAndRow(3,$indiceFila);
				$valorD = $hojaActual->getCellByColumnAndRow(4,$indiceFila);
				$valorE = $hojaActual->getCellByColumnAndRow(5,$indiceFila);
				$valorF = $hojaActual->getCellByColumnAndRow(6,$indiceFila);
				$valorG = $hojaActual->getCellByColumnAndRow(7,$indiceFila);//INT>
				$valorH = $hojaActual->getCellByColumnAndRow(8,$indiceFila);
				$valorI = $hojaActual->getCellByColumnAndRow(9,$indiceFila);
				$valorJ = $hojaActual->getCellByColumnAndRow(10,$indiceFila);
				$valorK = $hojaActual->getCellByColumnAndRow(11,$indiceFila);
				$valorL = $hojaActual->getCellByColumnAndRow(12,$indiceFila);
				$valorM = $hojaActual->getCellByColumnAndRow(13,$indiceFila);
				$valorN = $hojaActual->getCellByColumnAndRow(14,$indiceFila);
				$valorÑ = $hojaActual->getCellByColumnAndRow(15,$indiceFila);
				$valorO = $hojaActual->getCellByColumnAndRow(16,$indiceFila);
				$valorP = $hojaActual->getCellByColumnAndRow(17,$indiceFila);
				$valorQ = $hojaActual->getCellByColumnAndRow(18,$indiceFila);//INT<
				$valorR = $hojaActual->getCellByColumnAndRow(19,$indiceFila);
				$valorS = $hojaActual->getCellByColumnAndRow(20,$indiceFila);//INT
				$valorT = $hojaActual->getCellByColumnAndRow(21,$indiceFila);
				$valorV = $hojaActual->getCellByColumnAndRow(22,$indiceFila);//INT
				$valorW = $hojaActual->getCellByColumnAndRow(23,$indiceFila);
				$valorX = $hojaActual->getCellByColumnAndRow(24,$indiceFila);//INT
				$valorY = $hojaActual->getCellByColumnAndRow(25,$indiceFila);
				//$valorC = $hojaActual->getCellByColumnAndRow(26,$indiceFila);
				//$valorD = $hojaActual->getCellByColumnAndRow(27,$indiceFila);

				$valorCelda = $valorG->getValue();
				$valorGi = intval($valorCelda);

				$valorCelda = $valorH->getValue();
				$valorHi = intval($valorCelda);

				$valorCelda = $valorI->getValue();
				$valorIi = intval($valorCelda);

				$valorCelda = $valorJ->getValue();
				$valorJi = intval($valorCelda);

				$valorCelda = $valorK->getValue();
				$valorKi = intval($valorCelda);

				$valorCelda = $valorL->getValue();
				$valorLi = intval($valorCelda);

				$valorCelda = $valorM->getValue();
				$valorMi = intval($valorCelda);

				$valorCelda = $valorN->getValue();
				$valorNi = intval($valorCelda);

				$valorCelda = $valorÑ->getValue();
				$valorÑi = intval($valorCelda);

				$valorCelda = $valorO->getValue();
				$valorOi = intval($valorCelda);

				$valorCelda = $valorP->getValue();
				$valorPi = intval($valorCelda);

				$valorCelda = $valorQ->getValue();
				$valorQi = intval($valorCelda);

				$valorCelda = $valorS->getValue();
				$valorSi = intval($valorCelda);

				$valorCelda = $valorT->getValue();
				$valorTi = intval($valorCelda);

				$valorCelda = $valorV->getValue();
				$valorVi = intval($valorCelda);

				$valorCelda = $valorX->getValue();
				$valorXi = intval($valorCelda);


				$data = array(
					'CLAVE_PQG' => $valorA,
					'NOMBRE_INDICADOR' => $valorB,
					'NOMBRE_META' => $valorC,
					'DescripcionOA' => $valorD,
					'Modalidad' => $valorE,
					'Nombre_Simplificado' => $valorF,
					'ID_META_SED' => $valorGi,
					'id_Categoria' => $valorHi,
					'subcategoria' => $valorIi,
					'idTipoObraAccion' => $valorJi,
					'idTipo' => $valorKi,
					'idStatusObraAccion' => $valorLi,
					'idStatusAvance' => $valorMi,
					'idSituacion' => $valorNi,
					'Detallado_meta' => $valorÑi,
					'idTipoBeneficiario_Hombre' => $valorOi,
					'idTipoBeneficiario_Mujer' => $valorPi,
					'AlineaciónPSPG' => $valorQi,
					'Como_abona' => $valorR,
					'Alineación_PEJ' => $valorSi,
					'Como_abona_2' => $valorT,
					'idEnfoque_1' => $valorVi,
					'Justificacion_1' => $valorW,
					'idEnfoque_2' => $valorXi,
					'Justificacion_2' => $valorY
				);
					/*CREATE TABLE ids(
						CLAVE_PQG varchar(7),
						NOMBRE_INDICADOR varchar(50),
						NOMBRE_META varchar(100),
						DescripcionOA varchar(200),
						Modalidad varchar(50),
						Nombre_Simplificado varchar(200),
						ID_META_SED int,
						id_Categoria int,
						subcategoria int,
						idTipoObraAccion int,
						idTipo int,
						idStatusObraAccion int,
						idStatusAvance int,
						idSituacion int,
						Detallado_meta int,
						idTipoBeneficiario_Hombre int,
						idTipoBeneficiario_Mujer int,
						AlineaciónPSPG int,
						Como_abona varchar(50),
						Alineación_PEJ int,
						Como_abona_2 int,
						idEnfoque_1 int,
						Justificacion_1 varchar(50),
						idEnfoque_2 int,
						Justificacion_2 varchar(100)
						) */
			
					
				
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				echo $valorA.' '.$valorB;
		
				
		}
	}


	public function metas($fn){
		$catalogo = 'cmetas';
		$nArch = 'Catalogos/cmetas.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);
        $totalRegistros = $this->db->count_all($catalogo);

        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }

		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++)
		{
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);
				$valorC = $hojaActual->getCellByColumnAndRow(3,$indiceFila);
				$valorD = $hojaActual->getCellByColumnAndRow(4,$indiceFila);
				$valorE = $hojaActual->getCellByColumnAndRow(5,$indiceFila);
				$valorF = $hojaActual->getCellByColumnAndRow(6,$indiceFila);
				
				$valorCelda = $valorD->getValue();
				$valorDi = intval($valorCelda);

				$valorCelda = $valorE->getValue();
				$valorEi = intval($valorCelda);

				$valorCelda = $valorF->getValue();
				$valorFi = intval($valorCelda);

				$data = array(
					'programa' => $valorA,
					'indicador' => $valorB,
					'nombre' => $valorC,
					'id_entregable' => $valorDi,
					'categoria' => $valorEi,
					'subcategoria' => $valorFi
				);
				/* 	programa VARCHAR (6),
					indicador VARCHAR(300),
					nombre varchar(350),
					id_entregable int,
					categoria int,
					subcategoria int)*/
					
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				echo $valorA.' '.$valorB.' '.$valorC.'	'.$valorDi.' '.$valorEi.' '.$valorFi;
		
			echo '<br/>';	
		}
	}

	public function montos($fn){
		$catalogo = 'cmontos';
		$nArch = 'Catalogos/cmontos.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);
        $totalRegistros = $this->db->count_all($catalogo);

        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }

		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++)
		{
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);
				$valorC = $hojaActual->getCellByColumnAndRow(3,$indiceFila);
				$valorCelda = $valorC->getValue();
				$valorCi = intval($valorCelda);
				$data = array(
					'programa' => $valorA,
					'modalidad' => $valorB,
					'monto' => $valorCi
				);
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				echo $valorA.' '.$valorB.' '.$valorCi;
		
			echo '<br/>';	
		}
	}

	
    public function cCategorias_update($fn) {
		$catalogo = 'cCategorias';
		$nArch = 'Catalogos/cCategorias.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);
        $totalRegistros = $this->db->count_all($catalogo);

        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }

		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++){
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);
				$valorCelda = $valorA->getValue();
				$valorAi = intval($valorCelda);
				$data = array(
					'idCategoria' => $valorAi,
					'Categoria' => $valorB
				);
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				//echo $valorAi.' '.$valorB;
			//}
			echo '<br/>';
			
    }
		
	}
    public function cTiposObrasAcciones_update($fn) {
		$catalogo = 'cTiposObrasAcciones';
		$nArch = 'Catalogos/cTiposObrasAcciones.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);

        $totalRegistros = $this->db->count_all($catalogo);

        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }

		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++){
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);
				$valorCelda = $valorA->getValue();
				$valorAi = intval($valorCelda);
				$data = array(
					'idTipoObraAccion' => $valorAi,
					'TipoObraAccion' => $valorB
				);
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				//echo $valorAi.' '.$valorB;
			//}
			echo '<br/>';
			
    }
		
	}
    //04.- cSubCategorias
	public function cSubCategorias_update($fn) {
		$catalogo = 'cSubCategorias';
		$nArch = 'Catalogos/cSubCategorias.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);
        $totalRegistros = $this->db->count_all($catalogo);

        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }

		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++){
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);
				$valorC = $hojaActual->getCellByColumnAndRow(3,$indiceFila);
				
				$valorCelda = $valorA->getValue();
				$valorCeldaB = $valorB->getValue();
				$valorAi = intval($valorCelda);
				$valorBi = intval($valorCeldaB);
				$data = array(
					'idCategoria' => $valorAi,
					'idSubCategoria' => $valorBi,
					'SubCategoria' => $valorC
				);
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				//echo $valorAi.'		'.$valorBi.'	'.$valorC;
			//}
			echo '<br/>';
			
    }
		
	}
    //05.- cEnfoques
	public function cEnfoques_update($fn) {
		$catalogo = 'cEnfoques';
		$nArch = 'Catalogos/cEnfoques.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);
        $totalRegistros = $this->db->count_all($catalogo);

        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }

		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++){
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);
				$valorC = $hojaActual->getCellByColumnAndRow(3,$indiceFila);


				$valorCelda = $valorA->getValue();
				$valorAi = intval($valorCelda);

				$valorCelda = $valorC->getValue();
				$valorCi = intval($valorCelda);

				$data = array(
					'idEnfoque' => $valorAi,
					'Enfoque' => $valorB,
					'idTipoEnfoque' => $valorCi
				);
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				//echo $valorAi.'		'.$valorB.'		'.$valorCi;
			//}
			echo '<br/>';
			
        }
    }
	//08.- cTipos
	public function cTipos_update($fn) {
		$catalogo = 'cTipos';
		$nArch = 'Catalogos/cTipos.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);
        $totalRegistros = $this->db->count_all($catalogo);

        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }
		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++){
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);
				$valorC = $hojaActual->getCellByColumnAndRow(3,$indiceFila);
				$valorD = $hojaActual->getCellByColumnAndRow(4,$indiceFila);
				
				
				$valorCelda = $valorA->getValue();
				$valorAi = intval($valorCelda);

				$valorCelda = $valorC->getValue();
				$valorCi = intval($valorCelda);

				$valorCelda = $valorD->getValue();
				$valorDi = intval($valorCelda);

				$data = array(
					'idTipo' => $valorAi,
					'Tipo' => $valorB,
					'Obra' => $valorCi,
					'Accion' => $valorDi
				);
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				//echo $valorAi.'		'.$valorB.'		'.$valorCi.'	'.$valorDi;
			//}
			echo '<br/>';
			
    }
		
	}
    
	public function cStatusObrasAcciones_update($fn) {
		$catalogo = 'cStatusObrasAcciones';
		$nArch = 'Catalogos/cStatusObrasAcciones.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);
        $totalRegistros = $this->db->count_all($catalogo);

        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }
		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++){
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);
				$valorC = $hojaActual->getCellByColumnAndRow(3,$indiceFila);
				$valorD = $hojaActual->getCellByColumnAndRow(4,$indiceFila);
				
				
				$valorCelda = $valorA->getValue();
				$valorAi = intval($valorCelda);

				$data = array(
					'idStatusObraAccion' => $valorAi,
					'StatusObraAccion' => $valorB,
					'Representacion' => $valorC,
					'DescripcionDGPI' => $valorD
				);
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				//echo $valorAi.' 		'.$valorB.'		'.$valorC.'		'.$valorD;
			//}
			echo '<br/>';
			
    }
		
	}

    public function cStatusAvance_update($fn) {
		$catalogo = 'cStatusAvance';
		$nArch = 'Catalogos/cStatusAvance.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);
        $totalRegistros = $this->db->count_all($catalogo);

        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }
		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++){
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);
				$valorC = $hojaActual->getCellByColumnAndRow(3,$indiceFila);
				$valorD = $hojaActual->getCellByColumnAndRow(4,$indiceFila);
				$valorE = $hojaActual->getCellByColumnAndRow(5,$indiceFila);

				
				$valorCelda = $valorA->getValue();
				$valorAi = intval($valorCelda);

				$valorCelda = $valorD->getValue();
				$valorDi = intval($valorCelda);

				$data = array(
					'idStatusAvance' => $valorAi,
					'StatusAvance' => $valorB,
					'Descripcion' => $valorC,
					'idStatusEjecutivo' => $valorDi,
					'Tipo' => $valorE
				);
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				//echo $valorAi.' 		'.$valorB.'		'.$valorC.'		'.$valorDi.'		'.$valorE;
			//}
			echo '<br/>';
			
    }
		
	}
    
	public function cDependencias_update($fn) {
		$catalogo = 'cDependencias';
		$nArch = 'Catalogos/cDependencias.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);
        $totalRegistros = $this->db->count_all($catalogo);

        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }
		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++){
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);
				$valorC = $hojaActual->getCellByColumnAndRow(3,$indiceFila);
				$valorD = $hojaActual->getCellByColumnAndRow(4,$indiceFila);
				$valorE = $hojaActual->getCellByColumnAndRow(5,$indiceFila);

				
				$valorCelda = $valorA->getValue();
				$valorAi = intval($valorCelda);

				$valorCelda = $valorB->getValue();
				$valorBi = intval($valorCelda);

				$valorCelda = $valorC->getValue();
				$valorCi = intval($valorCelda);

				$data = array(
					'idDependencia' => $valorAi,
					'idEje' => $valorBi,
					'cveDependencia' => $valorCi,
					'Dependencia' => $valorD,
					'Siglas' => $valorE
				);
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				//echo $valorAi.' 		'.$valorBi.'		'.$valorCi.'		'.$valorD.'		'.$valorE;
			//}
			echo '<br/>';
			
    }
		
	}

	public function cMunicipios_update($fn) {
		$catalogo = 'cMunicipios';
		$nArch = 'Catalogos/cMunicipios.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);
        $totalRegistros = $this->db->count_all($catalogo);

        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }
		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++){
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);
				$valorC = $hojaActual->getCellByColumnAndRow(3,$indiceFila);
				$valorD = $hojaActual->getCellByColumnAndRow(4,$indiceFila);
				
				
				$valorCelda = $valorA->getValue();
				$valorAi = intval($valorCelda);

				$valorCelda = $valorB->getValue();
				$valorBi = intval($valorCelda);

				$valorCelda = $valorC->getValue();
				$valorCi = intval($valorCelda);

				$data = array(
					'idMunicipio' => $valorAi,
					'idEstado' => $valorBi,
					'ClaveMunicipio' => $valorC,
					'NombreMunicipio' => $valorD
				);
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				//echo $valorAi.' 		'.$valorBi.'		'.$valorC.'		'.$valorD;
			//}
			echo '<br/>';
			
    }
		
	}
    public function cEstados_update($fn) {
		$Catalogo = 'cEstados';
		$nArch = 'Catalogos/cEstados.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($Catalogo);
        $totalRegistros = $this->db->count_all($Catalogo);
    
        if ($totalRegistros > 0) {
            $this->db->empty_table($Catalogo);
        }

		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++){
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);
				$valorCelda = $valorA->getValue();
				$valorAi = intval($valorCelda);
				$data = array(
					'idEstado' => $valorAi,
					'Estado' => $valorB
				);
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($Catalogo, $data);

				//echo $valorAi.' '.$valorB;
			//}
			echo '<br/>';
			
    }
		
	}
    public function cLocalidades_update($fn) {
		$catalogo = 'cLocalidades';
		$nArch = 'Catalogos/cLocalidades.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);
        $totalRegistros = $this->db->count_all($catalogo);

        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }
		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++){
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);
				$valorC = $hojaActual->getCellByColumnAndRow(3,$indiceFila);
				$valorD = $hojaActual->getCellByColumnAndRow(4,$indiceFila);
				$valorE = $hojaActual->getCellByColumnAndRow(5,$indiceFila);
				$valorF = $hojaActual->getCellByColumnAndRow(6,$indiceFila);
				$valorG = $hojaActual->getCellByColumnAndRow(7,$indiceFila);
				$valorH = $hojaActual->getCellByColumnAndRow(8,$indiceFila);
				$valorI = $hojaActual->getCellByColumnAndRow(9,$indiceFila);
				$valorJ = $hojaActual->getCellByColumnAndRow(10,$indiceFila);
				$valorK = $hojaActual->getCellByColumnAndRow(11,$indiceFila);
				$valorL = $hojaActual->getCellByColumnAndRow(12,$indiceFila);
				$valorM = $hojaActual->getCellByColumnAndRow(13,$indiceFila);

				
				$valorCelda = $valorA->getValue();
				$valorAi = intval($valorCelda);

				$valorCelda = $valorD->getValue();
				$valorDi = intval($valorCelda);

				$valorCelda = $valorE->getValue();
				$valorEi = intval($valorCelda);

				$valorCelda = $valorG->getValue();
				$valorGi = floatval($valorCelda);

				$valorCelda = $valorH->getValue();
				$valorHi = floatval($valorCelda);

				$valorCelda = $valorI->getValue();
				$valorIi = intval($valorCelda);

				$valorCelda = $valorJ->getValue();
				$valorJi = intval($valorCelda);

				$valorCelda = $valorK->getValue();
				$valorKi = intval($valorCelda);
				
				$valorCelda = $valorL->getValue();
				$valorLi = intval($valorCelda);

				$valorCelda = $valorM->getValue();
				$valorMi = intval($valorCelda);

				$data = array(
					'idLocalidad' => $valorAi,
					'ClaveLocalidad' => $valorB,
					'Localidad' => $valorC,
					'idEstado' => $valorDi,
					'idMunicipio' => $valorEi,
					'TipoLocalidad' => $valorF,
					'Latitud' => $valorGi,
					'Longitud' => $valorHi,
					'Altitud' => $valorIi,
					'PoblacionTotal' => $valorJi,
					'PoblacionMasculina' => $valorKi,
					'PoblacionFemenina' => $valorLi,
					'TotalViviendasHabitadas' => $valorMi

				);
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				//echo $valorAi.' 		'.$valorB.'		'.$valorC.'		'.$valorDi.'	'.$valorEi.'	'.$valorF.'		'.$valorGi.'	'.$valorHi.'	'.'		'.$valorIi.'	'.$valorJi.'	'.$valorKi.'	'.$valorLi.'	'.$valorMi;
			//}
			echo '<br/>';
			
    }
		
	}
    public function cZonasImpulso_update($fn) {
		$catalogo = 'cZonasImpulso';
		$nArch = 'Catalogos/cZonasImpulso.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);
        $totalRegistros = $this->db->count_all($catalogo);

        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }
		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++){
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);
				$valorC = $hojaActual->getCellByColumnAndRow(3,$indiceFila);
				$valorD = $hojaActual->getCellByColumnAndRow(4,$indiceFila);
				$valorE = $hojaActual->getCellByColumnAndRow(5,$indiceFila);
				$valorF = $hojaActual->getCellByColumnAndRow(6,$indiceFila);
				$valorG = $hojaActual->getCellByColumnAndRow(7,$indiceFila);
				$valorH = $hojaActual->getCellByColumnAndRow(8,$indiceFila);
				$valorI = $hojaActual->getCellByColumnAndRow(9,$indiceFila);
				$valorJ = $hojaActual->getCellByColumnAndRow(10,$indiceFila);
				$valorK = $hojaActual->getCellByColumnAndRow(11,$indiceFila);
				$valorL = $hojaActual->getCellByColumnAndRow(12,$indiceFila);
				
				
				$valorCelda = $valorA->getValue();
				$valorAi = intval($valorCelda);

				$valorCelda = $valorB->getValue();
				$valorBi = intval($valorCelda);

				$valorCelda = $valorD->getValue();
				$valorDi = intval($valorCelda);

				$valorCelda = $valorF->getValue();
				$valorFi = intval($valorCelda);

				$valorCelda = $valorG->getValue();
				$valorGi = intval($valorCelda);

				$valorCelda = $valorH->getValue();
				$valorHi = intval($valorCelda);

				$valorCelda = $valorI->getValue();
				$valorIi = intval($valorCelda);

				$valorCelda = $valorJ->getValue();
				$valorJi = intval($valorCelda);

				$valorCelda = $valorK->getValue();
				$valorKi = intval($valorCelda);

				$data = array(
					'Ejercicio' => $valorAi,
					'idZonaImpulso' => $valorBi,
					'nombre' => $valorC,
					'cve_mun' => $valorDi,
					'origen' => $valorE,
					'poblacion_total' => $valorFi,
					'viviendas_totales' => $valorGi,
					'personas_encuestadas' => $valorHi,
					'viviendas_encuestadas' => $valorIi,
					'coordenadasCentro' => $valorJi,
					'Etapa' => $valorKi,
					'cve_impuls' => $valorL
				);
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				//echo $valorAi.' 		'.$valorBi.'		'.$valorC.'		'.$valorDi.'	'.$valorE.'	'.$valorFi.'		'.$valorGi.'	'.$valorHi.'		'.$valorIi.'	'.$valorJi.'	'.$valorKi.'	'.$valorL;
			//}
			//echo '<br/>';
			
    }
		
	}
    public function cCentrosTrabajo_update($fn) {
		$catalogo = 'cCentrosTrabajo';
		$nArch = 'Catalogos/cCentrosTrabajo.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);
        $totalRegistros = $this->db->count_all($catalogo);

        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }
		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++){
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);
				$valorC = $hojaActual->getCellByColumnAndRow(3,$indiceFila);
				$valorD = $hojaActual->getCellByColumnAndRow(4,$indiceFila);
				$valorE = $hojaActual->getCellByColumnAndRow(5,$indiceFila);
				$valorF = $hojaActual->getCellByColumnAndRow(6,$indiceFila);
				$valorG = $hojaActual->getCellByColumnAndRow(7,$indiceFila);
				$valorH = $hojaActual->getCellByColumnAndRow(8,$indiceFila);
				$valorI = $hojaActual->getCellByColumnAndRow(9,$indiceFila);
				$valorJ = $hojaActual->getCellByColumnAndRow(10,$indiceFila);
				$valorK = $hojaActual->getCellByColumnAndRow(11,$indiceFila);
				$valorL = $hojaActual->getCellByColumnAndRow(12,$indiceFila);
				$valorM = $hojaActual->getCellByColumnAndRow(13,$indiceFila);
				$valorN = $hojaActual->getCellByColumnAndRow(14,$indiceFila);
				$valorO = $hojaActual->getCellByColumnAndRow(15,$indiceFila);
				$valorP = $hojaActual->getCellByColumnAndRow(16,$indiceFila);
				$valorQ = $hojaActual->getCellByColumnAndRow(17,$indiceFila);

				
				$valorCelda = $valorA->getValue();
				$valorAi = intval($valorCelda);

				$valorCelda = $valorJ->getValue();
				$valorJi = intval($valorCelda);

				$valorCelda = $valorN->getValue();
				$valorNi = floatval($valorCelda);

				$valorCelda = $valorO->getValue();
				$valorOi = floatval($valorCelda);

				$data = array(
					'idCCT' => $valorAi,
					'ClaveCCT' => $valorB,
					'NombreCCT' => $valorC,
					'Nivel' => $valorD,
					'Modalidad' => $valorE,
					'Sostenimiento' => $valorF,
					'Estatus' => $valorG,
					'Domicilio' => $valorH,
					'Region' => $valorI,
					'idMunicipio' => $valorJi,
					'CP' => $valorK,
					'Poblacion' => $valorL,
					'Marginacion' => $valorM,
					'Longitud' => $valorNi,
					'Latitud' => $valorOi,
					'Turno' => $valorP,
					'Provisional' => $valorQ,
				);
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				//echo $valorAi.' 		'.$valorB.'		'.$valorC.'		'.$valorD.'	'.$valorE.'	'.$valorF.'		'.$valorG.'		'.$valorH.'		'.$valorI.'		'.$valorJi.'	'.$valorK.'		'.$valorL.'		'.$valorM.'		'.$valorNi.'		'.$valorOi.'		'.$valorP.'		'.$valorQ;
			//}
			//echo '<br/>';
			
    }
		
	}

    public function cTiposAsentamientos_update($fn) {
		$catalogo = 'cTiposAsentamientos';
		$nArch = 'Catalogos/cTiposAsentamientos.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);
        $totalRegistros = $this->db->count_all($catalogo);

        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }
		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++){
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);
				
				
				$valorCelda = $valorA->getValue();
				$valorAi = intval($valorCelda);

				$data = array(
					'idTipoAsentamiento' => $valorAi,
					'TipoAsentamiento' => $valorB
				);
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				//echo $valorAi.' 		'.$valorB;
			//}
			//echo '<br/>';
			
    }
		
	}
		/*33.- cTiposVialidades*/
		public function cTiposVialidades_update($fn) {
		$catalogo = 'cTiposVialidades';
		$nArch = 'Catalogos/cTiposVialidades.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);
        $totalRegistros = $this->db->count_all($catalogo);

        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }
		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++){
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);
				
				
				$valorCelda = $valorA->getValue();
				$valorAi = intval($valorCelda);

				$data = array(
					'idTipoVialidad' => $valorAi,
					'TipoVialidad' => $valorB
				);
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				//echo $valorAi.' 		'.$valorB;
			//}
			//echo '<br/>';
			
    }
		
	}
		public function cSituaciones_update($fn) {
		$catalogo = 'cSituaciones';
		$nArch = 'Catalogos/35.- cSituaciones.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);
        $totalRegistros = $this->db->count_all($catalogo);

        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }
		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++){
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);
				$valorC = $hojaActual->getCellByColumnAndRow(3,$indiceFila);

				
				$valorCelda = $valorA->getValue();
				$valorAi = intval($valorCelda);

				$data = array(
					'idSituacion' => $valorAi,
					'Situacion' => $valorB,
					'DescSituacion' => $valorC
				);
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				//echo $valorAi.' 		'.$valorB.'		'.$valorC;
			//}
			//echo '<br/>';
			
    }
		
	}
    public function vwmd_ProgramaSectorial_update($fn) {
		$catalogo = 'vwmd_ProgramaSectorial';
		$nArch = 'Catalogos/37.- vwmd_ProgramaSectorial.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);
        $totalRegistros = $this->db->count_all($catalogo);

        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }

		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++){
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);
				$valorC = $hojaActual->getCellByColumnAndRow(3,$indiceFila);
				$valorD = $hojaActual->getCellByColumnAndRow(4,$indiceFila);
				$valorE = $hojaActual->getCellByColumnAndRow(5,$indiceFila);
				
				
				
				$valorCelda = $valorE->getValue();
				$valorEi = intval($valorCelda);

				$data = array(
					'ProgramaSectorial' => $valorA,
					'LineaEstrategica' => $valorB,
					'Objetivo' => $valorC,
					'LineaAccion' => $valorD,
					'Vigente' => $valorEi
				);
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				echo $valorA.' 		'.$valorB.' 		'.$valorC.' 		'.$valorD.' 		'.$valorEi;
			//}
			echo '<br/>';
			
    }
		
	}
		public function cAgendas_update($fn) {
		$catalogo = 'cAgendas';
		$nArch = 'Catalogos/38.- cAgendas.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);
        $totalRegistros = $this->db->count_all($catalogo);

        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }

		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++){
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);
				$valorC = $hojaActual->getCellByColumnAndRow(3,$indiceFila);
				$valorD = $hojaActual->getCellByColumnAndRow(4,$indiceFila);
				
				
				$valorCelda = $valorA->getValue();
				$valorAi = intval($valorCelda);

				$valorCelda = $valorC->getValue();
				$valorCi = intval($valorCelda);

				$data = array(
					'idAgenda' => $valorAi,
					'Descripcion' => $valorB,
					'idTipoAgenda' => $valorCi,
					'NombreCorto' => $valorD
				);
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				//echo $valorAi.' 		'.$valorB.' 		'.$valorCi.' 		'.$valorD;
			//}
			//echo '<br/>';
			
    }
		
	}
	public function cTiposBeneficiarios_update($fn) {
		$catalogo = 'cTiposBeneficiarios';
		$nArch = 'Catalogos/45.- cTiposBeneficiarios.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);
        $totalRegistros = $this->db->count_all($catalogo);

        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }

		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++){
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);
				$valorC = $hojaActual->getCellByColumnAndRow(3,$indiceFila);

				
				$valorCelda = $valorA->getValue();
				$valorAi = intval($valorCelda);

				$data = array(
					'idTipoBeneficiario' => $valorAi,
					'clave' => $valorB,
					'descripcion' => $valorC
				);
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				//echo $valorAi.' 		'.$valorB.' 		'.$valorC;
			//}
			//echo '<br/>';
			
    }
		
	}
    
    public function catPais_update() {
		$catalogo = 'catPais';
		$nArch = 'Catalogos/catPais.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		$this->load->model("pruebamodelo");
		$this->pruebamodelo->deletedb($catalogo);

		for($indiceFila = 7; $indiceFila<=$nFilas; $indiceFila++){
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);
				
				
				$valorCelda = $valorA->getValue();
				$valorAi = intval($valorCelda);

				$data = array(
					'idPais' => $valorAi,
					'nombreCortoIngles' => $valorB
				);
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				//echo $valorAi.' 		'.$valorB;
			//}
			//echo '<br/>';
			
    }
		
	}
	public function cCalificacionesCualitativas_update($fn) {
		$catalogo = 'cCalificacionesCualitativas';
		$nArch = 'Catalogos/cCalificacionesCualitativas.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);
        $totalRegistros = $this->db->count_all($catalogo);

        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }

		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++){
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);
				
				
				$valorCelda = $valorA->getValue();
				$valorAi = intval($valorCelda);

				$data = array(
					'idCalificacion' => $valorAi,
					'Calificacion' => $valorB
				);
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				//echo $valorAi.' 		'.$valorB;
			//}
			//echo '<br/>';
			
    }
		
	}
	
	public function cCodigosSepomex_update($fn) {
		$catalogo = 'cCodigosSepomex';
		$nArch = 'Catalogos/cCodigosSepomex.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);
        $totalRegistros = $this->db->count_all($catalogo);

        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }

		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++){
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);
				$valorC = $hojaActual->getCellByColumnAndRow(3,$indiceFila);
				$valorD = $hojaActual->getCellByColumnAndRow(4,$indiceFila);
				$valorE = $hojaActual->getCellByColumnAndRow(5,$indiceFila);
				$valorF = $hojaActual->getCellByColumnAndRow(6,$indiceFila);
				$valorG = $hojaActual->getCellByColumnAndRow(7,$indiceFila);
				$valorH = $hojaActual->getCellByColumnAndRow(8,$indiceFila);
				$valorI = $hojaActual->getCellByColumnAndRow(9,$indiceFila);
				$valorJ = $hojaActual->getCellByColumnAndRow(10,$indiceFila);
				$valorK = $hojaActual->getCellByColumnAndRow(11,$indiceFila);
				$valorL = $hojaActual->getCellByColumnAndRow(12,$indiceFila);
				$valorM = $hojaActual->getCellByColumnAndRow(13,$indiceFila);
				$valorN = $hojaActual->getCellByColumnAndRow(14,$indiceFila);
				$valorO = $hojaActual->getCellByColumnAndRow(15,$indiceFila);
				$valorP = $hojaActual->getCellByColumnAndRow(16,$indiceFila);
				
				
				$valorCelda = $valorA->getValue();
				$valorAi = intval($valorCelda);

				$valorCelda = $valorG->getValue();
				$valorGi = intval($valorCelda);

				$valorCelda = $valorH->getValue();
				$valorHi = intval($valorCelda);

				$valorCelda = $valorI->getValue();
				$valorIi = intval($valorCelda);

				$valorCelda = $valorP->getValue();
				$valorPi = intval($valorCelda);



				$data = array(
					'd_codigo' => $valorAi,
					'd_asenta' => $valorB ,
					'd_tipo_asenta' => $valorC,
					'D_mnpio' => $valorD,
					'd_estado' => $valorE,
					'd_ciudad' => $valorF,
					'd_CP' => $valorGi,
					'c_estado' => $valorHi,
					'c_oficina' => $valorIi,
					'c_CP' => $valorJ,
					'c_tipo_asenta' => $valorK,
					'c_mnpio' => $valorL,
					'id_asenta_cpcons' => $valorM,
					'd_zona' => $valorN,
					'c_cve_ciudad' => $valorO,
					'idCodigoPostal' => $valorPi
					
				);
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				//echo $valorAi.' 		'.$valorB.'		'.$valorC.'		'.$valorD.'	'.$valorE.'		'.$valorF.'		'.$valorGi.'	'.$valorHi.'		'.$valorIi.'	'.$valorJ.'	'.$valorK.'		'.$valorL.' 		'.$valorM.' 		'.$valorN.' 		'.$valorO.' 		'.$valorPi;
			//}
			//echo '<br/>';
			
    }
		
	}

    public function cEjes_update() {
		$catalogo = 'cEjes';
		$nArch = 'Catalogos/cEjes.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		$this->load->model("pruebamodelo");
		$this->pruebamodelo->deletedb($catalogo);

		for($indiceFila = 7; $indiceFila<=$nFilas; $indiceFila++){
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);
				$valorC = $hojaActual->getCellByColumnAndRow(3,$indiceFila);

				
				$valorCelda = $valorA->getValue();
				$valorAi = intval($valorCelda);

				$data = array(
					'idEje' => $valorAi,
					'Eje' => $valorB,
					'Periodo' => $valorC
				);
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				//echo $valorAi.' 		'.$valorB.' 		'.$valorC;
			//}
			//echo '<br/>';
			
    }
		
	}
	public function cEjesEstrategicos_update($fn) {
		$catalogo = 'cEjesEstrategicos';
		$nArch = 'Catalogos/cEjesEstrategicos.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);
        $totalRegistros = $this->db->count_all($catalogo);

        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }

		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++){
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);

				
				$valorCelda = $valorA->getValue();
				$valorAi = intval($valorCelda);

				$data = array(
					'idEjeEstrategico' => $valorAi,
					'EjeEstrategico' => $valorB
				);
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				//echo $valorAi.' 		'.$valorB;
			//}
			//echo '<br/>';
			
    }
		
	}
	public function cEstadosCivil_update($fn) {
		$catalogo = 'cEstadosCivil';
		$nArch = 'Catalogos/cEstadosCivil.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);
        $totalRegistros = $this->db->count_all($catalogo);

        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }

		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++){
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);

				
				$valorCelda = $valorA->getValue();
				$valorAi = intval($valorCelda);

				$data = array(
					'idEstadoCivil' => $valorAi,
					'DescripcionEstadoCivil' => $valorB
				);
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				//echo $valorAi.' 		'.$valorB;
			//}
			//echo '<br/>';
			
    }
		
	}
	public function cEstrategias_PG_update($fn) {
		$catalogo = 'cEstrategias_PG';
		$nArch = 'Catalogos/cEstrategias_PG.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);
        $totalRegistros = $this->db->count_all($catalogo);

        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }

		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++){
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);
				$valorC = $hojaActual->getCellByColumnAndRow(3,$indiceFila);
				$valorD = $hojaActual->getCellByColumnAndRow(4,$indiceFila);

				
				$valorCelda = $valorA->getValue();
				$valorAi = intval($valorCelda);

				$valorCelda = $valorB->getValue();
				$valorBi = intval($valorCelda);

				$data = array(
					'idEstrategiaPG' => $valorAi,
					'idObjetivoPG' => $valorBi,
					'ClaveEstrategia' => $valorC,
					'NombreEstrategia' => $valorD
				);
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				//echo $valorAi.' 		'.$valorB.' 		'.$valorC.' 		'.$valorD;
			//}
			//echo '<br/>';
			
    }
		
	}
	public function cGrupoCategorias_update($fn) {
		$catalogo = 'cGrupoCategorias';
		$nArch = 'Catalogos/cGrupoCategorias.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);
        $totalRegistros = $this->db->count_all($catalogo);

        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }

		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++){
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);

				
				$valorCelda = $valorA->getValue();
				$valorAi = intval($valorCelda);

				$data = array(
					'idGrupoCategoria' => $valorAi,
					'GrupoCategoria' => $valorB
				);
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				//echo $valorAi.' 		'.$valorB;
			//}
			//echo '<br/>';
			
    }
		
	}

    public function cMeses_update($fn) {
		$catalogo = 'cMeses';
		$nArch = 'Catalogos/cMeses.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);
        $totalRegistros = $this->db->count_all($catalogo);

        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }

		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++){
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);
				$valorC = $hojaActual->getCellByColumnAndRow(3,$indiceFila);

				
				$valorCelda = $valorA->getValue();
				$valorAi = intval($valorCelda);

				$data = array(
					'idMes' => $valorAi,
					'Mes' => $valorB,
					'NombreCortoMes' => $valorC
				);
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				//echo $valorAi.' 		'.$valorB.' 		'.$valorC;
			//}
			//echo '<br/>';
			
    }
		
	}
	public function cModalidadesContratacion_update($fn) {
		$catalogo = 'cModalidadesContratacion';
		$nArch = 'Catalogos/cModalidadesContratacion.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);
        $totalRegistros = $this->db->count_all($catalogo);

        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }

		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++){
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);

				
				$valorCelda = $valorA->getValue();
				$valorAi = intval($valorCelda);

				$data = array(
					'idModalidadContratacion' => $valorAi,
					'Modalidad' => $valorB
				);
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				//echo $valorAi.' 		'.$valorB;
			//}
			//echo '<br/>';
			
    }
		
	}
	public function cObjetivos_PG_update($fn) {
		$catalogo = 'cObjetivos_PG';
		$nArch = 'Catalogos/cObjetivos_PG.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);
        $totalRegistros = $this->db->count_all($catalogo);

        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }

		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++){
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);
				$valorC = $hojaActual->getCellByColumnAndRow(3,$indiceFila);

				
				$valorCelda = $valorA->getValue();
				$valorAi = intval($valorCelda);

				$data = array(
					'idObjetivoPG' => $valorAi,
					'ClaveObjetivo' => $valorB,
					'NombreObjetivo' => $valorC
				);
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				//echo $valorAi.' 		'.$valorB.' 		'.$valorC;
			//}
			//echo '<br/>';
			
    }
		
	}
	public function cTiposAgendas_update($fn) {
		$catalogo = 'cTiposAgendas';
		$nArch = 'Catalogos/cTiposAgendas.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);
        $totalRegistros = $this->db->count_all($catalogo);

        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }

		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++){
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);

				
				$valorCelda = $valorA->getValue();
				$valorAi = intval($valorCelda);

				$data = array(
					'idTipoAgenda' => $valorAi,
					'TipoAgenda' => $valorB
				);
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				//echo $valorAi.' 		'.$valorB;
			//}
			//echo '<br/>';
			
    }
		
	}
	public function cTiposConcurrencias_update($fn) {
		$catalogo = 'cTiposConcurrencias';
		$nArch = 'Catalogos/cTiposConcurrencias.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);
        $totalRegistros = $this->db->count_all($catalogo);

        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }

		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++){
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);

				
				$valorCelda = $valorA->getValue();
				$valorAi = intval($valorCelda);

				$data = array(
					'idTipoConcurrencia' => $valorAi,
					'TipoConcurrencia' => $valorB
				);
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				//echo $valorAi.' 		'.$valorB;
			//}
			//echo '<br/>';
			
    }
		
	}
	public function cTiposEnfoques_update($fn) {
		$catalogo = 'cTiposEnfoques';
		$nArch = 'Catalogos/cTiposEnfoques.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);
        $totalRegistros = $this->db->count_all($catalogo);

        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }

		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++){
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);

				
				$valorCelda = $valorA->getValue();
				$valorAi = intval($valorCelda);

				$data = array(
					'idTipoEnfoque' => $valorAi,
					'TipoEnfoque' => $valorB
				);
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				//echo $valorAi.' 		'.$valorB;
			//}
			//echo '<br/>';
			
    }
		
	}
	public function cTiposObrasAccionesG1_update($fn) {
		$catalogo = 'cTiposObrasAccionesG1';
		$nArch = 'Catalogos/cTiposObrasAccionesG1.xlsx';
		$documento = IOFactory::load($nArch);
		$totalHojas = $documento->getSheetCount();

		//for($indiceHoja = 0;$IndiceHoja < $totalHojas; $IndiceHoja++){}
		$hojaActual = $documento->getSheet(0);
		$nFilas = $hojaActual->getHighestDataRow();
		$letra = $hojaActual->getHighestColumn();

		$nLetra = Coordinate::columnIndexFromString($letra);
		$this->load->helper('url');
		//$this->load->model("pruebamodelo");
		//$this->pruebamodelo->deletedb($catalogo);
        $totalRegistros = $this->db->count_all($catalogo);

        if ($totalRegistros > 0) {
            $this->db->empty_table($catalogo);
        }

		for($indiceFila = $fn; $indiceFila<=$nFilas; $indiceFila++){
			//for($indiceColumna = 1; $indiceColumna<=$nLetra; $indiceColumna++){
				
				$valorA = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
				$valorB = $hojaActual->getCellByColumnAndRow(2,$indiceFila);

				
				$valorCelda = $valorA->getValue();
				$valorAi = intval($valorCelda);

				$data = array(
					'idTipoObraAccionG1' => $valorAi,
					'TipoObraAccionG1' => $valorB
				);
				//$sql = "insert into cEstados(idEstado,Estado) values ('$valorA','$valorB');";
				
				//$arr=$this->pruebamodelo->insertardb($Catalogo,$data);
                $this->db->insert($catalogo, $data);

				//echo $valorAi.' 		'.$valorB;
			//}
			//echo '<br/>';
			
    }
		
	}
}
?>