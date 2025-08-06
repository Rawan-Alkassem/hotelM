<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomTypeRequest;
use App\Http\Requests\StoreRoomTypeRequest;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Service;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roomTypes = RoomType::all();
        return view('room-types.index', compact('roomTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $services = \App\Models\Service::all();
    return view('room-types.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomTypeRequest $request)
    {
        RoomType::create($request->validated());

        return redirect()->route('room-types.index')->with('success', 'تمت إضافة نوع الغرفة بنجاح');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $roomType = RoomType::findOrFail($id);
        return view('room-types.show', compact('roomType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $roomType = RoomType::findOrFail($id);
        $services = Service::all();
        return view('room-types.edit', compact('roomType', 'services'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(RoomTypeRequest $request, string $id)
    {
        $roomType = RoomType::findOrFail($id);
        $roomType->update($request->validated());
        $roomType->services()->sync($request->input('services', []));


        return redirect()->route('room-types.view')->with('success', 'تم تعديل نوع الغرفة بنجاح');
    }







    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $roomType = RoomType::findOrFail($id);
        $roomType->delete();

        return redirect()->route('room-types.view')->with('success', 'تم حذف نوع الغرفة بنجاح');
    }


    public function view()
    {
        $roomTypes = RoomType::all();
        return view('room-types.view', compact('roomTypes'));
    }
}
