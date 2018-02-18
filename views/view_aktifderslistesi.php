<?php
$dersKod = $_GET["dersKod"];
$_SESSION["dersKod"] = $_GET["dersKod"];

/* YÖNLENDİRME BAŞLA */
$_SESSION["yonlendirme"] = "dersgoster";
include 'views/view_yonlendirme.php';
/* YÖNLENDİRME BİTİR */

include 'ayar/vtbaglan.php';


$sql = "SELECT * FROM donem";

if ($sonuc = $vt->query($sql)) {
    while($satir = $sonuc->fetch_assoc()) {
        $donem[] = $satir;
    }
} else {
    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !') </SCRIPT>");
}

//print_r($donem);

$sql = "SELECT * FROM aktifders WHERE derskod = $dersKod and aktif = 1";

if ($sonuc = $vt->query($sql)) {
    if($sonuc->num_rows > 0){
        echo "<table border='1'>\r\n";
        echo "<tr>";
        echo "<td> Yıl </td>";
        echo "<td> Dönem </td>";
        echo "<td> Grup İsmi </td>";
        echo "<td> Açıklama </td>";
        echo "<td> Ders Projeleri </td>";
        echo "<td> Ders Öğrencileri </td>";
        echo "</tr>\r\n";
        while ($satir = $sonuc->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$satir["yil"]."</td>";
            echo "<td>".$donem[$satir['donemKod']-1]['etiket']."</td>";
            echo "<td>".$satir["etiket"]."</td>";
            echo "<td>".$satir['aciklama']."</td>";
            echo "<td><a href='kisiselsayfa.php?aktifDersKod=".$satir["kod"]."&projeListe=1'>Listele</a></td>";
            echo "<td><a href='kisiselsayfa.php?aktifDersKod=".$satir["kod"]."&ogrenciListe=1'>Listele</a></td>";
            echo "</tr>\r\n";
        }
        echo "</table>\r\n";
    } else {
        echo ("Henüz bu dersin aktif bir oturumu yok! <br />");
    }
} else {
        echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !') </SCRIPT>");
}


echo "<br /> <br /><h2>Yeni Oturum Oluşturma </h2>\r\n";
echo "<form action='kaydet.php' method='POST'>\r\n";
echo "<input type='hidden' name='dersKod' value='$dersKod'>\r\n";
echo "Lütfen hangi yıl için oluşturuyorsunuz yazınız, ör: 2018";
echo "<input type='text' name='yil' length=4>\r\n";
echo "<select name='donem'>";
$sql = "SELECT * FROM donem";
if ($sonuc = $vt->query($sql)) {
    while ($satir = $sonuc->fetch_assoc()) {
        echo "<option value='".$satir['kod']."'>".$satir["etiket"]."</option>\r\n";
    }
} else {
        echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !') </SCRIPT>");
}
include 'ayar/vtkapat.php';

echo "</select><br />";
echo "Birinci Grubun ismi: ";
echo "<input type='text' name='birgrupisim'><br />\r\n";
echo "İkinci Grubun ismi: ";
echo "<input type='text' name='ikigrupisim'><br />\r\n";
echo "<input type='submit' name='olustur' value='Oluştur!'>\r\n";
echo "</form>";
