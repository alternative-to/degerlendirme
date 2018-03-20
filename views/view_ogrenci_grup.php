<?php
echo "<b> POST </b><br />";
print_r($_POST);
echo "<br />";
echo "<b> GET </b><br />";
print_r($_GET);
echo "<br />";
echo "<b> SESSION </b><br />";
print_r($_SESSION);
echo "<br />";
echo "Yapılacaklar: 1) Önce çalışma grubu oluştursunlar 2) Mevcut çalışma grupları listelensin 3) Çalışma gruplarındaki öğrenciler listelensin 4) Form üzerinden öğrenciler başkalarını davet edebilsin";
echo "<br />";
echo "<br />";
$projeKod = $_GET["projeKod"];

include 'ayar/vtbaglan.php';
/* AKTİF DERS KODU BULALIM */
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
/* DERSKOD'U BULALIM */
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
$_SESSION["yonlendirme"] = "ogrencilistegoster";
include 'views/view_yonlendirme.php';
/* YÖNLENDİRME BİTİR */

/* DAHA ÖNCE GRUP OLUŞTURMUŞ MU?                                              */
$sql = "SELECT * FROM calismagrubu WHERE projeKod = $projeKod AND olusturan =".$_SESSION["kod"];

if ($sonuc = $vt->query($sql)) {
  if ($sonuc->num_rows){
    $satir = $sonuc->fetch_assoc();
    $grupKod = $satir["kod"];
  }
} else {
    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !') </SCRIPT>");
}

/* BÜTÜN ÇALIŞMA GRUPLARI                                              */
$sql = "SELECT * FROM calismagrubu WHERE projeKod = $projeKod";

if ($sonuc = $vt->query($sql)) {
  if ($sonuc->num_rows>0 ){
    while($satir = $sonuc->fetch_assoc()) {
      $grupliste[]=$satir;
    }
  }
} else {
    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !') </SCRIPT>");
}
//var_dump($grupliste);
/*  KENDİ OLUŞTURDUĞU GRUP VE KATILIMCILARI GÖSTERELİM */
if (isset($grupliste)) {
  foreach ($grupliste as $grup) {
    if ($grup["olusturan"] == $_SESSION["kod"]) {
      echo "<p><b>Sizin Oluşturduğunu Grup: </b>\r\n ";
      echo $grup['isim']." isimli ve ";
      echo $grup['zaman']." 'da oluşturuldu.</p>";
    }
  }
}

/* ŞİMDİ DERSİN SEÇİLEN OTURUMUNA KAYITLI ÖĞRENCİLERİ ALALIM */
$sql = "SELECT * FROM ogrencialinanders WHERE aktifDersKod = $aktifDersKod";
if ($sonuc = $vt->query($sql)) {
    while($satir = $sonuc->fetch_assoc()) {
        $ogrencilistesi[] = $satir;
    }
} else {
    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !') </SCRIPT>");
}
/* DERSE KAYIT OLAN ÖĞRENCİLERİN DETAYLI BİLGİLERİNİ ELE ALALIM */
$sql = "SELECT kod, numara, ad, soyad FROM ogrenci where kod in (SELECT ogrenciKod FROM ogrencialinanders WHERE aktifDersKod = $aktifDersKod)";

if ($sonuc = $vt->query($sql)) {
    while($satir = $sonuc->fetch_assoc()) {
        $ogrencidetay[] = $satir;
    }
} else {
    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !') </SCRIPT>");
}

/*  VARSA ÖĞRENCİNİN OLUŞTURDUĞU GRUBA DAHİL OLMUŞ ÖĞRENCİLERİN (onaylı ve onaysız birlikte) LİSTESİNİ ALALIM */
$sql = "SELECT * FROM grupuye WHERE grupKod = $grupKod";
if ($sonuc = $vt->query($sql)) {
    while($satir = $sonuc->fetch_assoc()) {
        if ($satir["onay"]) {
          $onayligrupuyeleri[] = $satir["ogrenciKod"];
        } else {
          $onaysizgrupuyeleri[] = $satir["ogrenciKod"];
        }
    }
} else {
    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !') </SCRIPT>");
}
echo "<pre>";
var_dump($onayligrupuyeleri);
echo "</pre>";
echo "<pre>";
var_dump($onaysizgrupuyeleri);
echo "</pre>";
include 'ayar/vtkapat.php';

/* ŞİMDİ DERSİN SEÇİLEN OTURUMUNA KAYIT OLAN VE ONAYLI ÖĞRENCİLERİ LİSTELEYELİM */


echo "<h2>Dersi Alan Öğrenciler </h2>";
if (isset ($ogrencidetay) AND (count($ogrencidetay) > 1)){
  /* ÖĞRETMENİN ÖĞRENCİ KAYDEDEBİLMESİ İÇİN FORM                                */
  echo "<form action='kaydet.php' method='POST'>\r\n";
  echo "<input type='hidden' name='aktifDersKod' value='$aktifDersKod'>\r\n";
  echo "<p>Beraber çalışmak istediğiniz arkadaşınızı seçiniz: </p>\r\n ";
  echo "<table border='1'>";
  echo "<tr>";
  echo "<td> <b>Numara</b> </td>";
  echo "<td> <b>Ad</b> </td>";
  echo "<td> <b>Soyad</b> </td>";
  echo "<td> <b>Onayla</b> </td>";
  echo "</tr>\r\n";
  foreach ($ogrencidetay as $ogrenci) {
      if ($ogrenci["kod"] <> $_SESSION["kod"]) {
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
  echo "</table>\r\n";

} else {
    echo ("Sizden başka bu derse kayıt olmuş öğrenci yok! <br />");
}


/* GRUP OLUŞTURMAK İÇİN FORM */
if (!isset($grupKod)) { // Daha önce grup oluşturduysa bir daha bu formu görmesin...
  echo "<br /><br />";
  echo "<h2> Yeni Grup Oluştur </h2>";
  echo "<form action='kaydet.php' method='POST'>";
  echo "Grubun adını giriniz: <input type='text' name='isim'>";
  echo "<input type='hidden' name='projeKod' value='".$projeKod."'>";
  echo "<input type='submit' name='grupolustur' value='Oluştur!'>";
  echo "</form>";
}
