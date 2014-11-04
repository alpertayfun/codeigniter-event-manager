codeigniter-event-manager
=========================

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

Event’lerin tanımlanabileceği alanlar:
---

Event’lerinizi proje içinde controller, model, helper yada kod mantığınıza uygun CI çatısı dışına çıkılmadığı sürece her hangi bir yerde tanımlayabilirsiniz.

Bunun dışında **application/libraries/events** klasörü içindeki **defined.php** dosyası içinde de tanımlayabilirsiniz.

**defined.php** dosyası içindeki tanımlanan event’ler projede her alanda kullanılabilir.

Unutulmaması gereken önemli bir husus, **defined.php** dışında her hangi bir yerde tanımlanan event’ler çalıştırılmak istendiğinde  run-time durumunda aynı ortamda tanımlanmış olması gerekir.

Bu handikapı aşmak için event’lerinizi defined.php tanımlamanız önerilir.

Yeni bir event tanımlanması ve çalıştırılması
---
Yeni bir event tanımlamak için öncelikle event’e bir anahtar key belirlememiz gerekiyor.

Events kütüphanemizin projede autoload alanında otomatik olarak yüklendiğini varsayıyorum.

```sh
Events::add('event.manager', function($ci_instance, $parm){
    return 1+1;
});
```