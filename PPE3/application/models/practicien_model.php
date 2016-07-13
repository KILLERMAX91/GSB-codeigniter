<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
      class Practicien_model extends CI_Model {

          function get_practicien() {
              $sql = "SELECT * FROM praticien order by 2";

              $query = $this->db->query($sql);
              //$query = $this->db->get_where("praticien");
              return $query->result();
          }
        public function unPracticien($num){
            $sql = "SELECT * FROM praticien WHERE PRA_NUM = ?";
            $query = $this->db->query($sql, array($num));
            return $query->result();
        }
         //function get_practicien_next() {
         //     $sql = "SELECT * FROM praticien order by 2";

         //     $query = $this->db->query($sql);
         //     //$query = $this->db->get_where("praticien");
         //     return $query->result();
         // }

      }
      /* End of file blog_model.php */
      /* Location: ./application/models/blog_model.php */

?>