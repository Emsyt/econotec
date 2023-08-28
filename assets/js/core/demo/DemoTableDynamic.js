(function(namespace, $) {
	"use strict";

	var DemoTableDynamic = function() {
		// Create reference to this instance
		var o = this;
		// Initialize app when document is ready
		$(document).ready(function() {
			o.initialize();
		});

	};
	var p = DemoTableDynamic.prototype;

	// =========================================================================
	// INIT
	// =========================================================================

	p.initialize = function() {
		this._initDataTables();
	};

	// =========================================================================
	// DATATABLES
	// =========================================================================

	p._initDataTables = function() {
		if (!$.isFunction($.fn.dataTable)) {
			return;
		}

		// Init the demo DataTables
		this._createDataTable1();
		this._createDataTable2();
		this._createDataTable3();
	};

	p._createDataTable1 = function() {
		$('#datatable1').DataTable({
			"dom": 'lCfrtip',
			"order": [],
			"colVis": {
				"buttonText": "Columnas",
				"overlayFade": 0,
				"align": "right"
			},

			/*"language": {
				"lengthMenu": '_MENU_ entries per page',
				"search": '<i class="fa fa-search"></i>',
				"paginate": {
					"previous": '<i class="fa fa-angle-left"></i>',
					"next": '<i class="fa fa-angle-right"></i>'
				}
			}*/

			"language": {
				"processing": 'Procesando...',
				"lengthMenu": 'Mostrar _MENU_ filas por página',
				"zeroRecords": 'No se encontro ningun registro - lo sentimos',
				"emptyTable": 'No existen filas disponibles',
				"sInfo": 'Mostrando página _PAGE_ de _PAGES_',
		        "infoEmpty": 'Mostrando  registros del 0 al 0 de un total de 0 registros',
		        "infoFiltered": '(Filtrando de _MAX_ total filas)',
				"search": '<i class="fa fa-search"></i>',
				"loadingRecords": 'Cargando...',
				"paginate": {
					"previous": '<i class="fa fa-angle-left"></i>',
					"next": '<i class="fa fa-angle-right"></i>'
				}
			}

		    /*"language": {
		        //"sProcessing":     'Procesando...',
		        //"sLengthMenu":     'Mostrar _MENU_ filas por página',
		        //"sZeroRecords":    'No se encontro ningun registro - lo sentimos',
		        //"sEmptyTable":     'No existen filas disponibles',
		        //"sInfo":           'Mostrando página _PAGE_ de _PAGES_',
		        //"sInfoEmpty":      'Mostrando registros del 0 al 0 de un total de 0 registros',
		        //"sInfoFiltered":   '(Filtrando de _MAX_ total filas)',
		        "sInfoPostFix":    '',
		        //"sSearch":         '<i class="fa fa-search"></i>',
		        "sUrl":            '',
		        "sInfoThousands":  ',',
		        //"sLoadingRecords": 'Cargando...',
		        "oPaginate": {
					"previous": '<i class="fa fa-angle-left"></i>',
					"next": '<i class="fa fa-angle-right"></i>'
				},
		        "oAria": {
		            "sSortAscending":  ': Activar para ordenar la columna de manera ascendente',
		            "sSortDescending": ': Activar para ordenar la columna de manera descendente'
		        }
		    }*/
		});

		$('#datatable1 tbody').on('click', 'tr', function() {
			$(this).toggleClass('selected');
		});
	};

	p._createDataTable2 = function() {
		var table = $('#datatable2').DataTable({
			"dom": 'T<"clear">lfrtip',
			"ajax": $('#datatable2').data('source'),
			"columns": [
				{
					"class": 'details-control',
					"orderable": false,
					"data": null,
					"defaultContent": ''
				},
				{"data": "name"},
				{"data": "position"},
				{"data": "office"},
				{"data": "salary"}
			],
			"tableTools": {
				"sSwfPath": $('#datatable2').data('swftools')
			},
			"order": [[1, 'asc']],
			"language": {
				"lengthMenu": '_MENU_ entries per page',
				"search": '<i class="fa fa-search"></i>',
				"paginate": {
					"previous": '<i class="fa fa-angle-left"></i>',
					"next": '<i class="fa fa-angle-right"></i>'
				}
			}
		});
		
		//Add event listener for opening and closing details
		var o = this;
		$('#datatable2 tbody').on('click', 'td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table.row(tr);

			if (row.child.isShown()) {
				// This row is already open - close it
				row.child.hide();
				tr.removeClass('shown');
			}
			else {
				// Open this row
				row.child(o._formatDetails(row.data())).show();
				tr.addClass('shown');
			}
		});
	};

	// =========================================================================
	// DETAILS
	// =========================================================================

	p._formatDetails = function(d) {
		// `d` is the original data object for the row
		return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
				'<tr>' +
				'<td>Full name:</td>' +
				'<td>' + d.name + '</td>' +
				'</tr>' +
				'<tr>' +
				'<td>Extension number:</td>' +
				'<td>' + d.extn + '</td>' +
				'</tr>' +
				'<tr>' +
				'<td>Extra info:</td>' +
				'<td>And any further details here (images etc)...</td>' +
				'</tr>' +
				'</table>';
	};

	p._createDataTable3 = function() {
		$('#datatable3').DataTable({
			"dom": 'lCfrtip',
			"order": [],
			"colVis": {
				"buttonText": "Columnas",
				"overlayFade": 0,
				"align": "right"
			},

			"info": false,
			"language": {
				"processing": 'Procesando...',
				"lengthMenu": 'Mostrar _MENU_ filas por página',
				"zeroRecords": 'No se encontro ningun registro - lo sentimos',
				"emptyTable": 'No existen filas disponibles',
				"sInfo": 'Mostrando página _PAGE_ de _PAGES_',
		        "infoEmpty": 'Mostrando  registros del 0 al 0 de un total de 0 registros',
		        "infoFiltered": '(Filtrando de _MAX_ total filas)',
				"search": '<i class="fa fa-search"></i>',
				"loadingRecords": 'Cargando...',
				"paginate": {
					"previous": '<i class="fa fa-angle-left"></i>',
					"next": '<i class="fa fa-angle-right"></i>'
				}
			}
		});

		/*$('#datatable3 tbody').on('click', 'tr', function() {
			$(this).toggleClass('selected');
		});*/
	};

	// =========================================================================
	namespace.DemoTableDynamic = new DemoTableDynamic;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
