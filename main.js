//DODAVANJE
//dodavanje destinacije
$('#dodajForm').submit(function(event){
    event.preventDefault();
    //serijalizacija
    const $forma =$(this);
    const $unos = $forma.find('input, select, button');

    const serijalizacija = $forma.serialize();
    console.log(serijalizacija);

    $unos.prop('disabled', true); //neću da dozvolim dalji unos ako je dodavanje u toku

    //slanje zahteva
    zahtev = $.ajax({ //$.ajax funkcija koja prihvata json kao objekat koji je niz ključ-vrednost parova
        url: 'handler/dodaj.php',
        type:'post',
        data: serijalizacija
    });
    //provera zahteva
    zahtev.done(function(res, textStatus, jqXHR){
        if(res=="Success"){
            alert("Destinacija uspešno dodata");
            location.reload(true); //da se reload-uje stranica kako bi se prikazala dodata destinacija
        }else console.log("Destinacija nije dodata "+res );
    });

    zahtev.fail(function(jqXHR, textStatus, errorThrown){
        console.error('Sledeća greška se desila> '+textStatus, errorThrown)
    });
});

//BRISANJE
$('#btn-obrisi').click(function(){ //klikom na dugme 'obriši'
    const oznacena = $('input[name=cekirana]:checked'); //pokupi id čekirane destinacije preko name-a
    //slanje zahteva za brisanje
    zahtev = $.ajax({ //ako se desi POST, pošalji ga na obrisi.php, a kao podatke pošalji id koji je oznacena.val()
        url: 'handler/obrisi.php',
        type:'post', 
        data: {'id':oznacena.val()}
    });
    //provera zahteva
    zahtev.done(function(res, textStatus, jqXHR){
        if(res=="Success"){
           oznacena.closest('tr').remove(); //obriši najbliži 'tr' za 'označena'-to je red u kome se nalazi
           console.log('Obrisana');
        }else {
        console.log("Destinacija nije obrisana "+res);
        }
        console.log(res);
    });

});

//IZMENA
// dugme koje je na glavnoj formi i otvara dijalog za izmenu
$('.btn-izmeni').click(function () {
    //pristup id-u preko name-a
    const oznacena = $('input[name=cekirana]:checked');
    //pristupa informacijama te konkretne forme i popunjava dijalog
    zahtev = $.ajax({
        url: 'handler/pokupi.php',
        type: 'post',
        dataType: "json",
        data: {'id': oznacena.val()}
    });
    //provera zahteva
    zahtev.done(function (response, textStatus, jqXHR) {
        console.log('Popunjena');
        $('#naziv').val(response[0]['naziv']);
        console.log(response[0]['naziv']);

        $('#datum').val(response[0]['datum'].trim());
        console.log(response[0]['datum'].trim());

        $('#trajanje').val(response[0]['trajanje'].trim());
        console.log(response[0]['trajanje'].trim());

        $('#transport').val(response[0]['transport'].trim());
        console.log(response[0]['transport'].trim());

        $('#id').val(oznacena.val());

        console.log(response);
    });

   zahtev.fail(function (jqXHR, textStatus, errorThrown) {
       console.error('Desila se sledeća greška: ' + textStatus, errorThrown);
   });

});

//dugme za slanje UPDATE zahteva nakon popunjene forme
$('#izmeniForm').submit(function (event) {
    event.preventDefault();
    console.log("Izmene");
    const $forma = $(this);
    const $unos = $forma.find('input, select, button');
    const serijalizacija = $forma.serialize();
    console.log(serijalizacija);
    $unos.prop('disabled', true);
   //slanje zahteva
    zahtev = $.ajax({
        url: 'handler/azuriraj.php',
        type: 'post',
        data: serijalizacija
      
    });
    //provera zahteva
     zahtev.done(function(response, textStatus, jqXHR) {
       
          if (response ='Success') {
                console.log('Destinacija je izmenjena');
                alert('Destinacija je izmenjena');
                location.reload(true);
                $('#izmeniForm').reset;
            }
            else  {console.log('Destinacija nije izmenjena ' + response);
            alert('Destinacija nije izmenjena');
        }
            console.log(response);
        });
    

    zahtev.fail(function (jqXHR, textStatus, errorThrown) {
        console.error('Desila se sledeća greška: ' + textStatus, errorThrown);
    });

$('#izmeniDestinacijuModal').modal('hide'); 
});


$('#btnDodaj').submit(function () {
    $('#dodajDestinacijuModal').modal('toggle');
    return false;
});

$('.btnIzmeni').submit(function () {
    $('#izmeniDestinacijuModal').modal('toggle');
    return false;
});
$('#btnObrisi').submit(function () {
    $('#obrisiDestinacijuModal').modal('toggle');
    return false;
});