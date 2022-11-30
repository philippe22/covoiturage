<html>

<head>
    <title>Modifier le compte</title>

    <head>

    <body>
        <?php foreach ($lesInfos as $uneInfo) :
            echo '<div class="container p-5 my-5 border"><div class="container pt-1"><h1>Modifiez votre compte</h1></div><br>';

            echo form_open('client/modifierCompte');
            echo form_label('Nom : ', 'txtNom');
            echo form_input('txtNom', $uneInfo->nom, array('pattern' => '[A-Z]*', 'required' => 'required', 'title' => 'Saisir des lettres majuscule uniquement'));

            echo form_label('Prenom : ', 'txtPrenom');
            echo form_input('txtPrenom', $uneInfo->prenom, array('pattern' => '[A-ZÀ-ÿ]+[a-zÀ-ÿ]*', 'required' => 'required', 'title' => 'Saisir des lettres uniquement (Commence par une majuscule)'));

        ?><br><br>
        <?php
            echo form_label('Numéro de telephone : ', 'txtTelephone');
            echo '<input type="tel"' . form_input('txtTelephone', $uneInfo->no_tel, array('pattern' => '[0-9]{10}', 'required' => 'required', 'title' => 'Saisir des numéros uniquement'));

            echo form_label('Classe : ', 'txtClasse');
            echo form_input('txtClasse', $uneInfo->classe);

            echo '<br><br>';
            echo form_label('Mail : ', 'txtMail');
            echo '<input type="email"' . form_input('txtMail', $uneInfo->mail, array('required' => 'required'));

            echo form_label('Mot de passe : ', 'txtMDP');
            echo form_password('txtMDP', $uneInfo->mdp, array('pattern' => '.{8,}', 'required' => 'required'));
            echo form_submit('<button type="button" class="btn btn-primary"', 'Modifier');

            echo form_close();
        endforeach;
        echo '</div>';
        ?>
    </body>

</html>