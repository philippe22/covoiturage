<?php
class ModeleTrajet extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    public function creerTrajet($infoTrajet)
    {
        $this->db->insert('trajet', $infoTrajet);
        return $this->db->insert_id();
    }

    public function etape($infoEtape)
    {
        $this->db->insert('passe_par', $infoEtape);
    }

    public function renouveler($infoRenouveler)
    {
        $this->db->insert('renouveler', $infoRenouveler);
    }

    public function trajetHebdo($noTrajet)
    {
        $this->db->insert('trajethebdomadaire', $noTrajet);
    }

    public function trajetPonctuel($infoPonctuel)
    {
        $this->db->insert('trajetPonctuel', $infoPonctuel);
    }

    public function chercherTrajetDepart($jour, $ville, $date)
    {
        $this->db->select('nbPlacesProposees, pd.notrajet as notrajet, d.ville_nom as depart, a.ville_nom as arrivee, pd.heure as heure_depart, pa.heure as heure_arrivee, trajet.no_user');
        $this->db->from('passe_par pd');
        $this->db->join('villes_bretagne d', 'd.ville_id = pd.ville_id');
        $this->db->join('passe_par pa', 'pa.notrajet = pd.notrajet');
        $this->db->join('villes_bretagne a', 'a.ville_id = pa.ville_id');
        $this->db->join('trajet', 'pd.notrajet = trajet.notrajet');
        $this->db->join('renouveler', 'trajet.notrajet = renouveler.notrajet');
        $this->db->join('jour', 'renouveler.noJour = jour.noJour');
        $this->db->where('nomJour', $jour);
        $this->db->where('d.ville_nom', $ville);
        $this->db->where('a.ville_nom', 'saint-brieuc');
        $this->db->where('trajet.actif', 1);
        $requete1 = $this->db->get()->result();

        $this->db->select('nbPlacesProposees, pd.notrajet as notrajet, d.ville_nom as depart, a.ville_nom as arrivee, pd.heure as heure_depart, pa.heure as heure_arrivee, trajet.no_user');
        $this->db->from('passe_par pd');
        $this->db->join('villes_bretagne d', 'd.ville_id = pd.ville_id');
        $this->db->join('passe_par pa', 'pa.notrajet = pd.notrajet');
        $this->db->join('villes_bretagne a', 'a.ville_id = pa.ville_id');
        $this->db->join('trajet', 'pd.notrajet = trajet.notrajet');
        $this->db->join('trajetponctuel', 'trajet.notrajet = trajetponctuel.notrajet');
        $this->db->where('dateEffectiveDuTrajet', $date);
        $this->db->where('d.ville_nom', $ville);
        $this->db->where('a.ville_nom', 'saint-brieuc');
        $this->db->where('trajet.actif', 1);
        $requete2 = $this->db->get()->result();

        $query = array_merge($requete1, $requete2);
        return $query;
    }

    public function chercherTrajetArrivee($jour, $ville, $date)
    {
        $this->db->select('nbPlacesProposees, pd.notrajet as notrajet, d.ville_nom as depart, a.ville_nom as arrivee, pd.heure as heure_depart, pa.heure as heure_arrivee, trajet.no_user');
        $this->db->from('passe_par pd');
        $this->db->join('villes_bretagne d', 'd.ville_id = pd.ville_id');
        $this->db->join('passe_par pa', 'pa.notrajet = pd.notrajet');
        $this->db->join('villes_bretagne a', 'a.ville_id = pa.ville_id');
        $this->db->join('trajet', 'pd.notrajet = trajet.notrajet');
        $this->db->join('renouveler', 'trajet.notrajet = renouveler.notrajet');
        $this->db->join('jour', 'renouveler.noJour = jour.noJour');
        $this->db->where('nomJour', $jour);
        $this->db->where('d.ville_nom', 'saint-brieuc');
        $this->db->where('a.ville_nom', $ville);
        $this->db->where('trajet.actif', 1);
        $requete1 = $this->db->get()->result();

        $this->db->select('nbPlacesProposees, pd.notrajet as notrajet, d.ville_nom as depart, a.ville_nom as arrivee, pd.heure as heure_depart, pa.heure as heure_arrivee, trajet.no_user');
        $this->db->from('passe_par pd');
        $this->db->join('villes_bretagne d', 'd.ville_id = pd.ville_id');
        $this->db->join('passe_par pa', 'pa.notrajet = pd.notrajet');
        $this->db->join('villes_bretagne a', 'a.ville_id = pa.ville_id');
        $this->db->join('trajet', 'pd.notrajet = trajet.notrajet');
        $this->db->join('trajetponctuel', 'trajet.notrajet = trajetponctuel.notrajet');
        $this->db->where('dateEffectiveDuTrajet', $date);
        $this->db->where('d.ville_nom', 'saint-brieuc');
        $this->db->where('a.ville_nom', $ville);
        $this->db->where('trajet.actif', 1);
        $requete2 = $this->db->get()->result();

        $query = array_merge($requete1, $requete2);
        return $query;
    }

    public function infoTrajet($notrajet, $jour, $date)
    {
        $this->db->select('notrajet');
        $this->db->from('trajethebdomadaire');
        $this->db->where('notrajet', $notrajet);
        $requete = $this->db->get();
        if ($requete->result() != NULL) {
            $this->db->select('ville_nom, heure, nbPlacesProposees, passe_par.notrajet');
            $this->db->from('passe_par');
            $this->db->join('villes_bretagne', 'passe_par.ville_id = villes_bretagne.ville_id');
            $this->db->join('trajet', 'passe_par.notrajet = trajet.notrajet');
            $this->db->join('renouveler', 'renouveler.notrajet = trajet.notrajet');
            $this->db->join('jour', 'jour.nojour = renouveler.nojour');
            $this->db->where('trajet.notrajet', $notrajet);
            $this->db->where('jour.nomjour', $jour);
            $this->db->order_by('heure', 'ASC');
            $requete = $this->db->get();
            $this->session->type = 1;
            return $requete->result();
        } else {
            $this->db->select('villes_bretagne.ville_nom, passe_par.heure, trajetponctuel.nbPlacesProposees, passe_par.notrajet');
            $this->db->from('passe_par');
            $this->db->join('villes_bretagne', 'passe_par.ville_id = villes_bretagne.ville_id');
            $this->db->join('trajet', 'passe_par.notrajet = trajet.notrajet');
            $this->db->join('trajetponctuel', 'trajetponctuel.notrajet = trajet.notrajet');
            $this->db->where('passe_par.notrajet', $notrajet);
            $this->db->where('trajetponctuel.dateEffectiveDuTrajet', $date);
            $this->db->order_by('heure', 'ASC');
            $requete = $this->db->get();
            $this->session->type = 0;
            return $requete->result();
        }
    }

    public function nombrePlace($notrajet)
    {
        $this->db->select('notrajet');
        $this->db->from('choisir_h');
        $this->db->where('notrajet', $notrajet);
        $requete = $this->db->get();
        if ($requete->result() != NULL) {
            $this->db->select('choisir_h.notrajet');
            $this->db->from('choisir_h');
            $this->db->join('trajet', 'choisir_h.notrajet = trajet.notrajet');
            $this->db->where('choisir_h.notrajet', $notrajet);
            $requete = $this->db->count_all_results();
            return $requete;
        } else {
            $this->db->select('choisir_p.notrajet');
            $this->db->from('choisir_p');
            $this->db->join('trajet', 'choisir_p.notrajet = trajet.notrajet');
            $this->db->where('choisir_p.notrajet', $notrajet);
            $requete = $this->db->count_all_results();
            return $requete;
        }
    }

    public function reserverTrajetP($notrajet, $ville_id)
    {
        $this->db->select('notrajet');
        $this->db->from('choisir_p');
        $this->db->where('notrajet', $notrajet);
        $this->db->where('no_user',  $this->session->numeroClient);
        $requete = $this->db->get();
        if ($requete->result() == NULL) {
            $info = array(
                'noTrajet' => $notrajet,
                'no_user' => $this->session->numeroClient,
                'ville_id' => $ville_id
            );
            $this->db->insert('choisir_p', $info);
        }
    }

    public function reserverTrajetH($notrajet, $ville_id, $nojour)
    {
        $this->db->select('notrajet');
        $this->db->from('choisir_h');
        $this->db->where('notrajet', $notrajet);
        $this->db->where('no_user',  $this->session->numeroClient);
        $this->db->where('nojour',  $nojour);
        $requete = $this->db->get();
        if ($requete->result() == NULL) {
            $info = array(
                'noTrajet' => $notrajet,
                'no_user' => $this->session->numeroClient,
                'ville_id' => $ville_id,
                'noJour' => $nojour
            );
            $this->db->insert('choisir_h', $info);
        }
    }

    public function voirTrajetsH()
    {
        $this->db->select('trajet.notrajet, actif, ville_nom, heure, nomjour');
        $this->db->from('trajet');
        $this->db->join('passe_par', 'passe_par.notrajet = trajet.notrajet');
        $this->db->join('villes_bretagne', 'villes_bretagne.ville_id = passe_par.ville_id');
        $this->db->join('renouveler', 'renouveler.notrajet = trajet.notrajet');
        $this->db->join('jour', 'jour.nojour = renouveler.nojour');
        $this->db->where('no_user', $this->session->numeroClient);
        $this->db->order_by('trajet.notrajet', 'ASC');
		$this->db->order_by('renouveler.nojour', 'ASC');
		$this->db->order_by('passe_par.heure', 'ASC');
        $requete = $this->db->get();
        return $requete->result();
    }

    public function voirTrajetsP()
    {
        $this->db->select('trajet.notrajet, actif, ville_nom, heure, dateEffectiveDuTrajet');
        $this->db->from('trajet');
        $this->db->join('passe_par', 'passe_par.notrajet = trajet.notrajet');
        $this->db->join('villes_bretagne', 'villes_bretagne.ville_id = passe_par.ville_id');
        $this->db->join('trajetponctuel', 'trajetponctuel.notrajet = trajet.notrajet');
        $this->db->where('no_user', $this->session->numeroClient);
        $this->db->order_by('trajet.notrajet', 'ASC');
		$this->db->order_by('passe_par.heure', 'ASC');
        $requete = $this->db->get();
        return $requete->result();
    }

    public function desactiverTrajet($notrajet)
    {
        $this->db->where('notrajet', $notrajet);
        $this->db->update('trajet', array('actif' => 0));
    }

    public function activerTrajet($notrajet)
    {
        $this->db->where('notrajet', $notrajet);
        $this->db->update('trajet', array('actif' => 1));
    }

    public function nombrePlaceHebdo($notrajet)
    {
        $this->db->select('nbPlacesProposees, renouveler.nojour, nomjour');
        $this->db->from('renouveler');
        $this->db->join('jour', 'jour.nojour = renouveler.nojour');
        $this->db->where('notrajet', $notrajet);
        $requete = $this->db->get();
        return $requete->result();
    }

    public function nombrePlaceHebdoPrise($notrajet, $i)
    {
        $this->db->select('notrajet');
        $this->db->from('choisir_h');
        $this->db->where('notrajet', $notrajet);
        $this->db->where('nojour', $i);
        $requete = $this->db->count_all_results();
        return $requete;
    }
}
