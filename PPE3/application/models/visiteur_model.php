<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
      class Visiteur_model extends CI_Model {

          function get_visiteur() {
              $sql = "SELECT * FROM visiteur order by 2";

              $query = $this->db->query($sql);
              //$query = $this->db->get_where("visiteur");
              return $query->result();
          }

          function get_rapport(){
              $sql = "SELECT * FROM rapport_visite order by 4";

              $query = $this->db->query($sql);

              return $query->result();
          }
          public function regionVisiteur($id){
              $sql = "SELECT region.REG_CODE AS code, REG_NOM, GROUP_CONCAT( TRA_ROLE ) AS arrayRole
                FROM travailler, region
                WHERE region.REG_CODE = travailler.REG_CODE
                AND VIS_MATRICULE = ?
                GROUP BY region.REG_CODE";
              $query = $this->db->query($sql, array($id));
              return $query->result();
          }
          public function regionChoisie($id, $regionId = 0){
              $sql = "SELECT region.REG_CODE AS code, REG_NOM, GROUP_CONCAT( TRA_ROLE ) AS arrayRole
                FROM travailler, region
                WHERE region.REG_CODE = travailler.REG_CODE
                AND VIS_MATRICULE = ?
                AND region.REG_CODE = ?
                GROUP BY region.REG_CODE";
              $query = $this->db->query($sql, array($id, $regionId));
              $resultat = $query->result();
              if(!isset($resultat[0])){
                  $sql = "SELECT region.REG_CODE AS code, REG_NOM, GROUP_CONCAT( TRA_ROLE ) AS arrayRole
                    FROM travailler, region
                    WHERE region.REG_CODE = travailler.REG_CODE
                    AND VIS_MATRICULE = ?
                
                    GROUP BY region.REG_CODE";
                    $query = $this->db->query($sql, array($id));
              }
              return $query->result();
          }
      }
      /* End of file blog_model.php */
      /* Location: ./application/models/blog_model.php */

?>