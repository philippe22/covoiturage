<html>

<head>
    <title>Mot de passe oublié</title>
</head>

<body>
    <br>
    <?php
    echo '<div class="container p-5 my-5 border"><h1>Veuillez renseigner votre adresse mail</h1><br>';
    echo form_open('visiteur/changerMDP');
    echo form_label('', 'txtMel');
    echo '<input type="email" placeholder="Mail"' . form_input('txtMel', '', array('pattern' => '[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+.[a-zA-Z.]', 'required' => 'required'));
    echo '<br><br>';
    echo form_submit('<button type="button" class="btn btn-primary"', 'OK');
    echo form_close();
    echo 'Un nouveau mot de passe vous sera envoyé par mail';
    echo '</div>'; ?>
</body>

</html>