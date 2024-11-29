# **Proje Dokümantasyonu**

Bu proje, Docker tabanlı bir Laravel uygulamasıdır. Mesaj gönderimi, alıcı yönetimi ve kuyruk işlemleri gibi
özellikleri içerir. Aşağıda, kuruluma ve kullanım talimatlarına dair detaylı bilgiler bulabilirsiniz.

---

## **Kurulum**

### 1. **Docker Build ve Laravel Kurulumu**
Proje ortamını başlatmak için aşağıdaki komutu çalıştırın:

```bash
docker-compose up --build
```

### 2. **Sahte Verilerin Yüklenmesi**
Alıcıların oluşturulabilmesi için veritabanını hazırlayıp sahte verileri yükleyin:

```bash
docker exec -it insider-assessment-app php artisan migrate --seed
```

---

# **Mesaj Gönderimi**

### 1. **Kuyruk Sisteminin Başlatılması**
Mesaj gönderim sürecinin çalışabilmesi için Laravel kuyruk sistemi etkinleştirilmelidir:

```bash
docker exec -it insider-assessment-app php artisan queue:work
```

### 2. **Mesaj Gönderim Komutları**

#### a) Manuel Mesaj Gönderimi
Farklı bir terminal penceresinde aşağıdaki komut ile mesaj gönderimini başlatabilirsiniz:

```bash
docker exec -it insider-assessment-app php artisan app:send-message
```
Her komut çalıştırıldığında 2 adet mesaj gönderimi yapılır.

#### b) Zamanlanmış Gönderim
Sistemin her 5 saniyede 2 mesaj göndermesi için aşağıdaki komutu kullanabilirsiniz:
```bash
docker exec -it insider-assessment-app php artisan schedule:work
```
> **Not:** Mesaj gönderimi sırasında, veritabanındaki **recipients** tablosunun **sent** alanı güncellenir.
> Bu sayede, bir alıcıya yalnızca bir kez mesaj gönderimi sağlanır. Yüksek performans ve ölçeklenebilirlik amacıyla
> tüm işlemler yığın (bulk) yöntemiyle gerçekleştirilir.

---

# **API Dokümanları**

Mesaj gönderimi yapılan alıcıları ve ilgili API uç noktalarını incelemek için aşağıdaki
Swagger dokümanına erişebilirsiniz:

http://localhost:8080/api/documentation#/default

---

# **Testler**

Feature ve Unit testlerini çalıştırmak için şu komutu kullanın:

```bash
docker exec -it insider-assessment-app php artisan test
```

# **İletişim**
Her türlü soru ve geri bildirim için aşağıdaki iletişim bilgilerini kullanabilirsiniz:

**E-Posta:** serter.serbest@gmail.com

**Telefon:** 0551 417 73 58
