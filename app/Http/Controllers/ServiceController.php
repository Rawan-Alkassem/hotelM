<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('roomTypes')->get();
        return view('services.index', compact('services'));
    }

    public function create()
    {
        $roomTypes = RoomType::all();
        return view('services.create', compact('roomTypes'));
    }

    public function store(StoreServiceRequest $request)
    {
        $imagePath = null;

        if ($request->hasFile('image')) {
            // رفع الصورة وحفظها في storage/app/public/services
            $imagePath = $request->file('image')->store('services', 'public');
        }

        $service = Service::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imagePath ?? null,  // null يعني نستخدم الصورة الافتراضية بالعرض
        ]);

        if ($request->filled('room_types')) {
            $service->roomTypes()->sync($request->room_types);
        }

        return redirect()->route('services.index')->with('success', 'Service created successfully.');
    }

    public function edit(Service $service)
    {
        $roomTypes = RoomType::all();
        $selectedRoomTypes = $service->roomTypes->pluck('id')->toArray();
        return view('services.edit', compact('service', 'roomTypes', 'selectedRoomTypes'));
    }

    public function update(UpdateServiceRequest $request, Service $service)
    {
        // تحديث الصورة لو تم رفع واحدة جديدة
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة اذا موجودة
            if ($service->image && Storage::disk('public')->exists($service->image)) {
                Storage::disk('public')->delete($service->image);
            }
            // رفع الصورة الجديدة
            $imagePath = $request->file('image')->store('services', 'public');
            $service->image = $imagePath;
        }

        $service->name = $request->name;
        $service->description = $request->description;
        $service->save();

        if ($request->filled('room_types')) {
            $service->roomTypes()->sync($request->room_types);
        } else {
            $service->roomTypes()->detach();
        }

        return redirect()->route('services.index')->with('success', 'Service updated successfully.');
    }

    public function show(Service $service)
    {
        $service->load('roomTypes');
        return view('services.show', compact('service'));
    }

    public function destroy(Service $service)
    {
        // حذف الصورة من التخزين إذا موجودة
        if ($service->image && Storage::disk('public')->exists($service->image)) {
            Storage::disk('public')->delete($service->image);
        }

        $service->roomTypes()->detach();
        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service deleted.');
    }
}
