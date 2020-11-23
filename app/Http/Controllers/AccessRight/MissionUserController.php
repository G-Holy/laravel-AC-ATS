<?php

namespace App\Http\Controllers\AccessRight;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


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

        $linkExist = DB::table('mission_user')
            ->where("mission_id", $mission->id)
            ->where("user_id", $user->id)
            ->count();

        if (!$linkExist) {
            return response()->json([
                "success" => false,
                "error" => "Failed to detach"
            ], 400);
        }

        $sync = $mission->users()->detach($user->id);


        return response()->json([
            "succress" => true,
            "data" => $sync
        ]);
    }

    public function attachManyUser(Request $request, Mission $mission)
    {

        $validator  = Validator::make($request->all(), [
            "users" => "required",
        ]);

        if ($validator->fails())
            return response()->json(['error' => $validator->errors(), "success" => false,], 401);

        if (!Auth::user()->can("share", $mission)) {
            return response()->json([
                "success" => false,
                "error" => "Unauthorized"
            ], 401);
        }

        $sync = $mission->users()->syncWithoutDetaching($request->users);

        return response()->json([
            "succress" => true,
            "data" => $sync
        ]);
    }

    public function detachManyUser(Request $request, Mission $mission)
    {

        $validator  = Validator::make($request->all(), [
            "users" => "required",
        ]);

        if ($validator->fails())
            return response()->json(['error' => $validator->errors(), "success" => false,], 401);

        if (!Auth::user()->can("share", $mission)) {
            return response()->json([
                "success" => false,
                "error" => "Unauthorized"
            ], 401);
        }

        $sync = $mission->users()->detach($request->users);

        return response()->json([
            "succress" => true,
            "data" => $sync
        ]);
    }

    public function giveWriteToOne(Mission $mission, User $user)
    {

        if (!Auth::user()->can("share", $mission)) {
            return response()->json([
                "success" => false,
                "error" => "Unauthorized"
            ], 401);
        }

        $link = DB::table('mission_user')
            ->where("mission_id", $mission->id)
            ->where("user_id", $user->id)
            ->first();

        $link->update(["ac_write" => true]);

        return response()->json([
            "succress" => true,
            "data" => $link
        ]);
    }

    //Give TO ONE permission to READ
    //Give TO ONE permission to EDIT
    //Give TO ONE permission to DELETE

    //Give TO MANY permission to READ
    //Give TO MANY permission to EDIT
    //Give TO MANY permission to DELETE
}
