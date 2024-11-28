## Kurulum

1- Docker Build ve Laravel Installation işlemleri için aşağıdaki komutu çalıştırınız.
```bash
docker-compose up -d --build
```

2- Mesaj gönderilecek alıcıların oluşturulabilmesi için sahte veriler oluşturulmalıdır.
```bash
docker exec -it insider-assessment-app php artisan migrate --seed
```

## Mesaj Gönderimi

1- Öncelikle Laravel kuyruk sistem aktif hale getirilmelidir.
```bash
docker exec -it insider-assessment-app php artisan queue:work
```
2- Farklı bir CLI penceresinde aşağıdaki mesaj gönderecek komut çalıştırılmalıdır
```bash
docker exec -it insider-assessment-app php artisan app:send-message
```
Yukarıdaki komut her tetiklendiğinde 2 adet mesaj gönderimi yapacaktır.
Bunun yerine sistemin her 5 saniyede 2 adet gönderim yapması isteniyorsa aşağıdaki komut çağıralabilir.
```bash
docker exec -it insider-assessment-app php artisan schedule:work
```

## Doküman

Mesaj gönderimi yapılan alıcılar, aşağıdaki Swagger Dokümanında kontrol edilebilir.
http://localhost:8080/api/documentation#/default

## İletişim
E-Posta: serter.serbest@gmail.com

Telefon: 0551 417 73 58

