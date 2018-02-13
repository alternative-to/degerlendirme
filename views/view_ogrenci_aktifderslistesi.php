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
      echo "<form action='kaydet.php' method='POST'>\r\n";
      echo "<table border='1'>";
      echo "<tr>";
      echo "<td> Seç </td>";
      echo "<td> Yıl </td>";
      echo "<td> Dönem </td>";
      echo "<td> Grup İsmi </td>";
      echo "</tr>\r\n";
      while ($satir = $sonuc->fetch_assoc()) {
          echo "<tr>";
          echo "<td><input type='radio' name='aktifDersKod' value='".$satir["kod"]."'></td>";
          echo "<td>".$satir["yil"]."</td>";
          echo "<td>".$donem[$satir['donemKod']-1]['etiket']."</td>";
          echo "<td>".$satir["etiket"]."</td>";
          echo "</tr>\r\n";
      }
      echo "</table>\r\n";
      echo "<input type='submit' value='Kaydol!' name='dersekaydol'>";
      echo "</form>";
    } else {
        echo ("Henüz bu dersin aktif bir oturumu yok! <br />");
    }
} else {
        echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !') </SCRIPT>");
}

include 'ayar/vtkapat.php';
