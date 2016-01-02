<?php

namespace bloquesLiquidacion\tipoNomina\funcion;


include_once('Redireccionador.php');

class FormProcessor {
    
    var $miConfigurador;
    var $lenguaje;
    var $miFormulario;
    var $miSql;
    var $conexion;
    
    function __construct($lenguaje, $sql) {
        
        $this->miConfigurador = \Configurador::singleton ();
        $this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
        $this->lenguaje = $lenguaje;
        $this->miSql = $sql;
    
    }
    
    function procesarFormulario() {    

        //Aquí va la lógica de procesamiento
        
        $conexion = 'estructura';
        $primerRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
       
         if(isset($_REQUEST['reglamentacion'])){
                    switch($_REQUEST ['reglamentacion']){
                           case 1 :
					$_REQUEST ['reglamentacion']='DI';
			   break;
                       
                           case 2 :
					$_REQUEST ['reglamentacion']='AS';
			   break;
                       
                           case 3 :
					$_REQUEST ['reglamentacion']='EJ';
			   break;
                       
                           case 4 :
					$_REQUEST ['reglamentacion']='TE';
			   break;
			   
                           case 5 :
					$_REQUEST ['reglamentacion']='AI';
			   break;
                       
                           case 6 :
					$_REQUEST ['reglamentacion']='TO';
			   break;
		           		
                           case 7 :
					$_REQUEST ['reglamentacion']='DC';
			   break;
                           
                           case 8 :
					$_REQUEST ['reglamentacion']='DP';
			   break;
                    
                    
                    }
                }
                
                if(isset($_REQUEST['tipoNomina'])){
                    switch($_REQUEST ['tipoNomina']){
                           case 1 :
					$_REQUEST ['tipoNomina']='Periodica';
			   break;
                       
                           case 2 :
					$_REQUEST ['tipoNomina']='Esporadica';
			   break;
                       
                           case 3 :
					$_REQUEST ['tipoNomina']='Mixta';
			   break;
                    }
                }
                
                if(isset($_REQUEST['estadoRegistroNomina'])){
                    switch($_REQUEST ['estadoRegistroNomina']){
                           case 1 :
					$_REQUEST ['estadoRegistroNomina']='Activo';
			   break;
                       
                           case 2 :
					$_REQUEST ['estadoRegistroNomina']='Inactivo';
			   break;
                    }
                }
                $periodo='';
                if(isset($_REQUEST['periodo'])){
                    switch($_REQUEST ['periodo']){
                                                
                           case 1 :
					$periodo='Enero';
			   break;
                           case 2 :
					$periodo='Febrero';
			   break;
                           case 3 :
					$periodo='Marzo';
			   break;
                           case 4 :
					$periodo='Abril';
			   break;
                           case 5 :
					$periodo='Mayo';
			   break;
                           case 6 :
					$periodo='Junio';
			   break;
                           case 7 :
					$periodo='Julio';
			   break;
                           case 8 :
					$periodo='Agosto';
			   break;
                           case 9 :
					$periodo='Septiembre';
			   break;
                           case 10 :
					$periodo='Octubre';
			   break;
                           case 11 :
					$periodo='Noviembre';
			   break;
                           case 12 :
					$periodo='Diciembre';
			   break;
                    }
                }
                else{
                    $periodo=$_REQUEST['per'];
                }

        $datos = array(
            
            'id' => $_REQUEST ['vinculacion'],
            'codigoNomina' => $_REQUEST['codigoNomina'],
            'nombreNomina' => $_REQUEST ['nombreNomina'],
            'tipoNomina' => $_REQUEST ['tipoNomina'],
            'periodo' => $periodo,
            'reglamentacion' => $_REQUEST ['reglamentacion'],
            'estadoRegistroNomina' => $_REQUEST ['estadoRegistroNomina'],
            'descripcionNomina' => $_REQUEST ['descripcionNomina'],
            'variable' => $_REQUEST['variable']
        
        );
        
                
        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("modificarRegistroxnomina",$datos);
        
        $resultado=$primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "acceso");
        //Al final se ejecuta la redirección la cual pasará el control a otra página
        if (!empty($resultado)) {
              Redireccionador::redireccionar('modifico',$datos);
            exit();
        } else {
           Redireccionador::redireccionar('noInserto');
            exit();
        }
        
    	        
    }
    
    function resetForm(){
        foreach($_REQUEST as $clave=>$valor){
             
            if($clave !='pagina' && $clave!='development' && $clave !='jquery' &&$clave !='tiempo'){
                unset($_REQUEST[$clave]);
            }
        }
    }
    
}

$miProcesador = new FormProcessor ( $this->lenguaje, $this->sql );

$resultado= $miProcesador->procesarFormulario ();

