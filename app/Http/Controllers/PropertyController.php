<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;


class PropertyController extends Controller{

    public function index()
    {
        $properties = Property::where('user_id', Auth::user()->id)->get();
        return view('properties.index')->with(['properties' => $properties]);
    }

    public function show($id)
    {
        $property = Property::findOrFail($id);
        return view('properties.show')->with(['property' => $property, 'owners' => $property->owners ]);
    }
}