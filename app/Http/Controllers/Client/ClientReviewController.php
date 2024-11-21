<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ClientReviewController extends Controller
{
    use AuthorizesRequests;

    public function create(Booking $booking)
    {
        // Verificar se o cliente já fez uma review para este serviço
        $existingReview = Review::where('booking_id', $booking->id)
            ->where('reviewer_type', 'client')
            ->exists();

        if ($existingReview) {
            // Redirecionar com mensagem de erro
            return redirect()->route('client.notifications.index')
                ->with('error', 'You have already reviewed this service.');
        }

        // Aplicar política de permissão
        $this->authorize('leaveServiceReview', $booking);

        return view('client.reviews.create', compact('booking'));
    }

    public function store(Request $request, Booking $booking)
    {
        // Aplicar a Policy para verificar permissão
        $this->authorize('leaveServiceReview', $booking);

        // Validar os dados da review
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Criar a review
        Review::create([
            'booking_id' => $booking->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'reviewer_type' => 'client',
            'is_approved' => false,
        ]);

        return redirect()->route('client.bookings')
            ->with('success', 'Review submitted successfully.');
    }

    public function report(Review $review)
    {
        $review->markAsReported();

        return back()->with('success', 'Review has been reported and will be reviewed by an administrator.');
    }
}
