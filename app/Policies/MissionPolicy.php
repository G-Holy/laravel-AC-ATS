<?php

namespace App\Policies;

use App\Models\Mission;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Access\HandlesAuthorization;

class MissionPolicy
{
    use HandlesAuthorization;


    // public function before($user, $ability)
    // {
    //     return $user->role === "admin";
    // }


    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Mission  $mission
     * @return mixed
     */
    public function edit(User $user, Mission $mission)
    {
        // OPTIMISATION 
        // ->pivot
        // créer un model juste pour la table pivot
        // conf la relation avec

        $relation = DB::table('mission_user')->where("mission_id", $mission->id)->where("user_id", $user->id)->first();


        return  $user->id == $mission->user_id || $relation != NULL && $relation->ac_write == true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Mission  $mission
     * @return mixed
     */
    public function delete(User $user, Mission $mission)
    {
        $relation = DB::table('mission_user')->where("mission_id", $mission->id)->where("user_id", $user->id)->first();

        return  $user->id == $mission->user_id || $relation != NULL && $relation->ac_delete == true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Mission  $mission
     * @return mixed
     */
    public function share(User $user, Mission $mission)
    {
        dd("STOP HERE ADVENTURER");
        $relation = DB::table('mission_user')->where("mission_id", $mission->id)->where("user_id", $user->id)->first();

        return  $user->id == $mission->user_id || $relation != NULL && $relation->ac_share == true;
    }
}
