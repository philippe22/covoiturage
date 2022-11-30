<?php
class Client extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('assets');
        $this->load->library("pagination");
        $this->load->library('form_validation');
        $this->load->model('ModeleClient');
        $this->load->model('ModeleTrajet');
        $this->load->model('ModeleVille');
        if ($this->session->identifiant == NULL  or $this->session->validation == 'En attente') {
            $this->load->helper('url');
            redirect('visiteur/accueil');
        }
    }

    public function modifierCompte()
    {
        $this->load->view('templates/bootstrap');

        $this->form_validation->set_rules('txtNom', 'Nom', 'required');
        $this->form_validation->set_rules('txtPrenom', 'Prenom', 'required');
        $this->form_validation->set_rules('txtTelephone', 'Telephone', 'required');
        $this->form_validation->set_rules('txtMail', 'Email', 'required');
        $this->form_validation->set_rules('txtMDP', 'MDP', 'required');

        if ($this->form_validation->run() === FALSE) {
            $donnees['lesInfos'] = $this->ModeleClient->infoCompte($this->session->numeroClient);
            $this->load->view('templates/Entete');
            $this->load->view('client/modifierCompte', $donnees);
        } else {
            $infoCompte = array(
                'nom' => $this->input->post('txtNom'),
                'prenom' => $this->input->post('txtPrenom'),
                'no_tel' => $this->input->post('txtTelephone'),
                'mail' => $this->input->post('txtMail'),
                'mdp' => $this->input->post('txtMDP'),
                'classe' => $this->input->post('txtClasse')
            );
            $this->ModeleClient->modifierCompte($infoCompte);
            $this->load->helper('url');
            $this->session->sess_destroy('identifiant');
            $this->session->sess_destroy('numeroClient');
            $this->session->sess_destroy('statut');
            redirect('visiteur/accueil');
        }
    }

    public function creerTrajet()
    {
        $this->load->view('templates/bootstrap');

        $this->form_validation->set_rules('txtDepart', 'depart', 'required');
        $this->form_validation->set_rules('txtArrivee', 'arrivee', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/Entete');
            $donnees['lesVilles'] = $this->ModeleVille->listerVilles();
            $this->load->view('client/creerTrajet', $donnees);
        } else {
            $villeDepart = $this->input->post('txtDepart');
            $villeArrivee = $this->input->post('txtArrivee');
            $hebdo = $this->input->post('txtCheck');
            $date = date("Y-m-d");

            //hebdomadaire
            if ($hebdo != NULL) {
                $infoTrajet = array(
                    'no_user' => $this->session->numeroClient,
                    'dateMiseEnLigneTrajet' => $date,
                    'actif' => 1
                );
                $noTrajet = $this->ModeleTrajet->creerTrajet($infoTrajet);
                $hebdo = array(
                    'noTrajet' => $noTrajet
                );
                $this->ModeleTrajet->trajetHebdo($hebdo);
                $no_ville = $this->ModeleVille->retournerNoVille($villeDepart);
                $depart = array(
                    'noTrajet' => $noTrajet,
                    'ville_id' => $no_ville->ville_id,
                    'heure' => $this->input->post('txtHeureDepart') . ':' . $this->input->post('txtMinuteDepart') . ':00'
                );
                $this->ModeleTrajet->etape($depart);
                $no_ville = $this->ModeleVille->retournerNoVille($villeArrivee);
                $arrivee = array(
                    'noTrajet' => $noTrajet,
                    'ville_id' => $no_ville->ville_id,
                    'heure' => $this->input->post('txtHeureArrivee') . ':' . $this->input->post('txtMinuteArrivee') . ':00'
                );
                $this->ModeleTrajet->etape($arrivee);

                for ($i = 1; $i <= 1000; $i++) {
                    if ($this->input->post('txtVille' . $i) != NULL) {
                        $villeEtape = $this->input->post('txtVille' . $i);
                        $no_ville = $this->ModeleVille->retournerNoVille($villeEtape);
                        $etape = array(
                            'notrajet' => $noTrajet,
                            'ville_id' => $no_ville->ville_id,
                            'heure' => $this->input->post('txtHeure' . $i) . ':' . $this->input->post('txtMinute' . $i) . ':00'
                        );
                        $this->ModeleTrajet->etape($etape);
                    } else {
                        break;
                    }
                }

                for ($i = 1; $i <= 6; $i++) {
                    if ($this->input->post('txtJour' . $i) != NULL) {
                        $infoRenouveler = array(
                            'notrajet' => $noTrajet,
                            'noJour' => $this->input->post('txtJour' . $i),
                            'nbPlacesProposees' => $this->input->post('txtPlace' . $i)
                        );
                        $this->ModeleTrajet->renouveler($infoRenouveler);
                    }
                }

                //non hebdomadaire
            } else {
                $infoTrajet = array(
                    'no_user' => $this->session->numeroClient,
                    'dateMiseEnLigneTrajet' => $date,
                    'actif' => 1
                );
                $noTrajet = $this->ModeleTrajet->creerTrajet($infoTrajet);
                $infoPonctuel = array(
                    'noTrajet' => $noTrajet,
                    'dateEffectiveDuTrajet' => $this->input->post('txtDate'),
                    'nbPlacesProposees' => $this->input->post('txtPlace')
                );
                $this->ModeleTrajet->trajetPonctuel($infoPonctuel);

                $no_ville = $this->ModeleVille->retournerNoVille($villeDepart);
                $depart = array(
                    'noTrajet' => $noTrajet,
                    'ville_id' => $no_ville->ville_id,
                    'heure' => $this->input->post('txtHeureDepart') . ':' . $this->input->post('txtMinuteDepart') . ':00'
                );
                $this->ModeleTrajet->etape($depart);
                $no_ville = $this->ModeleVille->retournerNoVille($villeArrivee);
                $arrivee = array(
                    'noTrajet' => $noTrajet,
                    'ville_id' => $no_ville->ville_id,
                    'heure' => $this->input->post('txtHeureArrivee') . ':' . $this->input->post('txtMinuteArrivee') . ':00'
                );
                $this->ModeleTrajet->etape($arrivee);

                for ($i = 1; $i <= 1000; $i++) {
                    if ($this->input->post('txtVille' . $i) != NULL) {
                        $villeEtape = $this->input->post('txtVille' . $i);
                        $no_ville = $this->ModeleVille->retournerNoVille($villeEtape);
                        $etape = array(
                            'notrajet' => $noTrajet,
                            'ville_id' => $no_ville->ville_id,
                            'heure' => $this->input->post('txtHeure' . $i) . ':' . $this->input->post('txtMinute' . $i) . ':00'
                        );
                        $this->ModeleTrajet->etape($etape);
                    } else {
                        break;
                    }
                }
            }
            redirect('visiteur/accueil');
        }
    }

    public function chercherTrajet()
    {
        $this->load->view('templates/bootstrap');

        $this->form_validation->set_rules('txtDate', 'date', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/bootstrap');
            $this->load->view('templates/Entete');
            $donnees['lesVilles'] = $this->ModeleVille->listerVilles();
            $this->load->view('client/chercherTrajet', $donnees);
        } else {
            if ($this->input->post('txtDepart') != NULL) {
                $this->session->choix = 'depart';
                $ville = $this->input->post('txtDepart');
                $date = $this->input->post('txtDate');
                $jour =  date('D', strtotime($date));
                if ($jour == 'Mon') {
                    $jour = "Lundi";
                } else if ($jour == 'Tue') {
                    $jour = "Mardi";
                } else if ($jour == 'Wed') {
                    $jour = "Mercredi";
                } else if ($jour == 'Thu') {
                    $jour = "Jeudi";
                } else if ($jour == 'Fri') {
                    $jour = "Vendredi";
                } else if ($jour == 'Sat') {
                    $jour = "Samedi";
                }
                $rendu = 0;
                $renduHebdo = 0;
                $donnees['lesTrajets'] = $this->ModeleTrajet->chercherTrajetDepart($jour, $ville, $date);
                foreach ($donnees['lesTrajets'] as $trajet) :
                    $rendu += 1;
                    $donnees['infoTrajet'][$rendu] = $this->ModeleTrajet->infoTrajet($trajet->notrajet, $jour, $date);
                    $donnees['nombrePlaceRes'][$rendu] = $this->ModeleTrajet->nombrePlace($trajet->notrajet);
                    if ($this->session->type == 1) {
                        $donnees['type'][$rendu] = 1;
                        $renduHebdo += 1;
                        $donnees['nombrePlaceHebdo'][$renduHebdo] = $this->ModeleTrajet->nombrePlaceHebdo($trajet->notrajet);
                        for ($i = 0; $i < 6; $i++) {
                            $donnees['nombrePlaceHebdoPrise'][$renduHebdo][$i] = $this->ModeleTrajet->nombrePlaceHebdoPrise($trajet->notrajet, $i);
                        }
                    } else {
                        $donnees['type'][$rendu] = 0;
                    }
                endforeach;
                $donnees['date'] = $date;
                $donnees['ville'] = $ville;
                $this->load->view('templates/Entete');
                $this->load->view('client/afficherTrajets', $donnees);
            } else {
                $this->session->choix = 'arrivee';
                $ville = $this->input->post('txtArrivee');
                $date = $this->input->post('txtDate');
                $jour =  date('D', strtotime($date));
                if ($jour == 'Mon') {
                    $jour = "Lundi";
                } else if ($jour == 'Tue') {
                    $jour = "Mardi";
                } else if ($jour == 'Wed') {
                    $jour = "Mercredi";
                } else if ($jour == 'Thu') {
                    $jour = "Jeudi";
                } else if ($jour == 'Fri') {
                    $jour = "Vendredi";
                } else if ($jour == 'Sat') {
                    $jour = "Samedi";
                }
                $rendu = 0;
                $renduHebdo = 0;
                $donnees['lesTrajets'] = $this->ModeleTrajet->chercherTrajetArrivee($jour, $ville, $date);
                foreach ($donnees['lesTrajets'] as $trajet) :
                    $rendu += 1;
                    $donnees['infoTrajet'][$rendu] = $this->ModeleTrajet->infoTrajet($trajet->notrajet, $jour, $date);
                    $donnees['nombrePlaceRes'][$rendu] = $this->ModeleTrajet->nombrePlace($trajet->notrajet);
                    if ($this->session->type == 1) {
                        $donnees['type'][$rendu] = 1;
                        $renduHebdo += 1;
                        $donnees['nombrePlaceHebdo'][$renduHebdo] = $this->ModeleTrajet->nombrePlaceHebdo($trajet->notrajet);
                        for ($i = 0; $i < 6; $i++) {
                            $donnees['nombrePlaceHebdoPrise'][$renduHebdo][$i] = $this->ModeleTrajet->nombrePlaceHebdoPrise($trajet->notrajet, $i);
                        }
                    } else {
                        $donnees['type'][$rendu] = 0;
                    }
                endforeach;
                $donnees['date'] = $date;
                $donnees['ville'] = $ville;
                $this->load->view('templates/Entete');
                $this->load->view('client/afficherTrajets', $donnees);
            }
        }
    }

    public function infoTrajet($notrajet = NULL)
    {
        $this->load->view('templates/bootstrap');
        $donnees['notrajet'] = $notrajet;
        $donnees['infoTrajet'] = $this->ModeleTrajet->infoTrajet($notrajet);
        $donnees['nombrePlaceRes'] = $this->ModeleTrajet->nombrePlace($notrajet);
        $this->load->view('templates/Entete');
        $this->load->view('client/infoTrajet', $donnees);
    }

    public function reserverTrajet($notrajet, $ville, $type, $noClient)
    {
        $noVille = $this->ModeleVille->retournerNoVille($ville);
        if ($type == 0) {
            $this->ModeleTrajet->reserverTrajetP($notrajet, $noVille->ville_id);
        } else {
            for ($i = 1; $i <= 6; $i++) {
                if ($this->input->post('txtCheck' . $i) != NULL) {
                    $this->ModeleTrajet->reserverTrajetH($notrajet, $noVille->ville_id, $i);
                }
            }
        }
        $donnees['lesClients'] = $this->ModeleClient->infoCompte($noClient);
        foreach ($donnees['lesClients'] as $client) :
            $this->load->library('email');

            $this->email->from('noreply@rabelais.com', 'CovoituRabelais');
            $this->email->to($client->mail);

            $this->email->subject('Réservation sur votre trajet');
            $this->email->message('Bonjour. Une réservation à été effectuer pour votre trajet n°' . $notrajet . '. Pour plus d informations sur votre nouveau client, consulter le site en ligne.');

            $this->email->send();
            redirect('client/chercherTrajet');

        endforeach;
    }

    public function voirReservation()
    {
        $donnees['lesReservationsH'] = $this->ModeleClient->voirReservationH();
        $donnees['lesReservationsP'] = $this->ModeleClient->voirReservationP();
        $this->load->view('templates/bootstrap');
        $this->load->view('templates/Entete');
        $this->load->view('client/voirReservation', $donnees);
    }

    public function annulerReservation($notrajet, $noJour = NULL, $noClient = NULL)
    {
        $donnees['lesClients'] = $this->ModeleClient->infoCompte($noClient);
        $this->ModeleClient->annulerReservation($notrajet, $noJour);
        foreach ($donnees['lesClients'] as $client) :
            $this->load->library('email');

            $this->email->from('noreply@rabelais.com', 'CovoituRabelais');
            $this->email->to($client->mail);

            $this->email->subject('Annulation de réservation sur votre trajet');
            $this->email->message('Bonjour. Une annulation de réservation à été effectuer pour votre trajet n°' . $notrajet . '.');

            $this->email->send();
        endforeach;
        redirect('client/voirReservation');
    }

    public function voirTrajet()
    {
        $donnees['lesTrajetsH'] = $this->ModeleTrajet->voirTrajetsH();
        $donnees['lesTrajetsP'] = $this->ModeleTrajet->voirTrajetsP();
        $this->load->view('templates/bootstrap');
        $this->load->view('templates/Entete');
        $this->load->view('client/voirTrajet', $donnees);
    }

    public function desactiverTrajet($notrajet)
    {
        $this->ModeleTrajet->desactiverTrajet($notrajet);
        redirect('client/voirTrajet');
    }

    public function activerTrajet($notrajet)
    {
        $this->ModeleTrajet->activerTrajet($notrajet);
        redirect('client/voirTrajet');
    }
}
