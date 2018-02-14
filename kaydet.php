<?php
session_start();

                              /* ÖĞRETMEN DERS OLUŞTURMAYI SEÇTİYSE           */
if (isset($_POST["dersolustur"])){

  include 'ayar/vtbaglan.php';

  $dersAdi = $vt->real_escape_string($_POST["dersadi"]);
  $sql = "INSERT INTO ders (ad) VALUES ('$dersAdi')";

  if ($vt->query($sql)) {
  echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Ders  başarıyla oluşturuldu!')
  window.location.href='kisiselsayfa.php';  </SCRIPT>");
  } else {
  echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !');  </SCRIPT>");
  }

  include 'ayar/vtkapat.php';
}

/*                    ÖĞRETMEN DERSİN AKTİF OTURUMUNU OLUŞTURUYOR             */
if  (isset($_POST["olustur"])){

    include 'ayar/vtbaglan.php';

    $dersKod = $_POST["dersKod"];
    $yil = $_POST["yil"];
    $donem = $_POST["donem"];
    $birgrupisim = $vt->real_escape_string($_POST["birgrupisim"]);
    $ikigrupisim = $vt->real_escape_string($_POST["ikigrupisim"]);
    $birgrupanahtar = $vt->real_escape_string($_POST["birgrupanahtar"]);
    $ikigrupanahtar = $vt->real_escape_string($_POST["ikigrupanahtar"]);

    $sql = "INSERT INTO aktifders (donemkod, yil, derskod, grupno, etiket, anahtar) VALUES ('$donem','$yil', '$dersKod', '1', '$birgrupisim', '$birgrupanahtar')";

    if ($vt->query($sql)) {
        $sql = "INSERT INTO aktifders (donemkod, yil, derskod, grupno, etiket, anahtar) VALUES ('$donem','$yil', '$dersKod', '2', '$ikigrupisim', '$ikigrupanahtar')";
        if ($vt->query($sql)) {
            echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Ders oturumu başarıyla oluşturuldu!')
            window.location.href='kisiselsayfa.php?dersKod=$dersKod';  </SCRIPT>");
        } else {
            echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !');  </SCRIPT>");
        }
    } else {
        echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !');  </SCRIPT>");
    }

    include 'ayar/vtkapat.php';
}

                            /* ÖĞRETMEN AKTİF DERSE ÖĞRENCİ KAYDI YAPIYORSA   */
if (isset($_POST["ogrenciekle"])) {
    include 'ayar/vtbaglan.php';
    $aktifDersKod = $_POST["aktifDersKod"];
    if (isset($_POST["kaydolacakogrenciler"])){
        $kaydolacakogrenciler = $_POST["kaydolacakogrenciler"];
        foreach ($kaydolacakogrenciler as $kaydolacakogrenci) {
            $sql = "INSERT INTO ogrencialinanders (ogrenciKod, aktifDersKod, onay) VALUES ('$kaydolacakogrenci','$aktifDersKod', 1)";
            if (!($vt->query($sql))) {
                echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !');  </SCRIPT>");
            }
        }
    }
    include 'ayar/vtkapat.php';
    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Öğrenciler derse kayıt edildi!')
    window.location.href='kisiselsayfa.php?aktifDersKod=".$aktifDersKod."&ogrenciListe=1';  </SCRIPT>");
}

/*              ÖĞRETMEN AKTİF DERSE KAYDEDİLEN ÖĞRENCİ ONAYI YAPIYORSA       */
if (isset($_POST["ogrencionay"])) {
  include 'ayar/vtbaglan.php';
  $aktifDersKod = $_POST["aktifDersKod"];
  if (isset($_POST["onaylanacakogrenciler"])){
    $onaylanacakogrenciler = $_POST["onaylanacakogrenciler"];
    foreach ($onaylanacakogrenciler as $onaylanacakogrenci) {
        $sql = "INSERT INTO ogrencialinanders (ogrenciKod, aktifDersKod, onay) VALUES ('$onaylanacakogrenci','$aktifDersKod', 1)";
        if (!($vt->query($sql))) {
            echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !');  </SCRIPT>");
        }
    }
  }
  include 'ayar/vtkapat.php';
  echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Öğrencilerin onay işlemi başarıyla yapıldı!')
  window.location.href='kisiselsayfa.php?aktifDersKod=".$aktifDersKod."&ogrenciListe=1';  </SCRIPT>");
}

                        /* ÖĞRETMEN AKTİF DERSE YENİ BİR PROJE İLAVE EDİYOR   */
if (isset($_POST["projeolustur"])) {

    include 'ayar/vtbaglan.php';
    $aktifDersKod = $_POST["aktifDersKod"];
    $baslik = $vt->real_escape_string($_POST["baslik"]);
    $tarih = $vt->real_escape_string($_POST["tarih"]);
    $talimat = $vt->real_escape_string($_POST["talimat"]);
    $sql = "INSERT INTO proje (baslik, talimat, bitistarihi, aktifderskod) VALUES ('$baslik','$talimat', '$tarih', '$aktifDersKod')";

    if ($vt->query($sql)) {
        echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Proje başarıyla oluşturuldu!')
        window.location.href='kisiselsayfa.php?aktifDersKod=$aktifDersKod&projeListe=1';  </SCRIPT>");
    } else {
        echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !');  </SCRIPT>");
    }
    include 'ayar/vtkapat.php';
}

              /*                 ÖĞRETMEN PROJE KRİTERİ OLUŞTURUYOR           */
if (isset($_POST["kriterolustur"])) {

    include 'ayar/vtbaglan.php';
    $projeKod = $_POST["projeKod"];
    $etiket = $vt->real_escape_string($_POST["etiket"]);
    $kriterTur= $_POST["kriterTur"];
    if (!is_numeric($_POST["puan"])) {
        echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Puan alanına sayısal olmayan değer girmeyiniz!')
        window.location.href='kisiselsayfa.php?projeKod=$projeKod&kriter=1';  </SCRIPT>");
    } else {
        $puan = $_POST["puan"];
    }

    $sql = "INSERT INTO kriter (etiket, kriterTur, azamiPuan, projeKod) VALUES ('$etiket','$kriterTur', '$puan', '$projeKod')";

    if ($vt->query($sql)) {
        echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Proje kriteri başarıyla oluşturuldu!')
        window.location.href='kisiselsayfa.php?projeKod=$projeKod&kriter=1';  </SCRIPT>");
    } else {
        echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !');  </SCRIPT>");
    }
    include 'ayar/vtkapat.php';
}

                    /* ÖĞRENCİ KENDİSİ BİR AKTİF OTURUMA KAYIT OLUYORSA       */
if (isset($_POST["dersekaydol"])) {
  include 'ayar/vtbaglan.php';
  $aktifDersKod = $_POST["aktifDersKod"];
  $ogrenciKod = $_SESSION["kod"];
  $sql = "INSERT INTO ogrencialinanders (ogrenciKod, aktifDersKod) VALUES ('$ogrenciKod','$aktifDersKod')";
  if (!($vt->query($sql))) {
    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !');  </SCRIPT>");
  }
  include 'ayar/vtkapat.php';
  echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Derse kayıt oldunuz, hocanız onayladıktan sonra dersle ilgili etkinlikleri görebileceksiniz!')
  window.location.href='kisiselsayfa.php';  </SCRIPT>");
}

              /*             HERHANGİ BİR FORMDAN GELMİYORSA                  */
if (!isset($_POST)) {
    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Formu doldurup tekrar deneyiniz!')
    window.location.href='kisiselsayfa.php';  </SCRIPT>");
}
