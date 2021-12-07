<?php

include 'config.php';
include 'klase/korisnikUlogovan.php';

session_start();
//isključi sve izveštaje o greškama
error_reporting(0);

//ukoliko je korisnik ulogovan, onemogući pristup ovoj strani, vodi ga na izbor destinacija
if (isset($_SESSION['user_id'])) {
    header("Location: glavna.php");
    exit();
}
//ako je korisnik uneo email i password
if (isset($_POST['email']) && isset($_POST['password'])) {
    //preuzmi unete podatke
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    //kreiraj korisnika i pozovi metodu ulogujKorisnika koja cita sve podatke o korisniku iz baze
    $korisnik = new KorisnikUlogovan(1, $email, $password);
    $odg = KorisnikUlogovan::ulogujKorisnika($korisnik, $conn); //pristup statickim funkcijama preko klase

    if ($odg->num_rows == 1) { //ako je broj redova jednak 1, odnosno ako se vratio jedan korisnik
        $_SESSION['user_id'] = $korisnik->id;
        header("Location: glavna.php"); //idi na glavnu stranu
        exit();
    } else {

        echo "<script>alert('Ups! Pogrešan e-mail ili lozinka.')</script>";
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="css/prijava.css">

</head>

<body>
    <?php
    include 'zaglavlja/header.php';
    ?>
    <div class="bodi">

        <div class="container">
            <form action="" method="POST" class="login-email">
                <p class="login-text" style="font-size: 2rem; font-weight: 800;">Uloguj se</p>
                <div class="input-group">
                    <input type="email" placeholder="E-mail" name="email" value="<?php echo $email; ?>" required>
                </div>
                <div class="input-group">
                    <input type="password" placeholder="Lozinka" name="password" value="<?php echo $_POST['password']; ?>" required>
                </div>
                <div class="input-group">
                    <button name="submit" class="btn">Uloguj se</button>
                </div>
                <p class="login-register-text">Nemaš nalog? <a href="register.php">Registruj se ovde</a>.</p>
            </form>
        </div>
    </div>

    <?php
    include 'zaglavlja/footer.php';
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>