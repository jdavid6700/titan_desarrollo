<?php

namespace bloquesParametro\parametroArl;

if (! isset ( $GLOBALS ["autorizado"] )) {
    include ("../index.php");
    exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

/**
 * IMPORTANTE: Se recomienda que no se borren registros. Utilizar mecanismos para - independiente del motor de bases de datos,
 * poder realizar rollbacks gestionados por el aplicativo.
 */



class Sql extends \Sql {
    
    var $miConfigurador;
    
    function getCadenaSql($tipo, $variable = '') {
        
        
        
        /**
         * 1.
         * Revisar las variables para evitar SQL Injection
         */
        $prefijo = $this->miConfigurador->getVariableConfiguracion ( "prefijo" );
        $idSesion = $this->miConfigurador->getVariableConfiguracion ( "id_sesion" );
        $cadenaSql='';
        switch ($tipo) {
            
            /**
             * Clausulas específicas
             */
            
            case 'buscarArl':
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'nit as NIT, ';
                $cadenaSql .= 'nombre as NOMBRE, ';
                $cadenaSql .= 'direccion as DIRECCION, ';
                $cadenaSql .= 'telefono as TELEFONO, ';
                $cadenaSql .= 'extencion_telefono as EXTENCION_TELEFONO, ';
                $cadenaSql .= 'estado as ESTADO ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'nomina.arl';
                break;
            
            case 'buscarPersona':
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'documento as DOCUMENTO, ';
                $cadenaSql .= 'primer_nombre as NOMBRE, ';
                $cadenaSql .= 'primer_apellido as APELLIDO, ';
                $cadenaSql .= 'autorretenedor as AUTORRETENEDOR, ';
                $cadenaSql .= 'regimen_tributario as REGIMEN ';
               
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'persona.persona_natural';
                break;
         case 'buscarArl1':
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'nit as NIT, ';
                $cadenaSql .= 'nombre as NOMBRE, ';
                $cadenaSql .= 'direccion as DIRECCION, ';
                $cadenaSql .= 'telefono as TELEFONO, ';
                $cadenaSql .= 'extencion_telefono as EXTENCION_TELEFONO, ';
                $cadenaSql .= 'fax as FAX, ';
                $cadenaSql .= 'extencion_fax as EXTENCION_FAX, ';
                $cadenaSql .= 'lugar as LUGAR,';
                $cadenaSql .= 'nombre_representante_legal as NOMBRE_REPRESENTANTE_LEGAL, ';
                $cadenaSql .= 'email as EMAIL, ';
                $cadenaSql .= 'estado as ESTADO ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'nomina.arl';
                break;
            
             case 'modificarRegistro' :
                $cadenaSql = 'UPDATE ';
                $cadenaSql .= 'nomina.arl ';
                $cadenaSql .= 'SET ';
                $cadenaSql .= 'nombre = ';
                $cadenaSql .= "'".$variable ['nombre'] . "',";
                $cadenaSql .= 'direccion = ';
                $cadenaSql .= "'".$variable ['direccion']  . "',";
                $cadenaSql .= 'telefono = ';
                $cadenaSql .= $variable ['telefono']  . ', ';
                $cadenaSql .= 'extencion_telefono = ';
                $cadenaSql .= $variable ['extencionTelefono']  . ', ';
                $cadenaSql .= 'Fax = ';
                $cadenaSql .= $variable ['fax']  . ', ';
               
               
                if($variable ['lugar']!='')
                {
                     $cadenaSql .= 'lugar = ';
                     $cadenaSql .= "'".$variable ['lugar']  . "',";
                }
               
                $cadenaSql .= 'nombre_representante_legal = ';
                $cadenaSql .= "'".$variable ['nombreRepresentante']  . "',";
                $cadenaSql .= 'email = ';
                $cadenaSql .= "'".$variable ['email']."'";
                $cadenaSql .= ' WHERE ';
                $cadenaSql .= 'nit = ';
                $cadenaSql .= $variable ['nit']  .';';
                break;
                
            case 'inactivarRegistro' :
                $cadenaSql = 'UPDATE ';
                $cadenaSql .= 'nomina.arl ';
                $cadenaSql .= 'SET ';
                $cadenaSql .= 'estado = ';
                $cadenaSql .= "'". $variable ['estadoRegistro']  ."' ";
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'nit = ';
                $cadenaSql .= $variable ['codigoRegistro'].";";
                break;
        
        
            case "registrarArl" :
				$cadenaSql=" INSERT INTO nomina.arl";
				$cadenaSql.=" (";
				$cadenaSql.=" nit,";
				$cadenaSql.=" nombre,";
				$cadenaSql.=" direccion,";
				$cadenaSql.=" telefono,";
				$cadenaSql.=" extencion_telefono,";
				$cadenaSql.=" fax,";
				$cadenaSql.=" extencion_fax,";
				$cadenaSql.=" lugar,";
				$cadenaSql.=" nombre_representante_legal,";
				$cadenaSql.=" email,";
				$cadenaSql.=" estado";
				$cadenaSql.=" )";
				$cadenaSql.=" VALUES";
				$cadenaSql.=" (";
				$cadenaSql.=" '" . $_REQUEST['nit']. "',";
				$cadenaSql.=" '" . $_REQUEST['nombre']. "',";
				$cadenaSql.=" '" . $_REQUEST['direccion']. "',";
				$cadenaSql.=" '" . $_REQUEST['telefono']. "',";
				$cadenaSql.=" '" . $_REQUEST['extencionTelefono']. "',";
				$cadenaSql.=" '" . $_REQUEST['fax']. "',";
				$cadenaSql.=" '" . $_REQUEST['extencionFax']. "',";
				$cadenaSql.=" '" . $_REQUEST['lugar']. "',";
				$cadenaSql.=" '" . $_REQUEST['nombreRepresentante']. "',";
                                $cadenaSql.=" '" . $_REQUEST['email']. "',";
				$cadenaSql.=" 'Activo'";
				$cadenaSql.=" );";
				break;  
            
            case 'insertarRegistro' :
                $cadenaSql = 'INSERT INTO ';
                $cadenaSql .= 'parametro.cargo ';
                $cadenaSql .= '( ';
                $cadenaSql .= 'nivel,';
                $cadenaSql .= 'codigo_alternativo,';
                $cadenaSql .= 'grado,';
                $cadenaSql .= 'nombre,';
                $cadenaSql .= 'cod_tipo_cargo,';
                $cadenaSql .= 'sueldo,';
                $cadenaSql .= 'tipo_sueldo,';
                $cadenaSql .= 'estado';
                $cadenaSql .= ') ';
                $cadenaSql .= 'VALUES ';
                $cadenaSql .= '( ';
                $cadenaSql .= $_REQUEST ['nivelRegistro'] . ', ';
                $cadenaSql .= $_REQUEST ['codAlternativoRegistro'] . ', ';
                $cadenaSql .= $_REQUEST ['gradoRegistro'] . ', ';
                $cadenaSql .= '\'' . $_REQUEST ['nombreRegistro']  . '\', ';
                $cadenaSql .= '\'' . $_REQUEST ['codTipoCargoRegistro'] . '\', ';
                $cadenaSql .= $_REQUEST ['sueldoRegistro'] . ', ';
                $cadenaSql .= '\'' . $_REQUEST ['tipoSueldoRegistro'] . '\', ';
                $cadenaSql .= '\'' . 'Activo' . '\' ';
                $cadenaSql .= ') ';
                echo $cadenaSql;
                break;
            
            case 'actualizarRegistro' :
                $cadenaSql = 'INSERT INTO ';
                $cadenaSql .= $prefijo . 'pagina ';
                $cadenaSql .= '( ';
                $cadenaSql .= 'nombre,';
                $cadenaSql .= 'descripcion,';
                $cadenaSql .= 'modulo,';
                $cadenaSql .= 'nivel,';
                $cadenaSql .= 'parametro';
                $cadenaSql .= ') ';
                $cadenaSql .= 'VALUES ';
                $cadenaSql .= '( ';
                $cadenaSql .= '\'' . $_REQUEST ['nombrePagina'] . '\', ';
                $cadenaSql .= '\'' . $_REQUEST ['descripcionPagina'] . '\', ';
                $cadenaSql .= '\'' . $_REQUEST ['moduloPagina'] . '\', ';
                $cadenaSql .= $_REQUEST ['nivelPagina'] . ', ';
                $cadenaSql .= '\'' . $_REQUEST ['parametroPagina'] . '\'';
                $cadenaSql .= ') ';
                break;
            
            case 'buscarRegistro' :
                
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'id_pagina as PAGINA, ';
                $cadenaSql .= 'nombre as NOMBRE ';
                //$cadenaSql .= 'descripcion as DESCRIPCION,';
                //$cadenaSql .= 'modulo as MODULO,';
                //$cadenaSql .= 'nivel as NIVEL,';
                //$cadenaSql .= 'parametro as PARAMETRO ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= $prefijo . 'pagina ';
                //$cadenaSql .= 'WHERE ';
                //$cadenaSql .= 'nombre=\'' . $_REQUEST ['nombrePagina'] . '\' ';
                break;
                
             case 'buscarRegistroxCargo' :
                
                	$cadenaSql = 'SELECT ';
                        $cadenaSql .= 'codigo_cargo as COD_CARGO, ';
                        $cadenaSql .= 'nivel as NIVEL, ';
                        $cadenaSql .= 'codigo_alternativo as COD_ALTERNATIVO,';
                        $cadenaSql .= 'grado as GRADO,';
                        $cadenaSql .= 'nombre as NOMBRE,';
                        $cadenaSql .= 'cod_tipo_cargo as COD_TIPO, ';
                        $cadenaSql .= 'estado as ESTADO ';
                        $cadenaSql .= 'FROM ';
                        $cadenaSql .= 'parametro.cargo';
//                        $cadenaSql .= 'WHERE ';
//                        $cadenaSql .= 'nombre=\'' . $_REQUEST ['usuario']  . '\' AND ';
//                        $cadenaSql .= 'clave=\'' . $claveEncriptada . '\' ';
                        
                break;
                	
                case 'buscarRegistroUsuarioWhere' :
                		$cadenaSql = 'SELECT ';
                		$cadenaSql .= 'id_usuario as USUARIO, ';
                		$cadenaSql .= 'nombre as NOMBRE, ';
                		$cadenaSql .= 'apellido as APELLIDO, ';
                		$cadenaSql .= 'fecha_reg as FECHA_REG, ';
                		$cadenaSql .= 'edad as EDAD, ';
                		$cadenaSql .= 'telefono as TELEFONO, ';
                		$cadenaSql .= 'direccion as DIRECCION, ';
                		$cadenaSql .= 'ciudad as CIUDAD, ';
                		$cadenaSql .= 'estado as ESTADO ';
                		//$cadenaSql .= 'descripcion as DESCRIPCION,';
                		//$cadenaSql .= 'modulo as MODULO,';
                		//$cadenaSql .= 'nivel as NIVEL,';
                		//$cadenaSql .= 'parametro as PARAMETRO ';
                		$cadenaSql .= 'FROM ';
                		$cadenaSql .= "nomina." .$prefijo . 'usuarios ';
//                		$cadenaSql .= 'WHERE ';
//                		$cadenaSql .= 'fecha_reg <=\'' . $_REQUEST ['fechaRegistroConsulta'] . '\' ';
                break;

            case 'borrarRegistro' :
                $cadenaSql = 'INSERT INTO ';
                $cadenaSql .= $prefijo . 'pagina ';
                $cadenaSql .= '( ';
                $cadenaSql .= 'nombre,';
                $cadenaSql .= 'descripcion,';
                $cadenaSql .= 'modulo,';
                $cadenaSql .= 'nivel,';
                $cadenaSql .= 'parametro';
                $cadenaSql .= ') ';
                $cadenaSql .= 'VALUES ';
                $cadenaSql .= '( ';
                $cadenaSql .= '\'' . $_REQUEST ['nombrePagina'] . '\', ';
                $cadenaSql .= '\'' . $_REQUEST ['descripcionPagina'] . '\', ';
                $cadenaSql .= '\'' . $_REQUEST ['moduloPagina'] . '\', ';
                $cadenaSql .= $_REQUEST ['nivelPagina'] . ', ';
                $cadenaSql .= '\'' . $_REQUEST ['parametroPagina'] . '\'';
                $cadenaSql .= ') ';
                break;
        
        }
        
        return $cadenaSql;
    
    }
}
?>
