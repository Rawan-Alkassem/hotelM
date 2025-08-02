<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with(['type', 'images'])
            ->where('status', 'available')
            ->get();

        return response()->json($rooms, 200); 
    }

    public function show($id)
    {
        $room = Room::with(['type', 'images', 'type.services'])
            ->where('id', $id)
            ->where('status', 'available')
            ->firstOrFail();

        return response()->json($room, 200);    }

    public function types()
    {
        $types = RoomType::with(['rooms.images', 'services'])->get();
        return response()->json($types, 200);
    }
}