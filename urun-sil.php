<?php

session_start();

if (empty($_SESSION['KULLANICI_ADI'])) {
    Header('Location:index.php');
    exit();
}


$urunNo = $_GET['urun-no'] ?? NULL;

if (!$urunNo) {
    header('urunler.php');
    exit();
}


try {
    $db = new PDO('mysql:host=localhost;dbname=site-veritabani;charset=utf8', 'root', '');
} catch (PDOException $e) {

    echo $e->getMessage();
    exit();
}


$sorgu = $db->prepare('DELETE FROM urunler WHERE NO=:no');
$sorgu->execute(['no' => $urunNo]);

header('location:urunler.php');
exit();

