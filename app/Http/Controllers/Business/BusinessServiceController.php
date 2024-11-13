<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BusinessServiceController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Fetch services for the authenticated user's business
        $services = Auth::user()->business->services()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('name', 'LIKE', "{$search}%")
                        ->orWhere('name', 'LIKE', "%{$search}")
                        ->orWhere('name', 'LIKE', "{$search}");
                });
            })
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->with('category')
            ->paginate(9);

        $role = Auth::user()->role_id;

        return view('business.services.index', compact('services', 'role'));
    }

    public function show(Service $service)
    {
        return view('business.services.show', compact('service'));
    }

    public function create()
    {
        $categories = ServiceCategory::all();
        return view('business.services.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'service_category_id' => 'required|exists:service_categories,id',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:original_price',
            'discount_start_date' => 'nullable|date|before:discount_end_date',
            'discount_end_date' => 'nullable|date|after:discount_start_date',
            'duration_minutes' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive,archived',
            'tags' => 'nullable|string',
        ]);

        $data = $request->all();

        // Process tags
        if (!empty($data['tags'])) {
            $data['tags'] = array_map('trim', explode(',', $data['tags']));
        } else {
            $data['tags'] = [];
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('services', 'public');
            $data['image_path'] = '/storage/' . $path;
        }
        auth()->user()->business->services()->create($data);


        return redirect()->route('business.services.index')->with('success', 'Service created successfully.');
    }


    public function edit(Service $service)
    {
        $categories = ServiceCategory::all();
        return view('business.services.edit', compact('service', 'categories'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'service_category_id' => 'required|exists:service_categories,id',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:original_price',
            'discount_start_date' => 'nullable|date|before:discount_end_date',
            'discount_end_date' => 'nullable|date|after:discount_start_date',
            'duration_minutes' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive,archived',
            'tags' => 'nullable|string',
        ]);

        $data = $request->all();

        // Process tags
        if (!empty($data['tags'])) {
            $data['tags'] = array_map('trim', explode(',', $data['tags']));
        } else {
            $data['tags'] = [];
        }

        if ($request->hasFile('image')) {
            // Remove old image if exists
            if ($service->image_path) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $service->image_path));
            }

            $path = $request->file('image')->store('services', 'public');
            $data['image_path'] = '/storage/' . $path;
        }

        // Update the service
        $service->update($data);

        return redirect()->route('business.services.index')->with('success', 'Service updated successfully.');
    }


    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('business.services.index')->with('success', 'Service deleted successfully.');
    }

}