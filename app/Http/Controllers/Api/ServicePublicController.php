<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServicePublicController extends Controller
{
    public function index() {
        $services = Service::all();
        return response()->json($services, 200); 
    }

    public function show($id) {
        $service = Service::findOrFail($id);
        return response()->json($service, 200); 
    }
}
