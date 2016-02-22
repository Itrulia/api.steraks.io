<?php namespace App\Policies;

use App\Exceptions\UnauthorizedException;
use Illuminate\Auth\Access\HandlesAuthorization;

class Policy
{
    use HandlesAuthorization;

    /**
     * Throws an unauthorized exception.
     *
     * @param  string $message
     *
     * @throws \App\Exceptions\UnauthorizedException
     */
    protected function deny($message = null)
    {
        throw new UnauthorizedException;
    }
}
