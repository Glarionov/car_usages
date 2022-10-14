<?php

namespace Tests\Feature;

use App\Models\Car;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CarTest extends DefaultCrudTest
{
    protected string $modelName = 'car';

    protected array $checkValues = [
        1 => ['name' => 'car_1'],
        5 => ['name' => 'car_5'],
    ];

    /**
     * Test's main entry point
     *
     * @return void
     */
    public function test_start()
    {
        $this->getTest();
        $this->postTest([['name' => 'car_new']]);
    }
}
