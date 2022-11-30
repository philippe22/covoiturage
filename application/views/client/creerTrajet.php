<html>

<head>
    <title>Ajoutez un trajet</title>
    <script>
        var nbEtape = 0;
        var choix = 1;

        function ajouterEtape() {
            nbEtape += 1;
            villeEtape = "txtVille" + nbEtape;
            heureEtape = "txtHeure" + nbEtape;
            minuteEtape = "txtMinute" + nbEtape;
            var etape = "<br><br><div class='col-md-5'><input class='form-control md-5' placeholder='Ville' id='" + villeEtape + "' list ='listVille' name='" + villeEtape + "' required/><br></div><div class='col-md-3'><input class='form-control md-5' id = 'heure' name = '" + heureEtape + "' type='text' placeholder='Heures ex : 7' required><br></div><div class='col-md-3'><input class='form-control md-5' id = 'minutes' name = '" + minuteEtape + "' type='text' placeholder='Minutes ex : 30' required></div>";
            var endroit = document.getElementById("divEtape");
            endroit.insertAdjacentHTML("beforeEnd", etape);
        }

        function hebdomadaire() {
            if (choix == 1) {
                document.getElementById("hebdo").innerHTML = "<h4><label for=hebdo>Selectionner votre date de départ : </label></h4><br><input id=hebdo name=txtDate type=date required><br><br><fieldset id='hebdo' required><legend>Nombre de place(s) : </legend><div><select id='txtPlace' name='txtPlace' value='<?php echo set_value('txtPlace'); ?>'><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option></select></div>";
                choix = 0;
            } else {
                document.getElementById("hebdo").innerHTML = "<fieldset id=hebdo><legend>Veuillez sélectionner les jours où vous effectuez votre traversée</legend><div><input type=checkbox id=txtLundi name=jour value=Lundi><label for=txtLundi>Lundi</label></div><div><input type=checkbox id=txtMardi name=jour value=Mardi><label for=txtMardi>Mardi</label></div><div><input type=checkbox id=txtMercredi name=jour value=Mercredi><label for=txtMercredi>Mercredi</label></div><div><input type=checkbox id=txtJeudi name=jour value=Jeudi><label for=txtJeudi>Jeudi</label></div><div><input type=checkbox id=txtVendredi name=jour value=Vendredi><label for=txtVendredi>Vendredi</label></div><div><input type=checkbox id=txtSamedi name=jour value=Samedi><label for=txtSamedi>Samedi</label></div></fieldset>";
                choix = 1;
            }
        }
    </script>

    <head>

    <body>
        <?php
        echo '<div class="container p-5 my-5 border"><div class="container pt-1"><h1>Ajouter votre trajet</h1></div><br>';

        echo form_open('client/creerTrajet');

        ?>
        <label for="txtDepart">Ville de départ : </label>
        <input placeholder="Ville" id="txtDepart" list="listVille" name="txtDepart" required />
        <datalist id="listVille">
            <?php foreach ($lesVilles as $uneVille) :
                echo '<option value=' . $uneVille->ville_nom . '>';
            endforeach; ?>
        </datalist>
        <?php

        echo form_label('', 'txtHeureDepart');
        echo '<input placeholder="Heures (ex : 7)"' . form_input('txtHeureDepart', '', array('required' => 'required'));

        echo form_label('', 'txtMinuteDepart');
        echo '<input placeholder="Minutes (ex : 30)"' . form_input('txtMinuteDepart', '', array('required' => 'required'));

        ?><br><br>
        <label for="txtArrivee">Ville d arrivee : </label>
        <input placeholder="Ville" id="txtArrivee" list="listVille" name="txtArrivee" required />
        <?php

        echo form_label('', 'txtHeureArrivee');
        echo '<input placeholder="Heures (ex : 7)"' . form_input('txtHeureArrivee', '', array('required' => 'required'));

        echo form_label('', 'txtMinuteArrivee');
        echo '<input placeholder="Minutes (ex : 30)"' . form_input('txtMinuteArrivee', '', array('required' => 'required'));
        ?>
        <br><br><a class="btn btn-success" onclick="ajouterEtape()">Ajouter une étape</a><br><br>
        <div class='row' id='divEtape'></div>

        <br><br>
        <input type="checkbox" id="txtCheck" name="txtCheck" onclick="hebdomadaire()" checked>
        <label for="txtCheck">Cocher cette case si vous comptez réaliser ce trajet toutes les semaines</label><br><br>

        <fieldset id="hebdo" required>
            <legend>Veuillez sélectionner les jours où vous effectuez votre traversée</legend>
            <div>
                <input type="checkbox" id="txtJour1" name="txtJour1" value="1">
                <label for="txtJour1">Lundi &nbsp; &nbsp; &nbsp;</label>
                <label for="txtPlace1"> - Nombre de place(s) </label>
                <select id="txtPlace1" name="txtPlace1" value="<?php echo set_value('txtPlace'); ?>">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    <option>6</option>
                </select>
            </div>
            <div>
                <br>
                <input type="checkbox" id="txtJour2" name="txtJour2" value="2">
                <label for="txtJour2">Mardi &nbsp;&nbsp; &nbsp;</label>
                <label for="txtPlace2"> - Nombre de place(s) </label>
                <select id="txtPlace2" name="txtPlace2" value="<?php echo set_value('txtPlace'); ?>">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    <option>6</option>
                </select>
            </div>
            <div>
                <br>
                <input type="checkbox" id="txtJour3" name="txtJour3" value="3">
                <label for="txtJour3">Mercredi</label>
                <label for="txtPlace3"> - Nombre de place(s) </label>
                <select id="txtPlace3" name="txtPlace3" value="<?php echo set_value('txtPlace'); ?>">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    <option>6</option>
                </select>
            </div>
            <div>
                <br>
                <input type="checkbox" id="txtJour4" name="txtJour4" value="4">
                <label for="txtJour4">Jeudi &nbsp; &nbsp; &nbsp;</label>
                <label for="txtPlace4"> - Nombre de place(s) </label>
                <select id="txtPlace4" name="txtPlace4" value="<?php echo set_value('txtPlace'); ?>">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    <option>6</option>
                </select>
            </div>
            <div>
                <br>
                <input type="checkbox" id="txtJour5" name="txtJour5" value="5">
                <label for="txtJour5">Vendredi</label>
                <label for="txtPlace5"> - Nombre de place(s) </label>
                <select id="txtPlace5" name="txtPlace5" value="<?php echo set_value('txtPlace'); ?>">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    <option>6</option>
                </select>
            </div>
            <div>
                <br>
                <input type="checkbox" id="txtJour6" name="txtJour6" value="6">
                <label for="txtJour6">Samedi&nbsp;&nbsp;</label>
                <label for="txtPlace6"> - Nombre de place(s) </label>
                <select id="txtPlace6" name="txtPlace6" value="<?php echo set_value('txtPlace'); ?>">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    <option>6</option>
                </select>
            </div>
        </fieldset>
        <?php
        echo '<br><br>' . form_submit('<button type="button" class="btn btn-primary"', 'Créer');
        echo '</div>';

        echo form_close();
        ?>
    </body>

</html>