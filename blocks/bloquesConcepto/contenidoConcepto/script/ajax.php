<?php

?>

<script>
 
 $('#<?php echo $this->campoSeguro('listaSignos')?>').width(100);
 $("#<?php echo $this->campoSeguro('listaSignos')?>").select2();
 
 $('#<?php echo $this->campoSeguro('operadores')?>').width(120);
 $("#<?php echo $this->campoSeguro('operadores')?>").select2();

 $('#<?php echo $this->campoSeguro('concepto')?>').width(140);
 $("#<?php echo $this->campoSeguro('concepto')?>").select2();

 $('#<?php echo $this->campoSeguro('parametro')?>').width(140);
 $("#<?php echo $this->campoSeguro('parametro')?>").select2();
 
 $('#<?php echo $this->campoSeguro('tipoSueldoRegistroMod')?>').width(250);
 $('#<?php echo $this->campoSeguro('tipoSueldoRegistroMod')?>').select2(); 

 $('#<?php echo $this->campoSeguro('ley')?>').width(250);
 $('#<?php echo $this->campoSeguro('ley')?>').select2(); 

 $('#<?php echo $this->campoSeguro('naturaleza')?>').width(200);
 $('#<?php echo $this->campoSeguro('naturaleza')?>').select2();  
 
 
 $('#<?php echo $this->campoSeguro('estadoRegistro')?>').width(200);
 $("#<?php echo $this->campoSeguro('estadoRegistro')?>").select2();

 $('#<?php echo $this->campoSeguro('categoriaConceptos')?>').width(250);
 $("#<?php echo $this->campoSeguro('categoriaConceptos')?>").select2();
 
 $('#<?php echo $this->campoSeguro('categoriaConceptosList')?>').width(240);
 $("#<?php echo $this->campoSeguro('categoriaConceptosList')?>").select2();

 $('#<?php echo $this->campoSeguro('categoriaParametrosList')?>').width(240);
 $("#<?php echo $this->campoSeguro('categoriaParametrosList')?>").select2();

$( '#<?php echo $this->campoSeguro('ley')?>' ).change(function() {
		$("#<?php echo $this->campoSeguro('leyRegistros') ?>").val($("#<?php echo $this->campoSeguro('ley') ?>").val());
});
  
$( '#<?php echo $this->campoSeguro('formula')?>' ).keypress(function(tecla) {
	 if(tecla.charCode != 0  && tecla.charCode != 42 && tecla.charCode != 43 && 
	    tecla.charCode != 45 && tecla.charCode != 47 && 
	    tecla.charCode != 40 && tecla.charCode != 41) return false;
});

$( '#<?php echo $this->campoSeguro('valorConcepto')?>' ).keypress(function(tecla) {
	 if(tecla.charCode != 0  && tecla.charCode != 42 && tecla.charCode != 43 && 
	    tecla.charCode != 45 && tecla.charCode != 47 && 
	    tecla.charCode != 40 && tecla.charCode != 41) return false;
});

$(function () {
	    $("#parametros").draggable({
	        revert: true,
	        helper: 'clone',
	        start: function (event, ui) {
	            $(this).fadeTo('fast', 1.5);
	        },
	        stop: function (event, ui) {
	            $(this).fadeTo(0, 1);
	        }
	    });

	    $('#<?php echo $this->campoSeguro('formula')?>').droppable({
	        hoverClass: 'active',
	        drop: function (event, ui) {
	            this.value += $(ui.draggable).find('select option:selected').text();
	        }
	    });
});

$(function () {
    $("#conceptos").draggable({
        revert: true,
        helper: 'clone',
        start: function (event, ui) {
            $(this).fadeTo('fast', 1.5);
        },
        stop: function (event, ui) {
            $(this).fadeTo(0, 1);
        }
    });

    $('#<?php echo $this->campoSeguro('formula')?>').droppable({
        hoverClass: 'active',
        drop: function (event, ui) {
            this.value += $(ui.draggable).find('select option:selected').text();
        }
    });
});

$( '#<?php echo $this->campoSeguro('categoriaConceptosList')?>' ).change(function() {
	$('#<?php echo $this->campoSeguro('valorConcepto')?>').attr("readonly","readonly");
	$('#<?php echo $this->campoSeguro('valorConcepto')?>').addClass("readOnly");
	$('#<?php echo $this->campoSeguro('valorConcepto')?>').val("");

	$("#editarBotonesConcepto").show("slow");
	$("#ingresoBotonesConcepto").hide("fast");

	$("#<?php echo $this->campoSeguro('seccionConceptos')?>").removeAttr('disabled');
    $("#<?php echo $this->campoSeguro('seccionConceptos')?>").select2();
});

