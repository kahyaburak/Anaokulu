<?php

include "config.php";

izinliMi();

$mesaj = "";
$hata = false;

if (isset($_GET["id"])) {
   $id = $_GET["id"];
   try {
      $sonuc = birKayitSil($baglanti, $id, TABLE_WORKERS);
      if ($sonuc) {
         $mesaj = "Çalışan başarıyla silindi!";
      } else {

         throw new Exception("Çalışan silinemedi.");
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
   <title>Çalışan</title>
   <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>

   <div class="ana_konteyner">
      <?= headerYukle() ?>
      <main>
         <h1><?= $mesaj ?></h1>
         <?php ?>
      </main>
      <footer>
         <?= footer() ?>
      </footer>
   </div>
</body>

</html>