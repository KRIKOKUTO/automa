<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpParser\Node\Expr\FuncCall;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Fill;


defined ('BASEPATH') OR exit('No direct script access allowed');

class Automatizar extends CI_Controller {
    
    //DATOS INICIALES
    private $indiceBeneficiarios; //indice
    private $indiceiGto;
    private $nArchiGto;
    private $spreadsheetiGto;
    private $worksheetiGtoAFM;
    private $worksheetiGtoMP;
    private $nArchBeneficiarios;
    private $spreadsheetBeneficiarios;
    private $worksheetBeneficiarios;
    private $writer;
    



    //public $inicialConsecutivo;
    public function __construct() {
        parent::__construct();
        $cdn_url = "https://code.jquery.com/jquery-3.6.4.min.js";

        
        echo "<script src='$cdn_url'></script>";
        $this->load->helper(array('form', 'url'));
        $this->load->model("gestorDB");
        $this->load->model("automatizar_model");
        $this->load->model("cat_update");
        if ($this->session->userdata()['estado'] == 'inactivo'){
            redirect('pinactivo/redirigir');
        }
        
        
        if ($this->session->userdata()['rol'] == 'planeacion'){
            $navbar_data['title'] = 'Barra de Navegación';
            $this->load->view('navbar', $navbar_data);
        } else if($this->session->userdata()['rol'] == 'TI'){
            $navbar_data['title'] = 'Barra de Navegación';
            $this->load->view('navbarti', $navbar_data);
        } else if($this->session->userdata()['rol'] == null){
            redirect('auth/login');
        }
        
        //Foa
        //$this->inicialConsecutivo = 469;

        //DATOS INICIALES
        $this->indiceBeneficiarios = 2; //indice
        $this->indiceiGto = 3;
        $this->spreadsheetiGto = new Spreadsheet;

        $this->nArchBeneficiarios = 'Obtenidos/Beneficiarios.xlsx';
        $this->spreadsheetBeneficiarios = IOFactory::load($this->nArchBeneficiarios);
        $this->worksheetBeneficiarios = $this->spreadsheetBeneficiarios->getActiveSheet();
        //$this->writer = IOFactory::createWriter($this->spreadsheetiGto, 'Xlsx');
        //echo 'AUTOMATIZADO';
        
       //$this->inicialConsecutivo = 1;
    }

    public function index() {
        //echo $this->session->userdata()['rol'].'<br>';
        //echo $this->session->userdata()['estado'].'<br>';
        $tabla = 'archivos';
        $data['nombreArchivo'] = 'Beneficiarios.xlsx';
        $data['rol'] = $this->session->userdata()['rol'];
        $data['filas'] = $this->gestorDB->obtenerTabla(); 

        $this->load->view('automatizar_view', $data);

    }

    public function mes(){
        $mes_ = $this->input->post('mes_');

        $tabla = 'archivos';
        $data['nombreArchivo'] = 'Beneficiarios.xlsx';
        $data['rol'] = $this->session->userdata()['rol'];
        $data['filas'] = $this->gestorDB->obtener_filas($tabla,$mes_); 

        $this->load->view('automatizar_view', $data);
    }
    public function actualizarvista(){
        redirect('automatizar');
    }

