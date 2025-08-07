<?php

// RoomController
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoomResource;
use App\Http\Resources\RoomTypeResource;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class RoomController extends Controller
{



     public function index()
    {
        try {
            $rooms = Room::with(['roomType'])
                ->where('status', 'available')
                ->get();

            return RoomResource::collection($rooms);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching the rooms. ',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $room = Room::with(['roomType.services'])
                ->where('status', 'available')
                ->findOrFail($id);

            return new RoomResource($room);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'The room does not exist or is unavailable.'], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while displaying the room details.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function types()
    {
        try {
            $types = RoomType::with([ 'services'])->get();
            return RoomTypeResource::collection($types);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching the room types.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
