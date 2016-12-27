<?php
namespace bloquesNovedad\bloqueHojadeVida\bloqueFuncionario\formulario;

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}


class Formulario {

	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;

	function __construct($lenguaje, $formulario, $sql) {

		$this->miConfigurador = \Configurador::singleton ();

		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );

		$this->lenguaje = $lenguaje;

		$this->miFormulario = $formulario;

		$this->miSql = $sql;

	}

	function formulario() {

		/**
		 * IMPORTANTE: Este formulario está utilizando jquery.
		 * Por tanto en el archivo ready.php se delaran algunas funciones js
		 * que lo complementan.
		 */

		// Rescatar los datos de este bloque
		$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );

		// ---------------- SECCION: Parámetros Globales del Formulario ----------------------------------
		/**
		* Atributos que deben ser aplicados a todos los controles de este formulario.
		* Se utiliza un arreglo
		* independiente debido a que los atributos individuales se reinician cada vez que se declara un campo.
		*
		* Si se utiliza esta técnica es necesario realizar un mezcla entre este arreglo y el específico en cada control:
		* $atributos= array_merge($atributos,$atributosGlobales);
		*/
		$atributosGlobales ['campoSeguro'] = 'true';
		$_REQUEST['tiempo']=time();

		$conexion = 'estructura';
		$primerRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

		//var_dump($primerRecursoDB);
		//exit;

		// -------------------------------------------------------------------------------------------------

		// ---------------- SECCION: Parámetros Generales del Formulario ----------------------------------
		$esteCampo = $esteBloque ['nombre'];
		$atributos ['id'] = $esteCampo;
		$atributos ['nombre'] = $esteCampo;

		// Si no se coloca, entonces toma el valor predeterminado 'application/x-www-form-urlencoded'
		$atributos ['tipoFormulario'] = '';

		// Si no se coloca, entonces toma el valor predeterminado 'POST'
		$atributos ['metodo'] = 'POST';

		// Si no se coloca, entonces toma el valor predeterminado 'index.php' (Recomendado)
		$atributos ['action'] = 'index.php';
		$atributos ['titulo'] = false;
		//$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo );

		// Si no se coloca, entonces toma el valor predeterminado.
		$atributos ['estilo'] = '';
		$atributos ['marco'] = false;
		$tab = 1;
		// ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------

		// ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
		$atributos ['tipoEtiqueta'] = 'inicio';
		echo $this->miFormulario->formulario ( $atributos );

		// ---------------- SECCION: Controles del Formulario -----------------------------------------------

			
			$esteCampo = "novedadesOpcionesConsultaFuncionario";
			$atributos ['id'] = $esteCampo;
			$atributos ["estilo"] = "jqueryui";
			$atributos ['tipoEtiqueta'] = 'inicio';
			$atributos ["leyenda"] = $this->lenguaje->getCadena ( $esteCampo );
			echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
			unset ( $atributos );
			{
				$atributos ["id"] = "botonDatos";
				$atributos ["estilo"] = "botonDatos";
				echo $this->miFormulario->division ( "inicio", $atributos );
				{
					echo "<button id=\"mostrarb1\" name=\"mas1\" ALIGN=RIGHT class=\"\">
	        			<input type=image src=\"/titan/blocks/bloquesNovedad/bloqueHojadeVida/bloqueFuncionario/css/images/show.png\" width=\"20\" height=\"20\">
	        		  </button>";
					echo "<button id=\"ocultarb1\" ALIGN=RIGHT name=\"menos1\" class=\"\">
	        			<input type=image src=\"/titan/blocks/bloquesNovedad/bloqueHojadeVida/bloqueFuncionario/css/images/hide.png\" width=\"20\" height=\"20\">
	        		  </button>";
				}
				echo $this->miFormulario->division ( "fin" );
				 
				$atributos ["id"] = "contentDatos1";
				$atributos ["estilo"] = "marcoBotones";
				echo $this->miFormulario->agrupacion ( "inicio", $atributos );
				{
					// ---------------- CONTROL: Select --------------------------------------------------------
					$esteCampo = 'funcionarioIdentificacion';
					$atributos['nombre'] = $esteCampo;
					$atributos['id'] = $esteCampo;
					$atributos['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos['tab'] = $tab;
					 
					$cadenaSql = $this->miSql->getCadenaSql("buscarTipoDoc", $_REQUEST['funcionarioDocumentoBusqueda']);
					$matrizDoc = $primerRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
					 
					$atributos['seleccion'] = $matrizDoc[0][0];
					$atributos['evento'] = ' ';
					$atributos['deshabilitado'] = true;
					$atributos['limitar']= 50;
					$atributos['tamanno']= 1;
					$atributos['columnas']= 1;
					 
					$atributos ['ajax_function'] = "";
					$atributos ['ajax_control'] = $esteCampo;
					 
					$atributos ['obligatorio'] = true;
					$atributos ['etiquetaObligatorio'] = true;
					$atributos ['validar'] = 'required';
					 
					//var_dump($this->miSql->getCadenaSql("buscarRegistro"));
					 
					$matrizItems=array(
							array(1,'Cédula de Ciudadanía'),
							array(2,'Tarjeta de Identidad'),
							array(3,'Cédula de extranjería'),
							array(4,'Pasaporte')
					);
			
					$atributos['matrizItems'] = $matrizItems;
					if (isset ( $_REQUEST [$esteCampo] )) {
						$atributos ['valor'] = $_REQUEST [$esteCampo];
					} else {
						$atributos ['valor'] = '';
					}
					$tab ++;
					 
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroLista ( $atributos );
					// --------------- FIN CONTROL : Select --------------------------------------------------
			
					// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
					$esteCampo = 'funcionarioDocumento';
					$atributos ['id'] = $esteCampo;
					$atributos ['nombre'] = $esteCampo;
					$atributos ['tipo'] = 'text';
					$atributos ['estilo'] = 'jqueryui';
					$atributos ['marco'] = true;
					$atributos ['columnas'] = 1;
					$atributos ['dobleLinea'] = false;
					$atributos ['tabIndex'] = $tab;
					$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ['estiloEtiqueta'] = 'labelTamano';
					 
					$atributos ['obligatorio'] = true;
					$atributos ['etiquetaObligatorio'] = true;
					$atributos ['validar'] = 'required, minSize[5], custom[onlyNumberSp]';
					 
					$atributos ['valor'] = $_REQUEST['funcionarioDocumentoBusqueda'];
					$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
					$atributos ['deshabilitado'] = true;
					$atributos ['tamanno'] = 15;
					$atributos ['maximoTamanno'] = '';
					$tab ++;
					 
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
					 
					// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
					$esteCampo = 'funcionarioSoporteIden';
					$atributos ['id'] = $esteCampo;
					$atributos ['nombre'] = $esteCampo;
					$atributos ['tipo'] = 'file';
					$atributos ['estilo'] = 'jqueryui';
					$atributos ['marco'] = true;
					$atributos ['columnas'] = 1;
					$atributos ['dobleLinea'] = false;
					$atributos ['tabIndex'] = $tab;
					$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					 
					$atributos ['obligatorio'] = false;
					$atributos ['etiquetaObligatorio'] = false;
					$atributos ['validar'] = '';
					 
					if (isset ( $_REQUEST [$esteCampo] )) {
						$atributos ['valor'] = $_REQUEST [$esteCampo];
					} else {
						$atributos ['valor'] = '';
					}
					$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
					$atributos ['deshabilitado'] = true;
					$atributos ['tamanno'] = 30;
					$atributos ['maximoTamanno'] = '';
					$tab ++;
					 
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
					 
					// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
					$esteCampo = 'funcionarioFechaExpDocFun';
					$atributos ['id'] = $esteCampo;
					$atributos ['nombre'] = $esteCampo;
					$atributos ['tipo'] = 'text';
					$atributos ['estilo'] = 'jqueryui';
					$atributos ['marco'] = true;
					$atributos ['columnas'] = 1;
					$atributos ['dobleLinea'] = false;
					$atributos ['tabIndex'] = $tab;
					$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					 
					$atributos ['obligatorio'] = true;
					$atributos ['etiquetaObligatorio'] = true;
					$atributos ['validar'] = 'required, custom[date]';
					 
					if (isset ( $_REQUEST [$esteCampo] )) {
						$atributos ['valor'] = $_REQUEST [$esteCampo];
					} else {
						$atributos ['valor'] = '';
					}
					$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
					$atributos ['deshabilitado'] = true;
					$atributos ['tamanno'] = 10;
					$atributos ['maximoTamanno'] = '';
					$tab ++;
					 
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
					 
					 
					// ---------------- CONTROL: Cuadro Mensaje SubTitulo -----------------------------------------------
					 
					$esteCampo = 'lugarExp';
					$atributos['texto'] = ' ';
					$atributos['estilo'] = 'text-success';
					$atributos['etiqueta'] = "<h4>".$this->lenguaje->getCadena ( $esteCampo )."</h4>";
					$tab ++;
					 
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoTexto( $atributos );
					 
					// --------------------------------------------------------------------------------------------------
			
					// ---------------- CONTROL: Select --------------------------------------------------------
					$esteCampo = 'funcionarioPais';
					$atributos['nombre'] = $esteCampo;
					$atributos['id'] = $esteCampo;
					$atributos['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos['tab'] = $tab;
					$atributos['seleccion'] = -1;
					$atributos['evento'] = ' ';
					$atributos['deshabilitado'] = true;
					$atributos['limitar']= 50;
					$atributos['tamanno']= 1;
					$atributos['columnas']= 1;
			
					$atributos ['obligatorio'] = true;
					$atributos ['etiquetaObligatorio'] = true;
					$atributos ['validar'] = 'required';
					 
					$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarPais" );
					$matrizItems = $primerRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
			
					$atributos['matrizItems'] = $matrizItems;
			
					if (isset ( $_REQUEST [$esteCampo] )) {
						$atributos ['valor'] = $_REQUEST [$esteCampo];
					} else {
						$atributos ['valor'] = '';
					}
					$tab ++;
			
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroLista ( $atributos );
					// --------------- FIN CONTROL : Select ----------------------------------------------------
					 
					// ---------------- CONTROL: Select --------------------------------------------------------
					$esteCampo = 'funcionarioDepartamento';
					$atributos['nombre'] = $esteCampo;
					$atributos['id'] = $esteCampo;
					$atributos['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos['tab'] = $tab;
					$atributos['seleccion'] = -1;
					$atributos['evento'] = ' ';
					$atributos['deshabilitado'] = true;
					$atributos['limitar']= 50;
					$atributos['tamanno']= 1;
					$atributos['columnas']= 1;
					 
					$atributos ['obligatorio'] = true;
					$atributos ['etiquetaObligatorio'] = true;
					$atributos ['validar'] = 'required';
					 
					$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarDepartamento" );
					$matrizItems = $primerRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
					 
					$atributos['matrizItems'] = $matrizItems;
					 
					if (isset ( $_REQUEST [$esteCampo] )) {
						$atributos ['valor'] = $_REQUEST [$esteCampo];
					} else {
						$atributos ['valor'] = '';
					}
					$tab ++;
					 
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroLista ( $atributos );
					// --------------- FIN CONTROL : Select --------------------------------------------------
					 
					 
					// ---------------- CONTROL: Select --------------------------------------------------------
					$esteCampo = 'funcionarioCiudad';
					$atributos['nombre'] = $esteCampo;
					$atributos['id'] = $esteCampo;
					$atributos['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos['tab'] = $tab;
					$atributos['seleccion'] = -1;
					$atributos['evento'] = ' ';
					$atributos['deshabilitado'] = true;
					$atributos['limitar']= 50;
					$atributos['tamanno']= 1;
					$atributos['columnas']= 1;
					 
					$atributos ['obligatorio'] = true;
					$atributos ['etiquetaObligatorio'] = true;
					$atributos ['validar'] = 'required';
					 
					$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarCiudad" );
					$matrizItems = $primerRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
					 
					$atributos['matrizItems'] = $matrizItems;
					 
					if (isset ( $_REQUEST [$esteCampo] )) {
						$atributos ['valor'] = $_REQUEST [$esteCampo];
					} else {
						$atributos ['valor'] = '';
					}
					$tab ++;
					 
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroLista ( $atributos );
					// --------------- FIN CONTROL : Select --------------------------------------------------
					 
					 
					// ---------------- CONTROL: Cuadro Mensaje SubTitulo -----------------------------------------------
					 
					$esteCampo = 'nombresCampos';
					$atributos['texto'] = ' ';
					$atributos['estilo'] = 'text-success';
					$atributos['etiqueta'] = "<h4>".$this->lenguaje->getCadena ( $esteCampo )."</h4>";
					$tab ++;
					 
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoTexto( $atributos );
					 
					// --------------------------------------------------------------------------------------------------
					 
					 
					// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
					$esteCampo = 'funcionarioPrimerApellido';
					$atributos ['id'] = $esteCampo;
					$atributos ['nombre'] = $esteCampo;
					$atributos ['tipo'] = 'text';
					$atributos ['estilo'] = 'jqueryui';
					$atributos ['marco'] = true;
					$atributos ['columnas'] = 1;
					$atributos ['dobleLinea'] = false;
					$atributos ['tabIndex'] = $tab;
					$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					 
					$atributos ['obligatorio'] = true;
					$atributos ['etiquetaObligatorio'] = true;
					$atributos ['validar'] = 'required, minSize[1], custom[onlyLetterSp]';
					 
					$cadenaSql = $this->miSql->getCadenaSql("buscarPrimerApellido", $_REQUEST['funcionarioDocumentoBusqueda']);
					$matrizDoc = $primerRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
					 
					$atributos ['valor'] = $matrizDoc[0][0];
					 
					$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
					$atributos ['deshabilitado'] = true;
					$atributos ['tamanno'] = 30;
					$atributos ['maximoTamanno'] = '';
					$tab ++;
					 
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
					 
					// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
					$esteCampo = 'funcionarioSegundoApellido';
					$atributos ['id'] = $esteCampo;
					$atributos ['nombre'] = $esteCampo;
					$atributos ['tipo'] = 'text';
					$atributos ['estilo'] = 'jqueryui';
					$atributos ['marco'] = true;
					$atributos ['columnas'] = 1;
					$atributos ['dobleLinea'] = false;
					$atributos ['tabIndex'] = $tab;
					$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					 
					$atributos ['obligatorio'] = true;
					$atributos ['etiquetaObligatorio'] = true;
					$atributos ['validar'] = 'required, minSize[1], custom[onlyLetterSp]';
					 
					$cadenaSql = $this->miSql->getCadenaSql("buscarSegundoApellido", $_REQUEST['funcionarioDocumentoBusqueda']);
					$matrizDoc = $primerRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
			
					$atributos ['valor'] = $matrizDoc[0][0];
					 
					$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
					$atributos ['deshabilitado'] = true;
					$atributos ['tamanno'] = 30;
					$atributos ['maximoTamanno'] = '';
					$tab ++;
					 
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
					 
					// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
					$esteCampo = 'funcionarioPrimerNombre';
					$atributos ['id'] = $esteCampo;
					$atributos ['nombre'] = $esteCampo;
					$atributos ['tipo'] = 'text';
					$atributos ['estilo'] = 'jqueryui';
					$atributos ['marco'] = true;
					$atributos ['columnas'] = 1;
					$atributos ['dobleLinea'] = false;
					$atributos ['tabIndex'] = $tab;
					$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					 
					$atributos ['obligatorio'] = true;
					$atributos ['etiquetaObligatorio'] = true;
					$atributos ['validar'] = 'required, minSize[1], custom[onlyLetterSp]';
					 
					$cadenaSql = $this->miSql->getCadenaSql("buscarPrimerNombre", $_REQUEST['funcionarioDocumentoBusqueda']);
					$matrizDoc = $primerRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
			
					$atributos ['valor'] = $matrizDoc[0][0];
					 
					$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
					$atributos ['deshabilitado'] =true;
					$atributos ['tamanno'] = 30;
					$atributos ['maximoTamanno'] = '';
					$tab ++;
					 
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
					 
					// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
					$esteCampo = 'funcionarioSegundoNombre';
					$atributos ['id'] = $esteCampo;
					$atributos ['nombre'] = $esteCampo;
					$atributos ['tipo'] = 'text';
					$atributos ['estilo'] = 'jqueryui';
					$atributos ['marco'] = true;
					$atributos ['columnas'] = 1;
					$atributos ['dobleLinea'] = false;
					$atributos ['tabIndex'] = $tab;
					$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					 
					$atributos ['obligatorio'] = false;
					$atributos ['etiquetaObligatorio'] = false;
					$atributos ['validar'] = 'custom[onlyLetterSp]';
					 
					$cadenaSql = $this->miSql->getCadenaSql("buscarSegundoNombre", $_REQUEST['funcionarioDocumentoBusqueda']);
					$matrizDoc = $primerRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
			
					$atributos ['valor'] = $matrizDoc[0][0];
					 
					$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
					$atributos ['deshabilitado'] = true;
					$atributos ['tamanno'] = 30;
					$atributos ['maximoTamanno'] = '';
					$tab ++;
					 
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
			
					// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
					$esteCampo = 'funcionarioOtrosNombres';
					$atributos ['id'] = $esteCampo;
					$atributos ['nombre'] = $esteCampo;
					$atributos ['tipo'] = 'text';
					$atributos ['estilo'] = 'jqueryui';
					$atributos ['marco'] = true;
					$atributos ['columnas'] = 1;
					$atributos ['dobleLinea'] = false;
					$atributos ['tabIndex'] = $tab;
					$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					 
					$atributos ['obligatorio'] = false;
					$atributos ['etiquetaObligatorio'] = false;
					$atributos ['validar'] = 'custom[onlyLetterSp]';
					 
					if (isset ( $_REQUEST [$esteCampo] )) {
						$atributos ['valor'] = $_REQUEST [$esteCampo];
					} else {
						$atributos ['valor'] = '';
					}
					$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
					$atributos ['deshabilitado'] = true;
					$atributos ['tamanno'] = 30;
					$atributos ['maximoTamanno'] = '';
					$tab ++;
					 
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
				}
				echo $this->miFormulario->agrupacion ( "fin" );
			}
			echo $this->miFormulario->marcoAgrupacion ( 'fin' );
			



		// ------------------Division para los botones-------------------------
		$atributos ["id"] = "botonesUsuario";
		$atributos ["estilo"] = "marcoBotones";
		$atributos ["titulo"] = "Entrar a Registro";
		echo $this->miFormulario->division ( "inicio", $atributos );

		// -----------------CONTROL: Botón ----------------------------------------------------------------
		$esteCampo = 'botonModificarFuncionario';
		$atributos ["id"] = $esteCampo;
		$atributos ["tabIndex"] = $tab;
		$atributos ["tipo"] = 'boton';
		// submit: no se coloca si se desea un tipo button genérico
		$atributos ['submit'] = '';//true;
		$atributos ["estiloMarco"] = '';
		$atributos ["estiloBoton"] = 'jqueryui';
		// verificar: true para verificar el formulario antes de pasarlo al servidor.
		$atributos ["verificar"] = '';
		$atributos ["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
		$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ['nombreFormulario'] = $esteBloque ['nombre'];
		$tab ++;

		// Aplica atributos globales al control
		$atributos = array_merge ( $atributos, $atributosGlobales );
		//echo $this->miFormulario->campoBoton ( $atributos );
		// -----------------FIN CONTROL: Botón -----------------------------------------------------------


		// ------------------- SECCION: Paso de variables ------------------------------------------------

		/**
		 * En algunas ocasiones es útil pasar variables entre las diferentes páginas.
		 * SARA permite realizar esto a través de tres
		 * mecanismos:
		 * (a). Registrando las variables como variables de sesión. Estarán disponibles durante toda la sesión de usuario. Requiere acceso a
		 * la base de datos.
		 * (b). Incluirlas de manera codificada como campos de los formularios. Para ello se utiliza un campo especial denominado
		 * formsara, cuyo valor será una cadena codificada que contiene las variables.
		 * (c) a través de campos ocultos en los formularios. (deprecated)
		 */

		// En este formulario se utiliza el mecanismo (b) para pasar las siguientes variables:

		// Paso 1: crear el listado de variables

		//$valorCodificado = "actionBloque=" . $esteBloque ["nombre"]; //Ir pagina Funcionalidad
		$valorCodificado = "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );//Frontera mostrar formulario
		$valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
		$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
		$valorCodificado .= "&opcion=verDetalle"; //Opcion para Switch Case ------
		/**
		* SARA permite que los nombres de los campos sean dinámicos.
		* Para ello utiliza la hora en que es creado el formulario para
		* codificar el nombre de cada campo.
		*/
		$valorCodificado .= "&campoSeguro=" . $_REQUEST['tiempo'];
		// Paso 2: codificar la cadena resultante
		$valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar ( $valorCodificado );

		$atributos ["id"] = "formSaraData"; // No cambiar este nombre
		$atributos ["tipo"] = "hidden";
		$atributos ['estilo'] = '';
		$atributos ["obligatorio"] = false;
		$atributos ['marco'] = true;
		$atributos ["etiqueta"] = "";
		$atributos ["valor"] = $valorCodificado;
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );

		// ----------------FIN SECCION: Paso de variables -------------------------------------------------

		// ---------------- FIN SECCION: Controles del Formulario -------------------------------------------

		// ----------------FINALIZAR EL FORMULARIO ----------------------------------------------------------
		// Se debe declarar el mismo atributo de marco con que se inició el formulario.
		$atributos ['marco'] = true;
		$atributos ['tipoEtiqueta'] = 'fin';
		echo $this->miFormulario->formulario ( $atributos );

		return true;

	}

	function mensaje() {

		// Si existe algun tipo de error en el login aparece el siguiente mensaje
		$mensaje = $this->miConfigurador->getVariableConfiguracion ( 'mostrarMensaje' );
		$this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', null );

		if ($mensaje) {

			$tipoMensaje = $this->miConfigurador->getVariableConfiguracion ( 'tipoMensaje' );

			if ($tipoMensaje == 'json') {

				$atributos ['mensaje'] = $mensaje;
				$atributos ['json'] = true;
			} else {
				$atributos ['mensaje'] = $this->lenguaje->getCadena ( $mensaje );
			}
			// -------------Control texto-----------------------
			$esteCampo = 'divMensaje';
			$atributos ['id'] = $esteCampo;
			$atributos ["tamanno"] = '';
			$atributos ["estilo"] = 'information';
			$atributos ["etiqueta"] = '';
			$atributos ["columnas"] = ''; // El control ocupa 47% del tamaño del formulario
			echo $this->miFormulario->campoMensaje ( $atributos );
			unset ( $atributos );


		}

		return true;

	}
}

$miFormulario = new Formulario ( $this->lenguaje, $this->miFormulario, $this->sql );


$miFormulario->formulario ();
$miFormulario->mensaje ();