$( '#<?php echo $this->campoSeguro('seccionConceptos')?>' ).change(function() {
	$('#<?php echo $this->campoSeguro('valorConcepto')?>').attr("readonly","readonly");
	$('#<?php echo $this->campoSeguro('valorConcepto')?>').addClass("readOnly");
	$('#<?php echo $this->campoSeguro('valorConcepto')?>').val("");

	$("#editarBotonesConcepto").show("slow");
	$("#ingresoBotonesConcepto").hide("fast");
});


$( '#<?php echo $this->campoSeguro('categoriaParametrosList')?>' ).change(function() {

	$("#<?php echo $this->campoSeguro('seccionParametros')?>").removeAttr('disabled');
    $("#<?php echo $this->campoSeguro('seccionParametros')?>").select2();
});


//***********************************************************************************************************
//***********************************************************************************************************

//Codigo AGREGAR y QUITAR Campos Dinamicos

var limite = 20; //Se define el Limite de Paneles de Condiciones que se pueden Generar
				 //No requiere que se cambie en otro lugar

				 
var iCnt = 0;
var numId = 0;
 
// Crear un elemento div añadiendo estilos CSS
var container = $(document.createElement('div')).css({
	padding: '5px'
});

$(container).attr('class', 'col-md-12')
$(container).attr('id', 'pushDina')

$( document ).ready(function() {
	if($('#<?php echo $this->campoSeguro('estadoPagina')?>').val() == 'modificarCondiciones'){
		var cantidad = $('#<?php echo $this->campoSeguro('cantidadCargaCond')?>').val();
		$("#<?php echo $this->campoSeguro('cantidadCondicionesConcepto') ?>").val(cantidad)

		var entonces = $('#<?php echo $this->campoSeguro('cargaCondEntonces')?>').val();
		var cadenasEntonces = entonces.split("|");

		var si = $('#<?php echo $this->campoSeguro('cargaCondSi')?>').val();
		var cadenasSi = si.split("|");
		
		var indice = 0;
		
		while (iCnt < cantidad) {
			 
			iCnt = iCnt + 1;
	 
			// Añadir elementos Dinamicos en el DOM
			
			$(container).append('<fieldset id=panel'+iCnt+' class="ui-widget ui-widget-content">'+
					'<legend class="ui-state-default ui-corner-all"> CONDICIÓN #'+iCnt+'</legend>'+
					'<div id=lab1'+iCnt+' class="col-md-2">'+
						'<label> Si </label> ' + 
					'</div>'+
                                        '<input type=text class="input" id=tb1' + iCnt + ' size="80"  maxlength="500" value="" onBlur="devPos('+iCnt+')"/>'+
                                        '<br/><br/>'+
					'<div>'+
						'<div id=lab2'+iCnt+' class="col-md-2">'+
							'<label> Entonces </label> ' + 
						'</div>'+
					'<input type=text class="input" id=tb2' + iCnt + ' size="80"  maxlength="500" value="" onBlur="devPos2('+iCnt+')"/>'+
                                        '</textarea>'+	
					'</div>'+ 
					'</fieldset>');
			
			$('#camposDinamicos').after(container);
			$('#sel1'+iCnt).width(120);
			$('#sel1'+iCnt).select2();
			
			$('#sel2'+iCnt).width(120);
			$('#sel2'+iCnt).select2();
                        
                      arrastreParametro('tb1' + iCnt);
                      arrastreParametro('tb2' + iCnt);
	              
                      arrastreConcepto('tb1' + iCnt);
                      arrastreConcepto('tb2' + iCnt);

	        indice++;
	   
		}
		
	}				 
});

				 

