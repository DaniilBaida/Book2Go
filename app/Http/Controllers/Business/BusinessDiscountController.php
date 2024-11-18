<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\DiscountCode;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class BusinessDiscountController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $business = auth()->user()->business;

        $query = DiscountCode::query()->where('business_id', $business->id);

        if ($request->has('search') && !empty($request->search)) {
            $query->where('code', 'like', '%' . $request->search . '%')
                  ->orWhere('type', 'like', '%' . $request->search . '%')
                  ->orWhere('status', 'like', '%' . $request->search . '%');
        }

        $discountCodes = $query->paginate(10);

        return view('business.discounts.index', compact('discountCodes'));
    }

    public function create()
    {
        return view('business.discounts.create');
    }

    public function store(Request $request)
    {
        $business = auth()->user()->business;

        $request->validate([
            'code' => 'required|string|unique:discount_codes',
            'type' => 'required|string|in:percentage,fixed',
            'value' => 'required|numeric|min:1',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
        ]);

        DiscountCode::create([
            'code' => $request->input('code'),
            'type' => $request->input('type'),
            'value' => $request->input('value'),
            'max_uses' => $request->input('max_uses', null),
            'business_id' => $business->id,
            'admin_id' => null,
            'expires_at' => $request->input('expires_at', null),
        ]);

        return redirect()->route('business.discounts.index')->with('success', 'Discount created successfully!');
    }

    public function edit(DiscountCode $discount)
    {
        $this->authorize('update', $discount); // Certifica-se de que pertence ao business
        return view('business.discounts.edit', compact('discount'));
    }

    public function update(Request $request, DiscountCode $discount)
    {
        $this->authorize('update', $discount);

        $request->validate([
            'code' => 'required|string|unique:discount_codes,code,' . $discount->id,
            'type' => 'required|string|in:percentage,fixed',
            'value' => 'required|numeric|min:1',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
        ]);

        $discount->update($request->only(['code', 'type', 'value', 'max_uses', 'expires_at']));

        return redirect()->route('business.discounts.index')->with('success', 'Discount updated successfully!');
    }

    public function destroy(DiscountCode $discount)
    {
        $this->authorize('delete', $discount);
        $discount->delete();

        return redirect()->route('business.discounts.index')->with('success', 'Discount deleted successfully!');
    }
}
