<?php
/*
  -------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:09/11/2021, Codigo: GAN-MS-A1-068
  Descripcion: Se modifico en la funciones de container1 y container2 para que se reciban los datos de lts_productos_mas_vendidos y lts_productos_menos_vendidos
  -------------------------------------------------------------------------------
  Modificado: Melvin Salvador Cussi Callisaya Fecha:21/04/2022, Codigo: GAN-MS-A0-180
  Descripcion: se adiciono la funcionalidad en el grafico de ingresos y egresos.
  --------------------------------------------------------------------------
  Modificado: Melani Alisson Cusi Burgoa  Fecha:28/10/2022, Codigo: GAN-MS-A2-0077
  Descripcion: Se adiciono la funcionalidad en el grafico de los 10 mejores clientes.
  --------------------------------------------------------------------------
  Modificado: Kevin Gerardo Alcon Lazarte  Fecha:13/02/2023, Codigo: GAN-PB-B0-0238
  Descripcion: Se comento algunas url que llaman a algunos scripts para mejorar el grafico,pero que noce ejecutan
  */
?>
<!-- Inicio Kevin G. Alcon L ,13/02/2023,GAN-PB-B0-0238-->
<script src="https://code.highcharts.com/highcharts.js"></script>
<!-- <script src="https://code.highcharts.com/modules/data.js"></script> -->
<!-- <script src="https://code.highcharts.com/modules/drilldown.js"></script> -->
<!-- <script src="https://code.highcharts.com/modules/exporting.js"></script> -->
<!-- <script src="https://code.highcharts.com/modules/export-data.js"></script> -->
<!-- <script src="https://code.highcharts.com/modules/accessibility.js"></script> -->
<!-- <script src="https://code.highcharts.com/highcharts.src.js"></script> -->
<!-- <script src="https://code.highcharts.com/highcharts-3d.js"></script> -->
<!-- Fin Kevin G. Alcon L ,13/02/2023,GAN-PB-B0-0238-->

<style>
  * {box-sizing:border-box}

/* Slideshow container */
.slideshow-container {
  max-width: 1000px;
  position: relative;
  margin: auto;
}

/* Hide the images by default */
.mySlides {
  display: none;
  border: 40px solid #999;
  
}

/* Next & previous buttons */
.prev, .next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  margin-top: -22px;
  padding: 16px;
  color: white;
  font-weight: bold;
  font-size: 18px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
  user-select: none;
  background-color: #e7e7e7; color: black;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover, .next:hover {
  background-color: rgba(0,0,0,0.8);
}

/* Caption text */


/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* The dots/bullets/indicators */
.dot {
  cursor: pointer;
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

@-webkit-keyframes fade {
  from {opacity: .4}
  to {opacity: 1}
}

@keyframes fade {
  from {opacity: .4}
  to {opacity: 1}
}
</style>
  <!-- BEGIN GRAFICO -->
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

      <h4></h4>
      
<!-- Slideshow container -->
<div class="slideshow-container">

  <!-- Full-width images with number and caption text -->
  <div class="mySlides " >
    <div id="container"></div>
  </div>
  <div class="mySlides ">
    <div id="container1"></div>
  </div>
  <div class="mySlides ">
    <div id="container2"></div>
  </div>
  <div class="mySlides ">
    <div id="container3"></div>
  </div>
  <div class="mySlides ">
    <div id="container4"></div>
  </div>
  <!-- Next and previous buttons -->
  <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
  <a class="next" onclick="plusSlides(1)">&#10095;</a>
</div>
<br>

<!-- The dots/circles -->
<div style="text-align:center">
  <span class="dot" onclick="currentSlide(1)"></span>
  <span class="dot" onclick="currentSlide(2)"></span>
  <span class="dot" onclick="currentSlide(3)"></span>
  <span class="dot" onclick="currentSlide(4)"></span>
  <span class="dot" onclick="currentSlide(5)"></span>
</div>

    </div>
  </div>
  <!-- END GRAFICO -->

<style>
  .highcharts-figure, .highcharts-data-table table {
      min-width: 310px;
      max-width: 800px;
      margin: 1em auto;
  }

  .highcharts-data-table table {
  	font-family: Verdana, sans-serif;
  	border-collapse: collapse;
  	border: 1px solid #EBEBEB;
  	margin: 10px auto;
  	text-align: center;
  	width: 100%;
  	max-width: 500px;
  }
  .highcharts-data-table caption {
      padding: 1em 0;
      font-size: 1.2em;
      color: #555;
  }
  .highcharts-data-table th {
  	font-weight: 600;
      padding: 0.5em;
  }
  .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
      padding: 0.5em;
  }
  .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
      background: #f8f8f8;
  }
  .highcharts-data-table tr:hover {
      background: #f1f7ff;
  }

  #button-bar {
      min-width: 310px;
      max-width: 800px;
      margin: 0 auto;
  }
  #container {
  height: 400px; 
}
#container1 {
  height: 400px; 
}
#container2 {
  height: 400px; 
}
#container3 {
  height: 400px; 
}
#container4 {
  height: 400px; 
}
.highcharts-figure, .highcharts-data-table table {
  min-width: 310px; 
  max-width: 800px;
  margin: 1em auto;
}

.highcharts-data-table table {
  font-family: Verdana, sans-serif;
  border-collapse: collapse;
  border: 1px solid #EBEBEB;
  margin: 10px auto;
  text-align: center;
  width: 100%;
  max-width: 500px;
}
.highcharts-data-table caption {
  padding: 1em 0;
  font-size: 1.2em;
  color: #555;
}
.highcharts-data-table th {
  font-weight: 600;
  padding: 0.5em;
}
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
  padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
  background: #f8f8f8;
}
.highcharts-data-table tr:hover {
  background: #f1f7ff;
}
</style>



