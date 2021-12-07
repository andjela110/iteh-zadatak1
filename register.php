<?php

include 'config.php';
include 'klase/korisnikRegistrovan.php';
error_reporting(0);

session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['cpassword'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $cpassword = md5($_POST['cpassword']);

    if ($password == $cpassword) {
        $korisnik = new KorisnikRegistrovan(1, $username, $email, $password);
        $odg = KorisnikRegistrovan::registrujKorisnika($korisnik, $conn);

        if (!$odg->num_rows > 0) {
            $odg = KorisnikRegistrovan::unesiKorisnika($korisnik, $conn);
            if ($odg) {
                echo "<script>alert('Uau! Tvoja registracija je završena.')</script>";
                header("Location: login.php");
                $username = "";
                $email = "";
                $_POST['password'] = "";
                $_POST['cpassword'] = "";
            } else {
                echo "<script>alert('Ups! Nešto je pošlo naopako.')</script>";
            }
        } else {
            echo "<script>alert('Ups! E-mail već postoji.')</script>";
        }
    } else {
        echo "<script>alert('Lozinke se ne poklapaju.')</script>";
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/prijava.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">



</head>

<body>
    <?php
    include 'zaglavlja/header.php';
    ?>

    <div class="bodi">
        <div class="container">
            <form action="" method="POST" class="login-email">
                <p class="login-text" style="font-size: 2rem; font-weight: 800;">Registruj se</p>
                <div class="input-group">
                    <input type="text" placeholder="Korisničko ime" name="username" value="<?php echo $username; ?>" required>
                </div>
                <div class="input-group">
                    <input type="email" placeholder="E-mail" name="email" value="<?php echo $email; ?>" required>
                </div>
                <div class="input-group">
                    <input type="password" placeholder="Lozinka" name="password" value="<?php echo $_POST['password']; ?>" required>
                </div>
                <div class="input-group">
                    <input type="password" placeholder="Potvrdi lozinku" name="cpassword" value="<?php echo $_POST['cpassword']; ?>" required>
                </div>
                <div class="input-group">
                    <button name="submit" class="btn">Registruj se</button>
                </div>
                <p class="login-register-text">Već imaš nalog? <a href="login.php">Uloguj se ovde</a>.</p>
            </form>
        </div>
    </div>

    <?php
    include 'zaglavlja/footer.php';
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"></script>

</body>

</html>