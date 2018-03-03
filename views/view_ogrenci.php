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

/* KRİTER TÜRLERİNİ ALALIM                */
$sql = "SELECT * FROM kriterTur";

if ($sonuc = $vt->query($sql)) {
    while($satir = $sonuc->fetch_assoc()) {
        $kriterTur[] = $satir;
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

// ÖĞRENCİNİN ALDIĞI DERSLERDEKİ PROJELERİ ALALIM...

foreach ($ogrenciAlinanDersler as $ogrenciAlinanDers) {
  $sql = "SELECT * FROM proje WHERE aktifDersKod = ".$ogrenciAlinanDers['aktifDersKod'];
  if ($sonuc = $vt->query($sql)) {
      while($satir = $sonuc->fetch_assoc()) {
          $projeler[] = $satir;
      }
  } else {
      echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !') </SCRIPT>");
  }
}
//print_r($projeler);

// ÖĞRENCİNİN ALDIĞI PROJELERİN KRİTERLERİNİ ALALIM...

foreach ($projeler as $proje) {
  $sql = "SELECT * FROM kriter WHERE projeKod = ".$proje['kod'];
  if ($sonuc = $vt->query($sql)) {
      while($satir = $sonuc->fetch_assoc()) {
          $kriterler[] = $satir;
      }
  } else {
      echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !') </SCRIPT>");
  }
}
//print_r($kriterler);

include 'ayar/vtkapat.php';
//
echo "<h2>Aldığım Dersler </h2>"; // ALDIĞI DERSLERİ LİSTELEYELİM
if (isset ($ogrenciAlinanDersler) AND (count($ogrenciAlinanDersler) > 0)){
    foreach ($ogrenciAlinanDersler as $ogrenciAlinanDers) {
        foreach ($aktifDersler as $aktifDers)
        if ($ogrenciAlinanDers["aktifDersKod"] == $aktifDers["kod"]) {
            //echo "<tr><td>";
            echo "<h3>";
            echo $aktifDers["yil"]." yılı ";
            echo $donem[$aktifDers["donemKod"]-1]["etiket"];
            echo " dönemine ait ";
            echo $dersler[$aktifDers["dersKod"]-1]["ad"];
            echo "</h3>\r\n";
            foreach ($projeler as $proje){// VARSA PROJE TABLOSUNU BAŞLATALIM
               if ($proje["aktifDersKod"] == $aktifDers["kod"]){
                 echo "<table border='1'>\r\n";
                 echo "<tr><td><b>".$proje["baslik"]."</b></td></tr>\r\n";
                 echo "<tr><td><a href='kisiselsayfa.php?ogrencikritergor=1&projeKod=".$proje['kod']."'>Kriterleri Gör</a></td></tr>\r\n";
                 echo "<tr><td><a href='kisiselsayfa.php?grupgor=1&projeKod=".$proje['kod']."'>Grubum</a></td></tr>\r\n";
                 echo "<tr><td>Yükle</td></tr>\r\n";
                 echo "<tr><td>Notum: ??</td></tr>\r\n";
                 echo "<tr><td>Grup Arkadaşlarımı Değerlendir</td></tr>\r\n";
                 echo "<tr><td>Diğer Grupları Değerlendir <br /> (7 grubun 3 tanesi değerlendirildi.)</td></tr>\r\n";
                 echo "</table><br />\r\n";
               }
            }
        }
    }
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
