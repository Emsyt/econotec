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
		$image_file = K_PATH_IMAGES.'logo_robely.jpg';
		$this->Image($image_file, 20, 7, 20, 22, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        /*$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false); */
		/*$this->Image($file, $x = '', $y = '', $w = 0, $h = 0, $type = '', $link = '', $align = '', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array() ) */
		//$this->Image($image_file, izquierdO, superior, ancho, alto, tipo, '', 'T', false, 300, '', false, false, 0, false, false, false);

		// Set font
		$this->SetFont('helvetica', 'B', 15);
		// Title
		$this->Ln(10);
		$this->Cell(0, 15, 'ROBELY IMPORT', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
		//$this->Cell(ancho de celda, alto de celda, texto de celda, borde de celda, 1, 'C', 0, '', 1);
		//alineado => [LEFT] = 'L' , [RIGHT] = 'R', [CENTER] = 'C', [JUSTIFY] = 'J', [DEFAULT] = '',
		//alig vertical =>[VERTICAL ALIGNMENT - TOP] = 'T', [VERTICAL ALIGNMENT - MIDDLE] = 'M', [VERTICAL ALIGNMENT - BOTTOM] = 'B'
	}

	// Page footer
	public function Footer() {
	    // Position at 15 mm from bottom
	    $this->SetY(-15);
	    // Set font
	    $this->SetFont('helvetica', 'I', 8);
	    // Page number
	    $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}
/* application/libraries/Pdf.php */