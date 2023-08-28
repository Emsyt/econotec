<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Brayan Janco Cahuana Fecha:27/04/2022, Codigo: GAN-FR-M6-210,
Descripcion: Creacion del Model M_informacion con su respectiva funcion para la relacion con la base de datos.
 */
class M_informacion extends CI_Model {
    public function get_version(){
        $query = $this->db->query("SELECT descripcion FROM cat_catalogo cc WHERE catalogo ='cat_version' AND codigo='VER'");
        return  $query->row();
      }
    
}

