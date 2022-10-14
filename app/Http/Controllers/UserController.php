<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct()
    {
        $this->mainService = new UserService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return LengthAwarePaginator|ResourceCollection
     */
    public function index()
    {
        return $this->mainService->list();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Model
     */
    public function store(Request $request)
    {
        return $this->mainService->store($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return Model
     */
    public function show(User $user)
    {
        return $this->mainService->show($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\Models\User $user
     * @return User
     */
    public function update(Request $request, User $user)
    {
        return $this->mainService->update($request, $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User $user
     * @return Response
     */
    public function destroy(User $user)
    {
        return $this->mainService->destroy($user);
    }
}
