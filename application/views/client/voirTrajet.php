<html>

<head>
    <title>Vos trajets</title>
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
                        <th>Activer/Désactiver</th>
                    </tr>
                </thead>
                <?php
                echo '<h1>Vos trajets :</h1><br>';
                $notrajet = "";
                $nomjour = "";
                $date = "";
                ?><?php
                    foreach ($lesTrajetsH as $unTrajetH) : ?>
                <tbody>
                    <tr>
                        <?php if ($notrajet != $unTrajetH->notrajet or $nomjour != $unTrajetH->nomjour) { ?>
                            <td>
                                <a class="text-warning"><?php echo $unTrajetH->notrajet; ?></a>
                            </td>
                            <td><?php echo $unTrajetH->nomjour ?></td>
                        <?php } else { ?>
                            <td></td>
                            <td></td>
                        <?php } ?>
                        <td><?php echo $unTrajetH->ville_nom ?></td>
                        <td><?php echo $unTrajetH->heure ?></td>
                        <?php if ($notrajet != $unTrajetH->notrajet) {
                            if ($unTrajetH->actif == 1) { ?>
                                <td><a class="text-danger" href="<?php echo site_url('client/desactiverTrajet/' . $unTrajetH->notrajet) ?>"><?php echo 'Désactiver le trajet n°'.$unTrajetH->notrajet?></a></td>
                            <?php } else { ?>
                                <td><a class="text-danger" href="<?php echo site_url('client/activerTrajet/' . $unTrajetH->notrajet) ?>"><?php echo 'Activer le trajet n°'.$unTrajetH->notrajet?></a></td>
                        <?php }
                        }
                        $notrajet = $unTrajetH->notrajet;
                        $nomjour = $unTrajetH->nomjour;
                    endforeach;
                    foreach ($lesTrajetsP as $unTrajetP) : ?>
                <tbody>
                    <tr>
                        <?php if ($notrajet != $unTrajetP->notrajet or $date != $unTrajetP->dateEffectiveDuTrajet) { ?>
                            <td>
                                <a class="text-warning"><?php echo $unTrajetP->notrajet; ?></a>
                            </td>
                            <td><?php $dateTrajet = date_create($unTrajetP->dateEffectiveDuTrajet);
                                echo date_format($dateTrajet, 'Y-m-d') ?></td>
                        <?php } else { ?>
                            <td></td>
                            <td></td>
                        <?php } ?>
                        <td><?php echo $unTrajetP->ville_nom ?></td>
                        <td><?php echo $unTrajetP->heure ?></td>
                        <?php if ($notrajet != $unTrajetP->notrajet or $date != $unTrajetP->dateEffectiveDuTrajet) {
                            if ($unTrajetP->actif == 1) { ?>
                                <td><a class="text-danger" href="<?php echo site_url('client/desactiverTrajet/' . $unTrajetP->notrajet) ?>"><?php echo 'Désactiver le trajet n°'.$unTrajetP->notrajet?></a></td>
                            <?php } else { ?>
                                <td><a class="text-danger" href="<?php echo site_url('client/activerTrajet/' . $unTrajetP->notrajet) ?>"><?php echo 'Activer le trajet n°'.$unTrajetP->notrajet?></a></td>
                    <?php }
                        }
                        $notrajet = $unTrajetP->notrajet;
                        $date = $unTrajetP->dateEffectiveDuTrajet;
                    endforeach;
                    echo '</table>';
                    ?>
        </div>
    </div>
</body>

</html>