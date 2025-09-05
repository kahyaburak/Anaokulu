<?php

function izinliMi()
{

   if (!isset($_SESSION["admin"])) {
      header("Location: index.php");
   }
}

function headerYukle()
{
   $user = "Ziyaretci";
   if (isset($_SESSION['user'])) {

      $user = $_SESSION["user"];
   }
   if (isset($_SESSION['admin'])) {
      $user = $_SESSION['admin'];
   }

   ?>
   <header>
      <h1>Anaokulu Yönetim sistemi</h1>
      <?= navigasyonBar() ?>
      <div class="kullanici_giris">
         <p>Hoşgeldin <?= $user ?>.</p>
      </div>
   </header>
   <?php
}

function navigasyonBar()
{
   $str = "<nav><ul> 
    <li><a href='index.php'>Ana menü</a></li> ";

   if (!isset($_SESSION['user'])) {

      $str .= "<li><a href='register.php'>Yeni kullanıcı oluştur</a></li>
             <li><a href='login.php'>Giriş yap</a></li>";
   } else {

      $str .= "<li><a href='logout.php'>Çıkış yap</a></li>
                 <li><a href='siniflar.php'>Sınıflar</a></li> ";


      if (isset($_SESSION['admin'])) {
         $str .= "<li><a href='calisanlar.php'>Çalışanlar</a></li>
                 <li><a href='ogrenciler.php'>Öğrenciler</a></li>
                 <li><a href='ogretmenler.php'>Öğretmenler</a></li>
                 <li><a href='yoneticiPaneli.php'>Yönetici Paneli</a></li>";
      }
   }

   $str .= "</ul></nav>";
   return $str;
}
function footer()
{
   return "<footer> &copy;2024 Burak Kahya. Tüm hakları saklıdır.</footer>";
}


function ogrenciTablosu($handle, $table, $mesaj)
{
   ?>
   <h1><?= $mesaj ?></h1>
   <table class="tablo" cellpadding="0" cellspacing="0">
      <thead>
         <tr>
            <th>No.</th>
            <th>İsim</th>
            <th>Soyadı</th>
            <th>Hastalık</th>
            <th>Ebeveyn İsmi</th>
            <th>Ebeveyn Telefon numarası</th>
            <th>Doğum yılı</th>
            <th>Sınıf id</th>
            <th>Aksiyon</th>
         </tr>
      </thead>
      <tbody>
         <?php
         $sonuc = tumKayitlariAl($handle, $table);
         while ($row = mysqli_fetch_array($sonuc)) {
            ?>
            <tr>
               <td><?= $row['id'] ?></td>
               <td><?= $row['name'] ?></td>
               <td><?= $row['surname'] ?></td>
               <td><?= $row['illnesses'] ?></td>
               <td><?= $row['parent_name'] ?></td>
               <td><?= $row['parent_phone'] ?></td>
               <td><?= $row['birth_year'] ?></td>
               <td><?= $row['class_id'] ?></td>

               <td>
                  <ul>
                     <li><a href="editOgrenci.php?id=<?= $row['id'] ?>">Düzenle</a></li>
                     <li><a href="deleteOgrenci.php?id=<?= $row['id'] ?>">Sil</a></li>
                  </ul>
               </td>
            </tr>
         <?php } ?>
      </tbody>
   </table>
   <?php
}

function sinifTablosu($handle, $table, $mesaj)
{
   ?>
   <h1><?= $mesaj ?></h1>
   <table class="tablo" cellpadding="0" cellspacing="0">
      <thead>
         <tr>
            <th>Sınıf numarası</th>
            <th>Adı</th>
            <th>Öğretmen numarası</th>
            <?php
            if (isset($_SESSION["admin"])) { ?>
               <th>Aksiyonlar</th><?php } ?>
         </tr>
      </thead>
      <tbody>
         <?php
         $sonuc = tumKayitlariAl($handle, $table);
         while ($row = mysqli_fetch_array($sonuc)) {
            ?>
            <tr>
               <td><?= $row['id'] ?></td>
               <td><?= $row['name'] ?></td>
               <td><?= $row['teacher_id'] ?></td>

               <?php
               if (isset($_SESSION["admin"])) { ?>
                  <td>
                     <ul>
                        <li><a href="seeSinif.php?id=<?= $row['id'] ?>">Görüntüle</a></li>
                        <li><a href="editSinif.php?id=<?= $row['id'] ?>">Düzenle</a></li>
                        <li><a href="deleteSinif.php?id=<?= $row['id'] ?>">Sil</a></li>
                     </ul>
                  </td>
               <?php } ?>
            </tr>
         <?php } ?>
      </tbody>
   </table>
   <?php
}

