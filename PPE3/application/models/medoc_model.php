<?php
class medoc_model extends CI_Model{
    function get_medoc()
    {
        $this->load->database();
        $query = $this->db->query('Select * from medicament order by 2 ');

        return $query;

    }
    function getUn_medoc($num = 0)
    {
        
        $this->load->database();
        
        //$query = $this->db->query('Select * from medicament');
        $this->db->select('MED_DEPOTLEGAL, MED_NOMCOMMERCIAL, MED_COMPOSITION, MED_EFFETS, MED_CONTREINDIC, MED_PRIXECHANTILLON, FAM_LIBELLE');
        $this->db->from('medicament ');
        //$this->db->where('medicament.FAM_CODE=famille.FAM_CODE');
        $this->db->join('famille', 'medicament.FAM_CODE=famille.FAM_CODE');
        $this->db->where('MED_DEPOTLEGAL', $num); 
        $query_user = $this->db->get();
        
        return $query_user->result();

    }
}
?>