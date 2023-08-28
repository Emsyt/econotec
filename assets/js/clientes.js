$(document).on("ready", main);


function main(){
	mostrarDatos("",1,4);

	
	$("input[name=busqueda]").keyup(function(){
		textobuscar = $(this).val();
		valoroption = $("#cantidad").val();
		mostrarDatos(textobuscar,1,valoroption);
	});

	$("body").on("click",".paginacion li a",function(e){
		e.preventDefault();
		valorhref = $(this).attr("href");
		valorBuscar = $("input[name=busqueda]").val();
		valoroption = $("#cantidad").val();
		mostrarDatos(valorBuscar,valorhref,valoroption);
	});

	$("#cantidad").change(function(){
		valoroption = $(this).val();
		valorBuscar = $("input[name=busqueda]").val();
		mostrarDatos(valorBuscar,1,valoroption);
	});
}

function mostrarDatos(valorBuscar,pagina,cantidad){
	//alert("Entro a mostrar datos")
	$.ajax({
		//url : "http://localhost/ejemplos/clientes/mostrar",
		//url : "http://localhost/robely_web/inicio/C_catalogo_productos/mostrar",
		//url  : "<?php echo base_url(); ?>/inicio/C_catalogo_productos/mostrar",
		url : "inicio/C_catalogo_productos/mostrar",
		type: "POST",
		data: {buscar:valorBuscar,nropagina:pagina,cantidad:cantidad},
		dataType:"json",
		success:function(response){
			
			filas = "";
			$.each(response.clientes,function(key,item){
				//filas+="<tr><td>"+item.id_producto+"</td><td>"+item.codigo+"</td><td>"+item.descripcion+"</td><td>"+item.caracteristica+"</td><td>"+item.precio_unidad+"</td><td>"+item.imagen+"</td></tr>";
			
				//filas+= "<div class='col-md-3 col-sm-6'><div class='product-grid2'><div class='product-image2'><a href='#'><img class='pic-1' src=' "<?php echo base_url();?>"assets/img/productos/1.jpg '><img class='pic-2' src='../assets/img/productos/"+item.imagen+"'> </a><ul class='social'><li><a href='#' data-tip='Add to Wishlist'><i class='fa fa-heart'></i></a></li><li><a href='#' data-tip='Quick View'><i class='fa fa-eye'></i></a></li><li><a href='#' data-tip='Add to Cart'><i class='fa fa-shopping-cart'></i></a></li> </ul><a class='add-to-cart' href='#'>Añadir a carrito</a></div><div class='product-content'><h3 class='title'><a href='#'>"+item.descripcion+"</a></h3><span class='price'>Bs. "+item.precio_unidad+"</span></div></div></div>";

				//filas+='<div class="col-md-3 col-sm-6"><div class="product-grid2"><div class="product-image2"><a href="#"><img class="pic-1" src="assets/img/productos/1.jpg"><img class="pic-2" src="assets/img/productos/'+item.imagen+' "></a><ul class="social"><li><a href="#" data-tip="Add to Wishlist"><i class="fa fa-heart"></i></a></li><li><a href="#" data-tip="Quick View"><i class="fa fa-eye"></i></a></li><li><a href="#" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li></ul><a class="add-to-cart" href="">Añadir a carrito</a></div> <div class="product-content"><h3 class="title"><a href="#"> '+item.descripcion+' </a></h3><span class="price"> '+item.precio_unidad+' </span></div></div></div>';
				filas+='<div class="col-md-3 col-sm-6"><div class="product-grid2"><div class="product-image2"><a href="#"><img class="pic-1" src="assets/img/productos/1.jpg"><img class="pic-2" src="assets/img/productos/2.jpg "></a><ul class="social"><li><a href="#" data-tip="Add to Wishlist"><i class="fa fa-heart"></i></a></li><li><a href="#" data-tip="Quick View"><i class="fa fa-eye"></i></a></li><li><a href="#" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li></ul><a class="add-to-cart" href="">Añadir a carrito</a></div> <div class="product-content"><h3 class="title"><a href="#"> '+item.descripcion+' </a></h3><span class="price"> '+item.precio_unidad+' </span></div></div></div>';

			});

			//$("#tbclientes tbody").html(filas);
			$("#tbclientes").html(filas);
			linkseleccionado = Number(pagina);
			//total registros
			totalregistros = response.totalregistros;
			//cantidad de registros por pagina
			cantidadregistros = response.cantidad;

			numerolinks = Math.ceil(totalregistros/cantidadregistros);
			paginador = "<ul class='pagination'>";
			if(linkseleccionado>1)
			{
				paginador+="<li><a href='1'>&laquo;</a></li>";
				paginador+="<li><a href='"+(linkseleccionado-1)+"' '>&lsaquo;</a></li>";

			}
			else
			{
				paginador+="<li class='disabled'><a href='#'>&laquo;</a></li>";
				paginador+="<li class='disabled'><a href='#'>&lsaquo;</a></li>";
			}
			//muestro de los enlaces 
			//cantidad de link hacia atras y adelante
 			cant = 2;
 			//inicio de donde se va a mostrar los links
			pagInicio = (linkseleccionado > cant) ? (linkseleccionado - cant) : 1;
			//condicion en la cual establecemos el fin de los links
			if (numerolinks > cant)
			{
				//conocer los links que hay entre el seleccionado y el final
				pagRestantes = numerolinks - linkseleccionado;
				//defino el fin de los links
				pagFin = (pagRestantes > cant) ? (linkseleccionado + cant) :numerolinks;
			}
			else 
			{
				pagFin = numerolinks;
			}

			for (var i = pagInicio; i <= pagFin; i++) {
				if (i == linkseleccionado)
					paginador +="<li class='active'><a href='javascript:void(0)'>"+i+"</a></li>";
				else
					paginador +="<li><a href='"+i+"'>"+i+"</a></li>";
			}
			//condicion para mostrar el boton sigueinte y ultimo
			if(linkseleccionado<numerolinks)
			{
				paginador+="<li><a href='"+(linkseleccionado+1)+"' >&rsaquo;</a></li>";
				paginador+="<li><a href='"+numerolinks+"'>&raquo;</a></li>";

			}
			else
			{
				paginador+="<li class='disabled'><a href='#'>&rsaquo;</a></li>";
				paginador+="<li class='disabled'><a href='#'>&raquo;</a></li>";
			}
			
			paginador +="</ul>";
			$(".paginacion").html(paginador);

		}
	});
}