<?php

include "config.php";

izinliMi();

$mesaj = "";
$formGoster = false;

if (isset($_GET["id"])) {
   $id = $_GET["id"];
   try {
      $sonuc = birKayitAl($baglanti, $id, TABLE_CLASSES);
      if ($sonuc) {
         $formGoster = true;
      } else {

         throw new Exception("Sınıf bulunamadı");
      }
   } catch (Exception $e) {
      $mesaj = $e->getMessage();
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Sınıf detayları.</title>
   <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>

   <div class="ana_konteyner">
      <?= headerYukle() ?>
      <main>
         <h1><?= $mesaj ?></h1>
         <?php
         if ($formGoster)
            sinif($baglanti, $sonuc) ?>
            </main>
            <footer>
         <?= footer() ?>
      </footer>
   </div>
</body>

</html>