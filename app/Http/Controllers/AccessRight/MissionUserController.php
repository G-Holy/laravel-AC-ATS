<?php

namespace App\Http\Controllers\AccessRight;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class MissionUserController extends Controller
{
    // Faire toutes les TO ONE + une TO MANY modulable ([users][right])


    public function attachUser(Mission $mission, User $user)
    {
        // ICI LA POLICY NE SEMBLE PAS S'APPELER

        //Gate::allows("share", $mission);
        // if (!Gate::allows("share", $mission)) {
        //     return response()->json([
        //         "success" => false,
        //         "error" => "Unauthorized"
        //     ], 401);
        // }

        $sync = $mission->users()->syncWithoutDetaching([$user->id]);

        return response()->json([
            "succress" => true,
            "data" => $sync
        ]);
    }

    //Give TO ONE permission to READ
    //Give TO ONE permission to EDIT
    //Give TO ONE permission to DELETE

    //Give TO MANY permission to READ
    //Give TO MANY permission to EDIT
    //Give TO MANY permission to DELETE
}
