<?php
require "../config.php";
require "../klase/destinacija.php";

session_start();
if (
    isset($_POST['naziv']) && isset($_POST['datum'])
    && isset($_POST['trajanje']) && isset($_POST['transport'])
) {
    $destinacija = new Destinacija(null, $_POST['naziv'], $_POST['datum'], $_POST['trajanje'], $_POST['transport'], $_SESSION['user_id']);
    $status = Destinacija::add($destinacija, $conn);

    if ($status) {
        echo 'Success';
    } else {
        //echo $status;
        echo "Failed";
    }
}
