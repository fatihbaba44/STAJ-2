<?php
session_start();

if (!empty($_SESSION['KULLANICI_ADI'])) {
    Header('Location:urunler.php');
    exit();
}

$kullaniciAdi = $_POST['kullanici-adi'] ?? null;
$sifre = $_POST['sifre'] ?? null;
$hataMesaj = '';

$validasyon = [
    'kullaniciAdi' => [
        'class' => '',
        'msg' => ''
    ],
    'sifre' => [
        'class' => '',
        'msg' => ''
    ]
];

if ($_POST) {
    try {

        $db = new PDO('mysql:host=localhost;dbname=site-veritabani;charset=utf8', 'root', '');
    } catch (PDOException $e) {

        echo $e->getMessage();
        exit();
    }
    $sorgu = $db->prepare("SELECT * FROM kullanicilar WHERE KULLANICI_ADI=:kullaniciAdi");
    $sorgu->execute(['kullaniciAdi' => $kullaniciAdi]);
    $kullanici = $sorgu->fetch(PDO::FETCH_ASSOC);

    if ($kullanici) { //KULLANICI VARSA
        if ($sifre === $kullanici['SİFRE']) { //GİRİŞ DOĞRU
            $_SESSION['KULLANICI_ADI'] = $kullaniciAdi;
            Header('Location:urunler.php');
        } else {
            $validasyon['kullaniciAdi']['class'] = 'is-valid';
            $validasyon['kullaniciAdi']['msg']   = '';
            $validasyon['sifre']['class']        = 'is-invalid';
            $validasyon['sifre']['msg']          = 'Şifreniz hatalı';
        }
    } else { //KULLANICI YOKSA
        $validasyon['kullaniciAdi']['class'] = 'is-invalid';
        $validasyon['kullaniciAdi']['msg']   = 'Böyle bir kullanıcı yok';
        $validasyon['sifre']['class']        = 'is-invalid';
        $validasyon['sifre']['msg']          = '';
    }
}

?>
<!DOCTYPE html>
<html class="h-100">

<head>
    <title>Giriş Yap</title>
    <style>
        body {
            background-image: url("image/sanayi.jpg");
            background-size: cover;
            background-repeat: no-repeat;
        }
     
    </style>
    <!--BOOSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>

    <!-- FONT AWASOME-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

 

</head>

<body class="h-100 d-flex align-items-center">

    <div class="mx-auto" style="width: 330px;">
  
        <h1>Yönetim Paneli</h1>
        <?php if ($hataMesaj) {
            echo "<p style='color:red;'>$hataMesaj</p>";
        } ?>
        <form action="index.php" method="POST">
            
            <div class="mb-3 ">
                <label>Kullanıcı Adı</label><span class="text-danger"><?= $validasyon['kullaniciAdi']['msg'] ?></span>
                <input class="form-control <?= $validasyon['kullaniciAdi']['class'] ?>" type="text" name="kullanici-adi" autocomplete="off" value="" required />
                
            </div>
            <div class="mb-3">
                <label>Şifre</label><span class="text-danger"><?= $validasyon['sifre']['msg'] ?></span>
                <input class="form-control <?= $validasyon['sifre']['class'] ?>" type="password" name="sifre" required />
            </div>
            <button class="btn btn-primary">Giriş</button>
        </form> 
    </div>


</body>


</html>