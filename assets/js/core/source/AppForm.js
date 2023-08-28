(function(namespace, $) {
	"use strict";

	var AppForm = function() {
		// Create reference to this instance
		var o = this;
		// Initialize app when document is ready
		$(document).ready(function() {
			o.initialize();
		});

	};
	var p = AppForm.prototype;

	// =========================================================================
	// INIT
	// =========================================================================

	p.initialize = function() {
		// Init events
		this._enableEvents();

		this._initRadioAndCheckbox();
		this._initFloatingLabels();
		this._initValidation();
	};

	// =========================================================================
	// EVENTS
	// =========================================================================

	// events
	p._enableEvents = function () {
		var o = this;

		// Link submit function
		$('[data-submit="form"]').on('click', function (e) {
			e.preventDefault();
			var formId = $(e.currentTarget).attr('href');
			$(formId).submit();
		});

		// Init textarea autosize
		$('textarea.autosize').on('focus', function () {
			$(this).autosize({append: ''});
		});
	};

	// =========================================================================
	// RADIO AND CHECKBOX LISTENERS
	// =========================================================================

	p._initRadioAndCheckbox = function () {
		// Add a span class the styled checkboxes and radio buttons for correct styling
		$('.checkbox-styled input, .radio-styled input').each(function () {
			if ($(this).next('span').length === 0) {
				$(this).after('<span></span>');
			}
		});
	};

	// =========================================================================
	// FLOATING LABELS
	// =========================================================================

	p._initFloatingLabels = function () {
		var o = this;

		$('.floating-label .form-control').on('keyup change', function (e) {
			var input = $(e.currentTarget);

			if ($.trim(input.val()) !== '') {
				input.addClass('dirty').removeClass('static');
			} else {
				input.removeClass('dirty').removeClass('static');
			}
		});

		$('.floating-label .form-control').each(function () {
			var input = $(this);

			if ($.trim(input.val()) !== '') {
				input.addClass('static').addClass('dirty');
			}
		});

		$('.form-horizontal .form-control').each(function () {
			$(this).after('<div class="form-control-line"></div>');
		});
	};

	// =========================================================================
	// VALIDATION
	// =========================================================================

	p._initValidation = function () {
		if (!$.isFunction($.fn.validate)) {
			return;
		}
		$.validator.setDefaults({
			/*Permite la validacion de campos ocultos*/
			ignore: '.select2-input, .select2-focusser',

			highlight: function (element) {
				$(element).closest('.form-group').addClass('has-error');
			},
			unhighlight: function (element) {
				$(element).closest('.form-group').removeClass('has-error');
			},

			errorElement: 'span',
			errorClass: 'help-block',
			errorPlacement: function (error, element) {
				if (element.parent('.input-group').length) {
					error.insertAfter(element.parent());
				}
				else if (element.parent('label').length) {
					error.insertAfter(element.parent());
				}
				else {
					error.insertAfter(element);
				}
			}
		});

		$.validator.messages = {
			required: "Este campo es obligatorio.",
			remote: "Por favor, rellena este campo.",
			email: "Por favor, escribe una dirección de correo válida",
			url: "Por favor, escribe una URL válida.",
			date: "Por favor, escribe una fecha válida.",
			dateISO: "Por favor, escribe una fecha (ISO) válida.",
			number: "Por favor, escribe un número.", //modificado
			digits: "Por favor, escribe sólo dígitos.",
			creditcard: "Por favor, escribe un número de tarjeta válido.",
			equalTo: "Por favor, escribe el mismo valor de nuevo.",
			accept: "Por favor, escribe un valor con una extensión aceptada.",
			maxlength: $.validator.format("Por favor, no escribas más de {0} caracteres."),
			minlength: $.validator.format("Por favor, no escribas menos de {0} caracteres."),
			rangelength: $.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
			range: $.validator.format("Por favor, escribe un valor entre {0} y {1}."),
			max: $.validator.format("Por favor, escribe un valor menor o igual a {0}."),
			//min: $.validator.format("Por favor, escribe un valor mayor o igual a {0}."), original
			min: $.validator.format("El valor debe ser mayor a 0."), //modificado
			prueba: "El Registro ya ha sido ingresado",
		};

		$('.form-validate').each(function () {
			var validator = $(this).validate();
			$(this).data('validator', validator);
		});
	};

	// =========================================================================
	// DEFINE NAMESPACE
	// =========================================================================

	window.materialadmin.AppForm = new AppForm;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
