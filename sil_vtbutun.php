<?php

/* TEK KAYIT OKUT */
$sql = "SELECT * FROM ogrenci WHERE kullaniciadi like '$kullanici' and sifre = '$sifre'";

if ($sonuc = $vt->query($sql)) {
    if($sonuc->num_rows > 0){
        $satir = $sonuc->fetch_assoc();
        $_SESSION["numara"] = $satir["numara"];
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
/*******************************************
/* ÇOK KAYIT OKUT                    *******/

include 'ayar/vtbaglan.php';
$sql = "SELECT * FROM ders";

if ($sonuc = $vt->query($sql)) {
    if($sonuc->num_rows > 0){
        while ($satir = $sonuc->fetch_assoc()) {
            echo "<ul>";
            echo "<li>";
            echo $satir["ad"];
               echo "<ul>";
               echo "<li>"; 
               echo "Aktif oturumlarını";
               echo "<form action='kisiselsayfa.php' method='POST'>";
               echo "<input type='hidden' name='kod' value='".$satir["kod"]."'>";
               echo "<input type='submit' name='liste' value='Listele!'>";
               echo "</li>";                   
               echo "</ul>";            
            echo "</li>";
            echo "</ul>";
        }
    } else {
        echo ("Henüz eklenmiş bir ders yok! <br />");   
    }
} else {
        echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !') </SCRIPT>");
}
include 'ayar/vtkapat.php';
/**************************************************/
/* KAYIT OKUTUP BİR DİZİDE SAKLA                  */
$sql = "SELECT * FROM donem";

if ($sonuc = $vt->query($sql)) {
    while($satir = $sonuc->fetch_assoc()) {
        $donem[] = $satir;
    }   
} else { 
    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !') </SCRIPT>");
}

/*** SONRA BUNU LİSTELERKEN */
echo "<td>".$donem[$satir['donemKod']-1]['etiket']."</td>";  


/*************************      ******/
/*             KAYIT EKLE            */
/*************************************/
include 'ayar/vtbaglan.php';

$kullanici = $vt->real_escape_string($_POST["kullanici"]);
$ad = $vt->real_escape_string($_POST["ad"]);
$soyad = $vt->real_escape_string($_POST["soyad"]);
$eposta = $vt->real_escape_string($_POST["eposta"]);

$sql = "INSERT INTO ogrenci (numara, kullaniciadi, sifre, ad, soyad, eposta) VALUES ('$numara','$kullanici', '$sifre', '$ad', '$soyad', '$eposta')";

if ($vt->query($sql)) {
    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Kayıt başarıyla oluşturuldu!')
    window.location.href='girisform.php';  </SCRIPT>");
} else {
    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !')
    window.location.href='kayitform.php';  </SCRIPT>");
}

include 'ayar/vtkapat.php';


/*****************  FORMLAR            ********************/
/******** VT TABLODAN OKUTARAK MENÜ OLUŞTUR ***************/

echo "<select name='kriterTuru'>";
$sql = "SELECT * FROM kriterTuru";
if ($sonuc = $vt->query($sql)) {
    while ($satir = $sonuc->fetch_assoc()) {
        echo "<option value='".$satir['kod']."'>".$satir["etiket"]." Seviye: ".$satir["seviye"]." </option>\r\n";
    }
} else {
        echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !') </SCRIPT>");
}
echo "</select>";

/************ GELEN VERİYİ TEMİZLE     ********************/

/* METİNSE */
$kriter = $vt->real_escape_string($_POST["etiket"]);

/* RAKAM MI */
if (!is_numeric($_POST["numara"])) {
    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Numara alanına sayısal olmayan değer girmeyiniz!')
    window.location.href='kayitform.php';  </SCRIPT>");
} else {
    $numara = $_POST["numara"];
}

/* ŞİFRELER AYNI MI */
if ($_POST["sifre1"] != $_POST["sifre2"]) {
    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Şifreler birbirinden farklı!')
    window.location.href='kayitform.php';  </SCRIPT>");
} else {
    $sifre = sha1($_POST["sifre1"]);
}