    public function geozona(){
        
        $fecha1 = $this->input->post('fecha_');
        
        
        $config['upload_path'] = FCPATH . 'Obtenidos/geozonas';
        $config['allowed_types']    = 'xlsx|xls';
        $config['max_size']         = 10000; // en kilobytes
        $config['file_name']        = 'geozonas_'.$fecha1.'.xlsx'; 
        //$nArchi =  'Obtenidos/geozonas/'.$config['file_name'];

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('archivo'))
        {
            //echo $fecha1;
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('noarchivo');
            //print_r($error); 

        }
        else
        {
            echo $fecha1;
            echo $config['file_name'];

            $archivoOrigen =   FCPATH .'Generados/iGTO/iGTO_'.$fecha1.'.xlsx';
            $carpetaDestino = FCPATH. 'Generados/iGTO+/';
            copy($archivoOrigen, $carpetaDestino . basename($archivoOrigen));

            $geozonasarch = new Spreadsheet;
            $geozonasarch = IOFactory::load('Obtenidos/geozonas/geozonas_'.$fecha1.'.xlsx');
            $geozonassheet = $geozonasarch->getActiveSheet();

            $igto_ = new Spreadsheet;
            $igto_ = IOFactory::load('Generados/IGTO+/iGTO_'.$fecha1.'.xlsx');
            $igto_mpr = $igto_->getSheetByName('mProyectos');

            $nArchi = $this->automatizar_model->geozon($fecha1,$geozonassheet,$igto_mpr,$igto_);

            $data = array(
                //'fecha' => $fecha,
                //'beneficiarios' => $nArchi
                //'igto' => $nArchi,
                'igto_' => $nArchi,
                //'status' => $valorAi
            );
            //$this->gestorDB->insertardb('archivos', $data);
            $this->gestorDB->insertardbwhere('archivos','fecha',$fecha1,$data);
            //echo 'El archivo se subió correctamente.';
            redirect('automatizar');
            //return array($fechaActual,$nArchi);
        }
        

        


    }


    public function automatizado(){
        $fecha1 = $this->input->post('fecha');
        //$fecha1 = '2023-10-13_22-31-30';
        $ejercicio1 = $this->gestorDB->getid('archivos','fecha',$fecha1,'ano');
        
        //$ejercicio1 = 2023;
        $mes =  $this->gestorDB->getid('archivos','fecha',$fecha1,'mes');
        //$mes = 'enero';
        $nArchBeneficiarios = 'Obtenidos/beneficiarios/Beneficiarios_'.$fecha1.'.xlsx';
        $spreadsheetBeneficiarios = IOFactory::load($nArchBeneficiarios);
        $worksheetBeneficiarios = $spreadsheetBeneficiarios->getActiveSheet();


        $writer = IOFactory::createWriter($this->spreadsheetiGto, 'Xlsx');
        $worksheetiGtomPr = $this->spreadsheetiGto->createSheet();
        $worksheetiGtomPr ->setTitle('mProyectos');

        //gestionar folios

        $highestRow = $worksheetBeneficiarios->getHighestRow();
        $columnaA = $worksheetBeneficiarios->getCellByColumnAndRow(2, 1)->getValue();


        
        $this->load->database();

        
        for ($row = 2; $row < $highestRow+1; $row++) {

            /*if ($ejercicio1 != null){
                $ejercicio1 = $ejercicio;
            }*/

            // Obtener folio
            $valorCelda = $worksheetBeneficiarios->getCellByColumnAndRow(3, $row)->getValue();

            // Verificar si existe el folio
            $this->db->select('folio');
            $this->db->from('foas');
            $this->db->where('folio', $valorCelda);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                //echo "El folio $valorCelda existe en la base de datos.<br>";
            } else {
                //echo $ejercicio1;
                $this->gestorDB->foa_($ejercicio1,3025,1,$valorCelda);
            }
            
        }
        


        //encabezados
        $datos = $this->automatizar_model->encabezadosmPro();
        $worksheetiGtomPr->getStyle('A'.'1'.':BD'.'1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFD966');
        $worksheetiGtomPr->getStyle('A'.'2'.':BD'.'2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('92D050');
        $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtomPr,1,$datos[0]);
        $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtomPr,2,$datos[1]);


        $worksheetiGtoAFM = $this->spreadsheetiGto->createSheet();
        $worksheetiGtoAFM ->setTitle('Avance financiero mensual');
        //encabezados
        $datos = $this->automatizar_model->encabezadosAFM();
        $worksheetiGtoAFM->getStyle('A'.'1'.':O'.'1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFD966');
        $worksheetiGtoAFM->getStyle('A'.'2'.':O'.'2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('92D050');
        $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtoAFM,1,$datos[0]);
        $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtoAFM,2,$datos[1]);


        $worksheetiGtoMP = $this->spreadsheetiGto->createSheet();
        $worksheetiGtoMP->setTitle('Metas proyectos');
        //encabezados
        $datos = $this->automatizar_model->encabezadosMetproyectos();
        $worksheetiGtoMP->getStyle('A'.'1'.':D'.'1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFD966');
        $worksheetiGtoMP->getStyle('A'.'2'.':D'.'2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('92D050');
        $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtoMP,1,$datos[0]);
        $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtoMP,2,$datos[1]);


        $worksheetiGtomTP = $this->spreadsheetiGto->createSheet();
        $worksheetiGtomTP ->setTitle('relProyecto_iGTO_cTiposBenefici');
        //encabezados
        $datos = $this->automatizar_model->encabezadosTP();
        $worksheetiGtomTP->getStyle('A'.'1'.':D'.'1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFD966');
        $worksheetiGtomTP->getStyle('A'.'2'.':D'.'2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('92D050');
        $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtomTP,1,$datos[0]);
        $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtomTP,2,$datos[1]);


        $worksheetiGtoE = $this->spreadsheetiGto->createSheet();
        $worksheetiGtoE ->setTitle('relProyecto_iGTO_cEnfoques');
        //encabezados
        $datos = $this->automatizar_model->encabezadosEn();
        $worksheetiGtoE->getStyle('A'.'1'.':D'.'1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFD966');
        $worksheetiGtoE->getStyle('A'.'2'.':D'.'2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('92D050');
        $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtoE,1,$datos[0]);
        $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtoE,2,$datos[1]);


        $worksheetiGtoEI = $this->spreadsheetiGto->createSheet();
        $worksheetiGtoEI ->setTitle('relProyecto_iGTO_cElementosInst');
        //encabezados
        $datos = $this->automatizar_model->encabezadosEI();
        $worksheetiGtoEI->getStyle('A'.'1'.':D'.'1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFD966');
        $worksheetiGtoEI->getStyle('A'.'2'.':D'.'2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('92D050');
        $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtoEI,1,$datos[0]);
        $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtoEI,2,$datos[1]);


        //$fechaActual = date('Y-m-d');
        //$fecha1 = $this->input->post('fecha');
        

        $this->automaAFM($worksheetiGtoAFM,$worksheetBeneficiarios,$mes);
        $this->indiceiGto = 3;
        $this->automaMP($worksheetiGtoMP,$worksheetBeneficiarios);
        $this->indiceiGto = 3;
        $this->automaTB($worksheetiGtomTP,$worksheetBeneficiarios);
        $this->indiceiGto = 3;
        $this->automaE($worksheetiGtoE,$worksheetBeneficiarios);
        $this->indiceiGto = 3;
        $this->automaEI($worksheetiGtoEI,$worksheetBeneficiarios);
        $this->indiceiGto = 3;
        $this->automamProyectos($worksheetiGtomPr,$worksheetBeneficiarios,$fecha1);
        $writer->save('Generados/iGTO/iGTO_'.$fecha1.'.xlsx');
        $nArchi =  'Generados/iGTO/iGTO_'.$fecha1.'.xlsx';
        $data = array(
            //'fecha' => $fechaA,
            //'beneficiarios' => $nArchi
            'igto' => $nArchi
            //'igto_' => $valorB,
            //'status' => $valorAi
        );
        //$this->gestorDB->insertardb('archivos', $data);
        $this->gestorDB->insertardbwhere('archivos','fecha',$fecha1,$data);
        //echo 'yeeet';
        
        redirect('automatizar');
        
        
    }
    public function actualizar_vista() {
        $tabla = 'archivos';
        $data['nombreArchivo'] = 'Beneficiarios.xlsx';
        $data['filas'] = $this->gestorDB->obtenerTabla(); 
        $data['rol'] = $this->session->userdata()['rol'];

        
        $this->load->view('automatizar_view',$data);
    }

    public function vaciarfoas(){
        $this->gestorDB->emptyfoa();
    }

    public function generarFoayGuardarenDB(){
        $ejercicio = '2023';
        $fijo = '3025';
        $consecutivo = 1;
        $this->gestorDB->foa($ejercicio,$consecutivo);
    }
    public function resetfoa(){
        $contrasena = $this->input->post('pass');
        $contrasenaEncriptada = $this->session->userdata()['pass'];

        
        if( password_verify($contrasena, $contrasenaEncriptada) == true){
            /*
            $ejercicio = $_POST["ano"];
            $consecutivo = $_POST["numero"];
            $fijo = '3025';
            */
            $this->gestorDB->vaciartabla('foas');
            //$this->gestorDB->foa($ejercicio,$fijo,$consecutivo);

            $data['filas'] = $this->gestorDB->obtenerDatos();

            $this->load->view('foas_view', $data);
        }else{
            echo 'contraseña incorrecta';
        }
        
    }
    public function borrarArch(){
        $contrasena = $this->input->post('pass');
        $contrasenaEncriptada = $this->session->userdata()['pass'];

        
        if( password_verify($contrasena, $contrasenaEncriptada) == true){
            
            $this->gestorDB->vaciartabla('archivos');
            //$this->gestorDB->foa($ejercicio,$fijo,$consecutivo);
            $destinationPath = FCPATH . 'Obtenidos/beneficiarios';
            $this->automatizar_model->vaciarCarpeta($destinationPath);
            $destinationPath = FCPATH . 'Obtenidos/geozonas';
            $this->automatizar_model->vaciarCarpeta($destinationPath);
            $destinationPath = FCPATH . 'Generados/iGTO';
            $this->automatizar_model->vaciarCarpeta($destinationPath);
            $destinationPath = FCPATH . 'Generados/iGTO+';
            $this->automatizar_model->vaciarCarpeta($destinationPath);
            

            redirect('automatizar');
        }else{
            echo 'contraseña incorrecta';
        }
    }
    public function verfoas(){
        $data['filas'] = $this->gestorDB->obtenerDatos();
        $this->load->view('foas_view', $data);
    }
    

    public function do_upload()
    {
        $mesSeleccionado = $_POST['mes'];
        $ejercicio = $_POST['ano'];
        date_default_timezone_set('America/Mexico_City');
        $fechaActual = date('Y-m-d_H-i-s');
        $config['upload_path'] = FCPATH . 'Obtenidos/beneficiarios/';
        $config['allowed_types']    = 'xlsx|xls';
        $config['max_size']         = 10000; // en kilobytes
        $config['file_name']        = 'Beneficiarios_'.$fechaActual.'.xlsx'; 

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('archivo'))
        {
            $error = array('error' => $this->upload->display_errors());

            //$this->load->view('automatizar_view', $error);
            //return array();
        }
        else
        {
            $nArchi =  'Obtenidos/beneficiarios/'.$config['file_name'];
            $data = array(
                'fecha' => $fechaActual,
                'beneficiarios' => $nArchi,
                //'igto' => $valorAi,
                //'igto_' => $valorB,
                //'status' => $valorAi,
                'mes' => $mesSeleccionado,
                'ano' => $ejercicio
            );
            $this->gestorDB->insertardb('archivos', $data);
            //$this->gestorDB->insertardbwhere('archivos','fecha',$fecha,$data);
            //echo 'El archivo se subió correctamente.';
            redirect('automatizar');
            //return array($fechaActual,$nArchi);
        }
    }
    public function do_uploadiGto()
    {
        
        
        $fecha = $this->input->post('fecha');
        $config['upload_path'] = FCPATH . 'Generados/iGTO/';
        $config['allowed_types']    = 'xlsx|xls';
        $config['max_size']         = 10000; // en kilobytes
        $config['file_name']        = 'iGTO_'.$fecha.'.xlsx'; 
        $nArchi =  'Generados/iGTO/'.$config['file_name'];

        unlink($nArchi);
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('archivo'))
        {
            $error = array('error' => $this->upload->display_errors());
            print_r($error); 
            echo $config['file_name'];
            //$this->load->view('automatizar_view', $error);
            //return array();
        }
        else
        {
            
            $data = array(
                //'fecha' => $fecha,
                //'beneficiarios' => $nArchi
                'igto' => $nArchi,
                //'igto_' => $valorB,
                //'status' => $valorAi
            );
            //$this->gestorDB->insertardb('archivos', $data);
            $this->gestorDB->insertardbwhere('archivos','fecha',$fecha,$data);
            //echo 'El archivo se subió correctamente.';
            redirect('automatizar');
            //return array($fechaActual,$nArchi);
        }
    }
    public function do_uploadiGTO_()
    {
    
        $fecha = $this->input->post('fecha');
        $config['upload_path'] = FCPATH . 'Generados/iGTO+/';
        $config['allowed_types']    = 'xlsx|xls';
        $config['max_size']         = 10000; // en kilobytes
        $config['file_name']        = 'iGTO_'.$fecha.'.xlsx'; 
        $nArchi =  'Generados/iGTO+/'.$config['file_name'];

        unlink($nArchi);
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('archivo'))
        {
            $error = array('error' => $this->upload->display_errors());
            print_r($error); 
            echo $config['file_name'];
            //$this->load->view('automatizar_view', $error);
            //return array();
        }
        else
        {
            
            $data = array(
                //'fecha' => $fecha,
                //'beneficiarios' => $nArchi
                //'igto' => $nArchi,
                'igto_' => $nArchi,
                //'status' => $valorAi
            );
            //$this->gestorDB->insertardb('archivos', $data);
            $this->gestorDB->insertardbwhere('archivos','fecha',$fecha,$data);
            //echo 'El archivo se subió correctamente.';
            redirect('automatizar');
            //return array($fechaActual,$nArchi);
        }
    }




    public function automaAFM($worksheetiGtoAFM,$worksheetBeneficiarios,$mes){
        $this->load->helper('url');
        //$this->indiceiGto = 2;
        //$worksheetiGtoAFM ->setTitle('Avance financiero mensual');

        //DATOS DATOS POR EL USUARIO
        $colInicial='A'; //Columna inicial beneficiarios
        $colFinal='CR'; //Columna Final beneficiarios
        $filaInicial = 2;
        //$mes = 'JUNIO';

        //INICIA EL CICLO
        $filafinal= 100;
        $cicloN = 1;
        $ciclo = 100;
        //obtener array
        //OBTENER NUMERO TOTAL DE FILAS
        $totalFilas = $this->automatizar_model->numeroFilas($worksheetBeneficiarios);
        $totalFolios = $this->gestorDB->numFIl('foas');

        while ($filafinal < $totalFilas){
            //echo 'ciclo: '.$cicloN.'<br>';
            //echo 'fila inicial: '.$filaInicial.'<br>';
            //echo 'fila final:'.$filafinal.'<br>';
            $FilaB = $this->automatizar_model->obtenerFilaBeneficiario($worksheetBeneficiarios,$colInicial,$filaInicial,$colFinal,$filafinal);

            //$totalFilas = 10;
            for($i = $filaInicial; $i<=$filafinal; $i++){

                //OBTENER FOLIO
                $folio = $FilaB[$i]['C']; //C es la columna donde estan los folios de educafin

                //$this->gestorDB->foa_($ejercicio,3025,1,$folio);
                //$this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtoAFM,10,$valores);

                //VERIFICAR SI EL FOLIO OBTENIDO DEL EXCEL EXISTE EN LA BASE DE DATOS
                $validacion = $this->automatizar_model->coincidirfolioEnDB($folio);
                if ($validacion == true)
                {
                    //echo '<br>folio si esta cargado en la base de datos';
                    
                    //obtener FolioObraAccion desde la base de datos
                    $foai = $this->gestorDB->getFoaByFolio($folio);
                    $foa = "'".$foai;

                    //obtener ejercicio
                    $ejercicio = $FilaB[$i]['A'];

                    //obtener idMesFisico
                    //$idMesFisico = $this->automatizar_model->AFM_idMesFisico($mes);
                    $idMesFisico = $mes;

                    //obtener MontoEstatal
                    //$MontoEstatal = $FilaB[$indiceBeneficiarios]['BN'];
                    //$MontoEstatal = $FilaB[$indiceBeneficiarios]['BN'];
                    $filaInicio = $i;
                    $filaFin = $i;
                    $columnaInicio = 'AO';
                    $columnaFin = 'AZ';
                    $suma = 0;

                    for ($fila = $filaInicio; $fila <= $filaFin; $fila++) {
                        for ($columna = $columnaInicio; $columna <= $columnaFin; $columna++) {
                            $suma += $FilaB[$fila][$columna];
                        }
                    }
                    $MontoEstatal = $suma;

                    //MontoDeuda 
                    $MontoDeuda = 0;
                    //MontoRecursoPropio 

                    $filaInicio = $i;
                    $filaFin = $i;
                    $columnaInicio = 'BO';
                    $columnaFin = 'BZ';
                    $suma = 0;

                    for ($fila = $filaInicio; $fila <= $filaFin; $fila++) {
                        for ($columna = $columnaInicio; $columna <= $columnaFin; $columna++) {
                            $suma += $FilaB[$fila][$columna];
                        }
                    }
                    $MontoRecursoPropio = $suma;
                    
                    //MontoFederal	MontoMunicipal	MontoOtro	MontoBeneficiario
                    $filaInicio = $i;
                    $filaFin = $i;
                    $columnaInicio = 'BB';
                    $columnaFin = 'BM';
                    $suma = 0;

                    for ($fila = $filaInicio; $fila <= $filaFin; $fila++) {
                        for ($columna = $columnaInicio; $columna <= $columnaFin; $columna++) {
                            $suma += $FilaB[$fila][$columna];
                        }
                    }
                    $MontoFederal = $suma;
                    

                    //MontoMunicipal
                    $MontoMunicipal = 0;

                    //MontoOtro	
                    $filaInicio = $i;
                    $filaFin = $i;
                    $columnaInicio = 'CB';
                    $columnaFin = 'CM';
                    $suma = 0;

                    for ($fila = $filaInicio; $fila <= $filaFin; $fila++) {
                        for ($columna = $columnaInicio; $columna <= $columnaFin; $columna++) {
                            $suma += $FilaB[$fila][$columna];
                        }
                    }
                    $MontoOtro = $suma;
                    
                    //MontoBeneficiario
                    $MontoBeneficiario = 0;

                    //ObservacionAvanceFinanciero
                    /*$suma = 0;
                    $suma = $MontoEstatal+$MontoDeuda+$MontoRecursoPropio+$MontoFederal+$MontoMunicipal+$MontoOtro+$MontoOtro;
                    $FinalAvance = $this->automatizar_model->getId_('cMontos', $colDato1, $dato1, $colDato2, $dato2, $nId);*/

                

                    $catalogo = 'cStatusAvance';
                    $datoInicial = 7;
                    $columnaInicial = 'idStatusAvance';
                    $columnaDeseada = 'StatusAvance';

                    $ObservacionAvanceFinanciero = $this->automatizar_model->sacarCatalogo($catalogo,$datoInicial,$columnaInicial,$columnaDeseada);

                    //AvanceFisico
                    $AvanceFisico = 100;

                    //ObservacionAvanceFisico
                    $catalogo = 'cStatusAvance';
                    $datoInicial = 7;
                    $columnaInicial = 'idStatusAvance';
                    $columnaDeseada = 'StatusAvance';

                    $ObservacionAvanceFisico = $this->automatizar_model->sacarCatalogo($catalogo,$datoInicial,$columnaInicial,$columnaDeseada);

                    //echo '<br>';
                    //echo $foa.'|'.$ejercicio.'|'.$idMesFisico.'|'.$MontoEstatal.'|'.$MontoDeuda.'|'.$MontoRecursoPropio.'|'.$MontoFederal.'|'.$MontoMunicipal.'|'.$MontoOtro.'|'.$MontoBeneficiario.'|'.$ObservacionAvanceFinanciero.'|'.$AvanceFisico.'|'.$ObservacionAvanceFisico;
                    //echo '<br>';
                    $valores = array(
                    $foa, $ejercicio, $idMesFisico, $MontoEstatal, $MontoDeuda,
                    $MontoRecursoPropio, $MontoFederal, $MontoMunicipal, $MontoOtro,
                    $MontoBeneficiario, $ObservacionAvanceFinanciero, $idMesFisico,
                    $AvanceFisico, $ObservacionAvanceFisico,$folio
                    );
                    
                    $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtoAFM,$this->indiceiGto,$valores);
                    $this->indiceiGto++;
                    //echo '<br>';
                    //echo '<br>';

                }else {
                    echo 'FOLIO NO ENCONTRADO: folio aun no esta cargado en la base de datos';
                }
                //$this->writer->save('Generados/igto2.xlsx');

            }
        $filaInicial = $filafinal+1;
        $filafinal = $filafinal+$ciclo;
        $cicloN++;
        }
        //echo 'ciclo final: '.$cicloN.'<br>';
        //echo 'fila inicial: '.$filaInicial.'<br>';
        //echo 'fila final:'.$totalFilas.'<br>';
        $FilaB = $this->automatizar_model->obtenerFilaBeneficiario($worksheetBeneficiarios,$colInicial,$filaInicial,$colFinal,$filafinal);

        for($i = $filaInicial; $i<=$totalFilas; $i++){

                //OBTENER FOLIO DEL 
                $folio = $FilaB[$i]['C']; //B es la columna donde estan los folios de educafin

                //VERIFICAR SI EL FOLIO OBTENIDO DEL EXCEL EXISTE EN LA BASE DE DATOS
                $validacion = $this->automatizar_model->coincidirfolioEnDB($folio);
                if ($validacion == true)
                {
                    //echo '<br>folio si esta cargado en la base de datos';
                    
                    //obtener FolioObraAccion desde la base de datos
                    $foai = $this->gestorDB->getFoaByFolio($folio);
                    $foa = "'".$foai;

                    //obtener ejercicio
                    $ejercicio = $FilaB[$i]['A'];

                    //obtener idMesFisico
                    $idMesFisico = $mes;

                    //obtener MontoEstatal
                    //$MontoEstatal = $FilaB[$indiceBeneficiarios]['BN'];
                    //$MontoEstatal = $FilaB[$indiceBeneficiarios]['BN'];
                    $filaInicio = $i;
                    $filaFin = $i;
                    $columnaInicio = 'AO';
                    $columnaFin = 'AZ';
                    $suma = 0;

                    for ($fila = $filaInicio; $fila <= $filaFin; $fila++) {
                        for ($columna = $columnaInicio; $columna <= $columnaFin; $columna++) {
                            $suma += $FilaB[$fila][$columna];
                        }
                    }
                    $MontoEstatal = $suma;

                    //MontoDeuda 
                    $MontoDeuda = 0;
                    //MontoRecursoPropio 

                    $filaInicio = $i;
                    $filaFin = $i;
                    $columnaInicio = 'BO';
                    $columnaFin = 'BZ';
                    $suma = 0;

                    for ($fila = $filaInicio; $fila <= $filaFin; $fila++) {
                        for ($columna = $columnaInicio; $columna <= $columnaFin; $columna++) {
                            $suma += $FilaB[$fila][$columna];
                        }
                    }
                    $MontoRecursoPropio = $suma;
                    
                    //MontoFederal	MontoMunicipal	MontoOtro	MontoBeneficiario
                    $filaInicio = $i;
                    $filaFin = $i;
                    $columnaInicio = 'BB';
                    $columnaFin = 'BM';
                    $suma = 0;

                    for ($fila = $filaInicio; $fila <= $filaFin; $fila++) {
                        for ($columna = $columnaInicio; $columna <= $columnaFin; $columna++) {
                            $suma += $FilaB[$fila][$columna];
                        }
                    }
                    $MontoFederal = $suma;
                    

                    //MontoMunicipal
                    $MontoMunicipal = 0;

                    //MontoOtro	
                    $filaInicio = $i;
                    $filaFin = $i;
                    $columnaInicio = 'CB';
                    $columnaFin = 'CM';
                    $suma = 0;

                    for ($fila = $filaInicio; $fila <= $filaFin; $fila++) {
                        for ($columna = $columnaInicio; $columna <= $columnaFin; $columna++) {
                            $suma += $FilaB[$fila][$columna];
                        }
                    }
                    $MontoOtro = $suma;
                    
                    //MontoBeneficiario
                    $MontoBeneficiario = 0;

                    //ObservacionAvanceFinanciero
                    /*$suma = 0;
                    $suma = $MontoEstatal+$MontoDeuda+$MontoRecursoPropio+$MontoFederal+$MontoMunicipal+$MontoOtro+$MontoOtro;
                    $FinalAvance = $this->automatizar_model->getId_('cMontos', $colDato1, $dato1, $colDato2, $dato2, $nId);*/

                

                    $catalogo = 'cStatusAvance';
                    $datoInicial = 7;
                    $columnaInicial = 'idStatusAvance';
                    $columnaDeseada = 'StatusAvance';

                    $ObservacionAvanceFinanciero = $this->automatizar_model->sacarCatalogo($catalogo,$datoInicial,$columnaInicial,$columnaDeseada);

                    //AvanceFisico
                    $AvanceFisico = 100;

                    //ObservacionAvanceFisico
                    $catalogo = 'cStatusAvance';
                    $datoInicial = 7;
                    $columnaInicial = 'idStatusAvance';
                    $columnaDeseada = 'StatusAvance';

                    $ObservacionAvanceFisico = $this->automatizar_model->sacarCatalogo($catalogo,$datoInicial,$columnaInicial,$columnaDeseada);

                    //echo '<br>';
                    //echo $foa.'|'.$ejercicio.'|'.$idMesFisico.'|'.$MontoEstatal.'|'.$MontoDeuda.'|'.$MontoRecursoPropio.'|'.$MontoFederal.'|'.$MontoMunicipal.'|'.$MontoOtro.'|'.$MontoBeneficiario.'|'.$ObservacionAvanceFinanciero.'|'.$AvanceFisico.'|'.$ObservacionAvanceFisico;
                    //echo '<br>';
                    $valores = array(
                    $foa, $ejercicio, $idMesFisico, $MontoEstatal, $MontoDeuda,
                    $MontoRecursoPropio, $MontoFederal, $MontoMunicipal, $MontoOtro,
                    $MontoBeneficiario, $ObservacionAvanceFinanciero, $idMesFisico,
                    $AvanceFisico, $ObservacionAvanceFisico,$folio
                    );
                    
                    $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtoAFM,$this->indiceiGto,$valores);
                    $this->indiceiGto++;
                    //echo '<br>';
                    //echo '<br>';

                }else {
                    //echo 'FOLIO NO ENCONTRADO: folio aun no esta cargado en la base de datos';
                }
                //$this->writer->save('Generados/AvanceFinancieroMensual.xlsx');

            }

    }

    public function automaE($worksheetiGtoE,$worksheetBeneficiarios){
        $this->load->helper('url');
        //$this->indiceiGto = 2;
        //$worksheetiGtoE ->setTitle('relProyecto_iGTO_cEnfoques');
        //DATOS DATOS POR EL USUARIO
        $colInicial='A'; //Columna inicial beneficiarios
        $colFinal='CR'; //Columna Final beneficiarios
        $mes = 'JUNIO';
        $filaInicial = 2;
        
        //INICIA EL CICLO
        $filafinal= 100;
        $cicloN = 1;
        $ciclo = 100;
        //obtener array
        //OBTENER NUMERO TOTAL DE FILAS
        $totalFilas = $this->automatizar_model->numeroFilas($worksheetBeneficiarios);
        
        while ($filafinal < $totalFilas){
            //echo 'ciclo: '.$cicloN.'<br>';
            //echo 'fila inicial: '.$filaInicial.'<br>';
            //echo 'fila final:'.$filafinal.'<br>';
            $FilaB = $this->automatizar_model->obtenerFilaBeneficiario($worksheetBeneficiarios,$colInicial,$filaInicial,$colFinal,$filafinal);

            //$totalFilas = 10;
            for($i = $filaInicial; $i<=$filafinal; $i++){

                //OBTENER FOLIO DEL 
                $folio = $FilaB[$i]['C']; //B es la columna donde estan los folios de educafin

                //VERIFICAR SI EL FOLIO OBTENIDO DEL EXCEL EXISTE EN LA BASE DE DATOS
                $validacion = $this->automatizar_model->coincidirfolioEnDB($folio);
                if ($validacion == true)
                {
                    //echo '<br>folio si esta cargado en la base de datos';
                    
                    //obtener FolioObraAccion desde la base de datos
                    $foai = $this->gestorDB->getFoaByFolio($folio);
                    $foa = "'".$foai;

                    //idEnfoque	

                    /*CREATE TABLE cTiposEnfoques (
                    idTipoEnfoque INT,
                    TipoEnfoque VARCHAR(20)

                    ) */
                    $nivel = $FilaB[$i]['AH'];
                    $q = $FilaB[$i]['AA'];
                    
                    $idEnfoque_1 = $this->gestorDB->getId('ids','CLAVE_PQG',$q ,'idEnfoque_1');
                    $idEnfoque_2 = $this->gestorDB->getId('ids','CLAVE_PQG',$q ,'idEnfoque_2');
                    
                    //= $this->gestorDB->getId('cTiposBeneficiarios','descripcion','Mujer-Estudiante' ,'idTipoBeneficiario');;
                    
                    //Justificacion
                    $justificacion_1 = $this->gestorDB->getId('ids','CLAVE_PQG',$q ,'Justificacion_1');
                    $justificacion_2 = $this->gestorDB->getId('ids','CLAVE_PQG',$q ,'Justificacion_2');

                    $valores = array(
                    $foa,$idEnfoque_1,$justificacion_1,$folio
                    );
                    
                    $valores_ = array(
                        $foa,$idEnfoque_2,$justificacion_2,$folio
                    );
                    
                    

                    $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtoE,$this->indiceiGto,$valores);
                    $this->indiceiGto++;
                    if ($idEnfoque_2 != null){
                        $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtoE,$this->indiceiGto,$valores_);
                        $this->indiceiGto++;
                    }
                    
                    //echo '<br>';
                    //echo '<br>';

                }else{
                    //echo 'FOLIO NO ENCONTRADO: folio aun no esta cargado en la base de datos';
                }
                //$this->writer->save('Generados/MetasProyectos.xlsx');
            
            }

            $filaInicial = $filafinal+1;
            $filafinal = $filafinal+$ciclo;
            $cicloN++;
        }
        //echo 'ciclo final: '.$cicloN.'<br>';
        //echo 'fila inicial: '.$filaInicial.'<br>';
        //echo 'fila final:'.$totalFilas.'<br>';
        $FilaB = $this->automatizar_model->obtenerFilaBeneficiario($worksheetBeneficiarios,$colInicial,$filaInicial,$colFinal,$filafinal);

            //$totalFilas = 10;
            for($i = $filaInicial; $i<=$totalFilas; $i++){

                //OBTENER FOLIO DEL 
                $folio = $FilaB[$i]['C']; //B es la columna donde estan los folios de educafin

                //VERIFICAR SI EL FOLIO OBTENIDO DEL EXCEL EXISTE EN LA BASE DE DATOS
                $validacion = $this->automatizar_model->coincidirfolioEnDB($folio);
                if ($validacion == true)
                {
                    //echo '<br>folio si esta cargado en la base de datos';
                    
                    //obtener FolioObraAccion desde la base de datos
                    $foai = $this->gestorDB->getFoaByFolio($folio);
                    $foa = "'".$foai;

                    //idEnfoque	

                    /*CREATE TABLE cTiposEnfoques (
                    idTipoEnfoque INT,
                    TipoEnfoque VARCHAR(20)

                    ) */
                    $nivel = $FilaB[$i]['AH'];
                    $q = $FilaB[$i]['AA'];
                    
                    $idEnfoque_1 = $this->gestorDB->getId('ids','CLAVE_PQG',$q ,'idEnfoque_1');
                    $idEnfoque_2 = $this->gestorDB->getId('ids','CLAVE_PQG',$q ,'idEnfoque_2');
                    //= $this->gestorDB->getId('cTiposBeneficiarios','descripcion','Mujer-Estudiante' ,'idTipoBeneficiario');;
                    
                    //Justificacion
                    $justificacion_1 = $this->gestorDB->getId('ids','CLAVE_PQG',$q ,'Justificacion_1');
                    $justificacion_2 = $this->gestorDB->getId('ids','CLAVE_PQG',$q ,'Justificacion_2');

                    $valores = array(
                    $foa,$idEnfoque_1,$justificacion_1,$folio
                    );
                    
                    $valores_ = array(
                        $foa,$idEnfoque_2,$justificacion_2,$folio
                    );
                    
                    

                    $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtoE,$this->indiceiGto,$valores);
                    $this->indiceiGto++;
                    if ($idEnfoque_2 != null){
                        $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtoE,$this->indiceiGto,$valores_);
                        $this->indiceiGto++;
                    }
                    //echo '<br>';
                    //echo '<br>';

                }else{
                    //echo 'FOLIO NO ENCONTRADO: folio aun no esta cargado en la base de datos';
                }
                
                //$this->writer->save('Generados/MetasProyectos.xlsx');
            
            }

        
        
        
    }



    public function automaTB($worksheetiGtomTP,$worksheetBeneficiarios){
        $this->load->helper('url');
        //$this->indiceiGto = 2;
        //$worksheetiGtomTP ->setTitle('relProyecto_iGTO_cTiposBenefici');
        //DATOS DATOS POR EL USUARIO
        $colInicial='A'; //Columna inicial beneficiarios
        $colFinal='CR'; //Columna Final beneficiarios
        $mes = 'JUNIO';
        $filaInicial = 2;
        
        //INICIA EL CICLO
        $filafinal= 100;
        $cicloN = 1;
        $ciclo = 100;
        //obtener array
        //OBTENER NUMERO TOTAL DE FILAS
        $totalFilas = $this->automatizar_model->numeroFilas($worksheetBeneficiarios);
        
        while ($filafinal < $totalFilas){
            //echo 'ciclo: '.$cicloN.'<br>';
            //echo 'fila inicial: '.$filaInicial.'<br>';
            //echo 'fila final:'.$filafinal.'<br>';
            $FilaB = $this->automatizar_model->obtenerFilaBeneficiario($worksheetBeneficiarios,$colInicial,$filaInicial,$colFinal,$filafinal);

            //$totalFilas = 10;
            for($i = $filaInicial; $i<=$filafinal; $i++){

                //OBTENER FOLIO DEL 
                $folio = $FilaB[$i]['C']; //B es la columna donde estan los folios de educafin

                //VERIFICAR SI EL FOLIO OBTENIDO DEL EXCEL EXISTE EN LA BASE DE DATOS
                $validacion = $this->automatizar_model->coincidirfolioEnDB($folio);
                if ($validacion == true)
                {
                    //echo '<br>folio si esta cargado en la base de datos';
                    
                    //obtener FolioObraAccion desde la base de datos
                    $foai = $this->gestorDB->getFoaByFolio($folio);
                    $foa = "'".$foai;

                    //idTipoBeneficiario PENDIENTE
                    $sexo = $FilaB[$i]['I'];
                    $q = $FilaB[$i]['AA'];
                    if($sexo == 'Femenino'){
                        $idTipoBeneficiario = $this->gestorDB->getId('ids','CLAVE_PQG',$q,'idTipoBeneficiario_Mujer');
                    }else{
                        $idTipoBeneficiario = $this->gestorDB->getId('ids','CLAVE_PQG',$q,'idTipoBeneficiario_Hombre');
                    }

                    //cantidad
                    $cantidad = 1;

                    
                    $valores = array(
                    $foa,$idTipoBeneficiario,$cantidad,$folio
                    );

                    $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtomTP,$this->indiceiGto,$valores);
                    $this->indiceiGto++;
                    //echo '<br>';
                    //echo '<br>';

                }else{
                    //echo 'FOLIO NO ENCONTRADO: folio aun no esta cargado en la base de datos';
                }
                //$this->writer->save('Generados/MetasProyectos.xlsx');
            
            }

            $filaInicial = $filafinal+1;
            $filafinal = $filafinal+$ciclo;
            $cicloN++;
        }
        //echo 'ciclo final: '.$cicloN.'<br>';
        //echo 'fila inicial: '.$filaInicial.'<br>';
        //echo 'fila final:'.$totalFilas.'<br>';
        $FilaB = $this->automatizar_model->obtenerFilaBeneficiario($worksheetBeneficiarios,$colInicial,$filaInicial,$colFinal,$filafinal);

            //$totalFilas = 10;
            for($i = $filaInicial; $i<=$totalFilas; $i++){

                //OBTENER FOLIO DEL 
                $folio = $FilaB[$i]['C']; //B es la columna donde estan los folios de educafin

                //VERIFICAR SI EL FOLIO OBTENIDO DEL EXCEL EXISTE EN LA BASE DE DATOS
                $validacion = $this->automatizar_model->coincidirfolioEnDB($folio);
                if ($validacion == true)
                {
                    //echo '<br>folio si esta cargado en la base de datos';
                    
                    //obtener FolioObraAccion desde la base de datos
                    $foai = $this->gestorDB->getFoaByFolio($folio);
                    $foa = "'".$foai;

                    //idTipoBeneficiario PENDIENTE
                    $sexo = $FilaB[$i]['I'];
                    $q = $FilaB[$i]['AA'];
                    if($sexo == 'Femenino'){
                        $idTipoBeneficiario = $this->gestorDB->getId('ids','CLAVE_PQG',$q,'idTipoBeneficiario_Mujer');
                    }else{
                        $idTipoBeneficiario = $this->gestorDB->getId('ids','CLAVE_PQG',$q,'idTipoBeneficiario_Hombre');
                    }

                    //cantidad
                    $cantidad = 1;

                    
                    $valores = array(
                        $foa,$idTipoBeneficiario,$cantidad,$folio
                    );
                    

                    

                    $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtomTP,$this->indiceiGto,$valores);
                    $this->indiceiGto++;
                    
                    //echo '<br>';
                    //echo '<br>';

                }else{
                    //echo 'FOLIO NO ENCONTRADO: folio aun no esta cargado en la base de datos';
                }
                
                //$this->writer->save('Generados/MetasProyectos.xlsx');
            
            }

        
        
        
    }





    public function automaMP($worksheetiGtoMP,$worksheetBeneficiarios){
        $this->load->helper('url');
        //$this->indiceiGto = 2;
        //$worksheetiGtoMP ->setTitle('Metas proyectos');
        //DATOS DATOS POR EL USUARIO
        $colInicial='A'; //Columna inicial beneficiarios
        $colFinal='CR'; //Columna Final beneficiarios
        $mes = 'JUNIO';
        $filaInicial = 2;
        
        //INICIA EL CICLO
        $filafinal= 100;
        $cicloN = 1;
        $ciclo = 100;
        //obtener array
        //OBTENER NUMERO TOTAL DE FILAS
        $totalFilas = $this->automatizar_model->numeroFilas($worksheetBeneficiarios);
        
        while ($filafinal < $totalFilas){
            //echo 'ciclo: '.$cicloN.'<br>';
            //echo 'fila inicial: '.$filaInicial.'<br>';
            //echo 'fila final:'.$filafinal.'<br>';
            $FilaB = $this->automatizar_model->obtenerFilaBeneficiario($worksheetBeneficiarios,$colInicial,$filaInicial,$colFinal,$filafinal);

            //$totalFilas = 10;
            for($i = $filaInicial; $i<=$filafinal; $i++){

                //OBTENER FOLIO DEL 
                $folio = $FilaB[$i]['C']; //B es la columna donde estan los folios de educafin

                //VERIFICAR SI EL FOLIO OBTENIDO DEL EXCEL EXISTE EN LA BASE DE DATOS
                $validacion = $this->automatizar_model->coincidirfolioEnDB($folio);
                if ($validacion == true)
                {
                    //echo '<br>folio si esta cargado en la base de datos';
                    
                    //obtener FolioObraAccion desde la base de datos
                    $foai = $this->gestorDB->getFoaByFolio($folio);
                    $foa = "'".$foai;

                    //obtener cantidad
                    $cantidad = 1;

                    //obtener DetalladoMeta
                    $q = $FilaB[$i]['AA'];
                    $meta = $this->gestorDB->getId('ids','CLAVE_PQG',$q,'DescripcionOA');

                    //echo '<br>';
                    //echo $foa.'|'.$cantidad.'|'.$meta;
                    //echo '<br>';

                    $valores = array(
                    $foa,$cantidad,$meta,$folio
                    );

                    $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtoMP,$this->indiceiGto,$valores);
                    $this->indiceiGto++;
                    //echo '<br>';
                    //echo '<br>';

                }else{
                    //echo 'FOLIO NO ENCONTRADO: folio aun no esta cargado en la base de datos';
                }
                //$this->writer->save('Generados/MetasProyectos.xlsx');
            
            }

            $filaInicial = $filafinal+1;
            $filafinal = $filafinal+$ciclo;
            $cicloN++;
        }
        //echo 'ciclo final: '.$cicloN.'<br>';
        //echo 'fila inicial: '.$filaInicial.'<br>';
        //echo 'fila final:'.$totalFilas.'<br>';
        $FilaB = $this->automatizar_model->obtenerFilaBeneficiario($worksheetBeneficiarios,$colInicial,$filaInicial,$colFinal,$filafinal);

            //$totalFilas = 10;
            for($i = $filaInicial; $i<=$totalFilas; $i++){

                //OBTENER FOLIO DEL 
                $folio = $FilaB[$i]['C']; //B es la columna donde estan los folios de educafin

                //VERIFICAR SI EL FOLIO OBTENIDO DEL EXCEL EXISTE EN LA BASE DE DATOS
                $validacion = $this->automatizar_model->coincidirfolioEnDB($folio);
                if ($validacion == true)
                {
                    //echo '<br>folio si esta cargado en la base de datos';
                    
                    //obtener FolioObraAccion desde la base de datos
                    $foai = $this->gestorDB->getFoaByFolio($folio);
                    $foa = "'".$foai;

                    //obtener cantidad
                    $cantidad = 1;

                    //obtener DetalladoMeta
                    $q = $FilaB[$i]['AA'];
                    $meta = $this->gestorDB->getId('ids','CLAVE_PQG',$q,'DescripcionOA');

                    //echo '<br>';
                    //echo $foa.'|'.$cantidad.'|'.$meta;
                    //echo '<br>';

                    $valores = array(
                    $foa,$cantidad,$meta,$folio
                    );

                    $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtoMP,$this->indiceiGto,$valores);
                    $this->indiceiGto++;
                    //echo '<br>';
                    //echo '<br>';

                }else{
                    //echo 'FOLIO NO ENCONTRADO: folio aun no esta cargado en la base de datos';
                }
                
                //$this->writer->save('Generados/MetasProyectos.xlsx');
            
            }

        
        
        
    }

