<?php
class Visiteur extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('assets');
        $this->load->library("pagination");
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('ModeleClient');
    }

    public function Accueil()
    {
        $this->load->view('templates/bootstrap');
        $this->load->view('visiteur/accueil');
        $this->load->view('templates/Entete');
    }

    public function seConnecter()
    {
        $this->form_validation->set_rules('txtMel', 'Mel', 'required');
        $this->form_validation->set_rules('txtMDP', 'MDP', 'required');
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/bootstrap');
            $this->load->view('templates/Entete');
            $this->load->view('visiteur/seConnecter');
        } else {
            $mel = $this->input->post('txtMel');
            $mdp = $this->input->post('txtMDP');
            $client = $this->ModeleClient->connexion($mel, $mdp);
            if (!($client == null)) {
                $this->session->identifiant = $client->prenom;
                $this->session->numeroClient = $client->no_user;
                $this->session->statut = $client->statut;
                $this->session->validation = $client->validation;
                $this->load->helper('url');
                redirect('visiteur/Accueil');
            } else {
                redirect('visiteur/seConnecter');
            }
        }
    }

    public function creerCompte()
    {
        $this->load->view('templates/bootstrap');

        $this->form_validation->set_rules('txtNom', 'Nom', 'required');
        $this->form_validation->set_rules('txtPrenom', 'Prenom', 'required');
        $this->form_validation->set_rules('txtTelephone', 'Telephone', 'required');
        $this->form_validation->set_rules('txtMail', 'Email', 'required');
        $this->form_validation->set_rules('txtMDP', 'MDP', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/Entete');
            $this->load->view('visiteur/creerCompte');
        } else {
            $infoCompte = array(
                'nom' => $this->input->post('txtNom'),
                'prenom' => $this->input->post('txtPrenom'),
                'no_tel' => $this->input->post('txtTelephone'),
                'mail' => $this->input->post('txtMail'),
                'mdp' => $this->input->post('txtMDP'),
                'date_naissance' => $this->input->post('txtDate'),
                'classe' => $this->input->post('txtClasse'),
                'statut' => "Client",
                'validation' => "En attente"
            );
            $this->ModeleClient->creerCompte($infoCompte);
            $this->load->helper('url');
            redirect('visiteur/Accueil');
        }
    }

    public function seDeconnecter()
    {
        $this->session->sess_destroy('identifiant');
        $this->session->sess_destroy('numeroClient');
        $this->session->sess_destroy('statut');
        redirect('visiteur/Accueil');
    }

    public function mdpOublie()
    {
        $this->load->view('templates/bootstrap');
        $this->load->view('templates/Entete');
        $this->load->view('visiteur/mdpOublie');
    }

    public function changerMDP()
    {
        $this->load->view('templates/bootstrap');

        $this->form_validation->set_rules('txtMel', 'Mel', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/Entete');
            $this->load->view('visiteur/mdpOublie');
        } else {
            $bytes = openssl_random_pseudo_bytes(4);
            $pass = bin2hex($bytes);
            $mail = $this->input->post('txtMel');
            $donnees['infoCompte'] = $this->ModeleClient->infoCompteMail($mail);
            $infoModifier = array(
                'nom' => $donnees['infoCompte']->nom,
                'prenom' => $donnees['infoCompte']->prenom,
                'no_tel' => $donnees['infoCompte']->no_tel,
                'mail' => $donnees['infoCompte']->mail,
                'mdp' => $pass,
                'date_naissance' => $donnees['infoCompte']->date_naissance,
                'classe' => $donnees['infoCompte']->classe,
                'statut' => "Client",
                'validation' => "Valide"
            );
            $this->ModeleClient->modifierCompteMail($infoModifier, $mail);
            $this->load->library('email');

            $this->email->from('noreply@rabelais.com', 'CovoituRabelais');
            $this->email->to($mail);

            $this->email->subject('Nouveau mot de passe');
            $this->email->message('Bonjour. Voici votre nouveau mot de passe : ' . $pass . '. Il est fortement recommandé de le changer à nouveau dans : "Modifier Compte".');

            $this->email->send();
            redirect('visiteur/Accueil');
        }
    }
}
