<html>

<body>
    <?php
    echo '<div class="container p-5 my-5 border"><h1>Créez votre compte</h1><br>';

    echo form_open('visiteur/creerCompte');
    echo form_label('* Nom : ', 'txtNom');
    echo '<input placeholder="NOM"' . form_input('txtNom', '', array('pattern' => '[A-Z]*', 'required' => 'required', 'title' => 'Saisir des lettres majuscule uniquement'));

    echo form_label('* Prenom : ', 'txtPrenom');
    echo '<input placeholder="Prenom"' . form_input('txtPrenom', '', array('pattern' => '[A-Z]+[a-z]*', 'required' => 'required', 'title' => 'Saisir des lettres uniquement (Commence par une majuscule)'));

    ?><br><br>
    <?php
    echo form_label('* Numéro de telephone : ', 'txtTelephone');
    echo '<input type="tel" placeholder="0000000000"' . form_input('txtTelephone', '', array('pattern' => '[0-9]{10}', 'required' => 'required'));

    echo form_label('Date de naissance : ', 'txtDate');
    echo '<input type="date"' . form_input('txtDate', '');
    echo '<br><br>';

    echo form_label('Classe : ', 'txtClasse');
    echo '<input placeholder="Classe"' . form_input('txtClasse', '');

    ?><br><br>
    <?php echo form_label('* Mail : ', 'txtMail');
    echo '<input type="email" placeholder="exemple@exemple.exemple"' . form_input('txtMail', '', array('pattern' => '[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+.[a-zA-Z.]', 'required' => 'required'));

    echo form_label('* Mot de passe : ', 'txtMDP');
    echo form_password('txtMDP', '', array('pattern' => '.{8,}', 'required' => 'required'));
    echo form_submit('<button type="button" class="btn btn-primary"', 'Créer');

    echo '<br><br>Les champs avec une * sont obligatoires';

    echo form_close();
    ?>
</body>

</html>