<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;

class AvatarController extends Controller
{

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar_path' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        if ($user->avatar_path) {
            Storage::disk('public')->delete($user->avatar_path);
        }

        // Armazena o novo avatar
        $path = $request->file('avatar_path')->store('avatars', 'public');
        $user->avatar_path = '/storage/' . $path;
        $user->save();

        return redirect()->back()->with('status', 'Avatar atualizado com sucesso.');
    }
}
