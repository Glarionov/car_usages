<?php

namespace App\Services;

use App\Models\Car;

class CarService extends AbstractResourceService
{
    public function __construct()
    {
        parent::__construct(new Car());
    }
}
