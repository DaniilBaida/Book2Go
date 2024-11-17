<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountCode;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index()
    {
        $admin = auth()->user();
        $discountCodes = DiscountCode::all();
        return view('admin.discounts.index', compact('discountCodes'));
    }

    public function create()
    {
        return view('admin.discounts.create');
    }

    public function store(Request $request)
    {
        $admin = auth()->user();

        $request->validate([
            'code' => 'required|string|unique:discount_codes',
            'description' => 'nullable|string',
            'discount' => 'required|numeric|min:1|max:100',
        ]);

        DiscountCode::create([
            'code' => $request->input('code'),
            'description' => $request->input('description'),
            'discount' => $request->input('discount'),
            'admin_id' => $admin->id,
        ]);

        return redirect()->route('admin.discounts.index')->with('success', 'Discount created successfully!');
    }

    public function destroy(DiscountCode $discount)
    {
        $discount->delete();

        return redirect()->back()->with('success', 'Discount deleted successfully!');
    }
}
