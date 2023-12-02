<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('/data-master/pengguna', [
            "title" => "Pengguna",
            "users" => User::with('level')
                ->orderBy('level_id')
                ->latest()
                ->get(),
            "levels" => Level::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|file|max:1024',
            'username' => 'required|min:3|max:20|alpha_dash|unique:users,username',
            'password' => 'required|min:5|max:15',
            'password_confirmation' => 'required|same:password',
            'name' => 'required|min:3|max:50',
            'address' => 'required|min:3|max:35',
            'email' => 'required|min:5|max:30|email:rfc,dns|unique:users,email',
            'phone' => 'required|numeric|digits_between:10,13|unique:users,phone',
            'level_id' => 'required'
        ]);

        if ($request->file('image')) {
            $validated['image'] = $request->file('image')->store('img');
        }
        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);
        return redirect('/data-master/pengguna')->with('create', 'Data pengguna berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'image' => 'nullable|image|file|max:1024',
            'username' => "required|min:3|max:20|alpha_dash|unique:users,username,$id",
            'name' => 'required|min:3|max:50',
            'address' => 'required|min:3|max:35',
            'email' => "required|min:5|max:30|email:rfc,dns|unique:users,email,$id",
            'phone' => "required|numeric|digits_between:10,13|unique:users,phone,$id"
        ];

        $request->validateWithBag("edit$id", $rules);

        $data = [
            'image' => $request->image,
            'username' => $request->username,
            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        if ($request->file('image')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $data['image'] = $request->file('image')->store('img');
        }

        User::where('id', $id)
            ->update($data);
        return redirect('/data-master/pengguna')->with('update', 'Data pengguna berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->oldImage) {
            Storage::delete($request->oldImage);
        }

        User::destroy($id);
        return redirect('/data-master/pengguna')->with('delete', 'Data pengguna berhasil dihapus');
    }

    public function editPhoto(Request $request, $id)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|file|max:1024',
        ]);

        if ($request->oldImage) {
            Storage::delete($request->oldImage);
        }

        User::where('id', $id)
            ->update($validated);
        return redirect('/data-master/pengguna')->with('update', 'Foto profil berhasil dihapus');
    }

    public function changePassword(Request $request)
    {
        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            // The passwords matches
            return redirect('/data-master/pengguna')->with('delete', "Your current password does not matches with the password");
        }

        if (strcmp($request->get('current_password'), $request->get('new_password')) == 0) {
            // Current password and new password same
            return redirect('/data-master/pengguna')->with('delete', "New Password cannot be same as your current password");
        }

        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:5|max:15',
            'new_password_confirmation' => 'required|same:new_password',
        ]);

        $validated['new_password'] = bcrypt($validated['new_password']);

        // return dd($validated);
        $user = User::find($request->id);
        $user->password = bcrypt($request->get('new_password'));
        $user->save();

        return redirect('/data-master/pengguna')->with('update', "Kata sandi dari $user->name berhasil diedit");
    }
}
