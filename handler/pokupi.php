<?php

require "../config.php";
require "../klase/destinacija.php";

if (isset($_POST['id'])) {
    $myArray = Destinacija::getById($_POST['id'], $conn);
    echo json_encode($myArray);
}
