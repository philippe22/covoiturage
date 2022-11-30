<html>

<head>
    <title>Vos réservations</title>
</head>

<body>
    <div class="container p-5 my-5 border">
        <div class="container pt-1">
            <table class="table table table-dark">
                <thead>
                    <tr>
                        <th>Numéro du trajet</th>
                        <th>Jour</th>
                        <th>Passe par</th>
                        <th>Heure de passage</th>
                        <th>Annuler la réservation</th>
                    </tr>
                </thead>
                <?php
                echo '<h1>Vos réservations : </h1><br>';
                ?><?php
                    $notrajet = "";
                    $nomjour = "";
                    $date = "";
                    foreach ($lesReservationsH as $uneReservationH) : ?>
                <tbody>
                    <tr>
                        <?php if ($notrajet = $uneReservationH->notrajet or $nomjour = $uneReservationH->nomJour) { ?>
                            <td>
                                <a class="text-warning"><?php echo $uneReservationH->notrajet; ?></a>
                            </td>
                            <td><?php echo $uneReservationH->nomJour ?></td>
                        <?php } else { ?>
                            <td></td>
                            <td></td>
                        <?php } ?>
                        <td><?php echo $uneReservationH->ville_nom ?></td>
                        <td><?php echo $uneReservationH->heure ?></td>
                        <?php if ($notrajet = $uneReservationH->notrajet or $nomjour = $uneReservationH->nomJour) { ?>
                            <td><a class="text-danger" href="<?php echo site_url('client/annulerReservation/' . $uneReservationH->notrajet . '/' . $uneReservationH->noJour . '/' . $uneReservationH->no_user) ?>">Annuler la réservation</a></td>
                    </tr>
                <?php } else {
                            echo "<td></td></tr>";
                        }
                        $notrajet = $uneReservationH->notrajet;
                        $nomjour = $uneReservationH->nomJour;
                    endforeach;
                    $notrajet = "";
                    $nomjour = "";
                    $date = "";
                    foreach ($lesReservationsP as $uneReservationP) : ?>
                <tbody>
                    <tr>
                        <?php if ($notrajet = $uneReservationP->notrajet or $date = $uneReservationP->dateEffectiveDuTrajet) { ?>
                            <td>
                                <a class="text-warning"><?php echo $uneReservationP->notrajet; ?></a>
                            </td>
                            <td><?php $dateTrajet = date_create($uneReservationP->dateEffectiveDuTrajet);
                                echo date_format($dateTrajet, 'Y-m-d') ?></td>
                        <?php } else { ?>
                            <td></td>
                            <td></td>
                        <?php } ?>
                        <td><?php echo $uneReservationP->ville_nom ?></td>
                        <td><?php echo $uneReservationP->heure ?></td>
                        <?php if ($notrajet = $uneReservationP->notrajet or $date = $uneReservationP->dateEffectiveDuTrajet) { ?>
                            <td><a class="text-danger" href="<?php echo site_url('client/annulerReservation/' . $uneReservationP->notrajet . '/' . $uneReservationP->no_user) ?>">Annuler la réservation</a></td>
                    </tr>
            <?php }
                        $notrajet = $uneReservationP->notrajet;
                        $date = $uneReservationP->dateEffectiveDuTrajet;
                    endforeach;
                    echo '</table>';
            ?>
        </div>
    </div>
</body>

</html>