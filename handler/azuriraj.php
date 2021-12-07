<?php

require "../config.php";
require "../klase/destinacija.php";

session_start();

if (isset($_POST['id']) && isset($_POST['naziv']) && isset($_POST['datum']) && isset($_POST['trajanje']) && isset($_POST['transport'])) {

    $obj = new Destinacija($_POST['id'], $_POST['naziv'], $_POST['datum'], $_POST['trajanje'], $_POST['transport'], $_SESSION['user_id']);
    $status = $obj->update($_POST['id'], $conn);

    if ($status) {
        echo 'Success';
    } else {
        echo 'Failed';
    }
}
