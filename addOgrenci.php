<?php

include "config.php";

izinliMi();
$musaitSinif = uygunSiniflar($baglanti, TABLE_CLASSES);

$mesaj = "Yeni Öğrenci ekleme işlemini burada yapınız.";
$formGoster = true;
if (isset($_POST["submit"])) {
   unset($_POST["submit"]);
   try {
      $sonuc = ogrenciKayitiEkle($baglanti, TABLE_STUDENTS, $_POST);
      if ($sonuc) {
         $mesaj = "Öğrenci ekleme işlemi başarıyla tamamlandı!";
         $formGoster = false;
      } else {
         throw new Exception("Birşeyler ters gitti. Öğrenci eklenemedi.");
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
   <title>Öğrenci ekle</title>
   <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>

   <div class="ana_konteyner">
      <?= headerYukle() ?>
      <main>
         <h1><?= $mesaj ?></h1>
         <?php
         if ($formGoster)
            ogrenciEklemeFormu($musaitSinif) ?>
         </main>
         <footer>
         <?= footer() ?>
      </footer>
   </div>
</body>

</html>