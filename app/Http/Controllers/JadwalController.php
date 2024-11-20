<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Event;

class JadwalController extends Controller
{

    public function search(Request $request)
    {
        $query = Jadwal::query();

        if ($request->has('judul_sesi')) {
            $query->where('judul_sesi', $request->judul_sesi);
        }

        $jadwals = $query->with('event')->get(); 

        return response()->json($jadwals);
    }

    public function index()
    {
        $allJadwal = Jadwal::all();
        return response()->json($allJadwal);
    }

  
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_event' => 'required|exists:events,id', 
            'judul_sesi' => 'required|in:konser,doorprize,Meet and Greet',
            'waktu_mulai' => 'required|date', 
        ]);

        
        $deskripsi_sesi = null;
        if ($validated['judul_sesi'] === 'konser') {
            $deskripsi_sesi = 'Penampilan music dari suatu band.';
        } elseif ($validated['judul_sesi'] === 'doorprize') {
            $deskripsi_sesi = 'Pembagian hadiah dari panitia ke peserta.';
        } elseif ($validated['judul_sesi'] === 'Meet and Greet') {
            $deskripsi_sesi = 'Sesi pertemuan untuk artis dengan penggemar.';
        }

     
        $jadwal = Jadwal::create([
            'id_event' => $validated['id_event'],
            'judul_sesi' => $validated['judul_sesi'],
            'deskripsi_sesi' => $deskripsi_sesi,
            'waktu_mulai' => $validated['waktu_mulai'],
            'waktu_selesai' => date('Y-m-d H:i:s', strtotime($validated['waktu_mulai'] . ' +24 hour')), 
        ]);

        return response()->json([
            'message' => 'Jadwal berhasil ditambahkan',
            'data' => $jadwal,
        ]);
    }

 
    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::find($id);

        if (!$jadwal) {
            return response()->json(['message' => 'Jadwal tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'id_event' => 'sometimes|exists:events,id',
            'judul_sesi' => 'sometimes|in:konser,doorprize,Meet and Greet',
            'waktu_mulai' => 'sometimes|date',
        ]);

      
        if (isset($validated['judul_sesi'])) {
            if ($validated['judul_sesi'] === 'konser') {
                $jadwal->deskripsi_sesi = 'Penampilan music dari suatu band.';
            } elseif ($validated['judul_sesi'] === 'doorprize') {
                $jadwal->deskripsi_sesi = 'Pembagian hadiah dari panitia ke peserta.';
            } elseif ($validated['judul_sesi'] === 'Meet and Greet') {
                $jadwal->deskripsi_sesi = 'Sesi pertemuan untuk artis dengan penggemar.';
            }
        }

      
        if (isset($validated['waktu_mulai'])) {
            $jadwal->waktu_selesai = date('Y-m-d H:i:s', strtotime($validated['waktu_mulai'] . ' +24 hour'));
        }

        $jadwal->update($validated);

        return response()->json([
            'message' => 'Jadwal berhasil diperbarui',
            'data' => $jadwal,
        ]);
    }

 
    public function destroy($id)
    {
        $jadwal = Jadwal::find($id);

        if (!$jadwal) {
            return response()->json(['message' => 'Jadwal tidak ditemukan'], 404);
        }

        $jadwal->delete();

        return response()->json(['message' => 'Jadwal berhasil dihapus']);
    }
}
