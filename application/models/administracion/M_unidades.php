<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Gabriela Mamani Choquehuanca Fecha:25/07/2022, Codigo: GAN-MS-A1-317,
Descripcion: Creacion del Model M_unidades con sus respectivas funciones para la relacion con la base de datos.
 */
class M_unidades extends CI_Model {
     public function insert_unidad($codigo ,$descripcion, $usucre ,$catalogo,$apiestado){
     $resultado = $this->db->query("insert into cat_catalogo (catalogo,codigo,descripcion,apiestado,usucre)
     values ('$catalogo','$codigo','$descripcion','$apiestado','$usucre')");
     return $this->db->affected_rows();
     }

    public function get_lst_unidades(){
      $query = $this->db->query("SELECT * FROM fn_get_all_unidades();");
      //$query = $this->db->query("select * from cat_catalogo cc where catalogo ilike 'cat_unidades'");
      return $query->result();
    }

    public function get_datos_unidad($id_ubi){
        $query = $this->db->query("select codigo ,descripcion,apiestado  from cat_catalogo cc  where cc.id_catalogo = $id_ubi");
        return $query->result();
      }
    
    public function modificar($id_catalogo,$codigo ,$descripcion){
        $query = $this->db->query("UPDATE cat_catalogo SET codigo ='$codigo' , descripcion = '$descripcion' where id_catalogo = $id_catalogo");
        return $this->db->affected_rows();
      }  

      public function delete_unidad($id_cli, $apiestado){
        $query = $this->db->query(" UPDATE cat_catalogo cc SET apiestado ='$apiestado' WHERE $id_cli = cc.id_catalogo ");
        return $this->db->affected_rows();
        
      }  

}
