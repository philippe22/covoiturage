<html>

<head>
    <title>Chercher un trajet</title>
    <script>
        function depart() {
            document.getElementById("divVille").innerHTML = "<label for='txtDepart'>Ville de départ : </label><input id='txtDepart' list ='villeDepart' name='txtDepart' required/><datalist id ='villeDepart'><?php foreach ($lesVilles as $uneVille) : echo "<option value=" . $uneVille->ville_nom . ">";endforeach; ?></datalist><br><br><?php $date = date('Y-m-d'); echo "<label for='txtDate'>Jour où vous voulez partir : </label><input id=txtDate name=txtDate type=date min=".$date." required>";?>";
        }

        function arrivee() {
            document.getElementById("divVille").innerHTML = "<label for='txtArrivee'>Ville d'arrivée : </label><input id='txtArrivee' list ='villeDepart' name='txtArrivee' required/><datalist id ='villeDepart'><?php foreach ($lesVilles as $uneVille) : echo "<option value=" . $uneVille->ville_nom . ">";endforeach; ?></datalist><br><br><?php $date = date('Y-m-d'); echo "<label for='txtDate'>Jour où vous voulez partir : </label><input id=txtDate name=txtDate type=date min=".$date." required>"; ?>";
        }
    </script>

    <head>

    <body>
        <?php
        echo '<div class="container p-5 my-5 border"><div class="container pt-1"><h1>Cherchez votre trajet</h1><br>';

        echo form_open('client/chercherTrajet');
        ?>

        <label for="choix">Voulez vous partir ou aller vers Rabelais ? </labal><br>
            <a type="button" class="btn btn-success" onclick="depart()">Aller à Rabelais</a>
            <a type="button" class="btn btn-danger" onclick="arrivee()">Partir de Rabelais</a><br><br>
            <div class='row' id='divVille'></div>

            <?php
            echo '<br><br>' . form_submit('<button type="button" class="btn btn-primary"', 'Chercher');
            echo form_close(); ?>
    </body>

</html>