<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Test;
use Tests\TestCase;

abstract class DefaultCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Indicates whether the default seeder should run before each test.
     *
     * @var bool
     */
    protected $seed = true;

    /**
     * @var string
     */
    protected string $modelName;

    /**
     * @var array
     */
    protected array $checkValues;

    /**
     * Checks get type requests
     *
     * @return void
     */
    public function getTest($checkLimit = 5)
    {
        for ($i = 1; $i < $checkLimit; $i++) {
            $response = $this->get("/api/{$this->modelName}s/$i");
            $response->assertStatus(200);

            if (!empty($this->checkValues) && !empty($this->checkValues[$i])) {
                $response->assertJson($this->checkValues[$i]);
            }
        }
    }

    /**
     * @return void
     */
    public function postTest($postData)
    {
        foreach ($postData as $postDatum) {
            $response = $this->post("/api/{$this->modelName}s", $postDatum);
            $response->assertStatus(201);

            $content = $response->decodeResponseJson();

            $id = $content['id'];

            $response = $this->get("/api/{$this->modelName}s/$id");
            $response->assertStatus(200);

            $response = $this->delete("/api/{$this->modelName}s/$id");
            $response->assertStatus(200);

            $response = $this->get("/api/{$this->modelName}s/$id");
            $response->assertStatus(404);
        }
    }

}
