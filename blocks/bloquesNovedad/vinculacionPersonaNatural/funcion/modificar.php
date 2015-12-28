<?php

namespace bloquesParametro\parametroArl\funcion;
    
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
       
        if(isset($_REQUEST['codTipoCargoRegistro'])){
                    
                }
                
                if(isset($_REQUEST['tipoSueldoRegistro'])){
                    switch($_REQUEST ['tipoSueldoRegistro']){
                           case 1 :
					$_REQUEST ['tipoSueldoRegistro']='M';
			   break;
                       
                           case 2 :
					$_REQUEST ['tipoSueldoRegistro']='H';
			   break;
                    }
                }
                
                
        
        $datos = array(
            'nit' => $_REQUEST ['nit'],
            'nombre' => $_REQUEST ['nombre'],
            'direccion' => $_REQUEST ['direccion'],
            'telefono' => $_REQUEST ['telefono'],
            'extencionTelefono' => $_REQUEST ['extencionTelefono'],
            'fax' => $_REQUEST ['fax'],
            'extencionFax' => $_REQUEST ['extencionFax'],
            'lugar' => $_REQUEST ['lugar'],
            'nombreRepresentante' => $_REQUEST ['nombreRepresentante'],
            'email' => $_REQUEST ['email']
            
        );
//       
        
                
        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("modificarRegistro",$datos);
        
        
        
        $primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "acceso");
        //Al final se ejecuta la redirección la cual pasará el control a otra página
       
        Redireccionador::redireccionar('form');
    	        
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