<?php

namespace App\Http\Requests;

class CarUsageUpdateRequest extends AbstractUpdateOrCreateRequest
{
    protected array $updateRequestRules = [
        'usage_id' => ['integer', 'exists:car_usages,id'],
        'user_id' => ['integer', 'exists:users,id'],
        'car_id' => ['integer', 'exists:cars,id'],
        'start_using_at' => ['date', 'nullable'],
        'stop_using_at' => ['date', 'nullable'],
    ];
}
