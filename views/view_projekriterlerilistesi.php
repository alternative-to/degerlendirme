<?php
$projeKod = $_GET["projeKod"];
$_SESSION["projeKod"] = $_GET["projeKod"];

/* YÖNLENDİRME BAŞLA */
$_SESSION["yonlendirme"] = "projegoster";
include 'views/view_yonlendirme.php';
/* YÖNLENDİRME BİTİR */


include 'ayar/vtbaglan.php';

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

/* YENİ PROJE kriteri EKLEMEK İÇİN FORM */
echo "<form action='kaydet.php' method='POST'>\r\n";
echo "<input type='hidden' name='projeKod' value='$projeKod'>\r\n";
echo "Kriteri giriniz : ";
echo "<input type='text' name='etiket' required><br />\r\n";
echo "Kriterin puan değerini giriniz: ";
echo "<input type='text' name='puan' required><br />\r\n";
echo "<select name='kriterTur'>";
$sql = "SELECT * FROM kriterTur";
if ($sonuc = $vt->query($sql)) {
    while ($satir = $sonuc->fetch_assoc()) {
        echo "<option value='".$satir['kod']."'>".$satir["etiket"]." Seviye: ".$satir["seviye"]." </option>\r\n";
    }
} else {
        echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !') </SCRIPT>");
}
echo "</select>";
echo "<input type='submit' name='kriterolustur' value='Oluştur!'>\r\n";
echo "</form>";

include 'ayar/vtkapat.php';

?>
