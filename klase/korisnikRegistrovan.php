<?php

class KorisnikRegistrovan
{
    //atributi
    public $id;
    public $korisnickoime;
    public $imejl;
    public $lozinka;

    //konstruktor
    public function __construct($id = null, $korisnickoime = null, $imejl = null, $lozinka = null)
    {
        $this->id = $id;
        $this->korisnickoime = $korisnickoime;
        $this->imejl = $imejl;
        $this->lozinka = $lozinka;
    }

    public static function registrujKorisnika($korisnik, mysqli $conn)
    {
        $query = "SELECT * FROM users WHERE email='$korisnik->imejl'";
        return $conn->query($query);
    }
    public static function unesiKorisnika($korisnik, $conn)
    {
        $query = "INSERT INTO users (username, email, password)
        VALUES ('$korisnik->korisnickoime', '$korisnik->imejl', '$korisnik->lozinka')";
        return $conn->query($query);
    }
}
