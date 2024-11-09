<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = "events";
    protected $primaryKey = "id";

    protected $fillable = [
        
        'id_user',
        'nama_event',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'lokasi'
        
    ];

    public function peserta(){
        return $this->hasMany(Peserta::class);
    }
}
