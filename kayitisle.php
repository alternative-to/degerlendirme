 <?php
session_start();

/* Eğer POST atlanılarak gelindiyse tekrar forma gönder */
if (empty($_POST)) {
    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Form Bilgileri Girilmemiş!')
    window.location.href='kayitform.php';  </SCRIPT>");
}
/* Form doldurularak gelindiyse */
include 'ayar/vtbaglan.php';

/* FORM BİLGİLERİNİ AL VE TEMİZLE */

$kullanici = $vt->real_escape_string($_POST["kullanici"]);
if ($_POST["sifre1"] != $_POST["sifre2"]) {
    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Şifreler birbirinden farklı!')
    window.location.href='kayitform.php';  </SCRIPT>");
} else {
    $sifre = sha1($_POST["sifre1"]);
}
$ad = $vt->real_escape_string($_POST["ad"]);
$soyad = $vt->real_escape_string($_POST["soyad"]);
$eposta = $vt->real_escape_string($_POST["eposta"]);

if (empty($_POST["numara"])) {
    $sql = "INSERT INTO ogrenci (kullaniciadi, sifre, ad, soyad, eposta) VALUES ('$kullanici', '$sifre', '$ad', '$soyad', '$eposta')";    
} elseif (!is_numeric($_POST["numara"])) {
    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Numara alanına sayısal olmayan değer girmeyiniz!')
    window.location.href='kayitform.php';  </SCRIPT>");
} else {
    $numara = $_POST["numara"];
    $sql = "INSERT INTO ogrenci (numara, kullaniciadi, sifre, ad, soyad, eposta) VALUES ('$numara','$kullanici', '$sifre', '$ad', '$soyad', '$eposta')";
}

if ($vt->query($sql)) {
    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Kayıt başarıyla oluşturuldu!')
    window.location.href='girisform.php';  </SCRIPT>");
} else {
    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !')
    window.location.href='kayitform.php';  </SCRIPT>");
}

include 'ayar/vtkapat.php';
?> 