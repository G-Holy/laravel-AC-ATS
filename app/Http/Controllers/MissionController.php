<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;


class MissionController extends Controller
{

    // TODO : Mettre le middleware à un autre endroit
    //TODO : tester de créer une mission et de jouer avec les droits
    // TODO : un controller service ou non pour la table pivot ? ou qui gère les droit ?
    public function __construct()
    {
        $this->middleware("auth:api");
    }

    public function create(Request $request)
    {
        $validator  = Validator::make($request->all(), [
            "title" => "required|max:200|min:3",
            "description" => "required|min:3",
        ]);

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()], 401);

        $mission = new Mission;
        $mission->title = $request->title;
        $mission->description = $request->description;
        $mission->user_id = $request->user()->id;
        $mission->save();

        $mission->users()->attach($request->user()->id);

        return response()->json([
            "succress" => true,
            "data" => $mission
        ]);
    }

    public function edit(Request $request, Mission $mission)
    {
        // if (!Gate::allows("edit", $mission)) {
        //     return response()->json([
        //         "success" => false,
        //         "error" => "You don't have the right to edit this mission"
        //     ], 401);
        // }

        $validator  = Validator::make($request->all(), [
            "title" => "required|max:200|min:3",
            "description" => "required|min:3",
        ]);

        if ($validator->fails())
            return response()->json(['error' => $validator->errors(), "success" => false,], 401);

        $mission->update(["title" => $request->title, "description" => $request->description]);

        return response()->json([
            "succress" => true,
            "data" => $mission
        ]);
    }

    public function getReadable(Request $request)
    {
        // OPTI
        //If admin get all

        return response()->json([
            "succress" => true,
            "data" => $request->user()->missions
        ]);
    }
}