function sinif($handle, $sonuc)
{

   $class = mysqli_fetch_array($sonuc);
   $teacherResult = birKayitAl($handle, $class['teacher_id'], TABLE_TEACHERS);
   $teacher = mysqli_fetch_array($teacherResult);
   $studentCount = ogrenciSayisi($handle, $class['id']);

   ?>
   <h1><?= $class['name'] ?> detaylari</h1>
   <h2>Öğrenci sayisi: <?= $studentCount ?> </h2>
   <h2>Öğretmen adı soyadı: <?= $teacher['name'] ?>    <?= $teacher['surname'] ?></h2>
   <h2>Öğrenci bilgileri:</h2>
   <table class="tablo" cellpadding="0" cellspacing="0">
      <thead>
         <tr>
            <th>No.</th>
            <th>İsim</th>
            <th>Soyadı</th>
            <th>Hastalık</th>
            <th>Ebeveyn İsmi</th>
            <th>Ebeveyn Telefon numarası</th>
            <th>Doğum yili</th>
            <th>Sınıf id</th>
            <th>Aksiyonlar</th>
         </tr>
         </tr>
      </thead>
      <tbody>
         <?php
         $ogrenciler = tumKayitlariAl($handle, TABLE_STUDENTS, 'class_id', $class['id']);
         while ($row = mysqli_fetch_array($ogrenciler)) {
            ?>
            <tr>
               <td>
                  <?= $row['id'] ?>
               </td>
               <td>
                  <?= $row['name'] ?>
               </td>
               <td>
                  <?= $row['surname'] ?>
               </td>
               <td><?= $row['illnesses'] ?></td>
               <td><?= $row['parent_name'] ?></td>
               <td>
                  <?= $row['parent_phone'] ?>
               </td>
               <td>
                  <?= $row['birth_year'] ?>
               </td>
               <td>
                  <?= $row['class_id'] ?>
               </td>
               </td>
               <td>
                  <ul>
                     <li><a href="deleteOgrenci.php?id=<?= $row['id'] ?>">Sil</a></li>
                     <li><a href="editOgrenci.php?id=<?= $row['id'] ?>">Düzenle</a></li>
                  </ul>
               </td>


            </tr>
         <?php } ?>
      </tbody>
   </table>
   <?php
}

function ogretmenTablosu($handle, $table, $mesaj)
{
   ?>
   <h1><?= $mesaj ?></h1>
   <table class="tablo" cellpadding="0" cellspacing="0">
      <thead>
         <tr>
            <th>Adı</th>
            <th>Soyadı</th>
            <th>Sınıf numarası</th>

            <th>Öğretmen numarası</th>
            <th>Maaşı</th>
            <th>Aksiyonlar</th>
         </tr>
      </thead>
      <tbody>
         <?php
         $sonuc = tumKayitlariAl($handle, $table);
         while ($row = mysqli_fetch_array($sonuc)) {
            ?>
            <tr>
               <td><?= $row['name'] ?></td>
               <td><?= $row['surname'] ?></td>
               <td><?= $row['class_id'] ?></td>

               <td><?= $row['id'] ?></td>
               <td><?= $row['pay'] ?></td>
               <td>
                  <ul>
                     <li><a href="editOgretmen.php?id=<?= $row['id'] ?>">Düzenle</a></li>
                     <li><a href="deleteOgretmen.php?id=<?= $row['id'] ?>">Sil</a></li>
                  </ul>
               </td>
            </tr>
         <?php } ?>
      </tbody>
   </table>
   <?php
}
function calisanTablosu($handle, $table, $mesaj)
{
   ?>
   <h1><?= $mesaj ?></h1>
   <table class="tablo" cellpadding="0" cellspacing="0">
      <thead>
         <tr>
            <th>Adı</th>
            <th>Soyadı</th>
            <th>Maaşı</th>
            <th>İşe Giriş tarihi</th>
            <th>Çalıştığı departman</th>
            <th>Telefon numarası</th>
            <th>Tc No</th>
            <th>Aksiyonlar</th>
         </tr>
      </thead>
      <tbody>
         <?php
         $sonuc = tumKayitlariAl($handle, $table);
         while ($row = mysqli_fetch_array($sonuc)) {
            ?>
            <tr>
               <td><?= $row['name'] ?></td>
               <td><?= $row['surname'] ?></td>
               <td><?= $row['pay'] ?></td>
               <td><?= $row['starting_date'] ?></td>
               <td><?= $row['department'] ?></td>
               <td><?= $row['phone_number'] ?></td>
               <td><?= $row['tc_number'] ?></td>

               <td>
                  <ul>
                     <li><a href="editCalisan.php?id=<?= $row['id'] ?>">Düzenle</a></li>
                     <li><a href="deleteCalisan.php?id=<?= $row['id'] ?>">Sil</a></li>
                  </ul>
               </td>
            </tr>
         <?php } ?>
      </tbody>
   </table>
   <?php
}

