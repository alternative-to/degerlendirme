<?php
echo "<h2> Mevcut Dersler </h2>";
include 'ayar/vtbaglan.php';
$sql = "SELECT * FROM ders";

if ($sonuc = $vt->query($sql)) {
    if($sonuc->num_rows > 0){
        echo "<table border='1'>";
        echo "<tr><td><b> Dersin Adı</b> </td> <td><b> Aktif Oturumları </b></td></tr>";
        while ($satir = $sonuc->fetch_assoc()) {
            echo "<tr>";
            echo "<td>";
            echo $satir["ad"];
            echo "</td>";
            echo "<td>";
            echo "<a href='kisiselsayfa.php?dersKod=".$satir["kod"]."'>Listele</a>\r\n";
            echo "</td>";
            echo "</tr>\r\n";
        }
        echo "</table>";
    } else {
        echo ("Henüz eklenmiş bir ders yok! <br />");
    }
} else {
        echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !') </SCRIPT>");
}

include 'ayar/vtkapat.php';

echo "<br /><br />";
echo "<h2> Yeni Ders Oluştur </h2>";

echo "<form action='kaydet.php' method='POST'>";
echo "Dersin adını giriniz: <input type='text' name='dersadi'>";
echo "<input type='submit' name='dersolustur' value='Oluştur!'>";
echo "</form>";
