<?php
class Admin extends CI_Controller
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
        if ($this->session->identifiant == NULL && $this->session->statut != "Administrateur") {
            $this->load->helper('url');
            redirect('visiteur/accueil');
        }
    }

    public function listeDemande()
    {
        $donnees['lesDemandes'] = $this->ModeleClient->listeDemande();
        $this->load->view('templates/bootstrap');
        $this->load->view('templates/Entete');
        $this->load->view('admin/listeDemande', $donnees);
    }

    public function validerDemande($noClient = NULL)
    {
        $donnees['lesClients'] = $this->ModeleClient->infoCompte($noClient);
        foreach ($donnees['lesClients'] as $client) :
        $this->ModeleClient->validerDemande($noClient);
        $this->load->library('email');

        $this->email->from('bastienroux22@gmail.com', 'CovoituRabelais');
        $this->email->to($client->mail);

        $this->email->subject('Création de votre compte CovoituRabelais');
        $this->email->message('Bonjour. Votre demande de création de compte CovoituRabelais a été accepté. Vous pouvez désormais accéder aux différentes fonctionnalités du site');

        $this->email->send();
        endforeach;
        redirect('admin/listeDemande');
    }

    public function refuserDemande($noClient = NULL)
    {
        $donnees['lesClients'] = $this->ModeleClient->infoCompte($noClient);
        foreach ($donnees['lesClients'] as $client) :
        $this->ModeleClient->refuserDemande($noClient);
        $this->load->library('email');

        $this->email->from('noreply@rabelais.com', 'CovoituRabelais');
        $this->email->to($client->mail);

        $this->email->subject('Création de votre compte CovoituRabelais');
        $this->email->message('Bonjour. Votre demande de création de compte CovoituRabelais a été refusé. Les informations que vous avez renseignées n ont pas été validé par notre équipe.');

        $this->email->send();
        endforeach;
        redirect('admin/listeDemande');
    }
}
