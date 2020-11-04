<?php

namespace App\Http\Controllers\AccessRight;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class MissionUserController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:api");
    }

    public function attachUser(Request $request, Mission $mission, User $user)
    {
        if (!Auth::user()->can("share", $mission)) {
            return response()->json([
                "success" => false,
                "error" => "Unauthorized"
            ], 401);
        }

        $sync = $mission->users()->syncWithoutDetaching([$user->id]);

        return response()->json([
            "succress" => true,
            "data" => $sync
        ]);
    }

    public function detachUser(Mission $mission, User $user)
    {

        if (!Auth::user()->can("share", $mission)) {
            return response()->json([
                "success" => false,
                "error" => "Unauthorized"
            ], 401);
        }

        $sync = $mission->users()->detach($user->id);

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