function sinifEklemeFormu($availableTeachers)
{
   ?>

   <form name="guest_book" id="guest_book" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
      <div class="tablo_kontrol">
         <label for="name">İsim:</label>
         <input name="name" id="name">
      </div>
      <div class="tablo_kontrol">
         <label for="teacher_id">Öğretmen numarası:</label>
         <select name="teacher_id" id="teacher_id" required>
            <option value="">-- Müsait Öğretmen seçiniz --</option>
            <?php

            foreach ($availableTeachers as $teacher) {
               echo "<option value='{$teacher['id']}'>{$teacher['name']} {$teacher['surname']} (ID: {$teacher['id']})</option>";
            }
            ?>
         </select>
      </div>
      <?php if (empty($availableTeachers)): ?>

         <div class="tablo_kontrol">
            <a href="AddOgretmen.php" class="btn-submit">Müsait Öğretmen Bulunmuyor, Öğretmen Eklemek için tıklayın.</a>
         </div>
      <?php else: ?>

         <div class="tablo_kontrol">
            <input class="btn-submit" type="submit" name="submit" value="Ekle">
         </div>
      <?php endif; ?>
   </form>


   <?php
}
function ogrenciEklemeFormu($musaitSinif)
{
   ?>

   <form name="guest_book" id="guest_book" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">


      <div class="tablo_kontrol">
         <label for="name">Ad:</label>
         <input name="name" id="name">
      </div>

      <div class="tablo_kontrol">
         <label for="surname">Soyad:</label>
         <input name="surname" id="surname">
      </div>
      <div class="tablo_kontrol">
         <label for="illnesses">Hastalık:</label>
         <textarea name="illnesses" id="illnesses"></textarea>
      </div>

      <div class="tablo_kontrol">
         <label for="parent_name">Ebeveyn İsmi:</label>
         <input name="parent_name" id="parent_name">
      </div>

      <div class="tablo_kontrol">
         <label for="parent_phone">Ebeveyn Telefon numarası:</label>
         <input name="parent_phone" id="parent_phone">
      </div>

      <div class="tablo_kontrol">
         <label for="birth_year">Doğum Tarihi:</label>
         <input name="birth_year" id="birth_year">
      </div>

      <div class="tablo_kontrol">
         <label for="class_id">Sınıf numarası:</label>
         <select name="class_id" id="class_id" required>
            <option value="">-- Müsait sınıf seçiniz --</option>
            <?php

            foreach ($musaitSinif as $sinif) {
               echo "<option value='{$sinif['id']}'>{$sinif['name']}  (ID: {$sinif['id']})</option>";
            }


            if (empty($musaitSinif)) {
               echo "<option value=''>Müsait bir sınıf yok. Lutfen oncelikle sınıf ekleyiniz.</option>";
            }
            ?>
         </select>
      </div>

      <div class="tablo_kontrol">
         <input class="btn-submit" type="submit" name="submit" value="Ekle">
      </div>
   </form>

   <?php
}

