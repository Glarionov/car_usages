<?php

namespace App\Http\Requests;

class CarUsageRequest extends AbstractUpdateOrCreateRequest
{
    protected array $updateRequestRules = [
        'user_id' => ['integer', 'exists:users,id'],
        'car_id' => ['integer', 'exists:cars,id'],
        'start_using_at' => ['date', 'nullable'],
        'stop_using_at' => ['date', 'nullable'],
    ];
}
