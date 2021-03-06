<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Tweet;
use Illuminate\Auth\Access\HandlesAuthorization;

class TweetPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function destroy(User $user, Tweet $tweet)
    {
        return $user->id === $tweet->user_id;
    }

    public function update(User $user, Tweet $tweet)
    {
        return $user->id === $tweet->user_id;
    }
}
