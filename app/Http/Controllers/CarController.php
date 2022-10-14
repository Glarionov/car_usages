<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarUsageUpdateRequest;
use App\Models\Car;
use App\Models\CarsUsage;
use App\Services\CarService;
use App\Services\CarUsageService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class CarController extends Controller
{
    public function __construct()
    {
        $this->mainService = new CarService();
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
     * @param \App\Models\Car $car
     * @return Model
     */
    public function show(Car $car)
    {
        return $this->mainService->show($car);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\Models\Car $car
     * @return Car
     */
    public function update(Request $request, Car $car)
    {
        return $this->mainService->update($request, $car);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Car $car
     * @return Response
     */
    public function destroy(Car $car)
    {
        return $this->mainService->destroy($car);
    }
}
