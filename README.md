# Emlak Web Sitesi
Bu proje, PHP, MySQL ve AJAX kullanarak dinamik, kullanıcı dostu ve modern bir emlak listeleme platformu oluşturmak için geliştirilmiştir. Kullanıcılar, bu platform üzerinden kiralık evleri kolayca inceleyebilir, tercihlerine göre filtreleme yapabilir ve detaylı bilgi alabilirler.

## Özellikler
Dinamik İçerik Yönetimi: PHP ile sunucu tarafında içerik yönetimi sağlanır.
Güçlü Veritabanı Altyapısı: MySQL, verilerin hızlı, güvenilir ve optimize bir şekilde saklanmasını ve işlenmesini sağlar.
Gerçek Zamanlı İşlemler: AJAX sayesinde sayfa yenileme gereksinimi olmadan anlık filtreleme ve sıralama işlemleri yapılabilir.
Kullanıcı Dostu Arayüz: Modern ve responsive tasarım, tüm cihazlarda sorunsuz bir kullanıcı deneyimi sunar.
Performans Optimizasyonu: Hızlı yükleme süreleri ve yüksek performans için optimize edilmiştir.

## Teknolojiler
- PHP: Sunucu tarafında dinamik işlemler.
- MySQL: Veritabanı yönetimi ve veri depolama.
- AJAX: Dinamik ve etkileşimli kullanıcı deneyimi.
- HTML/CSS: Şık ve kullanıcı dostu bir arayüz tasarımı.

## Veritabanı Yapısı
Projede kullanılan veritabanı, veri normalizasyonu prensiplerine uygun olarak tasarlanmıştır. Kritik sorgular için indeksleme yapılmış ve veri güvenliği ön planda tutulmuştur.

Kiralık Daireler Tablosu: Emlak bilgilerini içerir.
İletişim Tablosu: Kullanıcıların mesajlarını saklar.

## Kurulum
Proje dosyalarını klonlayın:
git clone https://github.com/servet0/emlak-web-sitesi

Veritabanını yapılandırın:

emlak.sql dosyasını MySQL sunucunuza yükleyin.
Veritabanı bağlantı bilgilerini config.php dosyasına girin.

Sunucuyu başlatın:

PHP destekli bir sunucuda (ör. XAMPP) projeyi çalıştırın.
Erişim:

Tarayıcınızda http://localhost/emlak-web-sitesi adresini ziyaret edin.

## Katkıda Bulunma
Katkıda bulunmak istiyorsanız:

Bu projeyi forklayın.
Yeni bir dal (branch) oluşturun: git checkout -b feature/yeniozellik
Değişikliklerinizi işleyin ve commit yapın: git commit -m 'Yeni özellik eklendi'
Dalınızı iterek gönderin: git push origin feature/yeniozellik
Bir pull request oluşturun.

## Lisans
Bu proje, MIT Lisansı ile lisanslanmıştır. Daha fazla bilgi için lütfen LICENSE dosyasına göz atın.
