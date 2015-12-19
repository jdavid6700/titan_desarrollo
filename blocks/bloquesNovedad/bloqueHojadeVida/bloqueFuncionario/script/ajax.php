<?php

?>

<script>
function seleccionDoc(usuario){
	$("#<?php echo $this->campoSeguro('funcionarioDocumentoBusqueda') ?>").val(usuario);
	//alert("cLICK EN EL bOTON "+"<?php echo ' Hola ' ?> ->"+posicion);
}

function seleccionNom(nombre){
	$("#<?php echo $this->campoSeguro('funcionarioNombre') ?>").val(nombre);
}

function seleccionApe(apellido){
	$("#<?php echo $this->campoSeguro('funcionarioApellido') ?>").val(apellido);
}

$( "#<?php echo $this->campoSeguro('funcionarioFechaNacimiento')?>" ).datepicker({
	showButtonPanel: true,  /*added by oussama*/
    changeMonth: true, /*added by oussama*/
    changeYear: true, /*added by oussama*/
    dateFormat: 'yy-mm-dd',/*'dd/mm/yy'*/
    yearRange: "-99:+0",
    maxDate: "+0m +0d",
	onSelect: function(dateText) {
		
		var fecha=document.getElementById("<?php echo $this->campoSeguro('funcionarioFechaNacimiento')?>").value;

		var values=fecha.split("-");
	    var dia = values[2];
	    var mes = values[1];
	    var ano = values[0];

	    // tomamos los valores actuales

	    var fecha_hoy = new Date();
	    var ahora_ano = fecha_hoy.getYear();
	    var ahora_mes = fecha_hoy.getMonth()+1;
	    var ahora_dia = fecha_hoy.getDate();

	    // realizamos el calculo
	    var edad = (ahora_ano + 1900) - ano;
	    if ( ahora_mes < mes )
	    {
	        edad--;
	    }
	    if ((mes == ahora_mes) && (ahora_dia < dia))
	    {
	        edad--;
	    }

	    if (edad > 1900)
	    {
	        edad -= 1900;
	    }
	    $("#<?php echo $this->campoSeguro('funcionarioEdad') ?>").val(edad);
		//alert("Formato"); 
	} 
});

$( "#<?php echo $this->campoSeguro('funcionarioPaisNacimiento')?>" ).change(function() {
	$("#<?php echo $this->campoSeguro('funcionarioDepartamentoNacimiento') ?>").attr("enabled", enabled);
});
</script>