<script>
   Highcharts . setOptions ( { 
        lang : { 
            downloadCSV : 'Descargar CSV' , 
            downloadXLS : 'Descargar XLS' , 

            hideData:"Hide data table"
        } 
    } ) ;
  var chart = Highcharts.chart('container', {

      chart: {
          type: 'column'
      },

      title: {
          text: '<?php echo $titulo ?>'
      },

      subtitle: {
          text: '<?php echo $subtitulo ?>'
      },

      legend: {
          align: 'right',
          verticalAlign: 'middle',
          layout: 'vertical'
      },

      xAxis: {
          categories: ['<?php echo $titulo_x ?>'],

          labels: {
              x: -10
          }
      },

      yAxis: {
          allowDecimals: false,
          title: {
              text: '<?php echo $titulo_y ?>'
          }
      },

      series: [
        <?php foreach ($datos_graf as $graf) { ?>{
            name: '<?php echo $graf->vendedor ?>',
            data: [<?php echo $graf->cantidad ?>]
            },
        <?php } ?>
      ],

      responsive: {
          rules: [{
              condition: {
                  maxWidth: 500
              },
              chartOptions: {
                  legend: {
                      align: 'center',
                      verticalAlign: 'bottom',
                      layout: 'horizontal'
                  },
                  yAxis: {
                      labels: {
                          align: 'left',
                          x: 0,
                          y: -5
                      },
                      title: {
                          text: null
                      }
                  },
                  subtitle: {
                      text: null
                  },
                  credits: {
                      enabled: false
                  }
              }
          }]
      }
  });

// document.getElementById('small').addEventListener('click', function () {
//     chart.setSize(400);
// });
// document.getElementById('large').addEventListener('click', function () {
//     chart.setSize(600);
// });
// document.getElementById('auto').addEventListener('click', function () {
//     chart.setSize(null);
// });

/** Productos mas vendidos **/

Highcharts.chart('container1', {
  chart: {
    type: 'cylinder',
    options3d: {
      enabled: true,
      alpha: 15,
      beta: 15,
      depth: 50,
      viewDistance: 25
    }
  },
  title: {
    text: 'Productos Más Vendidos'
  },
  plotOptions: {
    series: {
      depth: 25,
      colorByPoint: true
    }
  },
  yAxis: [{
    title: {
      text: 'Cantidad Vendida'
    }
  }],
  xAxis: {
    title: {
      text: 'Productos'
    },
    categories: <?php echo $lts_mas_vendidos_producto ?>
  },

  series: [{
    data: <?php echo $lts_mas_vendidos_cantidad ?>,
    name: 'Cantidad'
  }],
  
});



/** Productos menos vendidos **/

Highcharts.chart('container2', {
  chart: {
    type: 'pyramid3d',
    options3d: {
      enabled: true,
      alpha: 10,
      depth: 50,
      viewDistance: 50
    }
  },
  title: {
    text: 'Productos Menos Vendidos'
  },
  plotOptions: {
    series: {
      dataLabels: {
        enabled: true,
        format: '<b>{point.name}</b> ({point.y:,.0f})',
        allowOverlap: true,
        x: 10,
        y: -5
      },
      width: '60%',
      height: '80%',
      center: ['50%', '45%']
    
    }
  },
  series: [{
    name: 'Cantidad Vendida',
    data: <?php echo $lts_menos_vendidos_producto ?>
  }]
});

/** Ingresos/Egresos **/

Highcharts.chart('container3', {
  chart: {
    type: 'areaspline'
  },
  title: {
    text: 'Ingresos y Egresos del Mes'
  },
  legend: {
    layout: 'vertical',
    align: 'left',
    verticalAlign: 'top',
    x: 150,
    y: 100,
    floating: true,
    borderWidth: 1,
    backgroundColor:
      Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF'
  },
  xAxis: {
    categories: <?php echo $fechas ?>,
    plotBands: [{ // visualize the weekend
      from: 4.5,
      to: 6.5,
      color: 'rgba(68, 170, 213, .2)'
    }]
  },
  yAxis: {
    title: {
      text: 'Monto'
    }
  },
  tooltip: {
    shared: true,
    valueSuffix: ' Bs.'
  },
  credits: {
    enabled: false
  },
  plotOptions: {
    areaspline: {
      fillOpacity: 0.5
    }
  },
  series: [{
    name: 'Ingresos',
    data: <?php echo $ingresos ?>
  }, {
    name: 'Egresos',
    data: <?php echo $egresos ?>
  }]
});

/** Productos mas vendidos **/

Highcharts.chart('container4', {
  chart: {
    type: 'bar',
    options3d: {
      enabled: true,
      alpha: 15,
      beta: 15,
      depth: 50,
      viewDistance: 25
    }
  },
  title: {
    text: 'Los 10 mejores clientes'
  },
  plotOptions: {
    series: {
      depth: 25,
      colorByPoint: true
    }
  },
  yAxis: [{
    title: {
      text: 'Monto compras cliente'
    }
  }],
  xAxis: {
    title: {
      text: 'Clientes',
      align: 'high'
    },
    categories: <?php echo $lts_diez_mejores_clientes?>
  },

  series: [{
    data: <?php echo $lts_diez_mejores_clientes_monto?>,
    name: 'Monto'
  }],
  
});

function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}
currentSlide(1);
function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
}
</script>
