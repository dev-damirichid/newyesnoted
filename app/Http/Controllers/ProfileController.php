<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    function index() {        
        $data = (object) [
            'title' => 'Profile',
        ];
        
        return view('profile.index', compact('data'));
    }

    function update(Request $request) {
        $validated = $request->validate([
            'photo'     => 'nullable|image',
            'name'      => 'required|max:255',
            'company'   => 'nullable|max:255',
            'notes'     => 'nullable',
        ]);
        $user = User::find(auth()->user()->id);
        if ($request->file('photo')) {
            $file = $request->file('photo')->store('public/photos'); 
            $name = $request->file('photo')->hashName();
            Storage::delete('public/photos/'.auth()->user()->photo);
            $user->update([
                'photo'     => $name,
            ]);
        }
        $user->update([
            'name'      => $request->name,
            'company'   => $request->company,
            'notes'     => $request->notes,
        ]);
        toast('Profile have been update','success');
        return redirect()->route('profile.index');
    }
}
