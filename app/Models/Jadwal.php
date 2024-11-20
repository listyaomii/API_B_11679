<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $table = "jadwals";
    protected $primaryKey = "id";

    protected $fillable = [
   
        'id_event',
        'judul_sesi',
        'deskripsi_sesi',
        'waktu_mulai',
        'waktu_selesai'
        
    ]; 

    public function event(){
        return $this->belongsTo(Event::class);
    }
}
