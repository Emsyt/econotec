<?php 
/*
  ------------------------------------------------------------------------------
  Modificado: Luis Andres Cachaga Leuca Fecha:08/07/2021, Codigo:GAN-MS-A0-002
  Descripcion: Se cambio el logo en el reporte PDF  se agrego la imagen a las librerias del tcpdf
 */
/*
  ------------------------------------------------------------------------------
  Modificado: Milena Rojas Fecha:18/03/2022, Codigo:GAN-MS-A5-134
  Descripcion: Se modifico el header del pdf para que se pueda mostrar el logo y el nombre de la empresa segun
  los datos que se obtenga de la base de datos 
 */
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  //ob_end_clean();
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf extends TCPDF
{
	function __construct()
    {
        parent::__construct();
    }

	//Page header
	public function Header() {
		// Logo
		// $image_file = K_PATH_IMAGES.'logoEmpresa.png';

		// $this->Image($image_file, 20, 15, 45, 15, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

		// // Set font
		// $this->SetFont('times', 'B', 13);
		// Title
		// $this->Ln(10);
		// $this->Cell(0, 15, 'EMPRESA TESICON', 0, false, 'C', 0, '', 0, false, 'M', 'M');
	}

	// Page footer
	public function Footer() {
	    // Position at 15 mm from bottom
	    $this->SetY(-15);
	    // Set font
	    $this->SetFont('helvetica', 'I', 8);
	    // Page number
	    $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}
/* application/libraries/Pdf.php */
