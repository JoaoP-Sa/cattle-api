<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    public function index() {
        $animals = Animal::all();

        return response()->json($animals);
    }

    public function search(Request $request) {
        $query = $request->input("code");
        $animal = Animal::where("code", "like", "%$query%")->first();

        return response()->json($animal);
    }
}
