<?php namespace App\Policies;

use App\Game;
use App\User;

class UserPolicy extends Policy
{
    /**
     * @param \App\User $user
     * @param \App\User $user2
     *
     * @return bool
     */
    public function update(User $user, User $user2)
    {
        return $user->id === $user2->id;
    }

    /**
     * @param \App\User $user
     * @param \App\User $user2
     *
     * @return bool
     */
    public function destroy(User $user, User $user2)
    {
        return false;
    }

    /**
     * @param \App\User $user
     * @param \App\User $user2
     *
     * @return bool
     */
    public function getFollowing(User $user, User $user2) {
        return $user->id === $user2->id;
    }

    /**
     * @param \App\User $user
     * @param \App\User $user2
     *
     * @return bool
     */
    public function seeEmail(User $user, User $user2) {
        return $user->id === $user2->id;
    }

    /**
     * @param \App\User $user
     * @param \App\User $user2
     *
     * @return bool
     */
    public function seeName(User $user, User $user2) {
        return $user->id === $user2->id;
    }
}
