<?php

namespace bloquesNovedad\contenidoNovedad\formulario;

if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

class Formulario {

    var $miConfigurador;
    var $lenguaje;
    var $miFormulario;

    function __construct($lenguaje, $formulario, $sql) {
        $this->miConfigurador = \Configurador::singleton();
        $this->miConfigurador->fabricaConexiones->setRecursoDB('principal');
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
        $directorio = $this->miConfigurador->getVariableConfiguracion("host");
        $directorio .= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
        $directorio .= $this->miConfigurador->getVariableConfiguracion("enlace");
        // Rescatar los datos de este bloque
        $esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
        $rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
        $rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
        $rutaBloque.= $esteBloque['grupo'] . "/" . $esteBloque['nombre'];


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
        $_REQUEST['tiempo'] = time();

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
        $atributos ['titulo'] = false; //$this->lenguaje->getCadena ( $esteCampo );
        // Si no se coloca, entonces toma el valor predeterminado.
        $atributos ['estilo'] = '';
        $atributos ['marco'] = true;
        $tab = 1;
        // ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
        // ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
        $atributos ['tipoEtiqueta'] = 'inicio';
        echo $this->miFormulario->formulario($atributos);

        // ---------------- SECCION: Controles del Formulario -----------------------------------------------
        // --------------------------------------------------------------------------------------------------
        // --------------------------------------------------------------------------------------------------
        //******************************************************************************************************
        //******************************************************************************************************
        //PANEL CONDICIONES DINAMICAS

        unset($atributos);
        $esteCampo = "marcoDatosParametros";
        $atributos ['id'] = $esteCampo;
        $atributos ["estilo"] = "jqueryui";
        $atributos ['tipoEtiqueta'] = 'inicio';
        $atributos ["leyenda"] = "PANEL CONDICIONES";
        echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);
        {
            unset($atributos);
            $atributos ["id"] = "disenoCan";
            $atributos ["estilo"] = "col-md-8";
            echo $this->miFormulario->division("inicio", $atributos);
            {
                
            }
            echo $this->miFormulario->division("fin");

            unset($atributos);
            $atributos ["id"] = "camposDinamicosCont";
            $atributos ["estilo"] = "col-md-8";
            echo $this->miFormulario->division("inicio", $atributos);
            {
                unset($atributos);
                $atributos ["id"] = "camposDinamicos";
                $atributos ["estilo"] = "col-md-12";
                echo $this->miFormulario->division("inicio", $atributos);
                {
                    
                }
                echo $this->miFormulario->division("fin");
            }
            echo $this->miFormulario->division("fin");

            unset($atributos);
            $atributos ["id"] = "opcionesCamposDinamicos";
            $atributos ["estilo"] = "col-md-4";
            echo $this->miFormulario->division("inicio", $atributos);
            {

                unset($atributos);
                $atributos ["id"] = "blocBotn";
                $atributos ["estilo"] = "col-md-12";
                echo $this->miFormulario->division("inicio", $atributos);
                {
                    echo "<center>";
                    echo "<input type=\"button\" id=\"btAdd\" value=\"Añadir Condición\" class=\"btn btn-success btn-block\" />";
                    echo "<input type=\"button\" id=\"btRemove\" value=\"Eliminar Condición\" class=\"btn btn-danger btn-block\" />";
                    echo "<input type=\"button\" id=\"btRemoveAll\" value=\"Eliminar Todo\" class=\"btn btn-warning btn-block\" /><br />";
                    echo "</center>";
                }
                echo $this->miFormulario->division("fin");
                unset($atributos);
                // ---------------- CONTROL: Select --------------------------------------------------------
                $atributos ["id"] = "variables";
                $atributos ["estilo"] = "col-md-12";
                echo $this->miFormulario->division("inicio", $atributos);
                {
                    unset($atributos);


                    $esteCampo = "marcoDatosParametros";
                    $atributos ['id'] = $esteCampo;
                    $atributos ["estilo"] = "jqueryui";
                    $atributos ['tipoEtiqueta'] = 'inicio';
                    $atributos ["leyenda"] = "Panel Parámetros";
                    echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);
                    {

                        $atributos ["id"] = "categoriaParametros";
                        $atributos ["estilo"] = "col-md-12";
                        echo $this->miFormulario->division("inicio", $atributos);
                        {
                            // ---------------- CONTROL: Select --------------------------------------------------------
                            $esteCampo = 'categoriaParametrosList';
                            $atributos['nombre'] = $esteCampo;
                            $atributos['id'] = $esteCampo;
                            $atributos['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                            $atributos ['anchoEtiqueta'] = 230;
                            $atributos['tab'] = $tab;
                            $atributos['seleccion'] = -1;
                            $atributos['evento'] = ' ';
                            $atributos['deshabilitado'] = false;
                            $atributos['limitar'] = 50;
                            $atributos['tamanno'] = 1;
                            $atributos['columnas'] = 1;

                            $atributos ['obligatorio'] = false;
                            $atributos ['etiquetaObligatorio'] = false;
                            $atributos ['validar'] = '';

                            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("buscarCategoriaParametro");
                            $matrizParametros = $primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "busqueda");

                            $atributos['matrizItems'] = $matrizParametros;

                            if (isset($_REQUEST [$esteCampo])) {
                                $atributos ['valor'] = $_REQUEST [$esteCampo];
                            } else {
                                $atributos ['valor'] = '';
                            }
                            $atributos ["titulo"] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                            $tab++;

                            // Aplica atributos globales al control
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->campoCuadroLista($atributos);
                            // --------------- FIN CONTROL : Select --------------------------------------------------
                        }
                        echo $this->miFormulario->division("fin");

                        unset($atributos);

                        $atributos ["id"] = "parametros";
                        $atributos ["estilo"] = "col-md-12";
                        echo $this->miFormulario->division("inicio", $atributos);
                        {
                            // ---------------- CONTROL: Select --------------------------------------------------------
                            $esteCampo = 'seccionParametros';
                            $atributos['nombre'] = $esteCampo;
                            $atributos['id'] = $esteCampo;
                            $atributos['etiqueta'] = ' '; //$this->lenguaje->getCadena ( $esteCampo );
                            $atributos ['anchoEtiqueta'] = 10;
                            $atributos['tab'] = $tab;
                            $atributos['seleccion'] = -1;
                            $atributos['evento'] = ' ';
                            $atributos['deshabilitado'] = true;
                            $atributos['limitar'] = 50;
                            $atributos['tamanno'] = 1;
                            $atributos['columnas'] = 1;

                            $atributos ['obligatorio'] = false;
                            $atributos ['etiquetaObligatorio'] = false;
                            $atributos ['validar'] = '';

                            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("buscarRegistroxParametro");
                            $matrizParametros = $primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "busqueda");

                            $atributos['matrizItems'] = $matrizParametros;

                            if (isset($_REQUEST [$esteCampo])) {
                                $atributos ['valor'] = $_REQUEST [$esteCampo];
                            } else {
                                $atributos ['valor'] = '';
                            }
                            $atributos ["titulo"] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                            $tab++;

                            // Aplica atributos globales al control
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->campoCuadroLista($atributos);
                            // --------------- FIN CONTROL : Select --------------------------------------------------
                        }
                        echo $this->miFormulario->division("fin");
                    }
                    echo $this->miFormulario->marcoAgrupacion("fin");

                    unset($atributos);


                    $esteCampo = "marcoDatosConceptos";
                    $atributos ['id'] = $esteCampo;
                    $atributos ["estilo"] = "jqueryui";
                    $atributos ['tipoEtiqueta'] = 'inicio';
                    $atributos ["leyenda"] = "Panel Conceptos";
                    echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);
                    {

                        $atributos ["id"] = "categoriaConceptos";
                        $atributos ["estilo"] = "col-md-12";
                        echo $this->miFormulario->division("inicio", $atributos);
                        {
                            // ---------------- CONTROL: Select --------------------------------------------------------
                            $esteCampo = 'categoriaConceptosList';
                            $atributos['nombre'] = $esteCampo;
                            $atributos['id'] = $esteCampo;
                            $atributos['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                            $atributos ['anchoEtiqueta'] = 230;
                            $atributos['tab'] = $tab;
                            $atributos['seleccion'] = -1;
                            $atributos['evento'] = ' ';
                            $atributos['deshabilitado'] = false;
                            $atributos['limitar'] = 50;
                            $atributos['tamanno'] = 1;
                            $atributos['columnas'] = 1;

                            $atributos ['obligatorio'] = false;
                            $atributos ['etiquetaObligatorio'] = false;
                            $atributos ['validar'] = '';

                            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("buscarCategoriaConcepto");
                            $matrizParametros = $primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "busqueda");

                            $atributos['matrizItems'] = $matrizParametros;


                            /* $matrizItems=array(
                              array(1,'CP0001'),
                              array(2,'CP0002'),
                              array(3,'CP0003'),
                              array(4,'CP0004'),
                              array(5,'CP0005')

                              );
                              $atributos['matrizItems'] = $matrizItems; */

                            if (isset($_REQUEST [$esteCampo])) {
                                $atributos ['valor'] = $_REQUEST [$esteCampo];
                            } else {
                                $atributos ['valor'] = '';
                            }

                            $atributos ["titulo"] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                            $tab++;

                            // Aplica atributos globales al control
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->campoCuadroLista($atributos);
                            // --------------- FIN CONTROL : Select --------------------------------------------------
                        }
                        echo $this->miFormulario->division("fin");

                        unset($atributos);

                        $atributos ["id"] = "conceptos";
                        $atributos ["estilo"] = "col-md-12";
                        echo $this->miFormulario->division("inicio", $atributos);
                        {
                            // ---------------- CONTROL: Select --------------------------------------------------------
                            $esteCampo = 'seccionConceptos';
                            $atributos['nombre'] = $esteCampo;
                            $atributos['id'] = $esteCampo;
                            $atributos['etiqueta'] = ' '; //$this->lenguaje->getCadena ( $esteCampo );
                            $atributos ['anchoEtiqueta'] = 10;
                            $atributos['tab'] = $tab;
                            $atributos['seleccion'] = -1;
                            $atributos['evento'] = ' ';
                            $atributos['deshabilitado'] = true;
                            $atributos['limitar'] = 50;
                            $atributos['tamanno'] = 1;
                            $atributos['columnas'] = 1;

                            $atributos ['obligatorio'] = false;
                            $atributos ['etiquetaObligatorio'] = false;
                            $atributos ['validar'] = '';

                            $matrizItems = array(
                                array(1, 'CP0001'),
                                array(2, 'CP0002'),
                                array(3, 'CP0003'),
                                array(4, 'CP0004'),
                                array(5, 'CP0005')
                            );
                            $atributos['matrizItems'] = $matrizItems;

                            if (isset($_REQUEST [$esteCampo])) {
                                $atributos ['valor'] = $_REQUEST [$esteCampo];
                            } else {
                                $atributos ['valor'] = '';
                            }

                            $atributos ["titulo"] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                            $tab++;

                            // Aplica atributos globales al control
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->campoCuadroLista($atributos);
                            // --------------- FIN CONTROL : Select --------------------------------------------------
                        }
                        echo $this->miFormulario->division("fin");

                        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    }
                    echo $this->miFormulario->marcoAgrupacion("fin");
                    unset($esteCampo);
                    unset($atributos);
                    $esteCampo = "marcoDatosConceptos";
                    $atributos ["id"] = $esteCampo;
                    $atributos ["estilo"] = "jqueryui";
                    $atributos ["leyenda"] = "Operadores";
                    $atributos ['tipoEtiqueta'] = 'inicio';
                    echo $this->miFormulario->marcoAgrupacion("inicio", $atributos);
                    {


                        $atributos ["id"] = "botonesPanel2";
                        $atributos ["estilo"] = "col-md-3 btn-group-lg";
                        echo $this->miFormulario->division("inicio", $atributos);
                        {
                            echo "<input type=\"button\" id=\"btOper1C\" value=\"(\" class=\"btn btn-primary btn-block\"/>";

                            echo "<input type=\"button\" id=\"btOper2C\" value=\")\" class=\"btn btn-primary btn-block\" />";

                            echo "<input type=\"button\" id=\"btOper3C\" value=\"+\" class=\"btn btn-primary btn-block\"/>";

                            echo "<input type=\"button\" id=\"btOper4C\" value=\"-\" class=\"btn btn-primary btn-block\" />";
                        }
                        echo $this->miFormulario->division("fin");

                        $atributos ["id"] = "botonesPanel2";
                        $atributos ["estilo"] = "col-md-3 btn-group-lg";
                        echo $this->miFormulario->division("inicio", $atributos);
                        {
                            echo "<input type=\"button\" id=\"btOper5C\" value=\"*\" class=\"btn btn-primary btn-block\"/>";

                            echo "<input type=\"button\" id=\"btOper6C\" value=\"÷\" class=\"btn btn-primary btn-block\" />";
                            echo "<input type=\"button\" id=\"btOper7C\" value=\"√\" class=\"btn btn-primary btn-block\"/>";
                            echo "<input type=\"button\" id=\"btOper8C\" value=\"^\" class=\"btn btn-primary btn-block\" />";
                        }
                        echo $this->miFormulario->division("fin");

                        $atributos ["id"] = "botonesPanel2";
                        $atributos ["estilo"] = "col-md-3 btn-group-lg";
                        echo $this->miFormulario->division("inicio", $atributos);
                        {
                            echo "<input type=\"button\" id=\"btOper9C\" value=\"<\" class=\"btn btn-primary btn-block\" />";
                            echo "<input type=\"button\" id=\"btOper10C\" value=\"<=\" class=\"btn btn-primary btn-block\"/>";
                            echo "<input type=\"button\" id=\"btOper11C\" value=\">\" class=\"btn btn-primary btn-block\" />";
                            echo "<input type=\"button\" id=\"btOper12C\" value=\">=\" class=\"btn btn-primary btn-block\" />";
                        }
                        echo $this->miFormulario->division("fin");

                        $atributos ["id"] = "botonesPanel2";
                        $atributos ["estilo"] = "col-md-3 btn-group-lg";
                        echo $this->miFormulario->division("inicio", $atributos);
                        {
                            echo "<input type=\"button\" id=\"btOper13C\" value=\"=\" class=\"btn btn-primary btn-block\"/>";
                            echo "<input type=\"button\" id=\"btOper14C\" value=\"!=\" class=\"btn btn-primary btn-block\" />";

                            echo "<input type=\"button\" id=\"btOper15C\" value=\"&&\" class=\"btn btn-warning btn-block\" />";

                            echo "<input type=\"button\" id=\"btOper16C\" value=\"||\" class=\"btn btn-warning btn-block\" />";
                        }
                        echo $this->miFormulario->division("fin");

                        echo "<input type=\"button\" id=\"btOper17C\" value=\"Borrar\" class=\"btn btn-danger btn-block\" />";
                    }
                    echo $this->miFormulario->marcoAgrupacion("fin");
                }
                echo $this->miFormulario->division("fin");
            }
            echo $this->miFormulario->division("fin");

            unset($atributos);
            // ---------------- CONTROL: Select --------------------------------------------------------
            $atributos ["id"] = "btnConf";
            $atributos ["estilo"] = "col-md-12";
            echo $this->miFormulario->division("inicio", $atributos);
            {

                $atributos ["id"] = "diseno";
                $atributos ["estilo"] = "col-md-5";
                echo $this->miFormulario->division("inicio", $atributos);
                {
                    
                }
                echo $this->miFormulario->division("fin");

                unset($atributos);
                // ---------------- CONTROL: Select --------------------------------------------------------
                $atributos ["id"] = "confirmar";
                $atributos ["estilo"] = "col-md-2";
                echo $this->miFormulario->division("inicio", $atributos);
                {
                    echo "<center>";
                    echo "<input type=\"button\" id=\"confirmarDina\" value=\"Confirmar\" class=\"btn btn-primary btn-block\" onclick=\"GetTextValue()\" />";
                    echo "</center>";
                }
                echo $this->miFormulario->division("fin");

                unset($atributos);
                // ---------------- CONTROL: Select --------------------------------------------------------
                $atributos ["id"] = "cancelar";
                $atributos ["estilo"] = "col-md-2";
                echo $this->miFormulario->division("inicio", $atributos);
                {
                    echo "<center>";
                    echo "<input type=\"button\" id=\"cancelarDina\" value=\"Cancelar\" class=\"btn btn-danger btn-block\" />";
                    echo "</center>";
                }
                echo $this->miFormulario->division("fin");
            }
            echo $this->miFormulario->division("fin");
        }
        echo $this->miFormulario->marcoAgrupacion("fin");


        //*************************************************************************************************
        //*************************************************************************************************
        //Campos para el Paso de los Valores de los Campos Dinamicos

        unset($atributos);
        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'variablesRegistros';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'hidden';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;

        $atributos ['valor'] = '';
        $atributos ['deshabilitado'] = false;
        $atributos ['maximoTamanno'] = '';
        $tab++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------


        unset($atributos);
        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'condicionesRegistros';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'hidden';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;

        $atributos ['valor'] = '';
        $atributos ['deshabilitado'] = false;
        $atributos ['maximoTamanno'] = '';
        $tab++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        //***************************************************************************************************
        //***************************************************************************************************
        //***************************************************************************************************
        //***************************************************************************************************
        //Campos atributos pagina anterior Info Basica


        unset($atributos);
        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        //***********************************************************************************************
        //  ***********************************************************************************************                     
        //***********************************************************************************************
        //***********************************************************************************************
        //Campos atributos pagina anterior Info Basica

        unset($atributos);
        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'variablesCampoCon';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'hidden';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        if (isset($_REQUEST ['variablesCampoFor'])) {
            $atributos ['valor'] = $_REQUEST ['variablesCampoFor'];
        } else {
            $atributos ['valor'] = '';
        }
        $atributos ['deshabilitado'] = false;
        $atributos ['maximoTamanno'] = '';
        $tab++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        unset($atributos);
        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'camposInfoExtraCon';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'hidden';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        if (isset($_REQUEST ['camposInfoExtraFor'])) {
            $atributos ['valor'] = $_REQUEST ['camposInfoExtraFor'];
        } else {
            $atributos ['valor'] = '';
        }
        $atributos ['deshabilitado'] = false;
        $atributos ['maximoTamanno'] = '';
        $tab++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        unset($atributos);
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'tipoNovedadCon';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'hidden';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;

        if (isset($_REQUEST ['tipoNovedadFor'])) {
            $atributos ['valor'] = $_REQUEST ['tipoNovedadFor'];
        } else {
            $atributos ['valor'] = '';
        }
        $atributos ['deshabilitado'] = false;
        $atributos ['maximoTamanno'] = '';
        $tab++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'categoriaNovedadCon';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'hidden';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;

        if (isset($_REQUEST ['categoriaNovedadFor'])) {
            $atributos ['valor'] = $_REQUEST ['categoriaNovedadFor'];
        } else {
            $atributos ['valor'] = '';
        }
        $atributos ['deshabilitado'] = false;
        $atributos ['maximoTamanno'] = '';
        $tab++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'nombreCon';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'hidden';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;

        if (isset($_REQUEST ['nombreFor'])) {
            $atributos ['valor'] = $_REQUEST ['nombreFor'];
        } else {
            $atributos ['valor'] = '';
        }
        $atributos ['deshabilitado'] = false;
        $atributos ['maximoTamanno'] = '';
        $tab++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'simboloCon';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'hidden';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;

        if (isset($_REQUEST ['simboloFor'])) {
            $atributos ['valor'] = $_REQUEST ['simboloFor'];
        } else {
            $atributos ['valor'] = '';
        }
        $atributos ['deshabilitado'] = false;
        $atributos ['maximoTamanno'] = '';
        $tab++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'leyCon';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'hidden';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;

        if (isset($_REQUEST ['leyRegistrosFor'])) {
            $atributos ['valor'] = $_REQUEST ['leyRegistrosFor'];
        } else {
            $atributos ['valor'] = '';
        }
        $atributos ['deshabilitado'] = false;
        $atributos ['maximoTamanno'] = '';
        $tab++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'naturalezaCon';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'hidden';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;

        if (isset($_REQUEST ['naturalezaFor'])) {
            $atributos ['valor'] = $_REQUEST ['naturalezaFor'];
        } else {
            $atributos ['valor'] = '';
        }
        $atributos ['deshabilitado'] = false;
        $atributos ['maximoTamanno'] = '';
        $tab++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'descripcionCon';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'hidden';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;

        if (isset($_REQUEST ['descripcionFor'])) {
            $atributos ['valor'] = $_REQUEST ['descripcionFor'];
        } else {
            $atributos ['valor'] = '';
        }
        $atributos ['deshabilitado'] = false;
        $atributos ['maximoTamanno'] = '';
        $tab++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        //***********************************************************************************************
        //***********************************************************************************************
        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'formulaConcepto';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'hidden';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;

        if (isset($_REQUEST ['formula'])) {
            $atributos ['valor'] = $_REQUEST ['formula'];
        } else {
            $atributos ['valor'] = '';
        }
        $atributos ['deshabilitado'] = false;
        $atributos ['maximoTamanno'] = '';
        $tab++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'cantidadCondicionesConcepto';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'hidden';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['valor'] = '';
        $atributos ['deshabilitado'] = false;
        $atributos ['maximoTamanno'] = '';
        $tab++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        //***********************************************************************************************
        //***********************************************************************************************
        // ------------------Division para los botones-------------------------
        $atributos ["id"] = "botones";
        $atributos ["estilo"] = "marcoBotones";
        echo $this->miFormulario->division("inicio", $atributos);
        {
            // -----------------CONTROL: Botón ----------------------------------------------------------------
            $esteCampo = 'enviarRegistroCon';
            $atributos ["id"] = $esteCampo;
            $atributos ["tabIndex"] = $tab;
            $atributos ["tipo"] = 'boton';
            // submit: no se coloca si se desea un tipo button genérico
            $atributos ['submit'] = true;
            $atributos ["estiloMarco"] = '';
            $atributos ["estiloBoton"] = 'jqueryui';
            // verificar: true para verificar el formulario antes de pasarlo al servidor.
            $atributos ["verificar"] = '';
            $atributos ["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
            $atributos ["valor"] = $this->lenguaje->getCadena($esteCampo);
            $atributos ['nombreFormulario'] = $esteBloque ['nombre'];
            $tab++;

            // Aplica atributos globales al control
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->campoBoton($atributos);

            // -----------------FIN CONTROL: Botón -----------------------------------------------------------
            // ------------------Fin Division para los botones-------------------------
        }
        echo $this->miFormulario->division("fin");

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
        $valorCodificado = "actionBloque=" . $esteBloque ["nombre"]; //Ir pagina Funcionalidad
        $valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina'); //Frontera mostrar formulario
        $valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
        $valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
        $valorCodificado .= "&opcion=modificar";
        $valorCodificado .= "&variable=" . $_REQUEST['variable'];
        /**
         * SARA permite que los nombres de los campos sean dinámicos.
         * Para ello utiliza la hora en que es creado el formulario para
         * codificar el nombre de cada campo. 
         */
        $valorCodificado .= "&campoSeguro=" . $_REQUEST['tiempo'];
        // Paso 2: codificar la cadena resultante
        $valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar($valorCodificado);
        $atributos ["id"] = "formSaraData"; // No cambiar este nombre
        $atributos ["tipo"] = "hidden";
        $atributos ['estilo'] = '';
        $atributos ["obligatorio"] = false;
        $atributos ['marco'] = true;
        $atributos ["etiqueta"] = "";
        $atributos ["valor"] = $valorCodificado;
        echo $this->miFormulario->campoCuadroTexto($atributos);
        unset($atributos);
        // ----------------FIN SECCION: Paso de variables -------------------------------------------------
        // ---------------- FIN SECCION: Controles del Formulario -------------------------------------------
        // ----------------FINALIZAR EL FORMULARIO ----------------------------------------------------------
        // Se debe declarar el mismo atributo de marco con que se inició el formulario.
        $atributos ['marco'] = true;
        $atributos ['tipoEtiqueta'] = 'fin';
        echo $this->miFormulario->formulario($atributos);
        return true;
    }

    function mensaje() {
        // Si existe algun tipo de error en el login aparece el siguiente mensaje
        $mensaje = $this->miConfigurador->getVariableConfiguracion('mostrarMensaje');
        $this->miConfigurador->setVariableConfiguracion('mostrarMensaje', null);
        if ($mensaje) {
            $tipoMensaje = $this->miConfigurador->getVariableConfiguracion('tipoMensaje');
            if ($tipoMensaje == 'json') {
                $atributos ['mensaje'] = $mensaje;
                $atributos ['json'] = true;
            } else {
                $atributos ['mensaje'] = $this->lenguaje->getCadena($mensaje);
            }
            // -------------Control texto-----------------------
            $esteCampo = 'divMensaje';
            $atributos ['id'] = $esteCampo;
            $atributos ["tamanno"] = '';
            $atributos ["estilo"] = 'information';
            $atributos ["etiqueta"] = '';
            $atributos ["columnas"] = ''; // El control ocupa 47% del tamaño del formulario
            echo $this->miFormulario->campoMensaje($atributos);
            unset($atributos);
        }
        return true;
    }

}

$miFormulario = new Formulario($this->lenguaje, $this->miFormulario, $this->sql);
$miFormulario->formulario();
$miFormulario->mensaje();
