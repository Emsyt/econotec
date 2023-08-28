<?php
/*
  ------------------------------------------------------------------------------
  Creador: Ayrton Jhonny Guevara Montaño Fecha:19/05/2023, Codigo: GAN-DPR-B5-0478
  Descripcion: Se creo el Controlador del submodulo de tickets en el modulo de promociones
    ------------------------------------------------------------------------------
  Modificado: Ayrton Jhonny Guevara Montaño Fecha:19/05/2023, Codigo: GAN-MS-B1-0486
  Descripcion: Se agrego la funcion imprimir pdf ticket
    ------------------------------------------------------------------------------
  Modificado: Ayrton Jhonny Guevara Montaño Fecha:19/05/2023, Codigo: GAN-MS-M0-0492
  Descripcion: Se agrego un nuevo parametro que se encia a la funcion ticket, repeticionn,
  para que los tickets impresos se impriman segun el numero de columnas

  */
defined('BASEPATH') or exit('No direct script access allowed');

class C_ticket extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->load->helper('url');

        $this->load->library('upload');
        $this->load->model('promociones/M_ticket', 'ticket');
        $this->load->library('Pdf');
    }

    public function index()
    {
        if ($this->session->userdata('login')) {
            $log['usuario'] = $this->session->userdata('usuario');
            $log['permisos'] = $this->session->userdata('permisos');
            $usr=$data['codigo_usr'] = $this->session->userdata('id_usuario');
            $data['fecha_imp'] = date('Y-m-d H:i:s');

            $data['lib'] = 0;
            $data['datos_menu'] = $log;

            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'promociones/ticket';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura', $data);
        } else {
            redirect('logout');
        }
    }

    public function add_update_ticket(){
        if($this->input->post('btn')=='add'){
            $NInicial = $this->input->post('NInicial');
            $NFinal = $this->input->post('NFinal');
            $Rango = $this->input->post('Rango');
            $tipo = $this->input->post('tipo');
            $filas = $this->input->post('NFilas');
            $columnas = $this->input->post('NColumnas');
            $conrepeticion=$this->input->post('repeticionn');
            $interlineado =$this->input->post('interlineado');
            $tamañohoja=$this->input->post('THoja');
            echo $tamañohoja;
            $ticketadd = $this->ticket->insert_ticket($NInicial,$NFinal,$Rango,$tipo);
            $response = json_decode($ticketadd[0]->fn_agregar_conf_ticket);
            $cantidadTickets = count($response->odata);
            $filasxcolumnas = ($conrepeticion=='false') ? ($filas * $columnas): ($cantidadTickets+1) ;
            
            if ($response->oboolean == 'true') {
                if($cantidadTickets <= $filasxcolumnas){
                    if($columnas>7){
                        $this->session->set_flashdata('error', 'la cantidad de columnas sobrepasa el ancho de la hoja');
                    }else{
                        $this->session->set_flashdata('success', 'Registro insertado exitosamente.');
                        $this->generar_pdf_ticket($response,$filas,$columnas,$conrepeticion,$interlineado,$tamañohoja);
                    }
                }else{
                    $this->session->set_flashdata('error', 'la cantidad de tickets sobrepasa los campos seleccionados');
                }
            } else {
                $this->session->set_flashdata('error', $response->omensaje);
            }
        }
        redirect('tickets');
    }


    public function generar_pdf_ticket($response,$filas,$columnas,$conrepeticion,$interlineado,$tamañohoja){
        //se inician valores
        $espacio = $interlineado==null? 0:$interlineado*10;
        $tickets = $response->odata;
        $totalTickets = count($tickets);
        $columnasrepeticion=$columnas;
        $contador=0;
        $contador2=0;
        $filas = $filas == null ? $totalTickets:$filas;
        
        if($tamañohoja=='carta'){
            $pdf_size = array(215, 279.4);
        }else if($tamañohoja=='oficio'){
            $pdf_size = array(215, 330);
        }
        $pdf = new Pdf('P', 'mm', $pdf_size, true, 'UTF-8', false);

        $pdf->SetCreator('PDF_CREATOR');
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Ticket PDF');
        $pdf->SetMargins(0, 0, 0);
        $pdf->SetAutoPageBreak(false, 0);
        $pdf->SetPrintFooter(false);
        
        $pdf->AddPage('P',$pdf_size);

            $pdf->SetFont('Helvetica', '', 12);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetTextColor(255,0,0);
            //se calcula las dimensiones de las celdas
            $cellWidth = ($pdf->GetPageWidth() / $columnas);
            $cellHeight = $pdf->GetPageHeight()/$filas<=10 ? 10 : ($pdf->GetPageHeight() / $filas); //

            //se comprueba si los tickets tendran repeticion
            if ($conrepeticion == 'true') {
                for ($row = 1; $row <= $filas; $row++) {
                    for ($col = 1; $col <= $columnas; $col++) {
                        //se calcula el lugar de la impresion de cada celda respecto a su tamaño, margen e interlineado
                        $x = (($col - 1) * $cellWidth)  + ($espacio/2)+ ($espacio*($col-1));
                        $y = (($row - 1) * $cellHeight) + ($espacio/2)+ ($espacio*($row-1));
                        //se verifica la cantidad de tickets para la impresion
                        if ($contador < $totalTickets) {
                            $ticketContent = $tickets[$contador]->ticket;
                        } else {
                            $ticketContent = '';
                            break;
                        }
                        //se imprimen los tickets
                        $pdf->SetXY($x, $y);
                        $pdf->Cell($cellWidth, $cellHeight, $ticketContent, 0, 0, 'C', true);
                        $contador2++;
                        //se verifica si el siguiente ticket estara dentro del tamaño de la hoja
                        if ($col!=$columnas) {
                            if (($x+($cellWidth*2)+$espacio) > $pdf->GetPageWidth()) {
                                //se calculan las columnas faltantes
                                $col2 = $columnas-($columnas - $col);
                                //se calculan las nuevas lineas
                                $nuevasfilas = ceil(($columnas*$totalTickets) / $col2); 
                                $filas=$nuevasfilas;
                                $columnas=$col2;
                            }
                        }
                        //solo si es con repeticion el contador de tickets se activara cuando el numero de impresiones sea el esperado
                        if($contador2==$columnasrepeticion){
                            $contador=$contador+1;
                            $contador2=0;
                        }
                    }
                    //se controla que las celdas no se sigan imprimiendo si no hay tickets
                    if($totalTickets<=$contador){break;}
                    //se controla que las celdas no excedan el tamaño de la hoja 
                    if (($y+($cellHeight*2)+$espacio) > $pdf->GetPageHeight()) {
                        $pdf->AddPage('P',$pdf_size);
                        $filas=$filas-$row+1;
                        $row=0;
                    }
                }
            }else{
                for ($row = 1; $row <= $filas; $row++) {
                    for ($col = 1; $col <= $columnas; $col++) {
                        $x = (($col - 1) * $cellWidth)  + ($espacio/2)+ ($espacio*($col-1));
                        $y = (($row - 1) * $cellHeight) + ($espacio/2)+ ($espacio*($row-1));
                        
                        if ($contador < $totalTickets) {
                            $ticketContent = $tickets[$contador]->ticket;
                        } else {
                            $ticketContent = '';
                            break;
                        }

                        $contador=$contador+1;
                        $pdf->SetXY($x, $y);
                        $pdf->Cell($cellWidth, $cellHeight, $ticketContent, 0, 0, 'C', true);

                        if ($col!=$columnas) {
                            if (($x+($cellWidth*2)+$espacio) > $pdf->GetPageWidth()) {
                                $col2 = $columnas-($columnas - $col);
                                $nuevasfilas = ceil($totalTickets / $col2); 
                                $filas=$nuevasfilas;
                                $columnas=$col2;
                            }
                        }
                        
                    }
                    if($totalTickets<=$contador){break;}
                    if (($y+($cellHeight*2)+$espacio) > $pdf->GetPageHeight()) {
                        $pdf->AddPage('P',$pdf_size);
                        $filas=$filas-$row+1;
                        $row=0;
                    }
                }
            }
        ob_end_clean();
        $pdf_ruta = 'Reporte_Abast_Pagar.pdf';
        $pdf->Output($pdf_ruta, 'I');

    }
}
