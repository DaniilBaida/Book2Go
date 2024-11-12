<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ClientServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::where('status', 'active')
            ->when(request('search'), function ($query) {
                $query->where('name', 'like', '%' . request('search') . '%');
            })
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->paginate(9);



        return view('client.services.index', compact('services'));
    }

    public function show(Service $service)
    {
        return view('client.services.show', compact('service'));
    }




}