$(function () {
    
    
    
	$("#cancelar").hide("fast");
	$('#<?php echo $this->campoSeguro('botones')?>').hide("fast");
                      
	 
	$('#btAdd').click(function() {
		if (iCnt < limite) {
	 
			iCnt = iCnt + 1;
	 
			// Añadir elementos Dinamicos en el DOM
			
			$(container).append('<fieldset id=panel'+iCnt+' class="ui-widget ui-widget-content">'+
					'<legend class="ui-state-default ui-corner-all"> CONDICIÓN #'+iCnt+'</legend>'+
					'<div id=lab1'+iCnt+' class="col-md-2">'+
						'<label> Si </label> ' + 
					'</div>'+
                                        '<input type=text class="input" id=tb1' + iCnt + ' size="80"  maxlength="500" value="" onBlur="devPos('+iCnt+')"/>'+
                                        '<br/><br/>'+
					'<div>'+
						'<div id=lab2'+iCnt+' class="col-md-2">'+
							'<label> Entonces </label> ' + 
						'</div>'+
					'<input type=text class="input" id=tb2' + iCnt + ' size="80"  maxlength="500" value="" onBlur="devPos2('+iCnt+')"/>'+
                                        '</textarea>'+	
					'</div>'+ 
					'</fieldset>');
			
			$('#camposDinamicos').after(container);
			$('#sel1'+iCnt).width(120);
			$('#sel1'+iCnt).select2();
			
			$('#sel2'+iCnt).width(120);
			$('#sel2'+iCnt).select2();
                        
                      arrastreParametro('tb1' + iCnt);
                      arrastreParametro('tb2' + iCnt);
	              
                      arrastreConcepto('tb1' + iCnt);
                      arrastreConcepto('tb2' + iCnt);
       
		}
		else { //alerta y deshabilitar boton de agregar por alcanzar el limite
	 
			alert('Limite Alcanzado');
			$('#btAdd').attr('disabled', 'disabled');
	 
		}
		$("#<?php echo $this->campoSeguro('cantidadCondicionesConcepto') ?>").val(iCnt)
	});
	
         
        
        
        
        
	$('#btRemove').click(function() { // Elimina un panel de condiciones del DOM
		if (iCnt != 0) {
			$('#lab1' + iCnt).remove(); 
			$('#tb1' + iCnt).remove();
			$('#sel1' + iCnt).remove();
			$('#tb2' + iCnt).remove();
			$('#sel2' + iCnt).remove();
			$('#lab2' + iCnt).remove(); 
			$('#tb3' + iCnt).remove();
			$('#panel' + iCnt).remove();    
			iCnt = iCnt - 1; 
			$('#btAdd').removeAttr('disabled');
			$('#btAdd').attr('class', 'btn btn-success btn-block');
		}
	 
		if (iCnt == 0) { $(container).empty(); 
	 
			$(container).remove();
			$('#btAdd').removeAttr('disabled');
			$('#btAdd').attr('class', 'btn btn-success btn-block')
	 
		}
		$("#<?php echo $this->campoSeguro('cantidadCondicionesConcepto') ?>").val(iCnt)
	});
	 
	$('#btRemoveAll').click(function() { //Quitar todos los paneles de condiciones Agregados
	 
		$(container).empty();
		$(container).remove();
		iCnt = 0;
		$('#btAdd').removeAttr('disabled');
		$('#btAdd').attr('class', 'btn btn-success btn-block');
		$("#<?php echo $this->campoSeguro('cantidadCondicionesConcepto') ?>").val(iCnt)
	});
        
        
});
function devPos(nombre){

$("#btOper1C").on("click",function(){
            var actual = $('#tb1'+nombre).val();
       	    var post = actual + "(";
            $('#tb1'+nombre).val(post);
            $("#btOper1C").off("click");
            $("#btOper2C").off("click");
            $("#btOper3C").off("click");
            $("#btOper4C").off("click");
            $("#btOper5C").off("click");
            $("#btOper6C").off("click");
            $("#btOper7C").off("click");
            $("#btOper8C").off("click");
            $("#btOper9C").off("click");
            $("#btOper10C").off("click");
            $("#btOper11C").off("click");
        });
$("#btOper2C").on("click",function(){
            var actual = $('#tb1'+nombre).val();
	    var post = actual + ")";
	    $('#tb1'+nombre).val(post);
            $("#btOper1C").off("click");
            $("#btOper2C").off("click");
            $("#btOper3C").off("click");
            $("#btOper4C").off("click");
            $("#btOper5C").off("click");
            $("#btOper6C").off("click");
            $("#btOper7C").off("click");
            $("#btOper8C").off("click");
            $("#btOper9C").off("click");
            $("#btOper10C").off("click");
            $("#btOper11C").off("click");
        });
$("#btOper3C").on("click",function(){
            var actual = $('#tb1'+nombre).val();
	    var post = actual + "+";
	    $('#tb1'+nombre).val(post);
            $("#btOper1C").off("click");
            $("#btOper2C").off("click");
            $("#btOper3C").off("click");
            $("#btOper4C").off("click");
            $("#btOper5C").off("click");
            $("#btOper6C").off("click");
            $("#btOper7C").off("click");
            $("#btOper8C").off("click");
            $("#btOper9C").off("click");
            $("#btOper10C").off("click");
            $("#btOper11C").off("click");
        });
$("#btOper4C").on("click",function(){
            var actual = $('#tb1'+nombre).val();
            var post = actual + "-";
	    $('#tb1'+nombre).val(post);
            $("#btOper1C").off("click");
            $("#btOper2C").off("click");
            $("#btOper3C").off("click");
            $("#btOper4C").off("click");
            $("#btOper5C").off("click");
            $("#btOper6C").off("click");
            $("#btOper7C").off("click");
            $("#btOper8C").off("click");
            $("#btOper9C").off("click");
            $("#btOper10C").off("click");
            $("#btOper11C").off("click");
       });
$("#btOper5C").on("click",function(){
	    var actual = $('#tb1'+nombre).val();
            var post = actual + "*";
	    $('#tb1'+nombre).val(post);
            $("#btOper1C").off("click");
            $("#btOper2C").off("click");
            $("#btOper3C").off("click");
            $("#btOper4C").off("click");
            $("#btOper5C").off("click");
            $("#btOper6C").off("click");
            $("#btOper7C").off("click");
            $("#btOper8C").off("click");
            $("#btOper9C").off("click");
            $("#btOper10C").off("click");
            $("#btOper11C").off("click");
        });
$("#btOper6C").on("click",function(){
            var actual = $('#tb1'+nombre).val();
	    var post = actual + "/";
	    $('#tb1'+nombre).val(post);
            $("#btOper1C").off("click");
            $("#btOper2C").off("click");
            $("#btOper3C").off("click");
            $("#btOper4C").off("click");
            $("#btOper5C").off("click");
            $("#btOper6C").off("click");
            $("#btOper7C").off("click");
            $("#btOper8C").off("click");
            $("#btOper9C").off("click");
            $("#btOper10C").off("click");
            $("#btOper11C").off("click");
           });
$("#btOper7C").on("click",function(){
	    var actual = $('#tb1'+nombre).val();
	    var post = actual + "√";
	   $('#tb1'+nombre).val(post);
           $("#btOper1C").off("click");
            $("#btOper2C").off("click");
            $("#btOper3C").off("click");
            $("#btOper4C").off("click");
            $("#btOper5C").off("click");
            $("#btOper6C").off("click");
            $("#btOper7C").off("click");
            $("#btOper8C").off("click");
            $("#btOper9C").off("click");
            $("#btOper10C").off("click");
            $("#btOper11C").off("click");
           });           
$("#btOper8C").on("click",function(){
	    var actual = $('#tb1'+nombre).val();
	    var post = actual + "^";
	    $('#tb1'+nombre).val(post);
            $("#btOper1C").off("click");
            $("#btOper2C").off("click");
            $("#btOper3C").off("click");
            $("#btOper4C").off("click");
            $("#btOper5C").off("click");
            $("#btOper6C").off("click");
            $("#btOper7C").off("click");
            $("#btOper8C").off("click");
            $("#btOper9C").off("click");
            $("#btOper10C").off("click");
            $("#btOper11C").off("click");
           });
$("#btOper9C").on("click",function(){
	    var actual = $('#tb1'+nombre).val();
	    var post = actual + "&&";
	    $('#tb1'+nombre).val(post);
            $("#btOper1C").off("click");
            $("#btOper2C").off("click");
            $("#btOper3C").off("click");
            $("#btOper4C").off("click");
            $("#btOper5C").off("click");
            $("#btOper6C").off("click");
            $("#btOper7C").off("click");
            $("#btOper8C").off("click");
            $("#btOper9C").off("click");
            $("#btOper10C").off("click");
            $("#btOper11C").off("click");
           });    
$("#btOper10C").on("click",function(){
	    var actual = $('#tb1'+nombre).val();
	    var post = actual + "||";
	    $('#tb1'+nombre).val(post);
            $("#btOper1C").off("click");
            $("#btOper2C").off("click");
            $("#btOper3C").off("click");
            $("#btOper4C").off("click");
            $("#btOper5C").off("click");
            $("#btOper6C").off("click");
            $("#btOper7C").off("click");
            $("#btOper8C").off("click");
            $("#btOper9C").off("click");
            $("#btOper10C").off("click");
            $("#btOper11C").off("click");
           });
$("#btOper11C").on("click",function(){
           $('#tb1'+nombre).val("");
           $("#btOper1C").off("click");
            $("#btOper2C").off("click");
            $("#btOper3C").off("click");
            $("#btOper4C").off("click");
            $("#btOper5C").off("click");
            $("#btOper6C").off("click");
            $("#btOper7C").off("click");
            $("#btOper8C").off("click");
            $("#btOper9C").off("click");
            $("#btOper10C").off("click");
            $("#btOper11C").off("click");
           });
}
       
           
function devPos2(nombre){

$("#btOper1C").on("click",function(){
            var actual = $('#tb2'+nombre).val();
       	    var post = actual + "(";
            $('#tb2'+nombre).val(post);
            $("#btOper1C").off("click");
            $("#btOper2C").off("click");
            $("#btOper3C").off("click");
            $("#btOper4C").off("click");
            $("#btOper5C").off("click");
            $("#btOper6C").off("click");
            $("#btOper7C").off("click");
            $("#btOper8C").off("click");
            $("#btOper9C").off("click");
            $("#btOper10C").off("click");
            $("#btOper11C").off("click");
        });  
$("#btOper2C").on("click",function(){
            var actual = $('#tb2'+nombre).val();
	    var post = actual + ")";
	    $('#tb2'+nombre).val(post);
            $("#btOper1C").off("click");
            $("#btOper2C").off("click");
            $("#btOper3C").off("click");
            $("#btOper4C").off("click");
            $("#btOper5C").off("click");
            $("#btOper6C").off("click");
            $("#btOper7C").off("click");
            $("#btOper8C").off("click");
            $("#btOper9C").off("click");
            $("#btOper10C").off("click");
            $("#btOper11C").off("click");
       });  
$("#btOper3C").on("click",function(){
            var actual = $('#tb2'+nombre).val();
	    var post = actual + "+";
	    $('#tb2'+nombre).val(post);
            $("#btOper1C").off("click");
            $("#btOper2C").off("click");
            $("#btOper3C").off("click");
            $("#btOper4C").off("click");
            $("#btOper5C").off("click");
            $("#btOper6C").off("click");
            $("#btOper7C").off("click");
            $("#btOper8C").off("click");
            $("#btOper9C").off("click");
            $("#btOper10C").off("click");
            $("#btOper11C").off("click");
        });
$("#btOper4C").on("click",function(){
            var actual = $('#tb2'+nombre).val();
            var post = actual + "-";
	    $('#tb2'+nombre).val(post);
            $("#btOper1C").off("click");
            $("#btOper2C").off("click");
            $("#btOper3C").off("click");
            $("#btOper4C").off("click");
            $("#btOper5C").off("click");
            $("#btOper6C").off("click");
            $("#btOper7C").off("click");
            $("#btOper8C").off("click");
            $("#btOper9C").off("click");
            $("#btOper10C").off("click");
            $("#btOper11C").off("click");
       });
$("#btOper5C").on("click",function(){
	    var actual = $('#tb2'+nombre).val();
            var post = actual + "*";
	    $('#tb2'+nombre).val(post);
            $("#btOper1C").off("click");
            $("#btOper2C").off("click");
            $("#btOper3C").off("click");
            $("#btOper4C").off("click");
            $("#btOper5C").off("click");
            $("#btOper6C").off("click");
            $("#btOper7C").off("click");
            $("#btOper8C").off("click");
            $("#btOper9C").off("click");
            $("#btOper10C").off("click");
            $("#btOper11C").off("click");
        });
$("#btOper6C").on("click",function(){
            var actual = $('#tb2'+nombre).val();
	    var post = actual + "/";
	    $('#tb2'+nombre).val(post);
            $("#btOper1C").off("click");
            $("#btOper2C").off("click");
            $("#btOper3C").off("click");
            $("#btOper4C").off("click");
            $("#btOper5C").off("click");
            $("#btOper6C").off("click");
            $("#btOper7C").off("click");
            $("#btOper8C").off("click");
            $("#btOper9C").off("click");
            $("#btOper10C").off("click");
            $("#btOper11C").off("click");
           });
$("#btOper7C").on("click",function(){
	    var actual = $('#tb2'+nombre).val();
	    var post = actual + "√";
	   $('#tb2'+nombre).val(post);
           $("#btOper1C").off("click");
            $("#btOper2C").off("click");
            $("#btOper3C").off("click");
            $("#btOper4C").off("click");
            $("#btOper5C").off("click");
            $("#btOper6C").off("click");
            $("#btOper7C").off("click");
            $("#btOper8C").off("click");
            $("#btOper9C").off("click");
            $("#btOper10C").off("click");
            $("#btOper11C").off("click");
           });           
$("#btOper8C").on("click",function(){
	    var actual = $('#tb2'+nombre).val();
	    var post = actual + "^";
	    $('#tb2'+nombre).val(post);
            $("#btOper1C").off("click");
            $("#btOper2C").off("click");
            $("#btOper3C").off("click");
            $("#btOper4C").off("click");
            $("#btOper5C").off("click");
            $("#btOper6C").off("click");
            $("#btOper7C").off("click");
            $("#btOper8C").off("click");
            $("#btOper9C").off("click");
            $("#btOper10C").off("click");
            $("#btOper11C").off("click");
           });
$("#btOper9C").on("click",function(){
	    var actual = $('#tb2'+nombre).val();
	    var post = actual + "&&";
	    $('#tb2'+nombre).val(post);
            $("#btOper1C").off("click");
            $("#btOper2C").off("click");
            $("#btOper3C").off("click");
            $("#btOper4C").off("click");
            $("#btOper5C").off("click");
            $("#btOper6C").off("click");
            $("#btOper7C").off("click");
            $("#btOper8C").off("click");
            $("#btOper9C").off("click");
            $("#btOper10C").off("click");
            $("#btOper11C").off("click");
           });    
$("#btOper10C").on("click",function(){
	    var actual = $('#tb2'+nombre).val();
	    var post = actual + "||";
	    $('#tb2'+nombre).val(post);
            $("#btOper1C").off("click");
            $("#btOper2C").off("click");
            $("#btOper3C").off("click");
            $("#btOper4C").off("click");
            $("#btOper5C").off("click");
            $("#btOper6C").off("click");
            $("#btOper7C").off("click");
            $("#btOper8C").off("click");
            $("#btOper9C").off("click");
            $("#btOper10C").off("click");
            $("#btOper11C").off("click");
           });
$("#btOper11C").on("click",function(){
           $('#tb2'+nombre).val("");
           $("#btOper1C").off("click");
            $("#btOper2C").off("click");
            $("#btOper3C").off("click");
            $("#btOper4C").off("click");
            $("#btOper5C").off("click");
            $("#btOper6C").off("click");
            $("#btOper7C").off("click");
            $("#btOper8C").off("click");
            $("#btOper9C").off("click");
            $("#btOper10C").off("click");
            $("#btOper11C").off("click");
           });       
} 
//Funciones de arrastre apara dinamicos
//
//	 
function arrastreParametro(nombre) {
            $('#'+nombre ).keypress(function(tecla) {
	    if(tecla.charCode != 0  && tecla.charCode != 42 && tecla.charCode != 43 && 
	    tecla.charCode != 45 && tecla.charCode != 47 && 
	    tecla.charCode != 40 && tecla.charCode != 41 && tecla.charCode != 38 && tecla.charCode != 179) return false;
           });
         
          

	    $("#parametros").draggable({
	        revert: true,
	        helper: 'clone',
	        start: function (event, ui) {
	            $(this).fadeTo('fast', 1.5);
	        },
	        stop: function (event, ui) {
	            $(this).fadeTo(0, 1);
	        }
	    });
	    $('#'+nombre).droppable({
	        hoverClass: 'active',
	        drop: function (event, ui) {
	            this.value += $(ui.draggable).find('select option:selected').text();
	        }
	    });
};

function arrastreConcepto(nombre) {
            
	$("#conceptos").draggable({
        revert: true,
        helper: 'clone',
        start: function (event, ui) {
            $(this).fadeTo('fast', 1.5);
        },
        stop: function (event, ui) {
            $(this).fadeTo(0, 1);
        }
    });
    $('#'+nombre).droppable({
        hoverClass: 'active',
        drop: function (event, ui) {
            this.value += $(ui.draggable).find('select option:selected').text();
        }
    });
};		
	 
// Funcion que Obtiene los valores de los textbox y los select
var values = '', condiciones = '', cantidad = 0;
	 
function GetTextValue() {
	 
	values = '';
	 
	var j = 0;
	
	while(j < iCnt){
		j++;
		values = values + $("#tb1"+j).val() + ',';
		values = values + $("#tb2"+j).val() + ',';
	}
	$("#<?php echo $this->campoSeguro('variablesRegistros') ?>").val(values);

	condiciones = '';

	$( "select option:selected" ).each(function() {
	   condiciones += '['+ this.value + ']';
	   $("#<?php echo $this->campoSeguro('condicionesRegistros') ?>").val(condiciones);
	});
	
}

</script>