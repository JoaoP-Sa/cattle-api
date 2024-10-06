<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnimalRequest;
use App\Models\Animal;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    // list all animals
    public function index() {
        $animals = Animal::all();

        return response()->json($animals);
    }

    // search animal by code
    public function search(Request $request) {
        $query = $request->input("code");
        $animal = Animal::where("code", "like", "%$query%")->first();

        return response()->json($animal);
    }

    // create a new animal register
    public function create(AnimalRequest $request, Animal $animal) {
        try {
            $request["born"] = Carbon::createFromFormat("d/m/Y", $request["born"]);

            $data = $request->all();
            $animal->create($data);

            return response()->json(["message" => "O animal foi cadastrado com sucesso."]);
        } catch (\Throwable $e) {
            return response()->json($e->getMessage());
        }
    }

    // update existent animal
    public function update(AnimalRequest $request, Animal $animal) {
        try {
            $request["born"] = Carbon::createFromFormat("d/m/Y", $request["born"]);

            $data = $request->all();

            $animal->fill($data);
            $animal->save();

            return response()->json(["message" => "O cadastro do animal foi atualizado com sucesso."]);
        } catch (\Throwable $e) {
            return response()->json($e->getMessage());
        }
    }

    // delete animal by id
    public function delete(Animal $animal) {
        $animal->delete();

        return response()->json(["message" => "O registro deste animal foi excluído com sucesso."]);
    }
}
