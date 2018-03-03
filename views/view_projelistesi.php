<?php
$aktifDersKod = $_GET["aktifDersKod"];
$_SESSION["aktifDersKod"] = $_GET["aktifDersKod"];

/* YÖNLENDİRME BAŞLA */
$_SESSION["yonlendirme"] = "aktifdersgoster";
include 'views/view_yonlendirme.php';
/* YÖNLENDİRME BİTİR */

/* ŞİMDİ DERSİN SEÇİLEN OTURUMUNA AİT PROJELERİ LİSTEYELİM */

include 'ayar/vtbaglan.php';
$sql = "SELECT * FROM proje WHERE aktifDersKod = $aktifDersKod";

if ($sonuc = $vt->query($sql)) {
    if($sonuc->num_rows > 0){
        echo "<table border='1'>";
        echo "<tr>";
        echo "<td> Başlık </td>";
        echo "<td> Talimat </td>";
        echo "<td> En Fazla </td>";
        echo "<td> Bitiş Tarihi </td>";
        echo "<td> Öğrenci Projeleri </td>";
        echo "<td> Kriterleri </td>";
        echo "</tr>\r\n";
        while ($satir = $sonuc->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$satir["baslik"]."</td>";
            echo "<td>".$satir["talimat"]."</td>";
            echo "<td>".$satir["kisisayisi"]." kişi</td>";
            echo "<td>".$satir['bitisTarihi']."</td>";
            echo "<td><a href='kisiselsayfa.php?projeKod=".$satir["kod"]."&ogrenciProjeleri=1'>Detay</a></td>";
            echo "<td><a href='kisiselsayfa.php?projeKod=".$satir["kod"]."&kriter=1'>Liste</a></td>";
            echo "</tr>\r\n";
        }
        echo "</table>\r\n";
    } else {
        echo ("Henüz bu derse tanımlanmış bir proje yok! <br />");
    }
} else {
    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !') </SCRIPT>");
}

include 'ayar/vtkapat.php';

echo "<h2> Yeni Proje Oluştur! </h2>";
/* YENİ PROJE EKLEMEK İÇİN FORM */
echo "<form action='kaydet.php' method='POST'>\r\n";
echo "<input type='hidden' name='aktifDersKod' value='$aktifDersKod'>\r\n";
echo "Projenin başlığını giriniz : ";
echo "<input type='text' name='baslik' required><br />\r\n";
echo "Projeyi en fazla kaç kişi yapabilir : ";
echo "<input type='text' name='kisisayisi' required><br />\r\n";
echo "Projenin teslim tarihini giriniz 2018-12-31 biçiminde: ";
echo "<input type='text' name='tarih' required><br />\r\n";
echo "<textarea name='talimat'></textarea><br />";
echo "<input type='submit' name='projeolustur' value='Oluştur!'>\r\n";
echo "</form>";
