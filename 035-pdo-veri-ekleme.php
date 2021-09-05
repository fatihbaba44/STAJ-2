<?php

try{

    $db = new PDO('mysql:host=localhost;dbname=site-veritabani;charset=utf8','root','');

}catch(PDOException $e){

    echo $e->getMessage();
    exit();
}


$sorgu = $db->query('SELECT * FROM urunler');
$urunler = $sorgu->fetchAll(PDO::FETCH_ASSOC);

echo '<pre>';
print_r($urunler);
echo '</pre>';

?>