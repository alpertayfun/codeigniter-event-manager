CodeIgniter Event Manager
=========

CI Version: 2 & 2.2.0

Min PHP Version: 5.3

CI Event Manager, Laravel PHP Framework'deki Event Manager kütüphanesinden esinlenerek tamamen CodeIgniter'a uyumlu bir şekilde yazılmıştır.

Uzun bir süredir (2012'den beri) geliştirilmeyen CI, 3ncü versiyonu çıkaracağını duyurdu. 
Ayrıntılar: http://www.codeigniter.com

Projeyi klonladıktan sonra yapmanız gereken:
---
1. events klasörünü **application** > **libraries** klasörüne ekleyin
2. Kütüphaneyi projeniziniz **config** > **autoload** dosyası içindeki $autoload["libraries"] dizisine ekleyin.

**örnek:**
```sh
$autoload["libraries"] = array("events/events");
```