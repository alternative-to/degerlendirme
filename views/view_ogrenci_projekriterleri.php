<?php
$projeKod = $_GET["projeKod"];
$_SESSION["projeKod"] = $_GET["projeKod"];
/* Aktif ders kodunu ve ders kodunu bulalım ve yönlendirme için gönderelim */
include 'ayar/vtbaglan.php';
$sql = "SELECT aktifDersKod FROM proje WHERE kod = $projeKod ";
if ($sonuc = $vt->query($sql)) {
  if($sonuc->num_rows > 0){
    $satir = $sonuc->fetch_assoc();
    $_SESSION["aktifDersKod"] = $satir["aktifDersKod"];
  } else {
    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Hangi projeyi seçtiğiniz anlaşılamadı, tekrar deneyiniz!') window.location.href='kisiselsayfa.php';  </SCRIPT>");
  }
} else {
    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !') </SCRIPT>");
}

$sql = "SELECT dersKod FROM aktifders WHERE kod =". $_SESSION["aktifDersKod"];
if ($sonuc = $vt->query($sql)) {
  if($sonuc->num_rows > 0){
    $satir = $sonuc->fetch_assoc();
    $_SESSION["dersKod"] = $satir["dersKod"];
  } else {
    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Hangi dersi seçtiğiniz anlaşılamadı, tekrar deneyiniz!') window.location.href='kisiselsayfa.php';  </SCRIPT>");
  }
} else {
    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !') </SCRIPT>");
}
/* YÖNLENDİRME BAŞLA */
$_SESSION["yonlendirme"] = "projegoster";
include 'views/view_yonlendirme.php';
/* YÖNLENDİRME BİTİR */




$sql = "SELECT * FROM kriterTur";
if ($sonuc = $vt->query($sql)) {
    while($satir = $sonuc->fetch_assoc()) {
        $kriterTur[] = $satir;
    }
} else {
    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !') </SCRIPT>");
}

$sql = "SELECT * FROM kriter WHERE projeKod = $projeKod";

if ($sonuc = $vt->query($sql)) {
    if($sonuc->num_rows > 0){ /* PROJE KRİTERLERİNİ LİSTELEYELİM */
        echo "<table border='1'>";
        echo "<tr>";
        echo "<td> Etiket </td>";
        echo "<td> Kriter Türü </td>";
        echo "<td> Azami Puan </td>";
        echo "</tr>";
        while ($satir = $sonuc->fetch_assoc()) {

            echo "<tr>";
            echo "<td>".$satir["etiket"]."</td>";
            echo "<td>".$kriterTur[$satir['kriterTur']-1]['etiket']." Seviyesi : ".$kriterTur[$satir['kriterTur']-1]['seviye']."</td>";
            echo "<td>".$satir["azamiPuan"]."</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<br />";
    } else { /* HENÜZ BİR PROJE KRİTERİ EKLENMEMİŞ */
        echo ("Henüz eklenmiş bir proje kriteri yok! <br />");
    }
} else { /* VERİ TABANINDA SORGUDA PROBLEM YAŞANDI */
        echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !') </SCRIPT>");
}

include 'ayar/vtkapat.php';

?>
