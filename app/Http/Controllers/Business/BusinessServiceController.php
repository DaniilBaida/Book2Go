<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BusinessServiceController extends Controller
{
    // Pagination count for service listing
    protected const PAGINATION_COUNT = 9;

    /**
     * Display a list of services for the authenticated business.
     *
     * @param Request $request The incoming request.
     * @return View The view displaying services.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $services = Auth::user()->business->services()
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%");
            })
            ->withCount([
                'reviews as reviews_count' => function ($query) {
                    $query->where('reviewer_type', 'client'); // Only reviews from clients
                }
            ])
            ->withAvg([
                'reviews as reviews_avg_rating' => function ($query) {
                    $query->where('reviewer_type', 'client'); // Calculate avg only from client reviews
                }
            ], 'rating')
            ->with('category') // Include the service category
            ->paginate(self::PAGINATION_COUNT);

        $role = Auth::user()->role_id;

        return view('business.services.index', compact('services', 'role'));
    }

    /**
     * Display a specific service.
     *
     * @param Service $service The service to display.
     * @return View The view displaying the service details.
     */
    public function show(Service $service)
    {
        return view('business.services.show', compact('service'));
    }

    /**
     * Show the form for creating a new service.
     *
     * @return View The view to create a new service.
     */
    public function create()
    {
        $categories = ServiceCategory::all(); // Fetch all service categories
        return view('business.services.create', compact('categories'));
    }

    /**
     * Store a new service in the database.
     *
     * @param Request $request The incoming request containing service data.
     * @return RedirectResponse Redirect back to service list with success message.
     */
    public function store(Request $request)
    {
        // Validate incoming service data
        $data = $this->validateServiceData($request);

        // Handle image upload and assign path
        $data['image_path'] = $this->handleImageUpload($request);

        // Ensure available_days is set as an empty array if no days are selected
        $data['available_days'] = $request->input('available_days', []);


        // Create the new service for the authenticated business
        auth()->user()->business->services()->create($data);

        return redirect()->route('business.services.index')->with('success', 'Service created successfully.');
    }

    /**
     * Show the form for editing an existing service.
     *
     * @param Service $service The service to edit.
     * @return View The view to edit the service.
     */
    public function edit(Service $service)
    {
        $categories = ServiceCategory::all(); // Fetch all service categories
        return view('business.services.edit', compact('service', 'categories'));
    }

    /**
     * Update an existing service in the database.
     *
     * @param Request $request The incoming request containing updated service data.
     * @param Service $service The service to update.
     * @return RedirectResponse Redirect back to service list with success message.
     */
    public function update(Request $request, Service $service)
    {
        // Validate incoming service data
        $data = $this->validateServiceData($request);

        // Handle image upload if there's a new one
        $data['image_path'] = $this->handleImageUpload($request, $service);

        // Ensure available_days is set as an empty array if no days are selected
        $data['available_days'] = $request->input('available_days', []);


        // Update the service with the new data
        $service->update($data);

        return redirect()->route('business.services.index')->with('success', 'Service updated successfully.');
    }

    /**
     * Delete a service from the database.
     *
     * @param Service $service The service to delete.
     * @return RedirectResponse Redirect back to service list with success message.
     */
    public function destroy(Service $service)
    {
        try {
            // Delete the image file if it exists
            if ($service->image_path) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $service->image_path));
            }

            // Delete the service from the database
            $service->delete();

            return redirect()->route('business.services.index')->with('success', 'Service deleted successfully.');
        } catch (Exception $e) {
            // Log the error for debugging
            Log::error('Error deleting service: ' . $e->getMessage());

            // Redirect back with an error message
            return redirect()->route('business.services.index')->with('error', 'An error occurred while deleting the service.');
        }
    }

    /**
     * Validate the incoming service data.
     *
     * @param Request $request The incoming request containing service data.
     * @return array Validated service data.
     */
    private function validateServiceData(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'service_category_id' => 'required|exists:service_categories,id',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'available_days' => 'nullable|array',
            'available_days.*' => 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive,archived',
        ]);
    }

    /**
     * Handle the image upload for the service and return the stored file path.
     *
     * @param Request $request The incoming request.
     * @param Service|null $service The service being updated (optional).
     * @return string|null The path to the stored image file.
     */
    private function handleImageUpload(Request $request, ?Service $service = null)
    {
        if ($request->hasFile('image')) {
            // If updating, delete the old image
            if ($service && $service->image_path) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $service->image_path));
            }

            // Store the new image in the 'services' directory and return the path
            $path = $request->file('image')->store('services', 'public');
            return '/storage/' . $path;
        }

        // Return the existing image path if no new image is uploaded
        return $service ? $service->image_path : null;
    }
}
