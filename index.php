<?php

include "config.php";


?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Anaokulu yönetim sistemi.</title>
   <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>


   <div class="ana_konteyner">
      <?= headerYukle() ?>
      <main>
         <?php if (!isset($_SESSION['user'])) { ?>
            <h1>Merhaba, Lütfen giriş yapınız veya yeni kullanıcı oluşturunuz.</h1>
         <?php } else { ?>
            <h1>Hoşgeldiniz.</h1>
         <?php } ?>
         <?= tarihGoster() ?>
      </main>
      <footer>
         <?= footer() ?>
      </footer>
   </div>
</body>

</html>