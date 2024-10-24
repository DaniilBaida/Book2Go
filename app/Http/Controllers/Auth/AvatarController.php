<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

        if ($request->hasFile('avatar_path')) {
            $file = $request->file('avatar_path');

            // Generate a unique filename and define the storage path
            $uuid = Str::uuid()->toString();
            $filename = $uuid . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('avatars', $filename, 'public');

            // Get the authenticated user
            $user = Auth::user();

            // Store the old avatar path before updating
            $oldAvatarPath = $user->avatar_path;

            // Update the user's avatar path in the database
            $user->avatar_path = '/storage/' . $path; // Adjust the path for public access
            $user->save();

            // Delete the old avatar file if it exists and is not the default avatar
            if ($oldAvatarPath && $oldAvatarPath != '/storage/avatars/default.png') {
                // Extract the relative path from the public path
                $oldAvatarRelativePath = str_replace('/storage/', '', $oldAvatarPath);

                // Check if the file exists in storage
                if (Storage::disk('public')->exists($oldAvatarRelativePath)) {
                    // Delete the old avatar file
                    Storage::disk('public')->delete($oldAvatarRelativePath);
                }
            }
        }

        return redirect()->back()->with('status', 'avatar-updated');
    }

}
