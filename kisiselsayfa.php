<?php
session_start();
if (!$_SESSION["yetki"]) { /*GİRİŞ YAPMAMIŞSA */
    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Lütfen önce giriş yapınız!') window.location.href='girisform.php';  </SCRIPT>");
} else { /*GİRİŞ YAPMIŞSA */
    if ($_SESSION["ogretmen"]){ /* ÖĞRETMENSE */
        if (isset($_GET["dersKod"])){ /* LİSTEDEN BİR DERS SEÇTİYSE */
            if (!is_numeric($_GET["dersKod"])) {
                    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu, lütfen tekrar deneyiniz!') window.location.href='kisiselsayfa.php';  </SCRIPT>");
            } else {
                include 'views/view_aktifderslistesi.php'; // Tamamlandı
            }
        } elseif (isset($_GET["aktifDersKod"])){ /* LİSTEDEN BİR AKTİF OTURUM SEÇTİYSE */
            if (!is_numeric($_GET["aktifDersKod"])) {
                echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu, lütfen tekrar deneyiniz!') window.location.href='kisiselsayfa.php';  </SCRIPT>");
            } elseif (isset($_GET["ogrenciListe"])) { /* AKTİF OTURUMDAKİ ÖĞRENCİLERİ LİSTELEMEYİ SEÇTİYSE */
                include 'views/view_ogrencilistesi.php'; // Üzerinde çalışıyorum...
            } elseif (isset($_GET["projeListe"])) { /* AKTİF OTURUMDAKİ PROJELERİ LİSTELEMEYİ SEÇTİYSE */
                include 'views/view_projelistesi.php'; // Tamamlandı...
            } else { /* FARKLI BİR YOLDAN GELDİYSE */
                echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Hangi işlemi yapmak istediğiniz anlaşılmadı, lütfen tekrar deneyiniz!') window.location.href='kisiselsayfa.php';  </SCRIPT>");
            }
        } elseif (isset($_GET["projeKod"])){ /* LİSTEDEN BİR  PROJE SEÇTİYSE */
            if (!is_numeric($_GET["projeKod"])) {
                    echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu, lütfen tekrar deneyiniz!') window.location.href='kisiselsayfa.php';  </SCRIPT>");
            } elseif (isset($_GET["ogrenciProjeleri"])) { /* ÖĞRENCİ PROJELERİNİ LİSTELEMEYİ SEÇTİYSE */
                include 'views/view_ogrenciprojelistesi.php';
            } elseif (isset($_GET["kriter"])) { /* PROJE KRİTERLERİNİ LİSTELEMEYİ SEÇTİYSE */
                include 'views/view_projekriterlerilistesi.php'; // Tamamlandı...
            } else { /* ??? */
                echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Proje sayfasında bir hata oluştu, lütfen tekrar deneyiniz!') window.location.href='kisiselsayfa.php';  </SCRIPT>");
            }
        } else {
            include 'views/view_dersliste.php'; // Tamam
        }
    } else { /* ÖĞRENCİYSE */
      if (isset($_GET["ogrenciaktifderskayit"])) {
        include 'views/view_ogrenci_aktifderslistesi.php';
      } elseif (isset($_GET["ogrencikritergor"]) AND (isset($_GET['projeKod']))) {
                                                // ÖĞRENCİ PROJE KRİTERLERİNİ GÖRÜNTÜLEMEYİ SEÇTİYSE ...
        include 'views/view_ogrenci_projekriterleri.php';
      } elseif (isset($_GET["ogrencikritergor"]) AND (isset($_GET['projeKod']))) {
                                                // ÖĞRENCİ GRUP ARKADAŞLARINI GÖRÜNTÜLEMEYİ SEÇTİYSE ...
        include 'views/view_ogrenci_projekriterleri.php';
      else {
        include 'views/view_ogrenci.php';
      }
    }
}
?>
