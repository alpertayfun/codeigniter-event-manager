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

Tanımladığımız event'te closure fonksiyonu ile gelen iki adet para metre görüyorsunuz. 

Bunu kısaca inceleyelim:
```sh
$ci_instance
```
Codeigniter ortamında gayri ihtiyari durumlarda kullandığımız, bize ortamdaki tüm kütüphanelere erişme imkanı veren super-object olarak bilinen global değişkendir.

```sh
$parm
```
Tanımlı event'leri tetikleme anında parametre gönderilirse, bu parametrelere $parm değişkeni ile erişebiliyoruz.

**$ci_instance** ve **$parm** parametrelerine değindikten sonra tanımladığımız event'in üzerine konuşmaya devam edelim.

Yukarıda tanımladığımız event'in anahtarını **event.manager** olarak belirledik.

Sonrasında içinde basit bir aritmetik işlem yaptık. Ve bu işlemin sonucunu tekrar return ile bize geri dönmesini istedik.

Bunu dilersek event içinde **echo** ile sonucu ekrana yansıtabiliriz.

Event'lerin çalıştırılması
--
Event'leri çalıştırmanın bir kaç varyasyonu olduğunu hatırlatalım ve en basit şekliyle çalıştırarak diğer varyasyonlara doğru adım adım ilerleyelim.

```sh
$result = Events::fire('event.manager');
```

**event.manager** anahtarına sahip event'i tetikledik ve sonucu bir değişkene aktardık. Artık event'te yapılan işlemin sonucunu **$result** değişkeninde isteğimiz gibi kullanabiliriz.

Detaylı kullanım
--
Şimdi diğer varyasyonları inceleyelim.

```sh
Events::add('event.manager', function($ci_instance, $parm){
    return $parm['num1'] + $parm['num2'];
});
```
Yukarıda event'e parametre gelmesini istiyoruz ve bu parametrelerle gene basit bir aritmetik işlem yapıyoruz.

Şimdi parametre göndererek çalıştıralım.
```sh
$result = Events::fire('event.manager',
    array(
        'num1' => 1, 
        'num2' => 1
    ), function($ci_instance, $eventResult){
    
});
```
Event'i çalıştırıdık, beklenen parametreleri gönderdik ve bunun yanında birde **callback** fonksiyonu çalıştırdık.

Tetiklenen event çalıştıktan sonra en son işlem olarak **callback** fonksiyonu ile kapanışı yaptık.
Burada gene callback fonksiyonu ile gelen parametreler görüyoruz.

Birinci parametre:
```sh
$ci_instance
```
Dökümanın başına gidecek olursak orada bu değişkeni açıklamıştık.

İkinci parametre:
```sh
$eventResult
```
Adından da belli olacağı gibi event sonucunu bize ulaştırıyor.

Tüm event'leri çalışmak
--
Her zaman tercih edilmeyebilir fakat bazeyapmak isteyebileceğimiz durumlarda olabilir.

Bir önceki başlıkta tanımladığımız event üzerinden gidecek olursak şu şekilde çalıştırabiliriz:

```sh
$result = Events::fire('*');
```

Bu kullanım kayıt tüm event'leri tetikleyecektir.

Dilerseniz gelin buna şimdi parametreler yollayalım.

```sh
$result = Events::fire('*',
    array('*' => array(
            'num1' => 1,
            'num2' => 2
        )
    )
);
```
Bu kullanım tetiklenecek olan tüm event'lere aynı parametreleri gönderecektir.

Siz her event'e yada bazılarına belirlediğiniz parametreleri göndermek isteyebilirsiniz.

Bunu da şu şekilde yapıyoruz.

```sh
$result = Events::fire('*',
    array('event.manager' =>
        array(
            'num1' => 1,
            'num2' => 2
        ),
        'event.manager2' => array(
            'num1' => 3,
            'num2' => 4
        )
    )
);
```
Yukarıda 3 boyutlu dizi yardımıyla istediğimiz event'lere belirlediğimiz parametreleri gönderebiliyoruz.

Ve yine bu işlem sonunda da bir callback çalıştırabileceğimizi hatırlayalım:
```sh
$result = Events::fire('*',
    array('event.manager' =>
        array(
            'num1' => 1,
            'num2' => 2
        ),
        'event.manager2' => array(
            'num1' => 3,
            'num2' => 4
        )
    ), function($ci_instance, $eventResult){
           foreach($eventResult as $e){
                var_dump($e);
            }
       
    });
```

**Önemli açıklama:**

Yukarıda tüm event'lere tetikleme komutunu verdik ve bazı event'lere parametreler gönderdik.
Parametre gönderdiklerimiz yada göndermediğimiz eventlerin sonuçları **$callback** fonksiyonuna bir dizi olarak gelecektir. Ve bu dizide her event'in anahtarı altında **return** sonuçları olacaktır.

Event'lerde prefix kullanımı
--
Bazen bir kısım event'leri tek seferde çalışmak gibi durumlarla karşı karşıya olabiliriz.

Bunu yapmak için bir kaç tane event tanımlayalım:
```sh
Events::add('auth.register', function($ci_instance, $parm){
  return  // üyeyi kaydetme işlemleri..
});

Events::add('event.login', function($ci_instance, $parm){
    return // üye giriş işlemleri
});

Events::add('auth.sendmail', function($ci_instance, $parm){
    return // üyeye kayıt sonrası mail gönderim işlemleri
});

Events::add('basket.refresh', function($ci_instance, $parm){
    return $parm['num1'] + $parm['num2'];
});
```

Yukarıda dört adet event tanımladık. Bunların üç tanesi üyelik işlemleri ile ilgili olduğunu görüyoruz. Sonuncusu ise üye sepetinin yenilenme işlemi ile ilgili.

Biz burada yeni üye kaydının hemen sonrasında yukarıdaki **auth.register**, **event.login**, **auth.sendmail** event'lerini tetiklemek istiyoruz.

Bunuda basitçe şu şekilde yapıyoruz:
```sh
$result = Events::fire('auth.*',
    array(
        'auth.register' => 
            array(
                'firstname' => 'Ali', 
                'lastname' => 'YILMAZ', 
                'email' => 'aliyilmaz@example.com', 
                'password' => '123456'
            ),
        'auth.login' => 
            array(
                'email' => 'aliyilmaz@example.com',
                'password' => '123456'
            ),
        'auth.sendmail' => 
            array(
                'email' => 'aliyilmaz@example.com',
                'detail' => 'bla bla bla'
            )
    ),function($ci_instance, $eventResult){
        foreach($eventResult as $e){
            var_dump($e);
        }
});
```

Burada tetiklenecek olan event'ler, anahtarları **auth.** ile başlayan event'lerdir.

Her event'e ayrı ayrı parametreler göndererek bir dizi işlemi halletmiş olduk.

Diğer başlıklarda örneklerdirdiğimiz parametre kullanımları aynı şekilde geçerlidir.

Her türlü önerilerinizi, sorularınızı proje altında konu açarak tartışabilir ve çözüme ulaştırabiliriz.

Happy coding!
===