function ogretmenEklemeFormu()
{
   ?>

   <form name="guest_book" id="guest_book" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">

      <div class="tablo_kontrol">
         <label for="name">Ad:</label>
         <input name="name" id="name">
      </div>
      <div class="tablo_kontrol">
         <label for="surname">Soyad:</label>
         <input name="surname" id="surname">
      </div>
      <input type="hidden" name="class_id" value=>
      <div class="tablo_kontrol">
         <label for="pay">Maaş:</label>
         <input name="pay" id="pay">
      </div>
      <div class="tablo_kontrol">
         <input class="btn-submit" type="submit" name="submit" value="Gönder">
      </div>
   </form>

   <?php
}
function calisanEklemeFormu()
{
   ?>

   <form name="guest_book" id="guest_book" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">

      <div class="tablo_kontrol">
         <label for="name">Ad:</label>
         <input name="name" id="name">
      </div>
      <div class="tablo_kontrol">
         <label for="surname">Soyad:</label>
         <input name="surname" id="surname">
      </div>
      <div class="tablo_kontrol">
         <label for="pay">Maaş:</label>
         <input name="pay" id="pay">
      </div>
      </div>
      <div class="tablo_kontrol">
         <label for="department">Departman:</label>
         <input name="department" id="department">
      </div>
      <div class="tablo_kontrol">
         <label for="phone_number">Telefon numarası:</label>
         <input name="phone_number" id="phone_number">
      </div>
      </div>
      <div class="tablo_kontrol">
         <label for="tc_number">Tc numarası:</label>
         <input name="tc_number" id="tc_number">
      </div>
      <div class="tablo_kontrol">
         <input class="btn-submit" type="submit" name="submit" value="Gönder">
      </div>
   </form>

   <?php
}

function sinifDuzenlemeFormu($sonuc)
{
   $row = mysqli_fetch_array($sonuc);
   $name = $row['name'];
   $id = $row['id'];
   ?>

   <form name="guest_book" id="guest_book" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">

      <input type="hidden" name="id" id="name" value="<?= $id ?>">

      <div class="tablo_kontrol">
         <label for="name">İsim:</label>
         <input name="name" id="name" value="<?= $name ?>">
      </div>
      <div class="tablo_kontrol">
         <input class="btn-submit" type="submit" name="submit" value="Gönder">
      </div>
   </form>

   <?php
}
function ogrenciDuzenlemeFormu($sonuc, $musaitSinif)
{
   $row = mysqli_fetch_array($sonuc);
   $name = $row['name'];
   $surname = $row['surname'];
   $illnesses = $row['illnesses'];
   $parentName = $row['parent_name'];
   $parentPhone = $row['parent_phone'];
   $birthYear = $row['birth_year'];
   $class_id = $row['class_id'];
   $id = $row['id'];
   ?>

   <form name="guest_book" id="guest_book" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">

      <input type="hidden" name="id" id="name" value="<?= $id ?>">

      <div class="tablo_kontrol">
         <label for="name">Ad:</label>
         <input name="name" id="name" value="<?= $name ?>">
      </div>

      <div class="tablo_kontrol">
         <label for="surname">Soyad:</label>
         <input name="surname" id="surname" value="<?= $surname ?>">
      </div>
      <div class="tablo_kontrol">
         <label for="illnesses">Hastalık:</label>
         <textarea name="illnesses" id="illnesses"><?= $illnesses ?></textarea>
      </div>

      <div class="tablo_kontrol">
         <label for="parent_name">Ebeveyn İsmi:</label>
         <input name="parent_name" id="parent_name" value="<?= $parentName ?>">
      </div>

      <div class="tablo_kontrol">
         <label for="parent_phone">Ebeveyn Telefon numarası:</label>
         <input name="parent_phone" id="parent_phone" value="<?= $parentPhone ?>">
      </div>

      <div class="tablo_kontrol">
         <label for="birth_year">Doğum Tarihi:</label>
         <input name="birth_year" id="birth_year" value="<?= $birthYear ?>">
      </div>

      <div class="tablo_kontrol">
         <label for="class_id">sınıf numarası:</label>
         <select name="class_id" id="class_id" required>
            <option value="<?= $class_id ?>"><?= $class_id ?></option>
            <?php

            foreach ($musaitSinif as $sinif) {
               echo "<option value='{$sinif['id']}'>{$sinif['name']}  (ID: {$sinif['id']})</option>";
            }


            if (empty($musaitSinif)) {
               echo "<option disabled value=''>Müsait bir sınıf yok. Lutfen oncelikle sınıf ekleyiniz.</option>";
            }
            ?>
         </select>
      </div>

      <div class="tablo_kontrol">
         <input class="btn-submit" type="submit" name="submit" value="Gönder">
      </div>
   </form>

   <?php
}
function ogretmenDuzenlemeFormu($sonuc)
{
   $row = mysqli_fetch_array($sonuc);
   $id = $row['id'];
   $name = $row['name'];
   $surname = $row['surname'];
   $pay = $row['pay'];
   ?>

   <form name="guest_book" id="guest_book" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">

      <input type="hidden" name="id" id="name" value="<?= $id ?>">

      <div class="tablo_kontrol">
         <label for="name">Ad:</label>
         <input name="name" id="name" value="<?= $name ?>">
      </div>
      <div class="tablo_kontrol">
         <label for="surname">Soyad:</label>
         <input name="surname" id="surname" value="<?= $surname ?>">
      </div>
      <div class="tablo_kontrol">
         <label for="pay">Maaş:</label>
         <input name="pay" id="pay" value="<?= $pay ?>">
      </div>
      <div class="tablo_kontrol">
         <input class="btn-submit" type="submit" name="submit" value="Gönder">
      </div>
   </form>

   <?php
}
function calisanDuzenlemeFormu($sonuc)
{
   $row = mysqli_fetch_array($sonuc);
   $id = $row['id'];

   $name = $row["name"];
   $surname = $row["surname"];
   $pay = $row["pay"];
   $department = $row["department"];
   $phone_number = $row["phone_number"];
   $tc_number = $row["tc_number"];
   ?>

   <form name="guest_book" id="guest_book" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">

      <input type="hidden" name="id" id="name" value="<?= $id ?>">

      <div class="tablo_kontrol">
         <label for="name">Ad:</label>
         <input name="name" id="name" value="<?= $name ?>">
      </div>
      <div class="tablo_kontrol">
         <label for="surname">Soyad:</label>
         <input name="surname" id="surname" value="<?= $surname ?>">
      </div>
      <div class="tablo_kontrol">
         <label for="pay">Maaş:</label>
         <input name="pay" id="pay" value="<?= $pay ?>">
      </div>
      </div>
      <div class="tablo_kontrol">
         <label for="department">Departman:</label>
         <input name="department" id="department" value="<?= $department ?>">
      </div>
      <div class="tablo_kontrol">
         <label for="phone_number">Telefon numarası:</label>
         <input name="phone_number" id="phone_number" value="<?= $phone_number ?>">
      </div>
      </div>
      <div class="tablo_kontrol">
         <label for="tc_number">Tc numarası:</label>
         <input name="tc_number" id="tc_number" value="<?= $tc_number ?>">
      </div>

      <div class="tablo_kontrol">
         <input class="btn-submit" type="submit" name="submit" value="Gönder">
      </div>
   </form>

   <?php
}

