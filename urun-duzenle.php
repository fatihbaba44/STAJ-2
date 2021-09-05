<?php
session_start();

if (empty($_SESSION['KULLANICI_ADI'])) {

    header('location:index.php');
    exit();
}


try {

    $db = new PDO('mysql:host=localhost;dbname=site-veritabani;charset=utf8', 'root', '');
} catch (PDOException $e) {

    echo $e->getMessage();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $urunNo = $_GET['urun-no'] ?? NULL;
    if (!$urunNo) {
        header('location:urunler.php');
        exit();
    }

    $sorgu = $db->prepare('SELECT * FROM urunler WHERE NO=:no');
    $sorgu->execute(['no' => $urunNo]);
    $urun = $sorgu->fetch(PDO::FETCH_ASSOC);

    if (!$urun) {
        header('location:urunler.php');
        exit();
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $no   = $_POST['no']    ?? null;
    $ad    = $_POST['ad']    ?? null;
    $stok  = $_POST['stok']  ?? null;
    $fiyat = $_POST['fiyat'] ?? null;
    $aciklama = $_POST['aciklama'] ?? null;

    if (!$no) {
        header('location:urunler.php');
        exit();
    }


    $sorgu = $db->prepare('UPDATE urunler SET AD=:ad, STOK=:stok, FİYAT=:fiyat, AÇIKLAMA=:aciklama WHERE NO=:no');
    $sorgu->execute([
        'no' => $no,
        'ad' => $ad,
        'stok' => $stok,
        'fiyat' => $fiyat,
        'aciklama' => $aciklama
    ]);

    header('location:urunler.php');
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Ürün Düzenle</title>
    <style type="text/css">
        th {
            text-align: left;
        }
    </style>

    <!--BOOSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>

    <!-- FONT AWASOME-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>



    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Sanayi Pazarı</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" href="urunler.php">Ürünler</a>
                </div>
                <div class="navbar-nav ms-auto">
                    <a class="nav-link active" href="cikis.php">
                        <i class="fas fa-sign-out-alt"></i>
                        Çıkış Yap
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container pt-5">

        <div class="d-flex">
            <h1 class="me-auto">Ürün Düzenle</h1>
            <div class="ms-auto">
                <a class="btn btn-success" href="urunler.php">
                    <i class="fas fa-backward"></i>Geri Gel
                </a>
            </div>
        </div>

        <form action="urun-duzenle.php" method="post">

            <input type="hidden" name="no" value="<?= $urun['NO'] ?>" />
            <div class="mb-3">
                <label>Ad</label><span class="text-danger"></span>
                <input class="form-control " type="text" name="ad" autocomplete="off" value="<?= $urun['AD'] ?>" required />
            </div>
            <div class="mb-3">
                <label>Stok</label><span class="text-danger"></span>
                <input class="form-control" type="number" name="stok" value="<?= $urun['STOK'] ?>" required />
            </div>
            <div class="mb-3">
                <label>Fiyat</label><span class="text-danger"></span>
                <input class="form-control " type="number" step="0.01" name="fiyat" value="<?= $urun['FİYAT'] ?>" required />
            </div>
            <div class="mb-3">
                <label>Açıklama</label><span class="text-danger"></span>
                <input class="form-control " type="text"  name="aciklama" autocomplete="off"  value="<?= $urun['AÇIKLAMA'] ?>" required />
            </div>
            <button class="btn btn-primary btn-lg w-100">TAMAM</button>
        </form>

    </div>
    <nav class="navbar fixed-bottom navbar-light bg-light">
        <div class="container">
            <span class="text-muted"><i class="far fa-copyright"></i> <?= date('Y') ?> - DGH ARGE </span>
        </div>
    </nav>

</body>

</html>