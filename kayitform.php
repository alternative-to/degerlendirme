<?php
session_start();
?>
<html>
    <head>
        <meta charset="utf-8">
    <title>
        Kayıt Form
    </title>
    </head>
    <body>
        <form action="kayitisle.php" method="post">
            Numara (boş bırakılabilir) <input type="text" name="numara"></input><br />            
            Kullanıcı Adı <input type="text" name="kullanici" required></input><br />
            Şifre <input type="password" name="sifre1" required></input><br />          
            Şifre Tekrar<input type="password" name="sifre2" required></input><br />
            Adınız <input type="text" name="ad" required></input><br />
            Soyadınız <input type="text" name="soyad" required></input><br />
            eposta <input type="email" name="eposta" required></input><br />
            <input type="submit" value="Kayıt Ol!"></input>
        </form>
    </body>
</html>
