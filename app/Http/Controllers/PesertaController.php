<?php

namespace App\Http\Controllers;

use\App\Models\User;
use\App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesertaController extends Controller
{
    public function index(){
        $allPeserta = Peserta::all();
        return response()->json($allPeserta);
    }

    public function store(Request $request){

        $validateData = $request->validate([
            'id_event' => 'required',
            'nama' => 'required',
            'email' => 'required',
            'telepon' => 'required',
        ]);

        $userId = Auth::id();

        $eventId = $validateData['id_event'];

        $event = Event::find($eventId);

        if(!$event || $event->id_user !==$userId){
            return response()->json(['message' => 'Event tidak ditemukan'], 403);
        }

        $peserta = Peserta::create([
            'id_user' => $userId,
            'id_event' => $eventId,
            'nama' => $validateData['nama'],
            'email' => $validateData['email'],
            'telepon' => $validateData['telepon'],
        ]);

        return response()->json([
            'message' => 'berhasil create peserta',
            'post' => $peserta,
        ], 201);
    }

    public function update(Request $request, string $id){
        $peserta = Peserta::find($id);

        if(!$peserta){
            return response()->json(['message' => 'Peserta tidak ditemukan'], 403);
        }

        $validateData = $request->validate([
            'id_event' => 'required',
            'nama' => 'required',
            'email' => 'required',
            'telepon' => 'required',
        ]);

        $userId = Auth::id();
        $eventId = $validateData['id_event'];

        $event = Event::find($eventId);

        if(!$event || $event->id_user !== $userId){
            return response()->json(['message' => 'Event tidak ditemukan'], 403);
        }

        $peserta->update($validateData);

        return response()->json([
            'message' => 'Berhasil mengupdate Peserta',
            'post' => $peserta,
        ], 201);
    }

    public function destroy(string $id){
        $userId = Auth::id();
        $peserta = Peserta::find($id);

        if(!$peserta){
            return response()->json(['message' => 'Peserta tidak ditemukan'], 403);
        }

        $peserta->delete();

        return response()->json(['message' => 'Peserta berhasil dihapus.']);
    }
}
