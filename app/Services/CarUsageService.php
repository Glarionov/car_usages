<?php

namespace App\Services;

use App\Models\CarsUsage;
use Carbon\Carbon;
use http\Client\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;

class CarUsageService extends AbstractResourceService
{
    public function __construct()
    {
        parent::__construct(new CarsUsage());
    }

    /**
     * @param $searchParams
     * @param null $carUsageId
     * @return \Illuminate\Http\Response|Application|ResponseFactory|null
     */
    public static function checkUsageIntersections($searchParams, $carUsageId = null)
    {
        $baseQuery = CarsUsage::query();

        if (!empty($carUsageId)) {
            $baseQuery->where('id', '!=', $carUsageId);
        }

        $baseQuery->where(function($marginQuery) use ($searchParams) {
            $startUsingAt = $searchParams['start_using_at'] ?? Carbon::now();
            if (!empty($searchParams['stop_using_at'])) {
                $stopUsingAt = $searchParams['stop_using_at'];

                $marginQuery->where(function($query) use ($stopUsingAt, $startUsingAt) {
                    $query->where('start_using_at', '<', $stopUsingAt)
                        ->where('start_using_at', '>', $startUsingAt);
                })->orWhere(function($query) use ($stopUsingAt, $startUsingAt) {
                    $query->where('start_using_at', '<', $startUsingAt)
                        ->whereNull('stop_using_at')->orWhere('stop_using_at', '>', $startUsingAt);
                });
            } else {
                $marginQuery->whereNull('stop_using_at')->orWhere('stop_using_at', '>', $startUsingAt)
                    ->orWhere('start_using_at', '>', $startUsingAt);
            }
        });

        $errorMessages = [];

        foreach (['user', 'car'] as $param) {
            $paramIdString = "{$param}_id";

            $idValue = $searchParams[$paramIdString];
            $query = clone $baseQuery;
            $query = $query->where($paramIdString, $idValue);

            $alreadyTakenEntities = $query->get();
            if ($alreadyTakenEntities->count()) {
                $errorMessages[$param] = [];
                $errorMessages[$param]['message'] = "$param already taken";
                $errorMessages[$param]['data'] = $alreadyTakenEntities;
            }
        }

        if (!empty($errorMessages)) {
            $result['success'] = false;
            $result['errors'] = $errorMessages;
            return response($result, 400);;
        }

        return null;
    }

    /**
     * @param $requestData
     * @return CarsUsage
     */
    public function store($requestData = [])
    {
        $carUsage = new CarsUsage();
        $carUsage->car_id = $requestData['car_id'];
        $carUsage->user_id = $requestData['user_id'];

        if (!empty($requestData['start_using_at'])) {
            $carUsage->start_using_at = $requestData['start_using_at'];
        }
        if (!empty($requestData['stop_using_at'])) {
            $carUsage->stop_using_at = $requestData['stop_using_at'];
        }

        $carUsage->save();

        return $carUsage;
    }

    /**
     * Replace data of car usage in database with fresh data from request
     *
     * @param CarsUsage $carsUsage
     * @param array $requestData
     * @return CarsUsage
     */
    public static function mergeEditUsageRequestData(CarsUsage $carsUsage, array $requestData): CarsUsage
    {
        if (!empty($requestData['stop_using_now'])) {
            $requestData['stop_using_at'] = Carbon::now();
        }

        $updateParams = ['car_id', 'user_id', 'start_using_at', 'stop_using_at'];

        foreach ($updateParams as $param) {
            if (array_key_exists($param, $requestData)) {
                $carsUsage->{$param} = $requestData[$param];
            }
        }

        return $carsUsage;
    }
}
