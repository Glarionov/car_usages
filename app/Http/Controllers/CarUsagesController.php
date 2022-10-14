<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarUsageUpdateRequest;
use App\Models\Car;
use App\Models\CarsUsage;
use App\Services\CarUsageService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class CarUsagesController extends Controller
{
    public function __construct()
    {
        $this->mainService = new CarUsageService();
    }

    /**
     * @param CarUsageUpdateRequest $request
     * @return Application|Response|ResponseFactory
     */
    public function store(CarUsageUpdateRequest $request)
    {
        $intersectionsError = CarUsageService::checkUsageIntersections($request->all());
        if (!empty($intersectionsError)) {
            return $intersectionsError;
        }

        $carUsage = $this->mainService->store($request->all());

        return response(['success' => true, 'id' => $carUsage->id], 201);
    }

    /**
     * @param CarsUsage $carUsage
     * @param CarUsageUpdateRequest $request
     * @return CarsUsage
     */
    public function update(CarUsageUpdateRequest $request, CarsUsage $carsUsage)
    {
        $carUsage = CarUsageService::mergeEditUsageRequestData($carsUsage, $request->all());

        $intersectionsError = CarUsageService::checkUsageIntersections($carUsage, $carsUsage->id);
        if (!empty($intersectionsError)) {
            return $intersectionsError;
        }

        $carUsage->save();

        return $carUsage;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CarsUsage $carUsage
     * @return Model
     */
    public function show(CarsUsage $carsUsage)
    {
        return $this->mainService->show($carsUsage);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CarsUsage $carUsage
     * @return Response
     */
    public function destroy(CarsUsage $carsUsage)
    {
        return $this->mainService->destroy($carsUsage);
    }
}
