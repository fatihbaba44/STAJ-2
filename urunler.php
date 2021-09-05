<?php

session_start();

if (empty($_SESSION['KULLANICI_ADI'])) {
    Header('Location:index.php');
    exit();
}


try {

    $db = new PDO('mysql:host=localhost;dbname=site-veritabani;charset=utf8', 'root', '');
} catch (PDOException $e) {

    echo $e->getMessage();
    exit();
}

$sorgu = $db->query('SELECT * FROM urunler');
$urunler = $sorgu->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>

<head>
    <title>SANAYİ PAZARI</title>
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
            <a class="navbar-brand" href="urun-detay.php">Sanayi Pazarı</a>
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
            <h1 class="me-auto">Ürünler</h1>
            <div class="ms-auto">
                <a class="btn btn-success" href="urun-ekle.php">
                    <i class="fas fa-plus"></i>Ürün Ekle
                </a>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>AD</th>
                    <th>STOK</th>
                    <th>FİYAT</th>
                    <th>AÇIKLAMA</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($urunler as $satirNo => $urun) { ?>
                    <tr>
                        <td><?= $urun['NO'] ?></td>
                        <td><?= $urun['AD'] ?></td>
                        <td><?= $urun['STOK'] ?></td>
                        <td><?= $urun['FİYAT'] ?></td>
                        <td><?= $urun['AÇIKLAMA'] ?></td>
                        <td class="text-end">
                            <a class="btn btn-sm btn-primary" href="urun-duzenle.php?urun-no=<?=$urun['NO']?>">
                            <i class="fas fa-edit"></i> Düzenle</a>
                            <a class="btn btn-sm btn-danger" href="urun-sil.php?urun-no=<?=$urun['NO']?>">
                            <i class="fas fa-trash-alt"></i> Sil</a>
                        </td>
                    </tr>
                <?php  } ?>
            </tbody>
        </table>

    </div>

    <nav class="navbar fixed-bottom navbar-light bg-light">
        <div class="container">
            <span class="text-muted "><i class="far fa-copyright"></i> <?= date('Y') ?> - DGH ARGE </span>
        </div>
    </nav>

</body>


</html>