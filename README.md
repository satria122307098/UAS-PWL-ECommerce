# UAS-PWL-ECommerce
File ini merupakan project pembuatan ecommerce sederhana. 
fitur kunci : PHP NAtive + MVC + Bootstrap5 + Midtrans payment gateway.

pengunjung dapat menjelajahi produk yang hendak dibeli. SAat hendak memasukkan ke dalam keranjang, dibutuhkan login. 
APabila belum memiliki akun, maka tersedia menu registrasi akun. 
Setelah login, pengunjung dapat memilih produk untuk dimasukkan ke dalam keranjang lalu melakukan checkout pembayaran. 
Pembayaran dilakukan melalui payment gateway Midtrans. 
User memiliki menu dapat melihat keranjang, serta melihat riwayat transaksi.

Untuk admin memiliki tambahan mengelola produk, melihat riwayat transaksi beserta status pembayarannya, membuat invoice, serta memiliki dashboard.

Login admin menggunakan uid : admin password : admin123.
untuk user silahkan menggunakan menu register
import database uasecommerce.sql
extract vendor.zip ke dalam root (karena tidak bisa di upload per file pada github)
Semoga bermanfaat.

Untuk dapat memanfaatkan melalui localhost apabila sedang dalam tahap pengembangan, gunakanlah aplikasi forwarding seperti "ngrok"
tata cara penggunaan ngrok:
1. instal ngrok ke dalam folder yang mudah di akses. misal c:\ngrok.
2. Jalankan command promt lalu pindah ke direktori c:\ngrok  (cd\ ENTER cd ngrok ENTER)
3. dapatkan authtoken melalui website
4. instal/tambah authtoken ke komputer kita (ngrok config add-authtoken $YOUR_AUTHTOKEN)
5. jalankan ngrok (nrok http 80)
6. nanti akan muncul url forwarding sebagai pengganti http://localhost. url itulah yang dimasukkan ke dalam MIdtrans pada menu Setting-Payment-Notfication URL


Setting MIdtrans
1. daftar akun midtrans lalu masuk
2. pastikan dalam environment sandbox
3. masuk menu setting - access key. lalu masukkan datanya pada file config.php
4. masuk ke menu setting-payment-Notification URL, lalu masukkan url callback.php (misal https://068f-103-47-133-91.ngrok-free.app/uasecommerce/callback.php)
5. APliaksi siap digunakan.