function girisFormu()
{
   ?>

   <form name="login_form" id="login_form" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
      <div class="giris_kontrol">
         <label for="username">Kullanıcı Adı:</label>
         <input name="username" id="username" required>
      </div>
      <div class="giris_kontrol">
         <label for="password">Şifre:</label>
         <input type="password" name="password" id="password" required>
      </div>
      <div class="giris_kontrol">
         <input class="btn-submit" type="submit" name="submit" value="Giriş Yap">
      </div>
   </form>

   <?php
}
function kayitOlmaFormu()
{
   ?>

   <form name="registration_form" id="registration_form" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
      <div class="kayit_kontrol">
         <label for="username">Kullanıcı Adı:</label>
         <input name="username" id="username">
      </div>
      <div class="kayit_kontrol">
         <label for="password">Şifre:</label>
         <input type="password" name="password" id="password">
      </div>

      <div class="kayit_kontrol">
         <label for="confirm_password">Şifre doğrulama:</label>
         <input type="password" name="confirm_password" id="confirm_password">
      </div>
      <div class="kayit_kontrol">
         <input class="btn-submit" type="submit" name="submit" value="Kaydet">
      </div>
   </form>

   <?php
}

function tarihGoster()
{
   ?>
   <p class="date">Bugün <?= date("Y/m/d") ?> </p><br>
   <?php
}

function yeniEklemeButonu($type)
{
   ?>

   <div class="tablo yeni_ekle">
      <a href="add<?= $type ?>.php"><button class="yeni_ekle_button">Yeni ekle</button></a>
   </div>


   <?php
}