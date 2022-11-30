<html>

<head>
    <title>Se connecter</title>
</head>

<body>
    <br>
    <?php
    echo '<div class="container p-5 my-5 border"><h1>Connectez vous</h1><br>';
    echo form_open('visiteur/seConnecter');
    echo form_label('', 'txtMel');
    echo '<input type="email" placeholder="Mail"' . form_input('txtMel', '', array('pattern' => '[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+.[a-zA-Z.]', 'required' => 'required'));
    echo form_label('', 'txtMDP');
    echo '<input type="password" placeholder="Mot de passe"' . form_password('txtMDP');
    echo form_submit('<button type="button" class="btn btn-primary"', 'OK');
    echo form_close();
    ?>
    <a class="nav-link" href="<?php echo site_url('visiteur/creerCompte') ?>">Créer un compte</a>&nbsp;&nbsp;<br>
    <?php
    echo anchor('Visiteur/mdpOublie', 'Mot de passe oublié ?');
    echo '</div>'; ?>
</body>

</html>