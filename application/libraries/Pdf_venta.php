<?php 
/*
  ------------------------------------------------------------------------------
  Creacion: Brayan Janco Cahuana Fecha:14/09/2021, Codigo:GAN-MS-A4-028
  Descripcion: Se diseño un formato para el pdf nota venta
 */
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  //ob_end_clean();
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf_venta extends TCPDF
{
	function __construct()
    {
        parent::__construct();
    }


	public function Header() {
		// Logo
		


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
