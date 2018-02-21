<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "degerlendirme";

// Create connection
$vt = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$vt) {
    die("Bağlanılamadı: " . mysqli_connect_error());
}

/* change character set to utf8 */
if (!$vt->set_charset("utf8")) {
    printf("Error loading character set utf8: %s\n", $mysqli->error);
    exit();
}
?>
