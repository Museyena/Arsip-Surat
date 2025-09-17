<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    // Menentukan nama tabel agar sesuai dengan migrasi kita.
    protected $table = 'kategoris';

    // Kolom-kolom yang bisa diisi dari formulir.
    protected $fillable = [
        'nama_kategori',
    ];
}