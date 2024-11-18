<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountCode;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index(Request $request)
    {
        // Iniciar a consulta de DiscountCode
        $query = DiscountCode::query()->with('business');

        // Aplicar filtro de busca, se existir
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('code', 'like', '%' . $search . '%')
                ->orWhere('type', 'like', '%' . $search . '%')
                ->orWhere('status', 'like', '%' . $search . '%');
        }

        // Paginar os resultados
        $discountCodes = $query->paginate(10);

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
            'type' => 'required|string|in:percentage,fixed',
            'value' => 'required|numeric|min:1',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
        ]);

        // Criar o código de desconto com o admin_id
        DiscountCode::create([
            'code' => $request->input('code'),
            'type' => $request->input('type'),
            'value' => $request->input('value'),
            'max_uses' => $request->input('max_uses', null),
            'admin_id' => $admin->id, // Adiciona o admin_id
            'business_id' => null, // Certifique-se de que business_id seja nulo
            'expires_at' => $request->input('expires_at', null),
        ]);

        return redirect()->route('admin.discounts.index')->with('success', 'Discount created successfully!');
    }

    public function edit(DiscountCode $discount)
    {
        // Retorna a view de edição com o código de desconto
        return view('admin.discounts.edit', compact('discount'));
    }

    public function update(Request $request, DiscountCode $discount)
    {
        // Valida os dados
        $request->validate([
            'code' => 'required|string|unique:discount_codes,code,' . $discount->id,
            'type' => 'required|string|in:percentage,fixed',
            'value' => 'required|numeric|min:1',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
        ]);

        // Atualiza o código de desconto
        $discount->update($request->only(['code', 'type', 'value', 'max_uses', 'expires_at']));

        // Redireciona com mensagem de sucesso
        return redirect()->route('admin.discounts.index')->with('success', 'Discount code updated successfully!');
    }

    public function destroy(DiscountCode $discount)
    {
        // Apaga o código de desconto
        $discount->delete();

        // Redireciona com uma mensagem de sucesso
        return redirect()->route('admin.discounts.index')->with('success', 'Discount code deleted successfully!');
    }
}
