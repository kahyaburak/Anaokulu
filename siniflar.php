<?php

include "config.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Sınıflar</title>
   <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>

   <div class="ana_konteyner">

      <?= headerYukle() ?>
      <main><?php sinifTablosu($baglanti, TABLE_CLASSES, 'Sınıfların listesi.') ?>
         </br><?php if (isset($_SESSION['admin'])) {
            yeniEklemeButonu('Sinif');
         } ?>
      </main>
      <footer>
         <?= footer() ?>
      </footer>
   </div>
</body>

</html>