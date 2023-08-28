<?php
 /*
  -------------------------------------------------------------------------------------------------------
  -- Creado: Jhonatan Nestor Romero Condori                                           Fecha:03/07/2023 --
  -- Modulo: recursos/feriado           Proyecto: ECOGAN                     Actividad:GAN-FCL-B3-0318 -- 
  -- Descripcion: se creo el modulo feriado y funciones para que realize un ABM.                       --
  -------------------------------------------------------------------------------------------------------
  */
class M_feriado extends CI_Model {

  public function get_marca(){
    $query = $this->db->get('rec_feriado');
    return $query->result();
  }
 

  public function gestionar_feriado($id_feriado,$fecha,$descripcion,$ambito){

    //Ejecucion de funcion
    $xf = "SELECT * FROM fn_gestionar_feriado('$fecha'::date,'$descripcion','$ambito');";
    $query = $this->db->query("SELECT * FROM fn_gestionar_feriado($id_feriado,'$fecha'::date,'$descripcion','$ambito');");
    return $query->result();
  
  }

  public function get_lista_feriad($json) {
    
      $query = $this->db->query("SELECT * FROM fn_listar_feriad('$json'::JSON)");

      return $query->result();
    }


 
  public function get_datos_feriado($id_fer){
    $query = $this->db->query("SELECT * FROM fn_get_datos_feriado($id_fer)");
    return $query->row();
  }

  public function listar_reg_feriado() {
    $query = $this->db->query("SELECT * FROM fn_listar_feriado()");
    return $query->result();
}
  

  
  public function delete_feriado($id_fer, $data){

    $vData = array_values($data);
    $vapiestado = $vData[0];
    $vusumod = $vData[1];    
    $query = $this->db->query("SELECT * FROM fn_delete_feriado2($id_fer,'$vapiestado','$vusumod')");
  }



}
