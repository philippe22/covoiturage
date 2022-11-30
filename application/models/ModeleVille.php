<?php
class ModeleVille extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    public function listerVilles()
    {
        $this->db->select('ville_nom');
        $this->db->from('villes_bretagne');
        $requete = $this->db->get();
        return $requete->result();
    }

    public function retournerNoVille($ville)
    {
        $requete = $this->db->get_where('villes_bretagne', array('ville_nom' => $ville));
        return $requete->row();
    }
}
