<?php
echo "Kişisel Sayfanıza Hoş Geldiniz!<br />";
switch ($_SESSION["yonlendirme"]) {
case "dersgoster":
    $dersKod = $_SESSION["dersKod"];
    dersismigoster($dersKod);
    break;
case "aktifdersgoster":
    $dersKod = $_SESSION["dersKod"];
    dersismigoster($dersKod); 
    $aktifDersKod = $_SESSION["aktifDersKod"];
    aktifdersismigoster($aktifDersKod);
    break;
case "ogrencilistegoster":
    $dersKod = $_SESSION["dersKod"];
    dersismigoster($dersKod); 
    $aktifDersKod = $_SESSION["aktifDersKod"];
    aktifdersismigoster($aktifDersKod);
    break;
case "projegoster":
    $dersKod = $_SESSION["dersKod"];
    dersismigoster($dersKod); 
    $aktifDersKod = $_SESSION["aktifDersKod"];
    aktifdersismigoster($aktifDersKod);
    $projeKod = $_SESSION["projeKod"];
    projeismigoster($projeKod);     
    break;
}

function dersismigoster($dersKod) {
    echo "<p> Seçtiğiniz Ders: ";
    include 'ayar/vtbaglan.php';

    $sql = "SELECT * FROM ders WHERE kod = $dersKod";
    if ($sonuc = $vt->query($sql)) {
        $satir = $sonuc->fetch_assoc();
        $dersAdi = $satir["ad"];  
    } else { 
        echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !') </SCRIPT>");
    }
    echo $dersAdi."</p>\r\n";
    include 'ayar/vtkapat.php';
}

function aktifdersismigoster($aktifDersKod) {
    echo "<p> Seçtiğiniz Grup: ";
    include 'ayar/vtbaglan.php';

    $sql = "SELECT * FROM donem";

    if ($sonuc = $vt->query($sql)) {
        while($satir = $sonuc->fetch_assoc()) {
            $donem[] = $satir;
        }   
    } else { 
        echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !') </SCRIPT>");
    }

    $sql = "SELECT * FROM aktifders WHERE kod = $aktifDersKod";
    if ($sonuc = $vt->query($sql)) {
        $satir = $sonuc->fetch_assoc();
        $aktifDersAdi = $satir["yil"]. " yılı ". $donem[$satir['donemKod']-1]['etiket']. " dönemi ". $satir["etiket"]. " grubu";
                ;  
    } else { 
        echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !') </SCRIPT>");
    }
    echo $aktifDersAdi."</p>\r\n";
    include 'ayar/vtkapat.php';
}

function projeismigoster($projeKod) {
    echo "<p> Seçtiğiniz Proje: ";
    include 'ayar/vtbaglan.php';

    $sql = "SELECT * FROM proje WHERE kod = $projeKod";
    if ($sonuc = $vt->query($sql)) {
        $satir = $sonuc->fetch_assoc();
        $projeEtiket = $satir["bitisTarihi"]. " tarihinde teslim edilecek  <b>".  $satir["baslik"]. "</b> başlıklı</p> <p> Talimat: ".$satir["talimat"]."</p>"; 
    } else { 
        echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Bir hata oluştu: $vt->error ve SQL: $sql !') </SCRIPT>");
    }
    echo $projeEtiket."\r\n";
    include 'ayar/vtkapat.php';
}