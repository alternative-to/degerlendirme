 <?php
session_start();
$_SESSION["yetki"] = false;

/* Eğer POST atlanılarak gelindiyse tekrar forma gönder */
if (empty($_POST)) {
    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Form Bilgileri Girilmemiş!')
    window.location.href='girisform.php';  </SCRIPT>");
}
/* Form doldurularak gelindiyse */
include 'ayar/vtbaglan.php';

/* FORM BİLGİLERİNİ AL VE TEMİZLE */

$kullanici = $vt->real_escape_string($_POST["kullanici"]);
$sifre = sha1($_POST["sifre"]);
 
$sql = "SELECT * FROM ogrenci WHERE kullaniciadi like '$kullanici' and sifre = '$sifre'";

if ($sonuc = $vt->query($sql)) {
    if($sonuc->num_rows > 0){
        $satir = $sonuc->fetch_assoc();
        $_SESSION["kod"] = $satir["kod"];
        if ((!empty($satir["numara"]))) { $_SESSION["numara"] = $satir["numara"]; }
        $_SESSION["ad"] = $satir["ad"];
        $_SESSION["soyad"] = $satir["soyad"]; 
        $_SESSION["eposta"] = $satir["eposta"];  
        $_SESSION["ogretmen"] = $satir["ogretmen"];
        $_SESSION["yetki"] = true;
        echo ("<SCRIPT LANGUAGE='JavaScript'> window.location.href='kisiselsayfa.php';  </SCRIPT>");          
    } else {
     echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Girdiğiniz bilgilerde birisine ulaşılamadı, tekrar deneyiniz!')
    window.location.href='girisform.php';  </SCRIPT>");       
    }
} else {
    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !')
    window.location.href='girisform.php';  </SCRIPT>");
}

include 'ayar/vtkapat.php';
?> 