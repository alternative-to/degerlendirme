-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3306
-- Üretim Zamanı: 14 Şub 2018, 15:40:07
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
DROP DATABASE IF EXISTS `degerlendirme`;
CREATE DATABASE IF NOT EXISTS `degerlendirme` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `degerlendirme`;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `akrandegerlendirme`
--

DROP TABLE IF EXISTS `akrandegerlendirme`;
CREATE TABLE IF NOT EXISTS `akrandegerlendirme` (
  `ogrenciKod` int(11) NOT NULL,
  `ogrProjeKod` int(11) NOT NULL,
  `kriterKod` int(11) NOT NULL,
  `puan` int(11) NOT NULL,
  PRIMARY KEY (`ogrenciKod`,`ogrProjeKod`,`kriterKod`),
  KEY `fk_ogrenci_has_ogrenciProjeleri_ogrenciProjeleri2_idx` (`ogrProjeKod`),
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
  `anahtar` varchar(10) NOT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT '1',
  `aciklama` text,
  PRIMARY KEY (`kod`),
  KEY `fk_aktifders_donem1_idx` (`donemKod`),
  KEY `fk_aktifders_ders1_idx` (`dersKod`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `aktifders`
--

INSERT INTO `aktifders` (`kod`, `donemKod`, `yil`, `dersKod`, `grupno`, `etiket`, `anahtar`, `aktif`, `aciklama`) VALUES
(2, 2, 2018, 3, 1, 'Kontrol Grubu', '', 1, NULL),
(3, 2, 2018, 3, 2, 'Deney Grubu', '', 1, NULL),
(4, 1, 2018, 1, 1, 'Kontrol Grubu', '', 1, NULL),
(5, 1, 2018, 1, 2, 'Deney Grubu', '', 1, NULL),
(6, 1, 2017, 1, 1, 'Kontrol Grubu', '', 1, NULL),
(7, 1, 2017, 1, 2, 'Deney Grubu', '', 1, NULL),
(8, 2, 2018, 6, 1, 'Kontrol Grubu', '', 1, NULL),
(9, 2, 2018, 6, 2, 'Deney Grubu', '', 1, NULL),
(10, 2, 2018, 5, 1, 'Deneme', '123', 1, NULL),
(11, 2, 2018, 5, 2, 'Deneme2', '123', 1, NULL),
(12, 2, 2018, 2, 1, '10:30', '123', 1, NULL),
(13, 2, 2018, 2, 2, '13:30', '1330', 1, NULL),
(14, 2, 2017, 1, 1, 'Grup 1', '', 1, NULL),
(15, 2, 2017, 1, 2, 'Grup 2', '', 1, NULL),
(16, 2, 2018, 4, 1, 'test1', '', 1, NULL),
(17, 2, 2018, 4, 2, 'test2', '', 1, NULL),
(18, 1, 2016, 5, 1, 'Grup 1', 'abc', 1, NULL),
(19, 1, 2016, 5, 2, 'Grup 2', 'abc', 1, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `calismagrubu`
--

DROP TABLE IF EXISTS `calismagrubu`;
CREATE TABLE IF NOT EXISTS `calismagrubu` (
  `ogrenciKod` int(11) NOT NULL,
  `ogrProjeKod` int(11) NOT NULL,
  PRIMARY KEY (`ogrenciKod`,`ogrProjeKod`),
  KEY `fk_ogrenci_has_ogrenciProjeleri_ogrenciProjeleri1_idx` (`ogrProjeKod`)
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
  `etiket` varchar(255) NOT NULL,
  `kriterTur` int(11) NOT NULL,
  `azamiPuan` int(11) NOT NULL,
  `projeKod` int(11) NOT NULL,
  PRIMARY KEY (`kod`),
  KEY `fk_kriter_kriterTuru1_idx` (`kriterTur`),
  KEY `fk_kriter_proje1_idx` (`projeKod`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `kriter`
--

INSERT INTO `kriter` (`kod`, `etiket`, `kriterTur`, `azamiPuan`, `projeKod`) VALUES
(1, '', 1, 3, 2),
(2, 'kriter1711306', 1, 3, 2),
(3, 'yok', 1, 3, 3),
(4, 'yeni', 2, 5, 3),
(5, 'deneme', 1, 3, 1),
(6, 'teslim edildi', 2, 4, 8);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kritertur`
--

DROP TABLE IF EXISTS `kritertur`;
CREATE TABLE IF NOT EXISTS `kritertur` (
  `kod` int(11) NOT NULL AUTO_INCREMENT,
  `etiket` varchar(255) NOT NULL,
  `seviye` int(11) NOT NULL,
  PRIMARY KEY (`kod`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `kritertur`
--

INSERT INTO `kritertur` (`kod`, `etiket`, `seviye`) VALUES
(1, 'Yok / Var', 2),
(2, 'Hayır / Evet', 2),
(3, 'Dereceli Kötü/Orta/İyi', 3);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ogrenci`
--

DROP TABLE IF EXISTS `ogrenci`;
CREATE TABLE IF NOT EXISTS `ogrenci` (
  `kod` int(11) NOT NULL AUTO_INCREMENT,
  `numara` int(11) DEFAULT NULL,
  `ad` varchar(255) NOT NULL,
  `soyad` varchar(255) NOT NULL,
  `kullaniciadi` varchar(255) NOT NULL,
  `sifre` char(40) NOT NULL,
  `eposta` varchar(255) NOT NULL,
  `ogretmen` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`kod`),
  UNIQUE KEY `kullaniciadi_UNIQUE` (`kullaniciadi`),
  UNIQUE KEY `eposta_UNIQUE` (`eposta`),
  UNIQUE KEY `numara` (`numara`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `ogrenci`
--

INSERT INTO `ogrenci` (`kod`, `numara`, `ad`, `soyad`, `kullaniciadi`, `sifre`, `eposta`, `ogretmen`) VALUES
(1, 123, 'aaa', 'vvv', '123', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'afsat@afsat.com', 1),
(2, NULL, 'Ahmet', 'Satıcı', '124', 'f38cfe2e2facbcc742bad63f91ad55637300cb45', 'asatici@asatici.com', 0),
(3, NULL, 'zubeyde', 'satıcı', 'zubeydeas', '612d9ec34bddce122042db4c143e86dca655bc15', 'zubeydeas@hotmail.com', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ogrencialinanders`
--

DROP TABLE IF EXISTS `ogrencialinanders`;
CREATE TABLE IF NOT EXISTS `ogrencialinanders` (
  `ogrenciKod` int(11) NOT NULL,
  `aktifDersKod` int(11) NOT NULL,
  `onay` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ogrenciKod`,`aktifDersKod`),
  KEY `fk_ogrenci_has_aktifders_aktifders1_idx` (`aktifDersKod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `ogrencialinanders`
--

INSERT INTO `ogrencialinanders` (`ogrenciKod`, `aktifDersKod`, `onay`) VALUES
(1, 16, 0),
(2, 3, 0),
(2, 5, 0),
(2, 6, 0),
(2, 8, 0),
(2, 16, 0),
(3, 16, 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `proje`
--

INSERT INTO `proje` (`kod`, `baslik`, `talimat`, `bitisTarihi`, `aktifDersKod`) VALUES
(1, 'deneme', 'gemilerde talim var bahriyeli yariiim var', '2018-12-31', 5),
(2, 'Proje 1711256', 'sadfasdf asdf asdf asdf ', '2018-12-31', 4),
(3, 'deneme', 'bla bla', '2018-12-31', 8),
(4, 'Proje622018', 'bla bla bla bla', '2018-12-30', 4),
(5, 'yeni proje', 'ha ha ha ha ha ha ha ha ha', '2018-12-29', 4),
(6, 'eski proje', 'ta ta ta ta ta ta ta ta ', '2018-12-28', 4),
(7, 'yeni yeni çok yeni', 'sadfasdf sadfasdf', '1234-12-12', 12),
(8, 'test', 'yok', '2018-12-28', 2);

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `akrandegerlendirme`
--
ALTER TABLE `akrandegerlendirme`
  ADD CONSTRAINT `akrandegerlendirme_ibfk_1` FOREIGN KEY (`ogrenciKod`) REFERENCES `ogrenci` (`kod`),
  ADD CONSTRAINT `fk_akrandegerlendirm_kriter1` FOREIGN KEY (`kriterKod`) REFERENCES `kriter` (`kod`) ON DELETE NO ACTION ON UPDATE NO ACTION,
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
  ADD CONSTRAINT `calismagrubu_ibfk_1` FOREIGN KEY (`ogrenciKod`) REFERENCES `ogrenci` (`kod`),
  ADD CONSTRAINT `fk_ogrenci_has_ogrenciProjeleri_ogrenciProjeleri1` FOREIGN KEY (`ogrProjeKod`) REFERENCES `ogrenciprojeleri` (`kod`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Tablo kısıtlamaları `kriter`
--
ALTER TABLE `kriter`
  ADD CONSTRAINT `fk_kriter_kriterTuru1` FOREIGN KEY (`kriterTur`) REFERENCES `kritertur` (`kod`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_kriter_proje1` FOREIGN KEY (`projeKod`) REFERENCES `proje` (`kod`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Tablo kısıtlamaları `ogrencialinanders`
--
ALTER TABLE `ogrencialinanders`
  ADD CONSTRAINT `fk_ogrenci_has_aktifders_aktifders1` FOREIGN KEY (`aktifDersKod`) REFERENCES `aktifders` (`kod`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ogrencialinanders_ibfk_1` FOREIGN KEY (`ogrenciKod`) REFERENCES `ogrenci` (`kod`);

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
