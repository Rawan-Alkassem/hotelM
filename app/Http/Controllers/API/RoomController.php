<?php
// namespace App\Http\Controllers\Api;

// use App\Http\Controllers\Controller;
// use App\Models\Room;
// use App\Models\RoomType;
// use Illuminate\Http\Request;

// class RoomController extends Controller
// {
//     public function index()
//     {
//         $rooms = Room::with(['type', 'images'])
//             ->where('status', 'available')
//             ->get();

//         return response()->json($rooms, 200);
//     }

//     public function show($id)
//     {
//         $room = Room::with(['type', 'images', 'type.services'])
//             ->where('id', $id)
//             ->where('status', 'available')
//             ->firstOrFail();

//         return response()->json($room, 200);    }

//     public function types()
//     {
//         $types = RoomType::with(['rooms.images', 'services'])->get();
//         return response()->json($types, 200);
//     }
// }

// 3. RoomController.php
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
    // public function index()
    // {
    //     return RoomResource::collection(
    //         Room::with(['type'])
    //             ->where('status', 'available')
    //             ->get()
    //     );
    // }

    // public function show($id)
    // {
    //     $room = Room::with(['type.services', 'images'])
    //         ->where('status', 'available')
    //         ->findOrFail($id);

    //     return new RoomResource($room);
    // }

    // public function types()
    // {
    //     return RoomTypeResource::collection(
    //         RoomType::with(['rooms.images', 'services'])->get()
    //     );
    // }



     public function index()
    {
        try {
            $rooms = Room::with(['roomType'])
                ->where('status', 'available')
                ->get();

            return RoomResource::collection($rooms);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'حدث خطأ أثناء جلب الغرف.',
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
            return response()->json(['message' => 'الغرفة غير موجودة أو غير متاحة.'], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'حدث خطأ أثناء عرض تفاصيل الغرفة.',
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
                'message' => 'حدث خطأ أثناء جلب أنواع الغرف.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
