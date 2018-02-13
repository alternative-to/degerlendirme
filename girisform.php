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
        <form action="girisisle.php" method="post">
            Kullanıcı Adı <input type="text" name="kullanici" required></input><br />
            Şifre <input type="password" name="sifre" required></input><br />          
            <input type="submit" value="Giriş Yap!" required></input>
        </form>
    </body>
</html>
