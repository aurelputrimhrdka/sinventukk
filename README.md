<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## INSTALLATION REQUIREMENTS
- Apache
  ```bash
  apt-get install apache2 -y
  ```
- MariaDB
  ```bash
  apt-get install mariadb-server -y
  ```
- PHP 8.3
  ```bash
  apt install ca-certificates apt-transport-https software-properties-common lsb- 
  release -y
  ```
  ```bash
  apt install curl
  ```
  ```bash
  curl -sSL https://packages.sury.org/php/README.txt | bash -x
  ```
  ```bash
  apt update
  ```
  ```bash
  apt-get install php8.3 php8.3-common php8.3-curl libapache2-mod-php php8.3-imap php8.3-redis php8.3-cli php8.3-snmp php8.3-xml php8.3-zip php8.3-mbstring php8.3-gd php8.3-xml php8.3 mysql php-mbstring -y

  ```
- Composer
  ```bash
  apt install curl php-cli php-mbstring git unzip
  ```
  ```bash
  curl -sS https://getcomposer.org/installer -o composer-setup.php
  ```
  ```bash
  HASH=`curl -sS https://composer.github.io/installer.sig`
  ```
  ```bash
  echo $HASH
  ```
  ```bash
  php -r "if (hash_file('SHA384', 'composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
  ```
  ```bash
  php composer-setup.php --install-dir=/usr/local/bin --filename=composer
  ```
  ```bash
  composer
  ```
## Laravel Installation
```bash
composer create-project laravel/laravel sinvent_ukk --prefer-dist
```
## Migration
```bash
php artisan make:migration create_barang_table --create=barang
php artisan make:migration create_kategori_table --create=kategori
php artisan make:migration create_barangmasuk_table --create=barangmasuk
php artisan make:migration create_barangkeluar_table --create=barangkeluar
```
## Model
```bash
php artisan make:model Barang
php artisan make:model Kategori
php artisan make:model BarangMasuk
php artisan make:model BarangKeluar
```
## Controller
```bash
php artisan make:controller BarangController
php artisan make:controller KategoriController
php artisan make:controller BarangMasukController
php artisan make:controller BarangKeluarController
```
## Authentication Controller
```bash
php artisan make:controller LoginController
php artisan make:controller RegistrasiController
```

## Deploy System Inventory
- Cloning repository
  ```bash
  git clone https://github.com/aurelputrimhrdka/sinventukk.git
  ```
  ```bash
  cd sinventukk
  ```
- Copy file .env.exsamples
  ```bash
  cp .env.example .env
  ```
- Create database
  ```bash
  create database sinvent_db;
  ```
  ```bash
  create user 'sinvent_adm'@'localhost' identified by '123';
  ```
  ```bash
  grant all privileges on sinvent_db.* to 'sinvent_adm'@'localhost' identified by '123';
  ```
  ```bash
  flush privileges;
  ```
- Edit file .env
  ```bash
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=sinvent_db
  DB_USERNAME=sinvent_adm
  DB_PASSWORD=123

  SESSION_DRIVER=file

  ```
- Install composer
  ```bash
  composer install
  ```
- Set key
  ```bash
  php artisan key:generate
  ```
- Database migration
  ```bash
  php artisan migrate
  ```
## VPS Configuration
- Masuk ke directory
  ```bash
  cd /etc/apache2/sites
  ```
- Buat file sinvent.conf
  ```bash
  nano sinvent.conf
  ```
- Konfigurasi file sinvent.conf
  ```bash
  <VirtualHost *:80>
    ServerName sinventukk.test

    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/sinventukk/public

    <Directory /var/www/sinventukk/public>

    	Options Indexes FollowSymLinks
    	AllowOverride All
        Require all granted 

    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/sinventukk-error.log
    CustomLog ${APACHE_LOG_DIR}/sinventukk-access.log combined

  </VirtualHost>

  ```
- Aktifkan file sinvent.conf
  ```bash
  a2ensite sinvent.conf
  ```
- Non-aktifkan file 000-default.conf
  ```bash
  a2dissite 000-default.conf
  ```
- Restart apache
  ```bash
  systemctl restart apache2
  ```
## Change Permissions
- Directory Storage
  ```bash
  chown www-data:www-data -R storage/
  ```
  ```bash
  chmod 755 -R storage/
  ```
- Directory Project
  ```bash
  chown www-data:www-data -R sinvent_ukk/
  ```
  ```bash
  chmod 755 -R sinvent_ukk/
  ```

## API
- Install API
  ```bash
  php artisan install:api
  ```
- Buat KategoriController di folder Api
  ```bash
  php artisan make:controller Api/KategoriController --api --model=Kategori
  ```
- Masuk ke file api.php di folder routes lalu tambahkan routenya
  ```bash
  use App\Http\Controllers\Api\KategoriController;
  Route::apiResource('kategori', KategoriController::class);
  ```

## Store Function
```bash
DELIMITER $$
CREATE FUNCTION ketKategorik(kat VARCHAR(4))
RETURNS varchar(30)
BEGIN
IF kat = 'M' THEN
return "Modal Barang";
ELSEIF kat="A" THEN
RETURN "Alat";
ELSEIF kat="BHP" THEN
RETURN "Bahan Habis Pakai";
ELSEIF kat="BTHP" THEN
RETURN "Bahan Tidak Habis Pakai";
END IF;
END$$
DELIMITER ;
```
## Store Procedure
```bash
DELIMITER $$
CREATE PROCEDURE getKategoriAll()
BEGIN
SELECT * FROM kategori;
END$$
DELIMITER ;
```

## Trigger
- Trigger untuk menambah stok di tabel barang pada barangmasuk
    ```bash
    DELIMITER //
    CREATE TRIGGER tambah_stok AFTER INSERT ON barangmasuk
    FOR EACH ROW
    BEGIN
    UPDATE barang SET barang.stok = barang.stok +
    NEW.qty_masuk WHERE barang.id = NEW.barang_id;
    END;
    //
    DELIMITER ;
    ```
- Trigger untuk mengurangi stok di tabel barang pada barangkeluar
    ```bash
    DELIMITER //
    CREATE TRIGGER kurangi_stok AFTER INSERT ON barangkeluar
    FOR EACH ROW
    BEGIN
    UPDATE barang SET barang.stok = barang.stok -
    NEW.qty_keluar WHERE barang.id = NEW.barang_id;
    END;
    //
    DELIMITER ;
   ```
- Trigger untuk mengupdate jumlah barang masuk dan berpengaruh pada tabel barang
    ```bash
    DELIMITER //
    CREATE TRIGGER edit_tambah_stok AFTER UPDATE ON barangmasuk
    FOR EACH ROW
    BEGIN
    UPDATE barang SET barang.stok = barang.stok +
    (NEW.qty_masuk - OLD.qty_masuk) WHERE barang.id =
    NEW.barang_id;
    END;
    //
    DELIMITER ;
    ```
- Trigger untuk mengupdate jumlah barang keluar dan berpengaruh pada tabel barang
    ``` bash
    DELIMITER //
    CREATE TRIGGER edit_kurangi_stok AFTER UPDATE ON barangkeluar
    FOR EACH ROW
    BEGIN
    UPDATE barang SET barang.stok = barang.stok -
    (NEW.qty_keluar - OLD.qty_keluar) WHERE barang.id =
    NEW.barang_id;
    END;
    //
    DELIMITER ;
    ```
- Trigger untuk delete barang masuk dan berpengaruh pada tabel barang
     ``` bash
    DELIMITER $$
    CREATE TRIGGER barang_undo_stokdelete
    BEFORE DELETE ON barangmasuk
    FOR EACH ROW
    BEGIN
    UPDATE barang
    SET barang.stok = barang.stok - OLD.qty_masuk
    WHERE barang.id = OLD.barang_id;
    END$$
    DELIMITER ;
    ```
- Trigger untuk delete barang masuk dan berpengaruh pada tabel barang
     ``` bash
    DELIMITER $$
    CREATE TRIGGER barang_undo_stokdel
    BEFORE DELETE ON barangkeluar
    FOR EACH ROW
    BEGIN
    UPDATE barang
    SET barang.stok = barang.stok + OLD.qty_keluar
    WHERE barang.id = OLD.barang_id;
    END$$
    DELIMITER ;
    ```


## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
