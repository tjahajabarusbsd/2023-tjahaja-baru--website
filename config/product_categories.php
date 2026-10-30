<?php

/*
 * Kategori produk. Urutan di sini = urutan tampil di navbar dan bar kategori.
 * - name : label yang ditampilkan + dipakai untuk <title>
 * - logo : file di public/images/products/logos/ (null = tampilkan teks)
 * Ikon bar kategori: public/images/products/icons/{slug}_i.png
 */
return [
  'maxi'   => ['name' => 'MAXi',   'logo' => 'maxi.png'],
  'classy' => ['name' => 'Classy', 'logo' => 'classy.png'],
  'matic'  => ['name' => 'Matic',  'logo' => 'gen_125.png'],
  'sport'  => ['name' => 'Sport',  'logo' => null],
  'moped'  => ['name' => 'Moped',  'logo' => null],
];
