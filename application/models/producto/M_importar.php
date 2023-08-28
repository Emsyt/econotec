<?php
/*
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Alison Paola Pari Pareja Fecha:14/12/2022   GAN-MS-A3-0182,
Descripcion: Se realizo la implementacion del modulo IMPORTAR , para que todos los datos que se suban a la tabla ope_importacion
mediante la funcion insert_datos_masivos()

*/
class M_importar extends CI_Model {

  public function get_ubicacion_cmb(){
    $this->db->where('apiestado', 'ELABORADO');
    $query = $this->db->get('cat_ubicaciones');
    return $query->result();
  }
  public function insert_datos_masivos($data, $nom_archivo,$id_ubicacion)
  {
    //$iddata = $data[0];
    $usucre =  $this->session->userdata('usuario');
    for ($i = 0; $i < sizeof($data); $i++) {
      for ($j = 0; $j < sizeof($data[0]); $j++) {
        $$data[$i][$j] = strval($data[$i][$j]);
      }
    }
    for ($i = 0; $i < sizeof($data[0]); $i++) {
      /* Insertar 1 x 1 */
      
      $dato1 = $data[0][$i];    // categoria
      $dato2 = $data[1][$i];    // marca
      $dato3 = $data[2][$i];    // codigo
      $dato4 = $data[3][$i];    // codigo_alt
      $dato5 = $data[4][$i];    // producto
      $dato6 = $data[5][$i];    // caracteristica
      $dato7 = $data[6][$i];    // cantidad
      $dato8 = $data[7][$i];    // precio_compra
      $dato9 = $data[8][$i];    // precio_venta
      

      if ($dato1 != null) {
        //$x = "SELECT * FROM fn_insertar_datosmasivo('$dato1','$dato2','$dato3','$dato4','$dato5','$dato6','$dato7','$dato8','$dato9','$nom_archivo','$usucre');";
        $query = $this->db->query("SELECT * FROM fn_insertar_productosmasivo('$dato1','$dato2','$dato3','$dato4','$dato5','$dato6','$dato7','$dato8','$dato9','$nom_archivo',$id_ubicacion,'$usucre');");
      }

      //$state= $query->result();
    }
    //return $query->result();
    /* Verificar errores */
    // try {
    //   $query = $this->db->query("SELECT * FROM fn_detecta_errores('$nom_archivo','$usucre');");
    //   return $query->result();
    // } catch (Exception $e) {
    //   return "Error: " . $e;
    // }
  }
  public function insert_archivo($data){
    $this->db->insert('ope_archivo', $data);
    return $this->db->affected_rows();
  }
  public function get_lst_archivos()
  {
    $usucre =  $this->session->userdata('usuario');
    $query = $this->db->query("SELECT row_number() over(order by feccre desc)as nro,archivo,feccre as fecha_revision,apiestado FROM ope_archivo oa WHERE usucre ='$usucre' order by feccre desc");
    return $query->result();
  }
  public function M_fn_migracion_masiva($rawname,$idusuario)
  {
    $query = $this->db->query("SELECT * from fn_migracion_masiva('$rawname',$idusuario)");
    return $query->result();
  }
}
