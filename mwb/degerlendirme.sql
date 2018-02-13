-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3306
-- Üretim Zamanı: 15 Oca 2018, 14:00:39
-- Sunucu sürümü: 5.7.19
-- PHP Sürümü: 7.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `degerlendirme`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `akrandegerlendirme`
--

DROP TABLE IF EXISTS `akrandegerlendirme`;
CREATE TABLE IF NOT EXISTS `akrandegerlendirme` (
  `ogrenciNo` int(11) NOT NULL,
  `ogrProjeKod` int(11) NOT NULL,
  `kriterKod` int(11) NOT NULL,
  `puan` int(11) NOT NULL,
  PRIMARY KEY (`ogrenciNo`,`ogrProjeKod`,`kriterKod`),
  KEY `fk_ogrenci_has_ogrenciProjeleri_ogrenciProjeleri2_idx` (`ogrProjeKod`),
  KEY `fk_ogrenci_has_ogrenciProjeleri_ogrenci2_idx` (`ogrenciNo`),
  KEY `fk_akrandegerlendirm_kriter1_idx` (`kriterKod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `aktifders`
--

DROP TABLE IF EXISTS `aktifders`;
CREATE TABLE IF NOT EXISTS `aktifders` (
  `kod` int(11) NOT NULL AUTO_INCREMENT,
  `donemKod` int(11) NOT NULL,
  `yil` year(4) NOT NULL,
  `dersKod` int(11) NOT NULL,
  `grupno` int(11) NOT NULL,
  `etiket` varchar(255) NOT NULL,
  `aciklama` text,
  PRIMARY KEY (`kod`),
  KEY `fk_aktifders_donem1_idx` (`donemKod`),
  KEY `fk_aktifders_ders1_idx` (`dersKod`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `aktifders`
--

INSERT INTO `aktifders` (`kod`, `donemKod`, `yil`, `dersKod`, `grupno`, `etiket`, `aciklama`) VALUES
(2, 2, 2018, 3, 1, 'Kontrol Grubu', NULL),
(3, 2, 2018, 3, 2, 'Deney Grubu', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `calismagrubu`
--

DROP TABLE IF EXISTS `calismagrubu`;
CREATE TABLE IF NOT EXISTS `calismagrubu` (
  `ogrenciNo` int(11) NOT NULL,
  `ogrProjeKod` int(11) NOT NULL,
  PRIMARY KEY (`ogrenciNo`,`ogrProjeKod`),
  KEY `fk_ogrenci_has_ogrenciProjeleri_ogrenciProjeleri1_idx` (`ogrProjeKod`),
  KEY `fk_ogrenci_has_ogrenciProjeleri_ogrenci1_idx` (`ogrenciNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ders`
--

DROP TABLE IF EXISTS `ders`;
CREATE TABLE IF NOT EXISTS `ders` (
  `kod` int(11) NOT NULL AUTO_INCREMENT,
  `ad` varchar(255) NOT NULL,
  PRIMARY KEY (`kod`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `ders`
--

INSERT INTO `ders` (`kod`, `ad`) VALUES
(1, 'İnternet Tabanlı Programlama'),
(2, 'Veri Tabanı Yönetim Sistemleri'),
(3, 'Uzaktan Eğitim'),
(4, 'Eğitimde Grafik ve Canlandırma'),
(5, 'Çağdaş Öğrenme Teorileri'),
(6, 'İstatistik');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `donem`
--

DROP TABLE IF EXISTS `donem`;
CREATE TABLE IF NOT EXISTS `donem` (
  `kod` int(11) NOT NULL AUTO_INCREMENT,
  `etiket` varchar(255) NOT NULL,
  PRIMARY KEY (`kod`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `donem`
--

INSERT INTO `donem` (`kod`, `etiket`) VALUES
(1, 'Güz'),
(2, 'Bahar'),
(3, 'Yaz');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kriter`
--

DROP TABLE IF EXISTS `kriter`;
CREATE TABLE IF NOT EXISTS `kriter` (
  `kod` int(11) NOT NULL AUTO_INCREMENT,
  `sirano` int(11) NOT NULL,
  `kriterTuru` int(11) NOT NULL,
  `maxPuan` int(11) NOT NULL,
  `proje_kod` int(11) NOT NULL,
  PRIMARY KEY (`kod`),
  KEY `fk_kriter_kriterTuru1_idx` (`kriterTuru`),
  KEY `fk_kriter_proje1_idx` (`proje_kod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kriterturu`
--

DROP TABLE IF EXISTS `kriterturu`;
CREATE TABLE IF NOT EXISTS `kriterturu` (
  `kod` int(11) NOT NULL AUTO_INCREMENT,
  `etiket` varchar(255) NOT NULL,
  `seviye` int(11) NOT NULL,
  PRIMARY KEY (`kod`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `kriterturu`
--

INSERT INTO `kriterturu` (`kod`, `etiket`, `seviye`) VALUES
(1, 'Yok / Var', 2),
(2, 'Hayır / Evet', 2),
(3, 'Dereceli Kötü/Orta/İyi', 3);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ogrenci`
--

DROP TABLE IF EXISTS `ogrenci`;
CREATE TABLE IF NOT EXISTS `ogrenci` (
  `numara` int(11) NOT NULL,
  `ad` varchar(255) NOT NULL,
  `soyad` varchar(255) NOT NULL,
  `kullaniciadi` varchar(255) NOT NULL,
  `sifre` char(40) NOT NULL,
  `eposta` varchar(255) NOT NULL,
  `ogretmen` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`numara`),
  UNIQUE KEY `kullaniciadi_UNIQUE` (`kullaniciadi`),
  UNIQUE KEY `eposta_UNIQUE` (`eposta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `ogrenci`
--

INSERT INTO `ogrenci` (`numara`, `ad`, `soyad`, `kullaniciadi`, `sifre`, `eposta`, `ogretmen`) VALUES
(123, 'aaa', 'vvv', '123', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'afsat@afsat.com', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ogrencialinanders`
--

DROP TABLE IF EXISTS `ogrencialinanders`;
CREATE TABLE IF NOT EXISTS `ogrencialinanders` (
  `ogrNo` int(11) NOT NULL,
  `aktifDersKod` int(11) NOT NULL,
  PRIMARY KEY (`ogrNo`,`aktifDersKod`),
  KEY `fk_ogrenci_has_aktifders_aktifders1_idx` (`aktifDersKod`),
  KEY `fk_ogrenci_has_aktifders_ogrenci1_idx` (`ogrNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ogrenciprojeleri`
--

DROP TABLE IF EXISTS `ogrenciprojeleri`;
CREATE TABLE IF NOT EXISTS `ogrenciprojeleri` (
  `kod` int(11) NOT NULL AUTO_INCREMENT,
  `projeKod` int(11) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`kod`),
  KEY `fk_calismaGrubu_proje1_idx` (`projeKod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `proje`
--

DROP TABLE IF EXISTS `proje`;
CREATE TABLE IF NOT EXISTS `proje` (
  `kod` int(11) NOT NULL AUTO_INCREMENT,
  `baslik` varchar(255) NOT NULL,
  `talimat` text,
  `bitisTarihi` date DEFAULT NULL,
  `aktifDersKod` int(11) NOT NULL,
  PRIMARY KEY (`kod`),
  KEY `fk_proje_aktifders1_idx` (`aktifDersKod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `akrandegerlendirme`
--
ALTER TABLE `akrandegerlendirme`
  ADD CONSTRAINT `fk_akrandegerlendirm_kriter1` FOREIGN KEY (`kriterKod`) REFERENCES `kriter` (`kod`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ogrenci_has_ogrenciProjeleri_ogrenci2` FOREIGN KEY (`ogrenciNo`) REFERENCES `ogrenci` (`numara`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ogrenci_has_ogrenciProjeleri_ogrenciProjeleri2` FOREIGN KEY (`ogrProjeKod`) REFERENCES `ogrenciprojeleri` (`kod`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Tablo kısıtlamaları `aktifders`
--
ALTER TABLE `aktifders`
  ADD CONSTRAINT `fk_aktifders_ders1` FOREIGN KEY (`dersKod`) REFERENCES `ders` (`kod`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_aktifders_donem1` FOREIGN KEY (`donemKod`) REFERENCES `donem` (`kod`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Tablo kısıtlamaları `calismagrubu`
--
ALTER TABLE `calismagrubu`
  ADD CONSTRAINT `fk_ogrenci_has_ogrenciProjeleri_ogrenci1` FOREIGN KEY (`ogrenciNo`) REFERENCES `ogrenci` (`numara`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ogrenci_has_ogrenciProjeleri_ogrenciProjeleri1` FOREIGN KEY (`ogrProjeKod`) REFERENCES `ogrenciprojeleri` (`kod`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Tablo kısıtlamaları `kriter`
--
ALTER TABLE `kriter`
  ADD CONSTRAINT `fk_kriter_kriterTuru1` FOREIGN KEY (`kriterTuru`) REFERENCES `kriterturu` (`kod`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_kriter_proje1` FOREIGN KEY (`proje_kod`) REFERENCES `proje` (`kod`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Tablo kısıtlamaları `ogrencialinanders`
--
ALTER TABLE `ogrencialinanders`
  ADD CONSTRAINT `fk_ogrenci_has_aktifders_aktifders1` FOREIGN KEY (`aktifDersKod`) REFERENCES `aktifders` (`kod`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ogrenci_has_aktifders_ogrenci1` FOREIGN KEY (`ogrNo`) REFERENCES `ogrenci` (`numara`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Tablo kısıtlamaları `ogrenciprojeleri`
--
ALTER TABLE `ogrenciprojeleri`
  ADD CONSTRAINT `fk_calismaGrubu_proje1` FOREIGN KEY (`projeKod`) REFERENCES `proje` (`kod`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Tablo kısıtlamaları `proje`
--
ALTER TABLE `proje`
  ADD CONSTRAINT `fk_proje_aktifders1` FOREIGN KEY (`aktifDersKod`) REFERENCES `aktifders` (`kod`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
