<?php
$aktifDersKod = $_GET["aktifDersKod"];
$_SESSION["aktifDersKod"] = $_GET["aktifDersKod"];

/* YÖNLENDİRME BAŞLA */
$_SESSION["yonlendirme"] = "ogrencilistegoster";
include 'views/view_yonlendirme.php';
/* YÖNLENDİRME BİTİR */

/* ŞİMDİ TÜM ÖĞRENCİ BİLGİLERİNİ ALALIM */
include 'ayar/vtbaglan.php';
$sql = "SELECT kod, numara, ad, soyad FROM ogrenci";

if ($sonuc = $vt->query($sql)) {
    while($satir = $sonuc->fetch_assoc()) {
        $ogrencilistesi[] = $satir;
    }
} else {
    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !') </SCRIPT>");
}

/* ŞİMDİ DERSİN SEÇİLEN OTURUMUNA KAYIT OLAN ÖĞRENCİLERİ ALALIM */
$sql = "SELECT * FROM ogrencialinanders WHERE aktifDersKod = $aktifDersKod";

if ($sonuc = $vt->query($sql)) {
    while($satir = $sonuc->fetch_assoc()) {
        $kayitliogrencilistesi[] = $satir;
    }
} else {
    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !') </SCRIPT>");
}
include 'ayar/vtkapat.php';

/* ŞİMDİ DERSİN SEÇİLEN OTURUMUNA KAYIT OLAN ÖĞRENCİLERİ LİSTELEYELİM */

echo "<h2>Dersi Alan Öğrenciler </h2>";
if (isset ($kayitliogrencilistesi) AND (count($kayitliogrencilistesi) > 0)){
    echo "<table border='1'>";
    echo "<tr>";
    echo "<td> <b>Numara</b> </td>";
    echo "<td> <b>Ad</b> </td>";
    echo "<td> <b>Soyad</b> </td>";
    echo "</tr>\r\n";
    foreach ($ogrencilistesi as $ogrenci) {
        foreach ($kayitliogrencilistesi as $kayitliogrenci)
        if ($kayitliogrenci["ogrenciKod"] == $ogrenci["kod"]) {
            echo "<tr>";
            echo "<td>".$ogrenci["numara"]."</td>";
            echo "<td>".$ogrenci["ad"]."</td>";
            echo "<td>".$ogrenci['soyad']."</td>";
        }
    }
    echo "</table>\r\n";
} else {
    echo ("Henüz bu derse kayıt olmuş öğrenci yok! <br />");
}

echo "<h2> Öğrenci Kayıt </h2>";
/* ÖĞRETMENİN ÖĞRENCİ KAYDEDEBİLMESİ İÇİN FORM */
echo "<form action='kaydet.php' method='POST'>\r\n";
echo "<input type='hidden' name='aktifDersKod' value='$aktifDersKod'>\r\n";
echo "<p>Kayıtlamak istediğiniz öğrencileri seçiniz: </p>\r\n ";


if (isset ($ogrencilistesi) AND (count($ogrencilistesi) > 0)){
    echo "<table border='1'>";
    echo "<tr>";
    echo "<td> <b>Seç</b> </td>";
    echo "<td> <b>Numara</b> </td>";
    echo "<td> <b>Ad</b> </td>";
    echo "<td> <b>Soyad</b> </td>";
    echo "</tr>\r\n";
    if (isset($kayitliogrencilistesi)) {
        foreach ($ogrencilistesi as $ogrenci) {
            $bulundu = false;
            foreach ($kayitliogrencilistesi as $kayitliogrenci){
                if ($ogrenci["kod"] == $kayitliogrenci["ogrenciKod"]) $bulundu = true;
            }
            if (!$bulundu) {
                echo "<tr>";
                echo "<td> <input type='checkbox' name='kaydolacakogrenciler[]' value='".$ogrenci["kod"]."'>";
                echo "<td>".$ogrenci["numara"]."</td>";
                echo "<td>".$ogrenci["ad"]."</td>";
                echo "<td>".$ogrenci['soyad']."</td>";
                echo "</tr>\r\n";
            }
        }
    } else {
        foreach ($ogrencilistesi as $ogrenci) {
            echo "<tr>";
            echo "<td> <input type='checkbox' name='kaydolacakogrenciler[]' value='".$ogrenci["kod"]."'>";
            echo "<td>".$ogrenci["numara"]."</td>";
            echo "<td>".$ogrenci["ad"]."</td>";
            echo "<td>".$ogrenci['soyad']."</td>";
            echo "</tr>\r\n";
        }
    }
    echo "</table>\r\n<br />";
} else {
    echo ("Henüz bu derse kayıt olmuş öğrenci yok! <br />");
}

echo "<input type='submit' name='ogrenciekle' value='Kaydet!'>\r\n";
echo "</form>";
