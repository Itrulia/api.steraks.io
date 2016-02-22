<?php namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\User\Update;
use App\User;
use App\Http\Requests;
use JWTAuth;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Auth\RegisterRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterRequest $request)
    {
        $user = User::create($request->all());
        JWTAuth::attempt($request->only('email', 'password'));

        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\User\Update $request
     * @param \App\User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, User $user)
    {
        $this->authorize('update', $user);
        $user->update($request->all());

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);
        $user->delete();

        return response()->json([]);
    }

    /**
     * @param \App\User $user
     */
    public function getFollowing(User $user) {
        $this->authorize('getFollowing', $user);
    }
}
