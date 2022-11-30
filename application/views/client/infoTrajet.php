<html>

<head>
    <title>Info du trajet</title>
</head>

<body>
    <div class="container p-5 my-5 border">
        <div class="container pt-1">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>Passe par</th>
                        <th>Heure de passage</th>
                    </tr>
                </thead>
                <?php
                $placeRestante = 0;
                echo '<h1>Informations sur le trajet n°' . $notrajet . '</h1><br>';
                foreach ($infoTrajet as $uneInfo) :
                    echo '<tbody><tr><td>' . $uneInfo->ville_nom . '</td><td>' . $uneInfo->heure . '</td>';
                    $placeRestante = $uneInfo->nbPlacesProposees - $nombrePlaceRes;
                endforeach;
                echo '</table>';
                if ($placeRestante != 0) {
                    echo 'Nombre de places restantes : ' . $placeRestante;
                    echo '<br>' . anchor('client/reserverTrajet/' . $notrajet, 'Reserver une place pour le trajet');
                } else {
                    echo '<p class="text-danger">Vous ne pouvez pas réserver ce trajet : Aucune place disponible.</p>';
                }
                ?>
        </div>
    </div>
</body>

</html>