public function automamProyectos($worksheetiGtomPr,$worksheetBeneficiarios,$fecha){
        $this->load->helper('url');
        //$this->indiceiGto = 2;
        //$worksheetiGtomPr ->setTitle('mProyectos');
        //DATOS DATOS POR EL USUARIO
        $colInicial='A'; //Columna inicial beneficiarios
        $colFinal='CR'; //Columna Final beneficiarios
        //$mes = 'JUNIO';
        $filaInicial = 2;
        
        //INICIA EL CICLO
        $filafinal= 100;
        $cicloN = 1;
        $ciclo = 100;
        //obtener array
        //OBTENER NUMERO TOTAL DE FILAS
        $totalFilas = $this->automatizar_model->numeroFilas($worksheetBeneficiarios);
        
        while ($filafinal < $totalFilas){
            //echo 'ciclo: '.$cicloN.'<br>';
            //echo 'fila inicial: '.$filaInicial.'<br>';
            //echo 'fila final:'.$filafinal.'<br>';
            $FilaB = $this->automatizar_model->obtenerFilaBeneficiario($worksheetBeneficiarios,$colInicial,$filaInicial,$colFinal,$filafinal);

            //$totalFilas = 10;
            for($i = $filaInicial; $i<=$filafinal; $i++){

                //OBTENER FOLIO DEL 
                $folio = $FilaB[$i]['C']; //B es la columna donde estan los folios de educafin

                //VERIFICAR SI EL FOLIO OBTENIDO DEL EXCEL EXISTE EN LA BASE DE DATOS
                $validacion = $this->automatizar_model->coincidirfolioEnDB($folio);
                if ($validacion == true)
                {
                    //echo '<br>folio si esta cargado en la base de datos';
                    
                    //obtener FolioObraAccion desde la base de datos
                    $foai = $this->gestorDB->getFoaByFolio($folio);
                    
                    $archivo = FCPATH . 'Foliostxt/folios'.$fecha.'.txt';
                    if (!file_exists($archivo)) {
                        touch($archivo);
                    }
                    file_put_contents($archivo, $foai . PHP_EOL, FILE_APPEND);

                    $foa = "'".$foai;

                    //Ejercicio
                    $ejercicio = $FilaB[$i]['A'];

                    //Q
                    $q = $FilaB[$i]['AA'];


                    //IdMetaSed
                    if ($q == 'QC3164'){
                        $idMetaSed = '2301';
                        $idMetaSed2 = '2302';
                        $idMetaSed3 = '2303';
                    } else if ($q == 'QC3767'){
                        $idMetaSed = '2301';
                        $idMetaSed2 = '2302';
                        $idMetaSed3 = null;
                    }else{
                        $idMetaSed = $this->gestorDB->getId('ids','CLAVE_PQG',$q,'ID_META_SED');
                        $idMetaSed2 = null;
                        $idMetaSed3 = null;
                    }

                    //$nom = 'Apoyos de movilidad y desarrollo de competencias globales para jóvenes y comunidad educativa. Modalidades: arranque, apoyo de movilidad, estancias en el extranjero y movilidad de empleabilidad y emprendimiento.';
                    
                    //idDependencia
                    $dep = 'JUVENTUDES GTO';
                    $idDependencia = $this->gestorDB->getId('cDependencias','Siglas',$dep ,'idDependencia');

                    //DescripcionObraAccion
                    $descripcionObraAccion = $this->gestorDB->getId('ids','CLAVE_PQG',$q,'DescripcionOA');

                    //EmpleosPermanentesMujeres	EmpleosEventualesMujeres	EmpleosPermanentesHombres	EmpleosEventualesHombres 	
                    $empleosPermanentesMujeres = 0;
                    $empleosEventualesMujeres = 0;	
                    $empleosPermanentesHombres = 0;	
                    $empleosEventualesHombres = 0;
                    $empleosProtegidosMujeres = 0;
                    $empleosProtegidosHombres = 0;

                    //nombre simplificado obra accion
                    $nombreSimplificadoObraAccion = $this->gestorDB->getId('ids','CLAVE_PQG',$q,'Nombre_Simplificado');

                    //idcategoria
                    $idcategoria = $this->gestorDB->getId('ids','CLAVE_PQG',$q,'id_Categoria');

                    //idsubcategoria
                    $idsubcategoria = $this->gestorDB->getId('ids','CLAVE_PQG',$q,'subcategoria');

                    //FechaEntrega	Latitud	Longitud
                    // Verificar si existe el folio
                    $fechaEntrega = $FilaB[$i]['AM'];
                    
                    //$bien = $this->gestorDB->actualizarFechaPorFolio($folio, $fechaEntrega);
                    //$fechaEntrega = $this->gestorDB->obtenerFechaPorFolio($folio);

                    //guardar q con los folios
                    $this->automatizar_model->guardar_q($folio, $q);

                    //latitud
                    $latitud = $this->automatizar_model->obtenerzona($folio, 'lat');
                    
                    //longitud
                    $longitud = $this->automatizar_model->obtenerzona($folio, 'lon');

                    //idEstado
                    $estado = $FilaB[$i]['X'];
                    $idEstado = $this->gestorDB->getId('cEstados','Estado',$estado,'idEstado');

                    //idmunicipio
                    $municipio = $FilaB[$i]['M'];
                    $idMunicipio = $this->gestorDB->getId('cMunicipios','NombreMunicipio',$municipio,'idMunicipio');

                    //idLocalidad
                    $idLocalidad = $this->gestorDB->getId('cLocalidades_','idMunicipio',$idMunicipio,'idLocalidad');

                    //TiposAsentamientos
                    $idTipoAsentamiento = $this->gestorDB->getId('cTiposAsentamientos','TipoAsentamiento','COLONIA','idTipoAsentamiento');

                    //NombreAsentamiento
                    $nombreAsentamiento = $FilaB[$i]['Q'];

                    //idTipoVialidad
                    $idTipoVialidad = $this->gestorDB->getId('cTiposVialidades','TipoVialidad','CALLE','idTipoVialidad');

                    //NombreVialidad
                    $nombreVialidad = $FilaB[$i]['N'];

                    //NumExt
                    $numExt = $FilaB[$i]['P'];

                    //NumInt
                    $numInt = $FilaB[$i]['O'];

                    //Codigo Postal
                    $codigopostal = $FilaB[$i]['W'];

                    //idZonaImpulso
                    $idZonaImpulso = $this->automatizar_model->obtenerzona($folio, 'zon');

                    //totalEstatal
                    $suma = 0;
                    $fila = $i; // Fila 1
                    $inicio = 'AO'; // Índice de inicio
                    $fin = 'AZ'; // Índice de fin

                    for ($in = $inicio; $in <= $fin; $in++) {
                        $suma += $FilaB[$fila][$in];
                    }
                    $totalEstatal = $suma;

                    //MontoDeuda	
                    $MontoDeuda = 0;	

                    //MontoRecursoPropio
                    $suma = 0;
                    $fila = $i; // Fila 1
                    $inicio = 'BO'; // Índice de inicio
                    $fin = 'BZ'; // Índice de fin

                    for ($in = $inicio; $in <= $fin; $in++) {
                        $suma += $FilaB[$fila][$in];
                    }
                    $totalPropio = $suma;

                    //MontoFederal
                    $modalidad = $FilaB[$i]['AC'];
                    $totalFederal = $this->gestorDB->getId_('cmontos','programa', $q, 'modalidad', $modalidad,'monto');
                    /*
                    $suma = 0;
                    $fila = $i; // Fila 1
                    $inicio = 'BB'; // Índice de inicio
                    $fin = 'BM'; // Índice de fin

                    for ($in = $inicio; $in <= $fin; $in++) {
                        $suma += $FilaB[$fila][$in];
                    }
                    $totalFederal = $suma;
                    */

                    //MontoMunicipal	
                    $MontoMunicipal = 0;
                    //MontoOtro	
                    $suma = 0;
                    $fila = $i; // Fila 1
                    $inicio = 'CB'; // Índice de inicio
                    $fin = 'CM'; // Índice de fin

                    for ($in = $inicio; $in <= $fin; $in++) {
                        $suma += $FilaB[$fila][$in];
                    }
                    $MontoOtro = $suma;

                    //MontoBeneficiario
                    $MontoBeneficiario = 0;

                    //EsRefrendo	AnioRefrendo	FolioRelacionado
                    $EsRefrendo = null;
                    $AnioRefrendo = null;	
                    $FolioRelacionado = null;

                    //idTipoObraAccion
                    $idTipoObraAccion = $this->gestorDB->getId('cTiposObrasAcciones','TipoObraAccion','ACCION','idTipoObraAccion');

                    //idTipo
                    $idTipo = $this->gestorDB->getId('ids','CLAVE_PQG',$q,'idTipo');

                    //idStatusObraAccion
                    $idStatusObraAccion = $this->gestorDB->getId('ids','CLAVE_PQG',$q,'idStatusObraAccion');

                    //idStatusAvance 
                    $idStatusAvance = $this->gestorDB->getId('ids','CLAVE_PQG',$q,'idStatusAvance');

                    //ObstervacionesStatusAvance
                    $ObstervacionesStatusAvance = $this->gestorDB->getId('cStatusAvance','idStatusAvance',7,'StatusAvance');

                    //observacionesGenerales
                    $observacionesGenerales = 'De acuerdo al plan';

                    //beneficiariosTotal Mujer Hombre
                    $benefTotal = 1;
                    $sexo =  $FilaB[$i]['I'];
                    if ($sexo == 'Femenino'){
                        $BenefMujeres = 1;
                        $BenefHombres = 0;	
                    } else{
                        $BenefMujeres = 0;
                        $BenefHombres = 1;
                    }

                    //idCCT
                    $cCT = $FilaB[$i]['AF'];
                    if ($cCT == 0){
                        $idCCT = null;
                    }else{
                        $cCT_ = strval($cCT);
                        $idCCT = $this->gestorDB->getId('cCentrosTrabajo','ClaveCCT',$cCT_,'idCCT');
                    }
                    

                    //idInformeGobierno	idSituacion	CifrasEstimadas
                    switch ($ejercicio) {
                        case 2022:
                            $idInformeGobierno = 5;
                            break;
                    
                        case 2023:
                            $idInformeGobierno = 6;
                            break;
                    
                        case 2024:
                            $idInformeGobierno = 1;
                            break;

                        case 2025:
                            $idInformeGobierno = 2;
                            break;
                    
                        case 2026:
                            $idInformeGobierno = 3;
                            break;
                    
                        case 2027:
                            $idInformeGobierno = 4
                            ;
                            break;

                        case 2028:
                            $idInformeGobierno = 5;
                            break;
                    
                        case 2029:
                            $idInformeGobierno = 6
                            ;
                        case 2030:
                            $idInformeGobierno = 1;
                            break;

                        case 2031:
                            $idInformeGobierno = 2;
                            break;
                    
                        case 2032:
                            $idInformeGobierno = 3;
                            break;
                    
                        case 2033:
                            $idInformeGobierno = 4
                            ;
                            break;

                        case 2034:
                            $idInformeGobierno = 5;
                            break;
                    
                        case 2035:
                            $idInformeGobierno = 6
                            ;
                            break;
                        case 2036:
                            $idInformeGobierno = 1;
                            break;

                        case 2037:
                            $idInformeGobierno = 2;
                            break;
                    
                        case 2038:
                            $idInformeGobierno = 3;
                            break;
                    
                        case 2039:
                            $idInformeGobierno = 4
                            ;
                            break;

                        case 2040:
                            $idInformeGobierno = 5;
                            break;
                    
                        case 2041:
                            $idInformeGobierno = 6;
                            break;

                        default:
                            // Código a ejecutar si $ejercicio no coincide con ninguna opción
                            echo "Opción no válida";
                            break;
                    }
                    

                    //idSituacion
                    $idSituacion = 1 ;//SE TIENE EL CATALOGO PERO FALTA MATRIZ BUSCADA
                    /*idSituacion	Situacion
                                1	Inicio Termina
                                2	Inicio
                                3	Continua
                                4	Termina
                                5	Continua y Termina
                                */

                    //CifrasEstimadas
                    $CifrasEstimadas = 0 ;//VACIO
                    if ($idMetaSed3 != null){
                        $valores = array(
                            $foa,$ejercicio,$q,$idMetaSed,$idDependencia,$descripcionObraAccion,$empleosPermanentesMujeres,
                            $empleosEventualesMujeres,$empleosPermanentesHombres,$empleosEventualesHombres,$empleosProtegidosMujeres,
                            $empleosProtegidosHombres,$nombreSimplificadoObraAccion,$idcategoria,$idsubcategoria,$fechaEntrega,$latitud,$longitud,
                            $idEstado,$idMunicipio,$idLocalidad,$idMunicipio,$idLocalidad,$idTipoAsentamiento,$nombreAsentamiento,
                            $idTipoVialidad,$nombreVialidad,$numExt,$numInt,$codigopostal,$idZonaImpulso,$totalEstatal,$MontoDeuda,$totalPropio,
                            $totalFederal,$MontoMunicipal,$MontoOtro,$MontoBeneficiario,$EsRefrendo,$AnioRefrendo,$FolioRelacionado,
                            $idTipoObraAccion,$idTipo,$idStatusObraAccion,$idStatusAvance,$ObstervacionesStatusAvance,$observacionesGenerales,
                            $benefTotal,$BenefMujeres,$BenefHombres,$idCCT,$idInformeGobierno,$idSituacion,$CifrasEstimadas,$folio
                            );
        
                            $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtomPr,$this->indiceiGto,$valores);
                            $this->indiceiGto++;

                        $valores = array(
                            $foa,$ejercicio,$q,$idMetaSed2,$idDependencia,$descripcionObraAccion,$empleosPermanentesMujeres,
                            $empleosEventualesMujeres,$empleosPermanentesHombres,$empleosEventualesHombres,$empleosProtegidosMujeres,
                            $empleosProtegidosHombres,$nombreSimplificadoObraAccion,$idcategoria,$idsubcategoria,$fechaEntrega,$latitud,$longitud,
                            $idEstado,$idMunicipio,$idLocalidad,$idMunicipio,$idLocalidad,$idTipoAsentamiento,$nombreAsentamiento,
                            $idTipoVialidad,$nombreVialidad,$numExt,$numInt,$codigopostal,$idZonaImpulso,$totalEstatal,$MontoDeuda,$totalPropio,
                            $totalFederal,$MontoMunicipal,$MontoOtro,$MontoBeneficiario,$EsRefrendo,$AnioRefrendo,$FolioRelacionado,
                            $idTipoObraAccion,$idTipo,$idStatusObraAccion,$idStatusAvance,$ObstervacionesStatusAvance,$observacionesGenerales,
                            $benefTotal,$BenefMujeres,$BenefHombres,$idCCT,$idInformeGobierno,$idSituacion,$CifrasEstimadas,$folio
                            );

                            $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtomPr,$this->indiceiGto,$valores);
                            $this->indiceiGto++;
                        
                        $valores = array(
                            $foa,$ejercicio,$q,$idMetaSed3,$idDependencia,$descripcionObraAccion,$empleosPermanentesMujeres,
                            $empleosEventualesMujeres,$empleosPermanentesHombres,$empleosEventualesHombres,$empleosProtegidosMujeres,
                            $empleosProtegidosHombres,$nombreSimplificadoObraAccion,$idcategoria,$idsubcategoria,$fechaEntrega,$latitud,$longitud,
                            $idEstado,$idMunicipio,$idLocalidad,$idMunicipio,$idLocalidad,$idTipoAsentamiento,$nombreAsentamiento,
                            $idTipoVialidad,$nombreVialidad,$numExt,$numInt,$codigopostal,$idZonaImpulso,$totalEstatal,$MontoDeuda,$totalPropio,
                            $totalFederal,$MontoMunicipal,$MontoOtro,$MontoBeneficiario,$EsRefrendo,$AnioRefrendo,$FolioRelacionado,
                            $idTipoObraAccion,$idTipo,$idStatusObraAccion,$idStatusAvance,$ObstervacionesStatusAvance,$observacionesGenerales,
                            $benefTotal,$BenefMujeres,$BenefHombres,$idCCT,$idInformeGobierno,$idSituacion,$CifrasEstimadas,$folio
                            );

                            $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtomPr,$this->indiceiGto,$valores);
                            $this->indiceiGto++;




                    }else if($idMetaSed2 != null){
                        $valores = array(
                            $foa,$ejercicio,$q,$idMetaSed,$idDependencia,$descripcionObraAccion,$empleosPermanentesMujeres,
                            $empleosEventualesMujeres,$empleosPermanentesHombres,$empleosEventualesHombres,$empleosProtegidosMujeres,
                            $empleosProtegidosHombres,$nombreSimplificadoObraAccion,$idcategoria,$idsubcategoria,$fechaEntrega,$latitud,$longitud,
                            $idEstado,$idMunicipio,$idLocalidad,$idMunicipio,$idLocalidad,$idTipoAsentamiento,$nombreAsentamiento,
                            $idTipoVialidad,$nombreVialidad,$numExt,$numInt,$codigopostal,$idZonaImpulso,$totalEstatal,$MontoDeuda,$totalPropio,
                            $totalFederal,$MontoMunicipal,$MontoOtro,$MontoBeneficiario,$EsRefrendo,$AnioRefrendo,$FolioRelacionado,
                            $idTipoObraAccion,$idTipo,$idStatusObraAccion,$idStatusAvance,$ObstervacionesStatusAvance,$observacionesGenerales,
                            $benefTotal,$BenefMujeres,$BenefHombres,$idCCT,$idInformeGobierno,$idSituacion,$CifrasEstimadas,$folio
                            );

                            $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtomPr,$this->indiceiGto,$valores);
                            $this->indiceiGto++;
                        $valores = array(
                            $foa,$ejercicio,$q,$idMetaSed2,$idDependencia,$descripcionObraAccion,$empleosPermanentesMujeres,
                            $empleosEventualesMujeres,$empleosPermanentesHombres,$empleosEventualesHombres,$empleosProtegidosMujeres,
                            $empleosProtegidosHombres,$nombreSimplificadoObraAccion,$idcategoria,$idsubcategoria,$fechaEntrega,$latitud,$longitud,
                            $idEstado,$idMunicipio,$idLocalidad,$idMunicipio,$idLocalidad,$idTipoAsentamiento,$nombreAsentamiento,
                            $idTipoVialidad,$nombreVialidad,$numExt,$numInt,$codigopostal,$idZonaImpulso,$totalEstatal,$MontoDeuda,$totalPropio,
                            $totalFederal,$MontoMunicipal,$MontoOtro,$MontoBeneficiario,$EsRefrendo,$AnioRefrendo,$FolioRelacionado,
                            $idTipoObraAccion,$idTipo,$idStatusObraAccion,$idStatusAvance,$ObstervacionesStatusAvance,$observacionesGenerales,
                            $benefTotal,$BenefMujeres,$BenefHombres,$idCCT,$idInformeGobierno,$idSituacion,$CifrasEstimadas,$folio
                            );

                            $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtomPr,$this->indiceiGto,$valores);
                            $this->indiceiGto++;
                    } else {
                        
                    $valores = array(
                        $foa,$ejercicio,$q,$idMetaSed,$idDependencia,$descripcionObraAccion,$empleosPermanentesMujeres,
                        $empleosEventualesMujeres,$empleosPermanentesHombres,$empleosEventualesHombres,$empleosProtegidosMujeres,
                        $empleosProtegidosHombres,$nombreSimplificadoObraAccion,$idcategoria,$idsubcategoria,$fechaEntrega,$latitud,$longitud,
                        $idEstado,$idMunicipio,$idLocalidad,$idMunicipio,$idLocalidad,$idTipoAsentamiento,$nombreAsentamiento,
                        $idTipoVialidad,$nombreVialidad,$numExt,$numInt,$codigopostal,$idZonaImpulso,$totalEstatal,$MontoDeuda,$totalPropio,
                        $totalFederal,$MontoMunicipal,$MontoOtro,$MontoBeneficiario,$EsRefrendo,$AnioRefrendo,$FolioRelacionado,
                        $idTipoObraAccion,$idTipo,$idStatusObraAccion,$idStatusAvance,$ObstervacionesStatusAvance,$observacionesGenerales,
                        $benefTotal,$BenefMujeres,$BenefHombres,$idCCT,$idInformeGobierno,$idSituacion,$CifrasEstimadas,$folio
                        );
    
                        $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtomPr,$this->indiceiGto,$valores);
                        $this->indiceiGto++;
    
                    }
                    //echo '<br>';
                    //echo '<br>';
                    //$this->writer->save('Generados/gen/mProyectos.xlsx');
                    

                }else{
                    //echo 'FOLIO NO ENCONTRADO: folio aun no esta cargado en la base de datos';
                }
                //$this->writer->save('Generados/MetasProyectos.xlsx');
            
            }
            
            $filaInicial = $filafinal+1;
            $filafinal = $filafinal+$ciclo;
            $cicloN++;
        }
        //echo 'ciclo: '.$cicloN.'<br>';
        //echo 'fila inicial: '.$filaInicial.'<br>';
        //echo 'fila final:'.$filafinal.'<br>';
        $FilaB = $this->automatizar_model->obtenerFilaBeneficiario($worksheetBeneficiarios,$colInicial,$filaInicial,$colFinal,$filafinal);

        //$totalFilas = 10;
        for($i = $filaInicial; $i<=$totalFilas; $i++){

            //OBTENER FOLIO DEL 
            $folio = $FilaB[$i]['C']; //B es la columna donde estan los folios de educafin

            //VERIFICAR SI EL FOLIO OBTENIDO DEL EXCEL EXISTE EN LA BASE DE DATOS
            $validacion = $this->automatizar_model->coincidirfolioEnDB($folio);
            if ($validacion == true)
            {
                //echo '<br>folio si esta cargado en la base de datos';
                
                    //obtener FolioObraAccion desde la base de datos
                    $foai = $this->gestorDB->getFoaByFolio($folio);

                    $archivo = FCPATH . 'Foliostxt/folios'.$fecha.'.txt';
                    if (!file_exists($archivo)) {
                        touch($archivo);
                    }
                    file_put_contents($archivo, $foai . PHP_EOL, FILE_APPEND);
                    
                    $foa = "'".$foai;

                    //Ejercicio
                    $ejercicio = $FilaB[$i]['A'];

                    //Q
                    $q = $FilaB[$i]['AA'];

                    //IdMetaSed PENDIENTE
                    if ($q == 'QC3164'){
                        $idMetaSed = '2301';
                        $idMetaSed2 = '2302';
                        $idMetaSed3 = '2303';
                    } else if ($q == 'QC3767'){
                        $idMetaSed = '2301';
                        $idMetaSed2 = '2302';
                        $idMetaSed3 = null;
                    }else{
                        $idMetaSed1 = $this->gestorDB->getId('ids','CLAVE_PQG',$q,'ID_META_SED');
                        $idMetaSed2 = null;
                        $idMetaSed3 = null;
                    }

                    //idDependencia
                    $dep = 'JUVENTUDES GTO';
                    $idDependencia = $this->gestorDB->getId('cDependencias','Siglas',$dep ,'idDependencia');

                    //DescripcionObraAccion
                    $descripcionObraAccion = $this->gestorDB->getId('ids','CLAVE_PQG',$q,'DescripcionOA');

                    //EmpleosPermanentesMujeres	EmpleosEventualesMujeres	EmpleosPermanentesHombres	EmpleosEventualesHombres 	
                    $empleosPermanentesMujeres = 0;
                    $empleosEventualesMujeres = 0;	
                    $empleosPermanentesHombres = 0;	
                    $empleosEventualesHombres = 0;
                    $empleosProtegidosMujeres = 0;
                    $empleosProtegidosHombres = 0;

                    //nombre simplificado obra accion
                    $nombreSimplificadoObraAccion = $this->gestorDB->getId('ids','CLAVE_PQG',$q,'Nombre_Simplificado');

                    //idcategoria
                    $idcategoria = $this->gestorDB->getId('cmetas','programa',$q,'categoria');

                    //idsubcategoria
                    $idsubcategoria = $this->gestorDB->getId('cmetas','programa',$q,'subcategoria');

                    //guardar q con los folios
                    $this->automatizar_model->guardar_q($folio, $q);

                    //latitud
                    $latitud = $this->automatizar_model->obtenerzona($folio, 'lat');
                    
                    //longitud
                    $longitud = $this->automatizar_model->obtenerzona($folio, 'lon');

                    //idEstado
                    $estado = $FilaB[$i]['X'];
                    $idEstado = $this->gestorDB->getId('cEstados','Estado',$estado,'idEstado');


                    //idmunicipio
                    $municipio = $FilaB[$i]['M'];
                    $idMunicipio = $this->gestorDB->getId('cMunicipios','NombreMunicipio',$municipio,'idMunicipio');

                    //idLocalidad
                    $idLocalidad = $this->gestorDB->getId('cLocalidades_','idMunicipio',$idMunicipio,'idLocalidad');

                    //TiposAsentamientos
                    $idTipoAsentamiento = $this->gestorDB->getId('cTiposAsentamientos','TipoAsentamiento','COLONIA','idTipoAsentamiento');

                    //NombreAsentamiento
                    $nombreAsentamiento = $FilaB[$i]['Q'];

                    //idTipoVialidad
                    $idTipoVialidad = $this->gestorDB->getId('cTiposVialidades','TipoVialidad','CALLE','idTipoVialidad');

                    //NombreVialidad
                    $nombreVialidad = $FilaB[$i]['N'];

                    //NumExt
                    $numExt = $FilaB[$i]['P'];

                    //NumInt
                    $numInt = $FilaB[$i]['O'];

                    //Codigo Postal
                    $codigopostal = $FilaB[$i]['W'];

                    //idZonaImpulso
                    $idZonaImpulso = null;



                    //totalEstatal
                    $suma = 0;
                    $fila = $i; // Fila 1
                    $inicio = 'AO'; // Índice de inicio
                    $fin = 'AZ'; // Índice de fin

                    for ($in = $inicio; $in <= $fin; $in++) {
                        $suma += $FilaB[$fila][$in];
                    }
                    $totalEstatal = $suma;

                    //MontoDeuda	
                    $MontoDeuda = 0;	

                    //MontoRecursoPropio
                    $suma = 0;
                    $fila = $i; // Fila 1
                    $inicio = 'BO'; // Índice de inicio
                    $fin = 'BZ'; // Índice de fin

                    for ($in = $inicio; $in <= $fin; $in++) {
                        $suma += $FilaB[$fila][$in];
                    }
                    $totalPropio = $suma;

                    //MontoFederal
                    $modalidad = $FilaB[$i]['AC'];
                    $totalFederal = $this->gestorDB->getId_('cmontos','programa', $q, 'modalidad', $modalidad,'monto');
                    /*
                    $suma = 0;
                    $fila = $i; // Fila 1
                    $inicio = 'BB'; // Índice de inicio
                    $fin = 'BM'; // Índice de fin

                    for ($in = $inicio; $in <= $fin; $in++) {
                        $suma += $FilaB[$fila][$in];
                    }
                    $totalFederal = $suma;
                    */
                    //MontoMunicipal	
                    $MontoMunicipal = 0;
                    //MontoOtro	
                    $suma = 0;
                    $fila = $i; // Fila 1
                    $inicio = 'CB'; // Índice de inicio
                    $fin = 'CM'; // Índice de fin

                    for ($in = $inicio; $in <= $fin; $in++) {
                        $suma += $FilaB[$fila][$in];
                    }
                    $MontoOtro = $suma;

                    //MontoBeneficiario
                    $MontoBeneficiario = 0;

                    //EsRefrendo	AnioRefrendo	FolioRelacionado
                    $EsRefrendo = null;
                    $AnioRefrendo = null;	
                    $FolioRelacionado = null;

                    //idTipoObraAccion
                    $idTipoObraAccion = $this->gestorDB->getId('cTiposObrasAcciones','TipoObraAccion','ACCION','idTipoObraAccion');

                    //idTipo
                    $idTipo = $this->gestorDB->getId('ids','CLAVE_PQG',$q,'idTipo');

                    //idStatusAvance 
                    $idStatusAvance = $this->gestorDB->getId('ids','CLAVE_PQG',$q,'idStatusAvance');

                    //ObstervacionesStatusAvance
                    $ObstervacionesStatusAvance = $this->gestorDB->getId('cStatusAvance','idStatusAvance',7,'StatusAvance');

                    //observacionesGenerales
                    $observacionesGenerales = 'De acuerdo al plan';

                    //beneficiariosTotal Mujer Hombre
                    $benefTotal = 1;
                    $sexo =  $FilaB[$i]['I'];
                    if ($sexo == 'MUJER'){
                        $BenefMujeres = 1;
                        $BenefHombres = 0;	
                    } else{
                        $BenefMujeres = 0;
                        $BenefHombres = 1;
                    }

                    //idCCT
                    $cCT = $FilaB[$i]['AF'];
                    if ($cCT == 0){
                        $idCCT = null;
                    }else{
                        $cCT_ = strval($cCT);
                        $idCCT = $this->gestorDB->getId('cCentrosTrabajo','ClaveCCT',$cCT_,'idCCT');
                    }
                    

                    //idInformeGobierno	idSituacion	CifrasEstimadas
                    switch ($ejercicio) {
                        case 2022:
                            $idInformeGobierno = 5;
                            break;
                    
                        case 2023:
                            $idInformeGobierno = 6;
                            break;
                    
                        case 2024:
                            $idInformeGobierno = 1;
                            break;

                        case 2025:
                            $idInformeGobierno = 2;
                            break;
                    
                        case 2026:
                            $idInformeGobierno = 3;
                            break;
                    
                        case 2027:
                            $idInformeGobierno = 4
                            ;
                            break;

                        case 2028:
                            $idInformeGobierno = 5;
                            break;
                    
                        case 2029:
                            $idInformeGobierno = 6
                            ;
                        case 2030:
                            $idInformeGobierno = 1;
                            break;

                        case 2031:
                            $idInformeGobierno = 2;
                            break;
                    
                        case 2032:
                            $idInformeGobierno = 3;
                            break;
                    
                        case 2033:
                            $idInformeGobierno = 4
                            ;
                            break;

                        case 2034:
                            $idInformeGobierno = 5;
                            break;
                    
                        case 2035:
                            $idInformeGobierno = 6
                            ;
                            break;
                        case 2036:
                            $idInformeGobierno = 1;
                            break;

                        case 2037:
                            $idInformeGobierno = 2;
                            break;
                    
                        case 2038:
                            $idInformeGobierno = 3;
                            break;
                    
                        case 2039:
                            $idInformeGobierno = 4
                            ;
                            break;

                        case 2040:
                            $idInformeGobierno = 5;
                            break;
                    
                        case 2041:
                            $idInformeGobierno = 6;
                            break;

                        default:
                            // Código a ejecutar si $ejercicio no coincide con ninguna opción
                            echo "Opción no válida";
                            break;
                    }
                    

                    //idSituacion
                    $idSituacion = 1; //SE TIENE EL CATALOGO PERO FALTA MATRIZ BUSCADA
                    /*idSituacion	Situacion
                                1	Inicio Termina
                                2	Inicio
                                3	Continua
                                4	Termina
                                5	Continua y Termina
                                */

                    //CifrasEstimadas
                    $CifrasEstimadas = 0 ;//VACIO
                    if ($idMetaSed3 != null){
                        $valores = array(
                            $foa,$ejercicio,$q,$idMetaSed,$idDependencia,$descripcionObraAccion,$empleosPermanentesMujeres,
                            $empleosEventualesMujeres,$empleosPermanentesHombres,$empleosEventualesHombres,$empleosProtegidosMujeres,
                            $empleosProtegidosHombres,$nombreSimplificadoObraAccion,$idcategoria,$idsubcategoria,$fechaEntrega,$latitud,$longitud,
                            $idEstado,$idMunicipio,$idLocalidad,$idMunicipio,$idLocalidad,$idTipoAsentamiento,$nombreAsentamiento,
                            $idTipoVialidad,$nombreVialidad,$numExt,$numInt,$codigopostal,$idZonaImpulso,$totalEstatal,$MontoDeuda,$totalPropio,
                            $totalFederal,$MontoMunicipal,$MontoOtro,$MontoBeneficiario,$EsRefrendo,$AnioRefrendo,$FolioRelacionado,
                            $idTipoObraAccion,$idTipo,$idTipoObraAccion,$idStatusAvance,$ObstervacionesStatusAvance,$observacionesGenerales,
                            $benefTotal,$BenefMujeres,$BenefHombres,$idCCT,$idInformeGobierno,$idSituacion,$CifrasEstimadas,$folio
                            );
        
                            $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtomPr,$this->indiceiGto,$valores);
                            $this->indiceiGto++;

                        $valores = array(
                            $foa,$ejercicio,$q,$idMetaSed2,$idDependencia,$descripcionObraAccion,$empleosPermanentesMujeres,
                            $empleosEventualesMujeres,$empleosPermanentesHombres,$empleosEventualesHombres,$empleosProtegidosMujeres,
                            $empleosProtegidosHombres,$nombreSimplificadoObraAccion,$idcategoria,$idsubcategoria,$fechaEntrega,$latitud,$longitud,
                            $idEstado,$idMunicipio,$idLocalidad,$idMunicipio,$idLocalidad,$idTipoAsentamiento,$nombreAsentamiento,
                            $idTipoVialidad,$nombreVialidad,$numExt,$numInt,$codigopostal,$idZonaImpulso,$totalEstatal,$MontoDeuda,$totalPropio,
                            $totalFederal,$MontoMunicipal,$MontoOtro,$MontoBeneficiario,$EsRefrendo,$AnioRefrendo,$FolioRelacionado,
                            $idTipoObraAccion,$idTipo,$idTipoObraAccion,$idStatusAvance,$ObstervacionesStatusAvance,$observacionesGenerales,
                            $benefTotal,$BenefMujeres,$BenefHombres,$idCCT,$idInformeGobierno,$idSituacion,$CifrasEstimadas,$folio
                            );

                            $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtomPr,$this->indiceiGto,$valores);
                            $this->indiceiGto++;
                        
                        $valores = array(
                            $foa,$ejercicio,$q,$idMetaSed3,$idDependencia,$descripcionObraAccion,$empleosPermanentesMujeres,
                            $empleosEventualesMujeres,$empleosPermanentesHombres,$empleosEventualesHombres,$empleosProtegidosMujeres,
                            $empleosProtegidosHombres,$nombreSimplificadoObraAccion,$idcategoria,$idsubcategoria,$fechaEntrega,$latitud,$longitud,
                            $idEstado,$idMunicipio,$idLocalidad,$idMunicipio,$idLocalidad,$idTipoAsentamiento,$nombreAsentamiento,
                            $idTipoVialidad,$nombreVialidad,$numExt,$numInt,$codigopostal,$idZonaImpulso,$totalEstatal,$MontoDeuda,$totalPropio,
                            $totalFederal,$MontoMunicipal,$MontoOtro,$MontoBeneficiario,$EsRefrendo,$AnioRefrendo,$FolioRelacionado,
                            $idTipoObraAccion,$idTipo,$idTipoObraAccion,$idStatusAvance,$ObstervacionesStatusAvance,$observacionesGenerales,
                            $benefTotal,$BenefMujeres,$BenefHombres,$idCCT,$idInformeGobierno,$idSituacion,$CifrasEstimadas,$folio
                            );

                            $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtomPr,$this->indiceiGto,$valores);
                            $this->indiceiGto++;




                    }else if($idMetaSed2 != null){
                        $valores = array(
                            $foa,$ejercicio,$q,$idMetaSed,$idDependencia,$descripcionObraAccion,$empleosPermanentesMujeres,
                            $empleosEventualesMujeres,$empleosPermanentesHombres,$empleosEventualesHombres,$empleosProtegidosMujeres,
                            $empleosProtegidosHombres,$nombreSimplificadoObraAccion,$idcategoria,$idsubcategoria,$fechaEntrega,$latitud,$longitud,
                            $idEstado,$idMunicipio,$idLocalidad,$idMunicipio,$idLocalidad,$idTipoAsentamiento,$nombreAsentamiento,
                            $idTipoVialidad,$nombreVialidad,$numExt,$numInt,$codigopostal,$idZonaImpulso,$totalEstatal,$MontoDeuda,$totalPropio,
                            $totalFederal,$MontoMunicipal,$MontoOtro,$MontoBeneficiario,$EsRefrendo,$AnioRefrendo,$FolioRelacionado,
                            $idTipoObraAccion,$idTipo,$idTipoObraAccion,$idStatusAvance,$ObstervacionesStatusAvance,$observacionesGenerales,
                            $benefTotal,$BenefMujeres,$BenefHombres,$idCCT,$idInformeGobierno,$idSituacion,$CifrasEstimadas,$folio
                            );

                            $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtomPr,$this->indiceiGto,$valores);
                            $this->indiceiGto++;
                        $valores = array(
                            $foa,$ejercicio,$q,$idMetaSed2,$idDependencia,$descripcionObraAccion,$empleosPermanentesMujeres,
                            $empleosEventualesMujeres,$empleosPermanentesHombres,$empleosEventualesHombres,$empleosProtegidosMujeres,
                            $empleosProtegidosHombres,$nombreSimplificadoObraAccion,$idcategoria,$idsubcategoria,$fechaEntrega,$latitud,$longitud,
                            $idEstado,$idMunicipio,$idLocalidad,$idMunicipio,$idLocalidad,$idTipoAsentamiento,$nombreAsentamiento,
                            $idTipoVialidad,$nombreVialidad,$numExt,$numInt,$codigopostal,$idZonaImpulso,$totalEstatal,$MontoDeuda,$totalPropio,
                            $totalFederal,$MontoMunicipal,$MontoOtro,$MontoBeneficiario,$EsRefrendo,$AnioRefrendo,$FolioRelacionado,
                            $idTipoObraAccion,$idTipo,$idTipoObraAccion,$idStatusAvance,$ObstervacionesStatusAvance,$observacionesGenerales,
                            $benefTotal,$BenefMujeres,$BenefHombres,$idCCT,$idInformeGobierno,$idSituacion,$CifrasEstimadas,$folio
                            );

                            $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtomPr,$this->indiceiGto,$valores);
                            $this->indiceiGto++;
                    } else {
                        
                    $valores = array(
                        $foa,$ejercicio,$q,$idMetaSed,$idDependencia,$descripcionObraAccion,$empleosPermanentesMujeres,
                        $empleosEventualesMujeres,$empleosPermanentesHombres,$empleosEventualesHombres,$empleosProtegidosMujeres,
                        $empleosProtegidosHombres,$nombreSimplificadoObraAccion,$idcategoria,$idsubcategoria,$fechaEntrega,$latitud,$longitud,
                        $idEstado,$idMunicipio,$idLocalidad,$idMunicipio,$idLocalidad,$idTipoAsentamiento,$nombreAsentamiento,
                        $idTipoVialidad,$nombreVialidad,$numExt,$numInt,$codigopostal,$idZonaImpulso,$totalEstatal,$MontoDeuda,$totalPropio,
                        $totalFederal,$MontoMunicipal,$MontoOtro,$MontoBeneficiario,$EsRefrendo,$AnioRefrendo,$FolioRelacionado,
                        $idTipoObraAccion,$idTipo,$idTipoObraAccion,$idStatusAvance,$ObstervacionesStatusAvance,$observacionesGenerales,
                        $benefTotal,$BenefMujeres,$BenefHombres,$idCCT,$idInformeGobierno,$idSituacion,$CifrasEstimadas,$folio
                        );
    
                        $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtomPr,$this->indiceiGto,$valores);
                        $this->indiceiGto++;
    
                    }
                    //echo '<br>';
                //echo '<br>';
                //$this->writer->save('Generados/gen/mProyectos.xlsx');
                

            }else{
                //echo 'FOLIO NO ENCONTRADO: folio aun no esta cargado en la base de datos';
            }
            //$this->writer->save('Generados/MetasProyectos.xlsx');
        
        }        
        //$this->writer->save('Generados/gen/mProyectos.xlsx');
        
    }





    public function automaEI($worksheetiGtoEI,$worksheetBeneficiarios){
        $this->load->helper('url');
        //$this->indiceiGto = 2;
        //$worksheetiGtoEI ->setTitle('relProyecto_iGTO_cEnfoques');
        //DATOS DATOS POR EL USUARIO
        $colInicial='A'; //Columna inicial beneficiarios
        $colFinal='CR'; //Columna Final beneficiarios
        $mes = 'JUNIO';
        $filaInicial = 2;
        
        //INICIA EL CICLO
        $filafinal= 100;
        $cicloN = 1;
        $ciclo = 100;
        //obtener array
        //OBTENER NUMERO TOTAL DE FILAS
        $totalFilas = $this->automatizar_model->numeroFilas($worksheetBeneficiarios);
        
        while ($filafinal < $totalFilas){
            //echo 'ciclo: '.$cicloN.'<br>';
            //echo 'fila inicial: '.$filaInicial.'<br>';
            //echo 'fila final:'.$filafinal.'<br>';
            $FilaB = $this->automatizar_model->obtenerFilaBeneficiario($worksheetBeneficiarios,$colInicial,$filaInicial,$colFinal,$filafinal);

            //$totalFilas = 10;
            for($i = $filaInicial; $i<=$filafinal; $i++){

                //OBTENER FOLIO DEL 
                $folio = $FilaB[$i]['C']; //B es la columna donde estan los folios de educafin

                //VERIFICAR SI EL FOLIO OBTENIDO DEL EXCEL EXISTE EN LA BASE DE DATOS
                $validacion = $this->automatizar_model->coincidirfolioEnDB($folio);
                if ($validacion == true)
                {
                    //echo '<br>folio si esta cargado en la base de datos';
                    
                    //obtener FolioObraAccion desde la base de datos
                    $foai = $this->gestorDB->getFoaByFolio($folio);
                    $foa = "'".$foai;

                    //idVistaInstrumentoPlaneacion 
                    $q = $FilaB[$i]['AA'];
                    $idVistaInstrumentoPlaneacion = $this->gestorDB->getId('ids','CLAVE_PQG',$q ,'AlineaciónPSPG');//AlineaciónPSPG
                    $idVistaInstrumentoPlaneacion2 = $this->gestorDB->getId('ids','CLAVE_PQG',$q ,'Alineación_PEJ');

                    //ComoAbona
                    $ComoAbona = $this->gestorDB->getId('ids','CLAVE_PQG',$q ,'Como_abona');
                    $ComoAbona2 = $this->gestorDB->getId('ids','CLAVE_PQG',$q ,'Como_abona_2');

                    $valores = array(
                    $foa,$idVistaInstrumentoPlaneacion,$ComoAbona,$folio
                    );

                    $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtoEI,$this->indiceiGto,$valores);
                    $this->indiceiGto++;

                    $valores = array(
                        $foa,$idVistaInstrumentoPlaneacion2,$ComoAbona2,$folio
                        );

                    $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtoEI,$this->indiceiGto,$valores);
                    $this->indiceiGto++;
                    //echo '<br>';
                    //echo '<br>';

                }else{
                    //echo 'FOLIO NO ENCONTRADO: folio aun no esta cargado en la base de datos';
                }
                //$this->writer->save('Generados/MetasProyectos.xlsx');
            
            }

            $filaInicial = $filafinal+1;
            $filafinal = $filafinal+$ciclo;
            $cicloN++;
        }
        //echo 'ciclo final: '.$cicloN.'<br>';
        //echo 'fila inicial: '.$filaInicial.'<br>';
        //echo 'fila final:'.$totalFilas.'<br>';
        $FilaB = $this->automatizar_model->obtenerFilaBeneficiario($worksheetBeneficiarios,$colInicial,$filaInicial,$colFinal,$filafinal);

            //$totalFilas = 10;
            for($i = $filaInicial; $i<=$totalFilas; $i++){

                //OBTENER FOLIO DEL 
                $folio = $FilaB[$i]['C']; //B es la columna donde estan los folios de educafin

                //VERIFICAR SI EL FOLIO OBTENIDO DEL EXCEL EXISTE EN LA BASE DE DATOS
                $validacion = $this->automatizar_model->coincidirfolioEnDB($folio);
                if ($validacion == true)
                {
                    //echo '<br>folio si esta cargado en la base de datos';
                    
                    //obtener FolioObraAccion desde la base de datos
                    $foai = $this->gestorDB->getFoaByFolio($folio);
                    $foa = "'".$foai;

                    //idVistaInstrumentoPlaneacion 
                    $q = $FilaB[$i]['AA'];
                    $idVistaInstrumentoPlaneacion = $this->gestorDB->getId('ids','CLAVE_PQG',$q ,'AlineaciónPSPG');//AlineaciónPSPG
                    $idVistaInstrumentoPlaneacion2 = $this->gestorDB->getId('ids','CLAVE_PQG',$q ,'AlineaciónPSPG');

                    
                    //ComoAbona
                    $ComoAbona = $this->gestorDB->getId('ids','CLAVE_PQG',$q ,'Como_abona');
                    $ComoAbona2 = $this->gestorDB->getId('ids','CLAVE_PQG',$q ,'Como_abona_2');

                    $valores = array(
                    $foa,$idVistaInstrumentoPlaneacion,$ComoAbona,$folio
                    );

                    $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtoEI,$this->indiceiGto,$valores);
                    $this->indiceiGto++;

                    $valores = array(
                        $foa,$idVistaInstrumentoPlaneacion2,$ComoAbona2,$folio
                        );

                    $this->automatizar_model->escribir($this->spreadsheetiGto,$worksheetiGtoEI,$this->indiceiGto,$valores);
                    $this->indiceiGto++;
                    //echo '<br>';
                    //echo '<br>';

                }else{
                    //echo 'FOLIO NO ENCONTRADO: folio aun no esta cargado en la base de datos';
                }
                
                //$this->writer->save('Generados/MetasProyectos.xlsx');
            
            }

        
        
        
    }
























    public function getLastDataRow($worksheet) {
        $lastRow = $worksheet->getHighestDataRow();
    
        while (empty(trim($worksheet->getCell('A' . $lastRow)->getValue()))) {
            $lastRow--;
        }
    
        return $lastRow;
    }

    

























}
?>