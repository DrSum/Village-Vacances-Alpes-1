<?php
$title = $_POST['title'];
$start = $_POST['start']->format('H:i:s');
$end = $_POST['end']->format('H:i:s');
$date = $POST['start']->format('Y-m-d');
try {
$bdd = new PDO('mysql:host=127.0.0.1;dbname=fullcalendar', 'root', '');
} catch(Exception $e) {
exit('Impossible de se connecter à la base de données.');
}
$sql = "INSERT INTO ACTIVITE
        (CODEANIM, CODEETATACT, DATEACT, HRDEBUTACT, HRFINACT, NOENCADRANT)
        VALUES('$form_values[cd]', '1', '$form_values[date]', '$form_values[start]', '$form_values[end]', '1')";
 ?>
