<?php

Breadcrumbs::for('admin.dashboard', function ($trail) {
    $trail->push(__('strings.backend.dashboard.title'), route('admin.dashboard'));
});

require __DIR__.'/auth.php';
require __DIR__.'/log-viewer.php';

Breadcrumbs::for('admin.mahasiswa.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Mahasiswa', route('admin.mahasiswa.index'));
});

Breadcrumbs::for('admin.mahasiswa.create', function ($trail) {
    $trail->parent('admin.mahasiswa.index');
    $trail->push('Tambah', route('admin.mahasiswa.create'));
});

Breadcrumbs::for('admin.mahasiswa.edit', function ($trail, $mahasiswa) {
    $trail->parent('admin.mahasiswa.index');
    $trail->push('Edit', route('admin.mahasiswa.edit', $mahasiswa));
});

// dosen
Breadcrumbs::for('admin.dosen.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Dosen', route('admin.dosen.index'));
});

Breadcrumbs::for('admin.dosen.create', function ($trail) {
    $trail->parent('admin.dosen.index');
    $trail->push('Tambah', route('admin.dosen.create'));
});

Breadcrumbs::for('admin.dosen.edit', function ($trail, $dosen) {
    $trail->parent('admin.dosen.index');
    $trail->push('Edit', route('admin.dosen.edit', $dosen));
});

// mata kuliah
Breadcrumbs::for('admin.mata_kuliah.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Mata Kuliah', route('admin.mata_kuliah.index'));
});

Breadcrumbs::for('admin.mata_kuliah.create', function ($trail) {
    $trail->parent('admin.mata_kuliah.index');
    $trail->push('Tambah', route('admin.mata_kuliah.create'));
});

Breadcrumbs::for('admin.mata_kuliah.edit', function ($trail, $mata_kuliah) {
    $trail->parent('admin.mata_kuliah.index');
    $trail->push('Edit', route('admin.mata_kuliah.edit', $mata_kuliah));
});

Breadcrumbs::for('admin.mata_kuliah.dosen', function ($trail, $mata_kuliah) {
    $trail->parent('admin.mata_kuliah.index');
    $trail->push('Dosen', route('admin.mata_kuliah.dosen', $mata_kuliah));
});

// Jadwal
Breadcrumbs::for('admin.jadwal.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Jadwal', route('admin.jadwal.index'));
});

Breadcrumbs::for('admin.jadwal.create', function ($trail) {
    $trail->parent('admin.jadwal.index');
    $trail->push('Tambah', route('admin.jadwal.create'));
});

Breadcrumbs::for('admin.jadwal.edit', function ($trail, $jadwal) {
    $trail->parent('admin.jadwal.index');
    $trail->push('Edit', route('admin.jadwal.edit', $jadwal));
});

Breadcrumbs::for('admin.jadwal.mahasiswa', function ($trail, $jadwal) {
    $trail->parent('admin.jadwal.index');
    $trail->push('Mahasiswa', route('admin.jadwal.mahasiswa', $jadwal));
});

// absensi
Breadcrumbs::for('admin.absensi.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Absensi', route('admin.absensi.index'));
});

Breadcrumbs::for('admin.absensi.create', function ($trail) {
    $trail->parent('admin.absensi.index');
    $trail->push('Tambah', route('admin.absensi.create'));
});

Breadcrumbs::for('admin.absensi.edit', function ($trail, $absensi) {
    $trail->parent('admin.absensi.index');
    $trail->push('Edit', route('admin.absensi.edit', $absensi));
});

// rating
Breadcrumbs::for('admin.rating.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Rating', route('admin.rating.index'));
});