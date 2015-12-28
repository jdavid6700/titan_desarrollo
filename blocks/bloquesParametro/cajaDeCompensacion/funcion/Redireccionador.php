<?php

namespace bloquesParametro\cajaDeCompensacion\funcion;
                        
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
}
class Redireccionador {
	public static function redireccionar($opcion, $valor = "") {
		
	    
            $miConfigurador = \Configurador::singleton ();
            $miPaginaActual = $miConfigurador->getVariableConfiguracion ( "pagina" );
		
            
		switch ($opcion) {
                    case "modificar" :
				$variable = 'pagina='.$miPaginaActual;                                
				$variable .= "&opcion=modificar";
                                $variable .= '&variable=' . $valor;
                                break;	
			case "inserto" :
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=confirma";
				
				break;
			
			case "noInserto" :
                            $variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=confirma";
                              
				break;
			
			case "opcion1" :
				
				$variable = "pagina=" . $miPaginaActual;
				$variable   = "&opcion=mensaje";
                                $variable   = "&mensaje=error";
                              
				
				break;
				case "verdetalle" :
				$variable = 'pagina='.$miPaginaActual;                                
				$variable .= "&opcion=verdetalle";
                                $variable .= '&variable=' . $valor;
                                break;	
                            
                            case "inactivar" :
                                
				$variable = 'pagina='.$miPaginaActual;                                
				$variable .= "&opcion=inactivar";
                                $variable .= '&variable=' . $valor;
                            break;  
                        case "form" :
                                
				$variable = 'pagina='.$miPaginaActual;                                
				$variable .= "&opcion=form";
                                
                            break;  
			
			
		}
		foreach ( $_REQUEST as $clave => $valor ) {
			unset ( $_REQUEST [$clave] );
		}
		$url = $miConfigurador->configuracion ["host"] . $miConfigurador->configuracion ["site"] . "/index.php?";
		
		$enlace = $miConfigurador->getVariableConfiguracion ( "enlace" );
		$variable = $miConfigurador->fabricaConexiones->crypto->codificar ( $variable );
		$_REQUEST [$enlace] = $enlace . '=' . $variable;
		$redireccion = $url . $_REQUEST [$enlace];
		
		echo "<script>location.replace('" . $redireccion . "')</script>";
		
		$_REQUEST [$enlace] = $variable;
		$_REQUEST ["recargar"] = true;
		
		return true;
	}
}
?>