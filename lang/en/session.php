<?php

use App\Helpers\Enums\RoleType;

$admin = RoleType::ADMIN->value;

return [
  'create' => 'Melakukan Penambahan Data Berhasil',
  'update' => 'Melakukan Perubahan Data Berhasil',
  'delete' => 'Melakukan Penghapusan Data Berhasil',
  'status' => 'Melakukan Perubahan Status Berhasil',
  'password' => 'Melakukan Perubahan Kata Sandi Berhasil',
  'image' => 'Melakukan Penghapusan Avatar Berhasil',
  'log' => [
    'error' => 'Tidak dapat melakukan tindakan, Periksa kembali',
  ],
  'restore' => 'Melakukan Pemulihan Data Berhasil',
  'is_null_roles' => 'Anda tidak bisa masuk ke halaman Aplikasi. Silahkan hubungi Administrator untuk info lebih lanjut',
  'banned' => "Mohon Maaf, Akun anda tidak aktif. \n Mohon hubungi {$admin} untuk mengaktifkan Akun Anda.",
];
