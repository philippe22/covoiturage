<html>

<head>
    <title>Trajet(s) disponible</title>
</head>

<body>
    <div class="container p-5 my-5 border">
        <div class="container pt-1">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>n° du trajet</th>
                        <th>Passe par</th>
                        <th>Heure de<br>passage</th>
                        <th>Arrive à</th>
                        <th>Heure<br>d'arrivée</th>
                    </tr>
                </thead>
                <?php
                $rendu = 0;
                $renduHebdo = 0;
                if ($this->session->choix == 'depart') {
                    echo '<h1>Trajets disponibles passant par ' . $ville . ' le ' . $date . ' vers Rabelais :</h1><br>';
                    foreach ($lesTrajets as $unTrajet) :
                        $rendu += 1;
                        if ($unTrajet->heure_depart < $unTrajet->heure_arrivee) {
                            echo '<tbody><tr><td>
                        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#myModal' . $rendu . '">' . $unTrajet->notrajet . '</button>
                        <div class="modal fade" id="myModal' . $rendu . '">
                        <div class="modal-dialog">
                        <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                        <h4 class="modal-title text-dark">Information sur le trajet n°' . $unTrajet->notrajet . '</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                        <table class="table table-dark table-striped">
                        <thead>
                        <tr>
                        <th>Passe par</th>
                        <th>Heure de passage</th>
                        </tr>
                        </thead>';
                            $placeRestante = 0;
                            foreach ($infoTrajet[$rendu] as $uneInfo) :
                                echo '<tbody><tr><td>' . $uneInfo->ville_nom . '</td><td>' . $uneInfo->heure . '</td>';
                                $placeRestante = $uneInfo->nbPlacesProposees - $nombrePlaceRes[$rendu];
                            endforeach;
                            echo '</table>';
                            if ($type[$rendu] == 0) {
                                if ($placeRestante != 0) {
                                    echo '<h6 class="text-dark"> Nombre de places restantes : ' . $placeRestante . '</h6>';
                                } else {
                                    echo '<p class="text-danger">Vous ne pouvez pas réserver ce trajet : Aucune place disponible.</p>';
                                }
                                echo '</div>
                        <!-- Modal footer -->
                        <div class="modal-footer">';
                                if ($placeRestante != 0) {
                                    echo '<br>' . anchor('client/reserverTrajet/' . $unTrajet->notrajet . '/' . $ville . '/' . $type[$rendu]  . '/' . $unTrajet->no_user, 'Reserver une place pour le trajet');
                                }
                            } else {
                                $jourDispo = 0;
                                $renduHebdo += 1;
                                echo form_open('client/reserverTrajet/' . $unTrajet->notrajet . '/' . $ville . '/' . $type[$rendu]  . '/' . $unTrajet->no_user);
                                foreach ($nombrePlaceHebdo[$renduHebdo] as $unePlaceHebdo) :
                                    for ($i = 0; $i < 6; $i++) {
                                        $placeRestante = $unePlaceHebdo->nbPlacesProposees - $nombrePlaceHebdoPrise[$renduHebdo][$i];
                                        if ($placeRestante != 0 && $i == $unePlaceHebdo->nojour) {
                                            echo '<h6 class="text-dark">' . $unePlaceHebdo->nomjour . ' (' . $placeRestante . ' place(s) diponibles) : <input type="checkbox" id="txtCheck' . $unePlaceHebdo->nojour . '" name="txtCheck' . $unePlaceHebdo->nojour . '"></h6>';
                                            $jourDispo += 1;
                                        } else if ($i == $unePlaceHebdo->nojour) {
                                            echo '<h6 class="text-danger">' . $unePlaceHebdo->nomjour . ' : aucune place disponible';
                                        }
                                    }
                                endforeach;
                                if ($jourDispo != 0) {
                                    echo '<!-- Modal footer -->
                                <div class="modal-footer">';
                                    echo '<br>' . form_submit('<button type="button" class="btn btn-primary"', 'Réserver');
                                    echo form_close();
                                } else {
                                    echo '<p class="text-danger">Vous ne pouvez pas réserver ce trajet : Aucune place disponible.</p>';
                                }
                            }
                            echo '</div>

                        </div>
                        </div>
                        </div>
                        </td><td>' . $unTrajet->depart . '</td><td>' . $unTrajet->heure_depart . '</td><td>' . $unTrajet->arrivee . '</td><td>' . $unTrajet->heure_arrivee . '</td>';
                        }
                    endforeach;
                } else {
                    echo '<h1>Trajets disponibles partant de Rabelais le ' . $date . ' en passant par ' . $ville . '</h1><br>';
                    foreach ($lesTrajets as $unTrajet) :
                        $rendu += 1;
                        if ($unTrajet->heure_depart < $unTrajet->heure_arrivee) {
                            echo '<tbody><tr><td>
                        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#myModal' . $rendu . '">' . $unTrajet->notrajet . '</button>
                        <div class="modal fade" id="myModal' . $rendu . '">
                        <div class="modal-dialog">
                        <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                        <h4 class="modal-title text-dark">Information sur le trajet n°' . $unTrajet->notrajet . '</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                        <table class="table table-dark table-striped">
                        <thead>
                        <tr>
                        <th>Passe par</th>
                        <th>Heure de passage</th>
                        </tr>
                        </thead>';
                            $placeRestante = 0;
                            foreach ($infoTrajet[$rendu] as $uneInfo) :
                                echo '<tbody><tr><td>' . $uneInfo->ville_nom . '</td><td>' . $uneInfo->heure . '</td>';
                                $placeRestante = $uneInfo->nbPlacesProposees - $nombrePlaceRes[$rendu];
                            endforeach;
                            echo '</table>';
                            if ($type[$rendu] == 0) {
                                if ($placeRestante != 0) {
                                    echo '<h6 class="text-dark"> Nombre de places restantes : ' . $placeRestante . '</h6>';
                                } else {
                                    echo '<p class="text-danger">Vous ne pouvez pas réserver ce trajet : Aucune place disponible.</p>';
                                }
                                echo '</div>
                        <!-- Modal footer -->
                        <div class="modal-footer">';
                                if ($placeRestante != 0) {
                                    echo '<br>' . anchor('client/reserverTrajet/' . $unTrajet->notrajet . '/' . $ville . '/' . $type[$rendu] . '/' . $unTrajet->no_user, 'Reserver une place pour le trajet');
                                }
                            } else {
                                $renduHebdo += 1;
                                $jourDispo = 0;
                                echo form_open('client/reserverTrajet/' . $unTrajet[$rendu]->notrajet . '/' . $ville . '/' . $type[$rendu]  . '/' . $unTrajet->no_user);
                                foreach ($nombrePlaceHebdo[$renduHebdo] as $unePlaceHebdo) :
                                    for ($i = 0; $i < 6; $i++) {
                                        $placeRestante = $unePlaceHebdo->nbPlacesProposees - $nombrePlaceHebdoPrise[$renduHebdo][$i];
                                        if ($placeRestante != 0 && $i == $unePlaceHebdo->nojour) {
                                            echo '<h6 class="text-dark">' . $unePlaceHebdo->nomjour . ' (' . $placeRestante . ' place(s) diponibles) : <input type="checkbox" id="txtCheck' . $unePlaceHebdo->nojour . '" name="txtCheck' . $unePlaceHebdo->nojour . '"></h6>';
                                            $jourDispo += 1;
                                        } else if ($i == $unePlaceHebdo->nojour) {
                                            echo '<h6 class="text-danger">' . $unePlaceHebdo->nomjour . ' : aucune place disponible';
                                        }
                                    }
                                endforeach;
                                if ($jourDispo != 0) {
                                    echo '<!-- Modal footer -->
                                <div class="modal-footer">';
                                    echo '<br>' . form_submit('<button type="button" class="btn btn-primary"', 'Réserver');
                                    echo form_close();
                                } else {
                                    echo '<p class="text-danger">Vous ne pouvez pas réserver ce trajet : Aucune place disponible.</p>';
                                }
                            }

                            echo '</div>

                        </div>
                        </div>
                        </div>
                        </td><td>' . $unTrajet->depart . '</td><td>' . $unTrajet->heure_depart . '</td><td>' . $unTrajet->arrivee . '</td><td>' . $unTrajet->heure_arrivee . '</td>';
                        }
                    endforeach;
                }
                echo '</table>';
                echo '<p class="text-dark">Cliquez sur un numero de trajet pour voir le trajet en détail et réserver</p>';
                ?>