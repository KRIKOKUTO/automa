<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpParser\Node\Expr\FuncCall;
defined('BASEPATH') OR exit('No direct script access allowed');

class Cactualizar extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("cat_update");
        $this->load->model("automatizar_model");
        $this->load->helper(array('form', 'url'));
        $this->load->library('upload');

        if ($this->session->userdata()['estado'] == 'inactivo'){
            redirect('pinactivo/redirigir');
        }
        //$navbar_data['title'] = 'Barra de Navegación';
        //$this->load->view('navbar', $navbar_data);
        if ($this->session->userdata()['rol'] == 'planeacion'){
            $navbar_data['title'] = 'Barra de Navegación';
            $this->load->view('navbar', $navbar_data);
        } else if($this->session->userdata()['rol'] == 'TI'){
            redirect('automatizar');
        } else if($this->session->userdata()['rol'] == null){
            redirect('auth/login');
        } else if ($this->session->userdata()['estado'] == 'inactivo'){
            redirect('pinactivo/redirigir');
        }

    }
    public function index()
    {
        $this->load->view('cactualizar_view');
    }

    public function verificarpass() {
        // Obtiene la contraseña del POST
        $password = $this->input->post('password');
        $contrasenaEncriptada = $this->session->userdata('pass');
        
        
        return 'oñacon';
        //$this->load->view('cactualizar_view', $data);
    }

    public function do_upload()
    {
        $config['upload_path'] = FCPATH . 'Catalogos/'; 
        $config['allowed_types'] = 'zip|xlsx|xls'; 
        $config['max_size'] = 25024; 
        $fn = $_POST["fila_inicial"];
        //echo $fn.'<br><br><br>';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Verificar si se ha enviado un archivo
            if (isset($_FILES["archivo"])) {
                $opciones = $_POST["opciones"];
            } else {
                

            }
        }
        if ($opciones == 'varios'){

            
            $zipFilePath = FCPATH . 'Catalogos/varios.zip';
            
            
            $destinationPath = FCPATH . 'Catalogos/';
            $this->automatizar_model->vaciarCarpeta($destinationPath);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('archivo')) {

                // El archivo se ha subido correctamente
                $data = $this->upload->data();
                
                echo "El archivo se ha subido correctamente.";
            } else {
                // Hubo un error en la subida del archivo
                $error = $this->upload->display_errors();
                
                echo "Hubo un error al subir el archivo: $error";
            }
            $this->automatizar_model->extractZipFile_($zipFilePath,$destinationPath);
            
        }else{
            $config['file_name'] = $opciones.'.xlsx'; 
            $archivo_a_borrar = FCPATH . 'Catalogos/'.$opciones.'.xlsx';

            //rename($archivo_a_borrar, FCPATH . 'Catalogos/'.$opciones.'_.xlsx');
            //$archivo_a_borrar_ = FCPATH . 'Catalogos/'.$opciones.'_.xlsx';


            $this->upload->initialize($config);

            if ($this->upload->do_upload('archivo')) {

                // El archivo se ha subido correctamente
                $data = $this->upload->data();
                
                if (file_exists(FCPATH . 'Catalogos/'.$opciones.'1.xlsx')) {
                    unlink($archivo_a_borrar);
                    rename(FCPATH . 'Catalogos/'.$opciones.'1.xlsx', FCPATH . 'Catalogos/'.$opciones.'.xlsx');
                }
                
                
                //echo "El archivo se ha subido correctamente.";
                
            } else {
                // Hubo un error en la subida del archivo
                $error = $this->upload->display_errors();
                
                
                echo "Hubo un error al subir el archivo: $error";
            }

        }
        $this->decideupdate($fn,$opciones);

    }
    public function decideupdate($fn,$opcion){
        //echo $opcion;
        
            switch ($opcion) {
                case 'ids':
                    $this->cat_update->cids($fn);
                    break;
                case 'cmetas':
                    $this->cat_update->metas($fn);
                    break;
                case 'cmontos':
                    $this->cat_update->montos($fn);
                    break;
                case 'varios':
                    $this->cat_update->cCategorias_update($fn);
                    break;
                case 'cTiposObrasAcciones':
                    $this->cat_update->cTiposObrasAcciones_update($fn);
                    break;
                case 'cCategorias':
                    $this->cat_update->cCategorias_update($fn);
                    break;
                case 'cSubCategorias':
                    $this->cat_update->cSubCategorias_update($fn);
                    break;
                case 'cEnfoques':
                    $this->cat_update->cEnfoques_update($fn);
                    break;
                case 'cTipos':
                    $this->cat_update->cTipos_update($fn);
                    break;
                case 'cStatusObrasAcciones':
                    $this->cat_update->cStatusObrasAcciones_update($fn);
                    break;
                case 'cStatusAvance':
                    $this->cat_update->cStatusAvance_update($fn);
                    break;
                case 'cDependencias':
                    $this->cat_update->cDependencias_update($fn);
                    break;
                case 'cMunicipios':
                    $this->cat_update->cMunicipios_update($fn);
                    break;
                case 'cEstados':
                    $this->cat_update->cEstados_update($fn);
                    break;
                case 'cLocalidades_':
                    $this->cat_update->cLocalidades($fn);
                    break;
                case 'cZonasImpulso':
                    $this->cat_update->cZonasImpulso_update($fn);
                    break;
                case 'cCentrosTrabajo':
                    $this->cat_update->cCentrosTrabajo_update($fn);
                    break;
                case 'cTiposAsentamientos':
                    $this->cat_update->cTiposAsentamientos_update($fn);
                    break;
                case 'cTiposVialidades':
                    $this->cat_update->cTiposVialidades_update($fn);
                    break;
                case 'cSituaciones':
                    $this->cat_update->cSituaciones_update($fn);
                case 'vwmd_ProgramaSectorial':
                    $this->cat_update->vwmd_ProgramaSectorial_update($fn);
                    break;
                case '38.- cAgendas':
                    $this->cat_update->cAgendas_update($fn);
                    break;
                case 'cTiposBeneficiarios':
                    $this->cat_update->cTiposBeneficiarios_update($fn);
                    break;
                case 'catPais':
                    $this->cat_update->catPais_update($fn);
                    break;
                case 'cCalificacionesCualitativas':
                    $this->cat_update->cCalificacionesCualitativas_update($fn);
        
                    break;
                case 'cCodigosSepomex':
                    $this->cat_update->cCodigosSepomex_update($fn);
        
                    break;
                case 'cEjes':
                    $this->cat_update->cEjes_update($fn);
        
                    break;
                case 'cEjesEstrategicos':
                    $this->cat_update->cEjesEstrategicos_update($fn);
        
                    break;
                case 'cEstadosCivil':
                    $this->cat_update->cEstadosCivil_update($fn);
        
                    break;
                case 'cEstrategias_PG':
                    $this->cat_update->cEstrategias_PG_update($fn);
        
                    break;
                case 'cGrupoCategorias':
                    $this->cat_update->cGrupoCategorias_update($fn);
        
                    break;
                case 'cMeses':
                    $this->cat_update->cMeses_update($fn);
        
                    break;
                case 'cModalidadesContratacion':
                    $this->cat_update->cModalidadesContratacion_update($fn);
                    break;
                case 'cObjetivos_PG':
                    $this->cat_update->cObjetivos_PG_update($fn);

                    break;
                case 'cTiposAgendas':
                    $this->cat_update->cTiposAgendas_update($fn);
        
                    break;
                case 'cTiposConcurrencias':
                    $this->cat_update->cTiposConcurrencias_update($fn);
        
                    break;
                case 'cTiposEnfoques':
                    $this->cat_update->cTiposEnfoques_update($fn);
                    
                    break;
                case 'cTiposObrasAccionesG1':
                    $this->cat_update->cTiposObrasAccionesG1_update($fn);
                    break;
                
                default:
                    $this->update($fn);
                    break;
                    
                    
            }
            $this->session->set_flashdata('opciones', $opcion);
            redirect('vercata');

    }

    public function update($fn) {
        
        $this->cat_update->cids($fn);
        $this->cat_update->montos($fn);
        $this->cat_update->cCategorias_update($fn);
        $this->cat_update->cTiposObrasAcciones_update($fn);
        $this->cat_update->cSubCategorias_update($fn);
        $this->cat_update->cEnfoques_update($fn);
        $this->cat_update->cTipos_update($fn);
        $this->cat_update->cStatusObrasAcciones_update($fn);
        $this->cat_update->cStatusAAvance_update();
        $this->cat_update->cDependencias_update();
        $this->cat_update->cMunicipios_update();
        $this->cat_update->cEstados_update();

        $this->cat_update->cLocalidades_update();
        $this->cat_update->cZonasImpulso_update();
        $this->cat_update->cCentrosTrabajo_update();
        $this->cat_update->cTiposAsentamientos_update();
        $this->cat_update->cTiposVialidades_update();
        $this->cat_update->cSituaciones_update();
        $this->cat_update->vwmd_ProgramaSectorial_update();
        $this->cat_update->cAgendas_update();
        $this->cat_update->cTiposBeneficiarios_update();
        $this->cat_update->catPais_update();

        $this->cat_update->cCalificacionesCualitativas_update();
        $this->cat_update->cCodigosSepomex_update();
        $this->cat_update->cEjes_update();
        $this->cat_update->cEjesEstrategicos_update();
        $this->cat_update->cEstadosCivil_update();
        $this->cat_update->cEstrategias_PG_update();
        $this->cat_update->cGrupoCategorias_update();
        $this->cat_update->cMeses_update();
        $this->cat_update->cModalidadesContratacion_update();
        $this->cat_update->cObjetivos_PG_update();

        $this->cat_update->cTiposAgendas_update();
        $this->cat_update->cTiposConcurrencias_update();
        $this->cat_update->cTiposEnfoques_update();
        $this->cat_update->cTiposObrasAccionesG1_update();


    }
}

