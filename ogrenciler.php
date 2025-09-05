<?php

include "config.php";

izinliMi();

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Öğrenciler</title>
   <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>

   <div class="ana_konteyner">

      <?= headerYukle() ?>
      <main><?php ogrenciTablosu($baglanti, TABLE_STUDENTS, 'Öğrencilerin listesi.') ?>
         </br><?php if (isset($_SESSION['admin'])) {
            yeniEklemeButonu('Ogrenci');
         } ?> </main>
      <footer>
         <?= footer() ?>
      </footer>
   </div>
</body>

</html>