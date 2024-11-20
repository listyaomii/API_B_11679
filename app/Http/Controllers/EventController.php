<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(){
        $allEvent = Event::all();  
        return response()->json($allEvent);
    }

    public function store(Request $request){
        $validateData = $request->validate([
            'nama_event' => 'required',
            'deskripsi' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
            'lokasi' => 'required',
        ]);

        $userId = Auth::id();

        $event = Event::create([ 
            'id_user' => $userId,
            'nama_event' => $validateData['nama_event'],
            'deskripsi' => $validateData['deskripsi'],
            'tanggal_mulai' => $validateData['tanggal_mulai'],
            'tanggal_selesai' => $validateData['tanggal_selesai'],
            'lokasi' => $validateData['lokasi'],
        ]);

        return response()->json([
            'message' => 'Event created successfully',
            'event' => $event,
        ], 201);
    }

    public function update(Request $request, string $id){
        $validateData = $request->validate([
            'nama_event' => 'required',
            'deskripsi' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
            'lokasi' => 'required',
        ]);

        $userId = Auth::id();
        $event = Event::find($id);  

        if(!$event || $event->id_user !== $userId){
            return response()->json(['message' => 'Event not found or unauthorized'], 403);
        }

        $event->update($validateData);

        return response()->json($event);
    }

    public function destroy(string $id){
        $userId = Auth::id();
        $event = Event::find($id);  

        if(!$event || $event->id_user !== $userId){
            return response()->json(['message' => 'Event not found or not logged in'], 403);
        }

        $event->delete();

        return response()->json(['message' => 'Event deleted successfully']);
    }

   
    public function search(Request $request)
    {
        $searchTerm = $request->input('nama_event'); 

     
        if (!$searchTerm) {
            return response()->json(['message' => 'Parameter nama_event is required'], 400);
        }
    
     
        $events = Event::where('nama_event', 'LIKE', '%' . $searchTerm . '%')->get();
    
        
        if ($events->isEmpty()) {
            return response()->json(['message' => 'No events found'], 404);
        }
    
        return response()->json($events);
    }
}
