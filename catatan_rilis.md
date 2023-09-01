Di rilis versi 2309.0.0 ini terdapat penambahan dan perbaikan lain yang diminta Komunitas SID.

#### Penambahan Fitur
1. [#55](https://github.com/OpenSID/wiki-pbb/issues/55) Penambahan validasi tombol hapus untuk tabel yang berelasi.
2. [#60](https://github.com/OpenSID/wiki-pbb/issues/60) Penambahan filter nama rayon & rt.
3. [#57](https://github.com/OpenSID/wiki-pbb/issues/57) Penambahan filter rayon pada laporan rekap-waktu agar bisa dipantau per rayon.

#### Perbaikan BUG

1. [#177](https://github.com/OpenSID/wiki-pbb/issues/177) Perbaikan tombol hapus, batal bayar dan salin sppt tidak berfungsi.
2. [#176](https://github.com/OpenSID/wiki-pbb/issues/176) Perbaikan pilihan tahun periode pada dashbord tidak menunjukkan tahun yang sesuai.
3. [#175](https://github.com/OpenSID/wiki-pbb/issues/175) Perbaikan menu rayon, gunakan null safety.
4. [#174](https://github.com/OpenSID/wiki-pbb/issues/174) Perbikan error ketika buka menu rekap pembayaran - rekap waktu.
5. [#173](https://github.com/OpenSID/wiki-pbb/issues/173) Perbaikan hapus url pada tombol unduh jika filter tidak valid.
6. [#172](https://github.com/OpenSID/wiki-pbb/issues/172) Perbaikan tidak dapat memperbarui token opensid.
7. [#193](https://github.com/OpenSID/wiki-pbb/issues/193) Perbaikan cara import sweetalert2.

### Perubahan Teknis

1. [#178](https://github.com/OpenSID/wiki-pbb/issues/178) Penyesuaian aktifkan tombol unduh jika semua filter terisi.
2. [#171](https://github.com/OpenSID/wiki-pbb/issues/171) Tampilkan pesan error dari server api ketika mengalami gagal sinkronisasi dengan OpenSID.
3. [#192](https://github.com/OpenSID/wiki-pbb/issues/192) Terapkan aturan password kuat dan throttle pada fitur login.
4. [#179](https://github.com/OpenSID/wiki-pbb/issues/179) Tambahkan validasi jenis file ketika import SPPT.
5. [#187](https://github.com/OpenSID/wiki-pbb/issues/187) Penyesuaian keamaan - Informasi server leaks via "X-Powered-By" header respon HTTP field.
6. [#188](https://github.com/OpenSID/wiki-pbb/issues/188) Penyesuaian keamaan - X-Content-Type-Options Header Missing.
7. [#183](https://github.com/OpenSID/wiki-pbb/issues/183) Penyesuaian keamaan - Content Security Policy (CSP) Header Not Set.
8. [#180](https://github.com/OpenSID/wiki-pbb/issues/180) Penyesuaian keamaan - Validasi extension file pada upload foto rayon.
9. [#191](https://github.com/OpenSID/wiki-pbb/issues/191) Penyesuaian keamaan - Ubah metode hapus file lama pada menu update foto rayon.
10. [#181](https://github.com/OpenSID/wiki-pbb/issues/181) Penyesuaian keamaan - Tambahkan validasi extension file pada upload foto modul pengaturan aplikasi.
11. [#189](https://github.com/OpenSID/wiki-pbb/issues/189) Penyesuaian keamaan - Ganti metode hapus file lama pada menu update foto pengguna.
12. [#182](https://github.com/OpenSID/wiki-pbb/issues/182) Penyesuaian keamaan - Tambahkan validasi extension file pada upload pengguna.
13. [#190](https://github.com/OpenSID/wiki-pbb/issues/190) Penyesuaian keamaan - Ganti metode hapus file lama pada menu update foto aplikasi.
14. [#195](https://github.com/OpenSID/wiki-pbb/issues/195) Penyesuaian transaction untuk import sppt dan perbaiki button sweetalert.
