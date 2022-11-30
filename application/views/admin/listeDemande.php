<html>

<head>
    <title>Liste des demandes</title>
</head>

<body>
    <div class="container mt-3">
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>Numéro de téléphone</th>
                    <th>Mail</th>
                    <th>Prenom</th>
                    <th>Nom</th>
                    <th>Date de<br>naissance</th>
                    <th>Classe</th>
                    <th>Valider/Refuser</th>
                </tr>
            </thead>
            <h1>Liste des demandes d'inscription :</h1><br>
            <?php foreach ($lesDemandes as $uneDemande) :
                echo '<tbody><tr><td>' . $uneDemande->no_tel . '</td><td>' . $uneDemande->mail . '</td><td>' . $uneDemande->prenom . '</td><td>' . $uneDemande->nom . '</td><td>' . $uneDemande->date_naissance . '</td><td>' . $uneDemande->classe . '</td><td>'; ?>
                <a class="text-warning" href="<?php echo site_url('admin/validerDemande/' . $uneDemande->no_user) ?>">Valider</a>
                /
                <a class="text-warning" href="<?php echo site_url('admin/refuserDemande/' . $uneDemande->no_user) ?>">Refuser</a>
                </td>
                </tr><?php
                    endforeach;
                        ?>
</body>

</html>