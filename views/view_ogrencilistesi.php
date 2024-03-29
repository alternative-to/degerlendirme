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

/* ŞİMDİ DERSİN SEÇİLEN OTURUMUNA KAYITLI ÖĞRENCİLERİ ALALIM */
$sql = "SELECT * FROM ogrencialinanders WHERE aktifDersKod = $aktifDersKod";

if ($sonuc = $vt->query($sql)) {
    while($satir = $sonuc->fetch_assoc()) {
      if ($satir["onay"]){ // onaylı ve onaysızları ayıralım...
        $onayliogrencilistesi[] = $satir;
      } else {
        $onaysizogrencilistesi[] = $satir;
      }
      $kayitliogrencilistesi[]=$satir;
    }
} else {
    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !') </SCRIPT>");
}
include 'ayar/vtkapat.php';
/* ŞİMDİ DERSİN SEÇİLEN OTURUMUNA KAYIT OLAN VE ONAYLI ÖĞRENCİLERİ LİSTELEYELİM */

if (isset ($onayliogrencilistesi) AND (count($onayliogrencilistesi) > 0)){
    echo "<h2>Dersi Alan Onaylı Öğrenciler </h2>";
    echo "<table border='1'>";
    echo "<tr>";
    echo "<td> <b>Numara</b> </td>";
    echo "<td> <b>Ad</b> </td>";
    echo "<td> <b>Soyad</b> </td>";
    echo "</tr>\r\n";
    foreach ($ogrencilistesi as $ogrenci) {
        foreach ($onayliogrencilistesi as $onayliogrenci)
        if ($onayliogrenci["ogrenciKod"] == $ogrenci["kod"]) {
            echo "<tr>";
            echo "<td>".$ogrenci["numara"]."</td>";
            echo "<td>".$ogrenci["ad"]."</td>";
            echo "<td>".$ogrenci['soyad']."</td>";
            echo "</tr>\r\n";
        }
    }
    echo "</table>\r\n";
} else {
    echo ("Henüz bu derse kayıtlı ve onaylı öğrenci yok! <br />");
}

/* ŞİMDİ DERSİN SEÇİLEN OTURUMUNA KAYIT OLAN VE ONAYSIZ ÖĞRENCİLERİ LİSTELEYELİM */

if (isset ($onaysizogrencilistesi) AND (count($onaysizogrencilistesi) > 0)){
  echo "<h2>Dersi Alan Onaysız Öğrenciler </h2>";
  /* ÖĞRETMENİN ÖĞRENCİ KAYDEDEBİLMESİ İÇİN FORM                                */
  echo "<form action='kaydet.php' method='POST'>\r\n";
  echo "<input type='hidden' name='aktifDersKod' value='$aktifDersKod'>\r\n";
  echo "<p>Onaylamak istediğiniz öğrencileri seçiniz: </p>\r\n ";
  echo "<table border='1'>";
  echo "<tr>";
  echo "<td> <b>Numara</b> </td>";
  echo "<td> <b>Ad</b> </td>";
  echo "<td> <b>Soyad</b> </td>";
  echo "<td> <b>Onayla</b> </td>";
  echo "</tr>\r\n";
  foreach ($ogrencilistesi as $ogrenci) {
      foreach ($onaysizogrencilistesi as $onaysizogrenci) {
      if ($onaysizogrenci["ogrenciKod"] == $ogrenci["kod"]) {
          echo "<tr>";
          echo "<td>".$ogrenci["numara"]."</td>";
          echo "<td>".$ogrenci["ad"]."</td>";
          echo "<td>".$ogrenci['soyad']."</td>";
          echo "<td><input type='checkbox' name='onaylanacakogrenciler[]' value='".$ogrenci["kod"]."'></td>\r\n";
          echo "</tr>\r\n";
      }
  }
  echo "</table>\r\n";
  echo "<br /><input type='submit' value='Onayla' name='ogrencionay'>";
  echo "</form>";
  }

    echo "</table>\r\n";
} else {
    echo ("Henüz bu derse kayıt olmuş öğrenci yok! <br />");
}

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
    echo ("Henüz sisteme kayıt olmuş öğrenci yok! <br />");
}

echo "<input type='submit' name='ogrenciekle' value='Kaydet!'>\r\n";
echo "</form>";
