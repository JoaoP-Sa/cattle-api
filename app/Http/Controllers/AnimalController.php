<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnimalRequest;
use App\Models\Animal;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * @OA\Info(title="Cattle API", version="1.0.0")
 */
class AnimalController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/animal",
     *     summary="List all animals",
     *     @OA\Response(
     *         response=200,
     *         description="A list of animals",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="code", type="string"),
     *                 @OA\Property(property="milk", type="number"),
     *                 @OA\Property(property="food", type="number"),
     *                 @OA\Property(property="weight", type="number", format="float"),
     *                 @OA\Property(property="born", type="string", format="date"),
     *                 @OA\Property(property="shooted_down", type="integer"),
     *                 @OA\Property(property="created_at", type="string", format="date"),
     *                 @OA\Property(property="updated_at", type="string", format="date")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token has expired",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Token has expired"),
     *             @OA\Property(property="exception", type="string", example="Symfony\\Component\\HttpKernel\\Exception\\UnauthorizedHttpException"),
     *             @OA\Property(property="file", type="string", example="/path/to/file.php"),
     *             @OA\Property(property="line", type="integer", example=74),
     *             @OA\Property(property="trace", type="array", @OA\Items(type="object", example={"file": "/path/to/file.php", "line": 30, "function": "authenticate"}))
     *         )
     *     )
     * )
     */
    public function index() {
        $animals = Animal::all();

        return response()->json($animals);
    }

    /**
     * @OA\Get(
     *     path="/api/animal/search",
     *     summary="Get animal by id or by code",
     *     @OA\Parameter(
     *         name="code",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string"),
     *         description="Code of the animal to search"
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer", format="int"),
     *         description="ID of the animal to search"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Animal details",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", format="int", description="Unique identifier for the animal"),
     *             @OA\Property(property="code", type="string", description="Animal's code"),
     *             @OA\Property(property="milk", type="number", format="float", description="Daily milk production in liters"),
     *             @OA\Property(property="food", type="number", format="float", description="Daily food consumption in kilograms"),
     *             @OA\Property(property="weight", type="number", format="float", description="Weight of the animal in arrobas"),
     *             @OA\Property(property="born", type="string", format="date", description="Date of birth of the animal"),
     *             @OA\Property(property="shooted_down", type="integer", format="int", description="Indicates if the animal has been shot down (1 for yes, 0 for no)"),
     *             @OA\Property(property="created_at", type="string", format="date", description="Date when the animal was created"),
     *             @OA\Property(property="updated_at", type="string", format="date", description="Date when the animal was last updated")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token has expired",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Token has expired"),
     *             @OA\Property(property="exception", type="string", example="Symfony\\Component\\HttpKernel\\Exception\\UnauthorizedHttpException"),
     *             @OA\Property(property="file", type="string", example="/path/to/file.php"),
     *             @OA\Property(property="line", type="integer", example=74),
     *             @OA\Property(property="trace", type="array", @OA\Items(type="object", example={"file": "/path/to/file.php", "line": 30, "function": "authenticate"}))
     *         )
     *     )
     * )
     */
    public function search(Request $request) {
        if ($request->input('id')) {
            $animal = Animal::find($request->id);
            return response()->json($animal);
        }

        $query = $request->input('code');

        $animal = Animal::query();
        $animal = Animal::where("code", "like", "%$query%")->first();

        return response()->json($animal);
    }

    /**
     * @OA\Post(
     *     path="/api/animal/create",
     *     summary="Create a new animal register",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="code", type="string", description="Animal's code"),
     *             @OA\Property(property="milk", type="number", format="float", description="Animal's daily milk production (in liters, if it produces)"),
     *             @OA\Property(property="food", type="number", format="float", description="Animal's daily food consume (in kilograms)"),
     *             @OA\Property(property="weight", type="number", format="float", description="Animal's weight (in arrobas)"),
     *             @OA\Property(property="born", type="string", example="01/01/2000", description="Animal's born date"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="O animal foi cadastrado com sucesso.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token has expired",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Token has expired"),
     *             @OA\Property(property="exception", type="string", example="Symfony\\Component\\HttpKernel\\Exception\\UnauthorizedHttpException"),
     *             @OA\Property(property="file", type="string", example="/path/to/file.php"),
     *             @OA\Property(property="line", type="integer", example=74),
     *             @OA\Property(property="trace", type="array", @OA\Items(type="object", example={"file": "/path/to/file.php", "line": 30, "function": "authenticate"}))
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation errors",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Foram encontrados um ou mais erros nas informações enviadas."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="code",
     *                     type="array",
     *                     @OA\Items(type="string", example="O campo code deve ser único, e já existe outro animal com este código.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Put(
     *     path="/api/animal/update/{animal}",
     *     summary="Update existent animal",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="code", type="string", description="Animal's code"),
     *             @OA\Property(property="milk", type="number", format="float", description="Animal's daily milk production (in liters, if it produces)"),
     *             @OA\Property(property="food", type="number", format="float", description="Animal's daily food consume (in kilograms)"),
     *             @OA\Property(property="weight", type="number", format="float", description="Animal's weight (in arrobas)"),
     *             @OA\Property(property="born", type="string", example="01/01/2000", description="Animal's born date"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="O cadastro do animal foi atualizado com sucesso.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token has expired",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Token has expired"),
     *             @OA\Property(property="exception", type="string", example="Symfony\\Component\\HttpKernel\\Exception\\UnauthorizedHttpException"),
     *             @OA\Property(property="file", type="string", example="/path/to/file.php"),
     *             @OA\Property(property="line", type="integer", example=74),
     *             @OA\Property(property="trace", type="array", @OA\Items(type="object", example={"file": "/path/to/file.php", "line": 30, "function": "authenticate"}))
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation errors",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Foram encontrados um ou mais erros nas informações enviadas."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="code",
     *                     type="array",
     *                     @OA\Items(type="string", example="O campo code deve ser único, e já existe outro animal com este código.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/animal/delete/{animal}",
     *     summary="Delete animal",
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="O registro deste animal foi excluído com sucesso.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Animal not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="No query results for model [App\\Models\\Animal] 1"),
     *             @OA\Property(property="exception", type="string", example="Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException"),
     *             @OA\Property(property="file", type="string", example="/home/joao/Documents/laravel/projects/cattle-api/vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php"),
     *             @OA\Property(property="line", type="integer", example=385),
     *             @OA\Property(property="trace", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="file", type="string", example="/home/joao/Documents/laravel/projects/cattle-api/vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php"),
     *                     @OA\Property(property="line", type="integer", example=332),
     *                     @OA\Property(property="function", type="string", example="prepareException"),
     *                     @OA\Property(property="class", type="string", example="Illuminate\\Foundation\\Exceptions\\Handler"),
     *                     @OA\Property(property="type", type="string", example="->")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token has expired",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Token has expired"),
     *             @OA\Property(property="exception", type="string", example="Symfony\\Component\\HttpKernel\\Exception\\UnauthorizedHttpException"),
     *             @OA\Property(property="file", type="string", example="/path/to/file.php"),
     *             @OA\Property(property="line", type="integer", example=74),
     *             @OA\Property(property="trace", type="array", @OA\Items(type="object", example={"file": "/path/to/file.php", "line": 30, "function": "authenticate"}))
     *         )
     *     )
     * )
     */
    public function delete(Animal $animal) {
        $animal->delete();

        return response()->json(["message" => "O registro deste animal foi excluído com sucesso."]);
    }

    /**
     * @OA\Put(
     *     path="/api/animal/shoot-down/{animal}",
     *     summary="Shoot down an alive animal",
     *     @OA\Response(
     *         response=200,
     *         description="Success"
     *     )
     * )
     */

        /**
     * @OA\Put(
     *     path="/api/animal/shoot-down/{animal}",
     *     summary="Shoot down an alive animal",
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="O foi abatido com sucesso.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Animal not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="No query results for model [App\\Models\\Animal] 1"),
     *             @OA\Property(property="exception", type="string", example="Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException"),
     *             @OA\Property(property="file", type="string", example="/home/joao/Documents/laravel/projects/cattle-api/vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php"),
     *             @OA\Property(property="line", type="integer", example=385),
     *             @OA\Property(property="trace", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="file", type="string", example="/home/joao/Documents/laravel/projects/cattle-api/vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php"),
     *                     @OA\Property(property="line", type="integer", example=332),
     *                     @OA\Property(property="function", type="string", example="prepareException"),
     *                     @OA\Property(property="class", type="string", example="Illuminate\\Foundation\\Exceptions\\Handler"),
     *                     @OA\Property(property="type", type="string", example="->")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token has expired",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Token has expired"),
     *             @OA\Property(property="exception", type="string", example="Symfony\\Component\\HttpKernel\\Exception\\UnauthorizedHttpException"),
     *             @OA\Property(property="file", type="string", example="/path/to/file.php"),
     *             @OA\Property(property="line", type="integer", example=74),
     *             @OA\Property(property="trace", type="array", @OA\Items(type="object", example={"file": "/path/to/file.php", "line": 30, "function": "authenticate"}))
     *         )
     *     )
     * )
     */
    public function shootDown(Animal $animal) {
        if (!$animal->shooted_down) {
            $animal->shooted_down = true;
            $animal->save();

            return response()->json(["message" => "O animal foi abatido com sucesso."]);
        }

        return response()->json(["message" => "Este animal já foi abatido."]);
    }
}
