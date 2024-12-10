<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientServiceController extends Controller
{
    /**
     * Display a listing of the active services.
     *
     * @return View The view displaying the list of active services.
     */
    public function index()
    {
        // Retrieve active services, applying optional search, hiding booked services, and calculating review count and average rating
        $services = Service::where('status', 'active')
            ->when(request('search'), function ($query) {
                // Apply search filter if the 'search' query parameter is provided
                $query->where('name', 'like', '%' . request('search') . '%');
            })
            ->when(request('hide_booked'), function ($query) {
                // Apply filter to hide booked services if 'hide_booked' is set
                $query->whereDoesntHave('bookings', function ($q) {
                    $q->where('user_id', auth()->id());
                });
            })
            ->withCount('reviews') // Include review count for each service
            ->withAvg('reviews', 'rating') // Calculate average rating for each service
            ->paginate(9); // Paginate results, displaying 9 services per page

        // Return the view with the services data
        return view('client.services.index', compact('services'));
    }


    /**
     * Display a specific service.
     *
     * @param Service $service The service to display.
     * @return View The view displaying the service details.
     */
    public function show(Service $service)
    {
        // Check if the authenticated user has an existing booking for this service
        $existingBooking = Booking::where('service_id', $service->id)
            ->where('user_id', auth()->id())
            ->first();

        // Fetch reviews for the service, including replies
        $serviceReviews = $service->reviews()
            ->with('replies.user') // Eager load replies and the users who wrote them
            ->get();

        // Return the view with the service and reviews
        return view('client.services.show', compact('service', 'existingBooking', 'serviceReviews'));
    }
}
