<?php

include "config.php";

izinliMi();

$mesaj = "Yeni Çalışan ekleme işlemini burada yapınız.";
$formGoster = true;
if (isset($_POST["submit"])) {
   unset($_POST["submit"]);
   try {
      $sonuc = calisanKayitiEkle($baglanti, TABLE_WORKERS, $_POST);
      if ($sonuc) {
         $mesaj = "Çalışan ekleme işlemi başarıyla tamamlandı!";
         $formGoster = false;
      } else {
         throw new Exception("Bir şeyler ters gitti.");
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
   <title>Çalışan ekle</title>
   <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>

   <div class="ana_konteyner">
      <?= headerYukle() ?>
      <main>
         <h1><?= $mesaj ?></h1>
         <?php
         if ($formGoster)
            calisanEklemeFormu() ?>
         </main>
         <footer>
         <?= footer() ?>
      </footer>
   </div>
</body>

</html>