<?php

namespace App\Http\Controllers;

use App\Models\Advert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\AdvertState;

class AdvertController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            'email' => Auth::user()->email ,
            'step' => 'first',
            'phone' => Auth::user()->phone_number
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->post('step') == 'first')
        {
            $advert = new Advert();
            $advert->header = $request->post('header');
            $advert->user_id = Auth::user()->id;
            $advert->price = $request->post('price');
            $advert->description = $request->post('description');
            $advert->registration_number = $request->post('registrationNumber');
            $advert->phone_number = $request->post('phone');
            $advert->state = AdvertState::Draft;
            $advert->save();

            return view('advert.create', ['step' => 'second']);
        } elseif ($request->post('step') == 'second')
        {

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Advert $advert)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Advert $advert)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Advert $advert)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advert $advert)
    {
        //
    }
}
