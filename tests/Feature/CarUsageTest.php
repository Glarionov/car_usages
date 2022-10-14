<?php

namespace Tests\Feature;

use App\Models\CarsUsage;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CarUsageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test's main entry point
     *
     * @return void
     */
    public function test_start()
    {

        $this->seed();

        $idsToDelete = [];
        $postData = [
            'car_id' => 2,
            'user_id' => 2,
            'start_using_at' => Carbon::now(),
        ];

        $response = $this->post("/api/cars-usages", $postData);

        $response->assertStatus(201)->assertJson([
            'success' => true
        ]);

        $firstUsageData = $response->decodeResponseJson();
        $idsToDelete[] = $firstUsageData['id'];

        /**
         * Trying to get error of interserction
         */
        $response = $this->post("/api/cars-usages", $postData);

        $response->assertStatus(400)->assertJson([
            'success' => false
        ]);

        /**
         * Changing car won't change response much, as user will be taken anyway
         */
        $postData['car_id'] = 3;
        $response = $this->post("/api/cars-usages", $postData);

        $response->assertStatus(400)->assertJson([
            'success' => false
        ]);

        /**
         * Sames goes with user id
         */
        $postData['car_id'] = 2;
        $postData['user_id'] = 3;
        $response = $this->post("/api/cars-usages", $postData);

        $response->assertStatus(400)->assertJson([
            'success' => false
        ]);

        /**
         * Testing if inserting data would work if using date will be changed to pastime
         */
        $postData['user_id'] = 2;
        $postData['start_using_at'] = '2000-01-01';
        $postData['stop_using_at'] = '2001-01-01';

        $response = $this->withHeaders(['Accept' => 'application/json'])->post("/api/cars-usages", $postData);

        $response->assertStatus(201)->assertJson([
            'success' => true
        ]);

        $content = $response->decodeResponseJson();
        $idsToDelete[] = $content['id'];

        /**
         * Sames goes with user id
         */
        $postData = ['stop_using_now' => true];
        $response = $this->patch("/api/cars-usages/" . $firstUsageData['id'], $postData);
        $response->assertStatus(200);

        $content = $response->decodeResponseJson();
        $stopUsageAt = $content['stop_using_at'];

        $this->assertNotNull($stopUsageAt);

        foreach ($idsToDelete as $id) {
            $url = "/api/cars-usages/$id";
            $response = $this->delete("/api/cars-usages/$id");
            $response->assertStatus(200);
        }
    }
}
