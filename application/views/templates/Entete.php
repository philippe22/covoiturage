<html>

<head>
</head>

<body>
   <nav class="navbar navbar-expand-sm bg-dark sticky-top">
      <div class="container-fluid">
         <ul class="navbar-nav">
            <?php if ($this->session->identifiant != '' && $this->session->statut == 'Client' && $this->session->validation == 'Valide') : ?>
               <?php echo '<p class="bg-dark text-white">Utilisateur connecté : ' . $this->session->identifiant . ' </p></B>&nbsp;&nbsp;'; ?>
               <a class="nav-link text-danger" href="<?php echo site_url('visiteur/seDeconnecter') ?>">Se déconnecter</a>&nbsp;&nbsp;
               <a class="nav-link text-warning" href="<?php echo site_url('client/modifierCompte') ?>">Modifier le compte</a>&nbsp;&nbsp;
               <a class="nav-link text-warning" href="<?php echo site_url('client/creerTrajet') ?>">Creer un trajet</a>&nbsp;&nbsp;
               <a class="nav-link text-warning" href="<?php echo site_url('client/chercherTrajet') ?>">Chercher un trajet</a>&nbsp;&nbsp;
               <a class="nav-link text-warning" href="<?php echo site_url('client/voirReservation') ?>">Voir vos réservations</a>&nbsp;&nbsp;
               <a class="nav-link text-warning" href="<?php echo site_url('client/voirTrajet') ?>">Voir vos trajets</a>&nbsp;&nbsp;
            <?php elseif ($this->session->identifiant != '' && $this->session->statut == 'Administrateur') : ?>
               <?php echo '<p class="bg-dark text-white">Utilisateur connecté : ' . $this->session->identifiant . '</p></B>&nbsp;&nbsp;'; ?>
               <a class="nav-link text-danger" href="<?php echo site_url('visiteur/seDeconnecter') ?>">Se déconnecter</a>&nbsp;&nbsp;
               <a class="nav-link text-warning" href="<?php echo site_url('admin/listeDemande') ?>">Liste des demandes</a>&nbsp;&nbsp;
            <?php elseif ($this->session->identifiant != '' && $this->session->validation == 'En attente' && $this->session->statut == 'Client') : ?>
               <?php echo '<p class="bg-dark text-white">Votre compte est en attente de validation</p></B>&nbsp;&nbsp;'; ?>
               <a class="nav-link text-danger" href="<?php echo site_url('visiteur/seDeconnecter') ?>">Se déconnecter</a>&nbsp;&nbsp;
            <?php else : ?>
               <a class="nav-link text-warning" href="<?php echo site_url('visiteur/seConnecter') ?>">Se Connecter/Créer un compte</a>&nbsp;&nbsp;
            <?php endif; ?>
            <a class="nav-link text-warning" href="<?php echo site_url('visiteur/Accueil') ?>">Retour à l'accueil</a>&nbsp;&nbsp;
         </ul>
      </div>
   </nav>

   <body>

</html>