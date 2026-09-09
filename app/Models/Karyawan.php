<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 'karyawans';

    protected $fillable = [
    'nama',
    'jabatan',
    'umur',
    'tanggal_masuk',
    'user_id',
    'foto',
    'gaji_pokok',
    'status'
];


    public function kasbon()
    {
        return $this->hasMany(Pengeluaran::class, 'karyawan_id')
                    ->where('jenis', 'kasbon');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
