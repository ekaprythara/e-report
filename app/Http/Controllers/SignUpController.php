<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Level;
use Illuminate\Http\Request;

class SignUpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('/sign-up/index', [
            "title" => "Registrasi",
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
            'username' => 'required|min:3|max:25|alpha_dash|unique:users,username',
            'password' => 'required|min:5|max:30',
            'password_confirmation' => 'required|same:password',
            'name' => 'required|min:3|max:30',
            'address' => 'required|min:5|max:50',
            'email' => 'required|email:dns|max:50',
            'phone' => 'required|min:10|max:13|unique:users,phone',
            'level_id' => 'required'
        ]);

        if ($request->file('image')) {
            $validated['image'] = $request->file('image')->store('img');
        }
        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);
        return redirect('/sign-up')->with('create', 'Registrasi berhasil! Silakan login.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
