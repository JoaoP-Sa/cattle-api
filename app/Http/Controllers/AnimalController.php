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
}
