<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\DiscountCode;
use Illuminate\Http\Request;

class BusinessDiscountController extends Controller
{
    public function index()
    {
        $business = auth()->user();
        $discountCodes = DiscountCode::where('business_id', $business->id)->get();

        return view('business.discounts.index', compact('discountCodes'));
    }

    public function create()
    {
        return view('business.discounts.create');
    }

    public function store(Request $request)
    {
        $business = auth()->user();

        $request->validate([
            'code' => 'required|string|unique:discount_codes',
            'description' => 'nullable|string',
            'discount' => 'required|numeric|min:1|max:100',
        ]);

        DiscountCode::create([
            'code' => $request->input('code'),
            'description' => $request->input('description'),
            'discount' => $request->input('discount'),
            'business_id' => $business->id,
        ]);

        return redirect()->route('business.discounts.index')->with('success', 'Discount created successfully!');
    }

    public function destroy(DiscountCode $discount)
    {
        $discount->delete();

        return redirect()->back()->with('success', 'Discount deleted successfully!');
    }
}
