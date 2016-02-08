$( document ).ready(function() {
	
	var campoFecha = [];
	var campoFechaInput = [];
	var campoFechaFin = [];
	var campoFechaFinInput = [];
	var IFechaA = 0;
	var IFechaB= 0
        var IFechaFinA = 0;
	var IFechaFinB= 0;
	var contFecha = 0;
	campoFecha[IFechaA++] = "#<?php echo $this->campoSeguro('fechaInicio')?>";
	campoFechaInput[IFechaB++] = "input#<?php echo $this->campoSeguro('fechaInicio')?>";
	
	campoFechaFin[IFechaFinA++] = "#<?php echo $this->campoSeguro('fechaFin')?>";
	campoFechaFinInput[IFechaFinB++] = "input#<?php echo $this->campoSeguro('fechaFin')?>";
	
	
	$(campoFecha).each(function(){
		$(this.valueOf()).datepicker({
			dateFormat: 'yy-mm-dd',
			
			yearRange: '-50:+0',
			changeYear: true,
			changeMonth: true,
			monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
			'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
			monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
			dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
			dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
			dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
			onSelect: function(dateText, inst) {
				var lockDate = new Date($(this.valueOf()).datepicker('getDate'));
			}, onClose: function() { 
				}
		})
	});
        $(campoFechaFin).each(function(){
		$(this.valueOf()).datepicker({
			dateFormat: 'yy-mm-dd',
			
			yearRange: '-50:+0',
			changeYear: true,
			changeMonth: true,
			monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
			'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
			monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
			dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
			dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
			dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
			onSelect: function(dateText, inst) {
				var lockDate = new Date($(this.valueOf()).datepicker('getDate'));
			}, onClose: function() { 
				}
		})
	});
});