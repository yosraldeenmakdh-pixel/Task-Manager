<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // public function index()
    // {
    //     $profiles = Profile::all();
    //     return response()->json($profiles, 200);
    // }

    public function store(StoreProfileRequest $request)
    {
        $user = Auth::user() ;
        if($user->profile)
            return response()->json([
                'message'=>'you already profile if you update profile go to update profile page'
            ], 200);


        $validatedData = $request->validated() ;
        $validatedData['user_id'] = $user->id ;
        if($request->hasFile('image')){
            $path = $request->file('image')->store('photos','public') ;
            $validatedData['image'] = $path ;
        }
        $profile = Profile::create($validatedData);
        return response()->json([
            'message' => 'Profile created successfully',
            'profile' => $profile,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function index()
    {
        $profile = Auth::user()->profile ;
        if(!$profile)
            return response()->json([
                'message'=>'you are not profile if you create profile go to create profile page'
            ], 200);

        return response()->json($profile, 200);
    }

    public function update(UpdateProfileRequest $request)
    {
        $profile = Auth::user()->profile ;
        if(!$profile)
            return response()->json([
                'message'=>'you are not profile if you create profile go to create profile page'
            ], 200);

        $profile->update($request->validated());
        return response()->json([
            'message' => 'the profile is updated',
            'new profile' => $profile,
        ], 200);

    }


    public function destroy()
    {
        $profile = Auth::user()->profile ;
        if(!$profile)
            return response()->json([
                'message'=>'you are not profile if you create profile go to create profile page'
            ], 404);

        $profile->delete();
        return response()->json(['message' => 'the profile is deleted'], 200);
    }
}
