<?php

include 'ayar/vtbaglan.php';

// DERS LİSTESİ
$sql = "SELECT * FROM ders";


if ($sonuc = $vt->query($sql)) {
    while($satir = $sonuc->fetch_assoc()) {
        $dersler[] = $satir;
    }
} else {
    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !') </SCRIPT>");
}

// AKTİF DERS LİSTESİ
$sql = "SELECT * FROM aktifders";
if ($sonuc = $vt->query($sql)) {
    while($satir = $sonuc->fetch_assoc()) {
        $aktifDersler[] = $satir;
    }
} else {
    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !') </SCRIPT>");
}

/* DÖNEMLERİ LİSTELEYELİM                */
$sql = "SELECT * FROM donem";

if ($sonuc = $vt->query($sql)) {
    while($satir = $sonuc->fetch_assoc()) {
        $donem[] = $satir;
    }
} else {
    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !') </SCRIPT>");
}

// ÖĞRENCİNİN ALDIĞI DERSLERİ LİSTEYE ALALIM

$ogrKod = $_SESSION["kod"];
$sql = "SELECT aktifDersKod FROM ogrenciAlinanDers WHERE ogrenciKod = $ogrKod";
if ($sonuc = $vt->query($sql)) {
    while($satir = $sonuc->fetch_assoc()) {
        $ogrenciAlinanDersler[] = $satir;
    }
} else {
    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !') </SCRIPT>");
}

include 'ayar/vtkapat.php';
//
echo "<h2>Aldığının Dersler </h2>"; // ALDIĞI DERSLERİ LİSTELEYELİM
if (isset ($ogrenciAlinanDersler) AND (count($ogrenciAlinanDersler) > 0)){
    echo "<table border='1'>\r\n";
    foreach ($ogrenciAlinanDersler as $ogrenciAlinanDers) {
        foreach ($aktifDersler as $aktifDers)
        if ($ogrenciAlinanDers["aktifDersKod"] == $aktifDers["kod"]) {
            echo "<tr><td>";
            echo $aktifDers["yil"]." yılı ";
            echo $donem[$aktifDers["donemKod"]-1]["etiket"];
            echo " dönemine ait ";
            echo $dersler[$aktifDers["dersKod"]-1]["ad"];
            echo "</td></tr>\r\n";
        }
    }
    echo "</table>\r\n";
} else {
    echo ("Henüz kaydolduğunuz ders yok! <br />");
}

echo "<h2>Tüm Dersler </h2>"; // ALMADIĞI DERSLERİ LİSTELEYELİM
echo "<table border='1'>";
echo "<tr>";
echo "<td> <b>Ders</b> </td>";
echo "<td> &nbsp; </td>";
echo "</tr>\r\n";
foreach ($dersler as $ders) {
    echo "<tr>";
    echo "<td>".$ders["ad"]."</td>";
    echo "<td>"."<a href='kisiselsayfa.php?ogrenciaktifderskayit=1&dersKod=".$ders["kod"]."'>Kaydol!</a>"."</td>";
    echo "</tr>\r\n";
}
echo "</table>\r\n";
