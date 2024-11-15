<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BusinessServiceController extends Controller
{
    protected const PAGINATION_COUNT = 9;

    public function index(Request $request)
    {
        $search = $request->input('search');

        // Fetch services for the authenticated user's business
        $services = Auth::user()->business->services()
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%");
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
        $data = $this->validateServiceData($request);

        $data['image_path'] = $this->handleImageUpload($request);
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
        $data = $this->validateServiceData($request);

        $data['image_path'] = $this->handleImageUpload($request, $service);

        $service->update($data);

        return redirect()->route('business.services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        if ($service->image_path) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $service->image_path));
        }

        $service->delete();

        return redirect()->route('business.services.index')->with('success', 'Service deleted successfully.');
    }

    private function validateServiceData(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'service_category_id' => 'required|exists:service_categories,id',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive,archived',

        ]);
    }

    private function handleImageUpload(Request $request, ?Service $service = null)
    {
        if ($request->hasFile('image')) {
            if ($service && $service->image_path) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $service->image_path));
            }

            $path = $request->file('image')->store('services', 'public');
            return '/storage/' . $path;
        }

        return $service ? $service->image_path : null;
    }
}
