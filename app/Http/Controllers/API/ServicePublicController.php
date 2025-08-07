<?php




namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;

class ServicePublicController extends Controller
{
    public function index()
    {
        return ServiceResource::collection(Service::all());
    }

    public function show($id)
    {
        $service = Service::findOrFail($id);
        return new ServiceResource($service);
    }
}
