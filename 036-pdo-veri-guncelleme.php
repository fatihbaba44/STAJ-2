<?php


$db = new PDO('mysql:host=localhost;dbname=site-veritabani;charset=utf8','root','');

$silmeSorgusu = $db->prepare('DELETE FROM urunler WHERE NO=:no');
$silmeSorgusu->execute([':no' => 2]);

if($silmeSorgusu->errorInfo()[1]){
    echo $silmeSorgusu->errorInfo()[2];
    exit();
}


$sorgu = $db->query('SELECT * FROM urunler');
$urunler = $sorgu->fetchAll(PDO::FETCH_ASSOC);

echo '<pre>';
print_r($urunler);
echo '</pre>';

?>