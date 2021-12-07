<?php

require "../config.php";
require "../klase/destinacija.php";

if (isset($_POST['id'])) {
    $obj = new Destinacija($_POST['id']);
    $status = $obj->deleteById($conn);
    if ($status) {
        echo "Success";
    } else {
        echo "Failed";
    }
}
