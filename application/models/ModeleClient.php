<?php
class ModeleClient extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    public function connexion($mail, $motdepasse)
    {
        $requete = $this->db->get_where('utilisateur', array('mail' => $mail, 'mdp' => $motdepasse));
        return $requete->row();
    }

    public function creerCompte($infoCompte)
    {
        $this->db->insert('utilisateur', $infoCompte);
    }

    public function infoCompte($noClient)
    {
        $this->db->select('nom, prenom, no_tel, mail, mdp, classe');
        $this->db->from('utilisateur');
        $this->db->where('no_user', $noClient);
        $requete = $this->db->get();
        return $requete->result();
    }

    public function infoCompteMail($mail)
    {
        $this->db->select('nom, prenom, no_tel, mail, mdp, classe');
        $this->db->from('utilisateur');
        $this->db->where('mail', $mail);
        $requete = $this->db->get();
        return $requete->result();
    }

    public function modifierCompte($infoCompte)
    {
        $this->db->where('no_user', $this->session->numeroClient);
        $this->db->update('utilisateur', $infoCompte);
    }

    public function modifierCompteMail($infoCompte, $mail)
    {
        $this->db->where('mail', $mail);
        $this->db->update('utilisateur', $infoCompte);
    }

    public function voirReservationH()
    {
        $this->db->select('choisir_h.notrajet, choisir_h.noJour, jour.nomJour, villes_bretagne.ville_nom, passe_par.heure, trajet.no_user');
        $this->db->from('choisir_h, utilisateur');
        $this->db->join('passe_par', 'passe_par.noTrajet = choisir_h.notrajet');
        $this->db->join('villes_bretagne', 'villes_bretagne.ville_id = passe_par.ville_id');
        $this->db->join('jour', 'jour.noJour = choisir_h.noJour');
        $this->db->join('trajet', 'trajet.noTrajet = choisir_h.notrajet');
        $this->db->where('utilisateur.no_user', $this->session->numeroClient);
        $this->db->order_by('choisir_h.noJour', 'ASC');
        $this->db->order_by('passe_par.heure', 'ASC');
        $requete = $this->db->get();
        return $requete->result();
    }

    public function voirReservationP()
    {
        $this->db->select('choisir_p.notrajet, trajetponctuel.dateEffectiveDuTrajet, villes_bretagne.ville_nom, passe_par.heure, trajet.no_user');
        $this->db->from('choisir_p, utilisateur');
        $this->db->join('passe_par', 'passe_par.noTrajet = choisir_p.noTrajet');
        $this->db->join('villes_bretagne', 'villes_bretagne.ville_id = passe_par.ville_id');
        $this->db->join('trajetponctuel', 'trajetponctuel.notrajet = trajetponctuel.notrajet');
        $this->db->join('trajet', 'trajet.noTrajet = choisir_p.notrajet');
        $this->db->where('utilisateur.no_user', $this->session->numeroClient);
        $this->db->order_by('trajetponctuel.dateEffectiveDuTrajet', 'ASC');
        $this->db->order_by('passe_par.heure', 'ASC');
        $requete = $this->db->get();
        return $requete->result();
    }

    public function annulerReservation($notrajet, $noJour)
    {
        $this->db->select('notrajet');
        $this->db->from('choisir_h');
        $this->db->where('notrajet', $notrajet);
        $requete = $this->db->get();
        if ($requete->result() != NULL) {
            $this->db->delete('choisir_h', array('no_user' => $this->session->numeroClient, 'notrajet' => $notrajet, 'noJour' => $noJour));
        } else {
            $this->db->delete('choisir_p', array('no_user' => $this->session->numeroClient, 'notrajet' => $notrajet));
        }
    }

    public function listeDemande()
    {
        $this->db->select('no_tel, mail, prenom, nom, date_naissance, classe, no_user');
        $this->db->from('utilisateur');
        $this->db->where('validation', 'En attente');
        $requete = $this->db->get();
        return $requete->result();
    }

    public function validerDemande($noClient)
    {
        $this->db->set('validation', 'Valide');
        $this->db->where('no_user', $noClient);
        $this->db->update('utilisateur');
    }

    public function refuserDemande($noClient)
    {
        $this->db->set('validation', 'Refuser');
        $this->db->where('no_user', $noClient);
        $this->db->update('utilisateur');
    }
}
