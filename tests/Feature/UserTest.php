<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends DefaultCrudTest
{
    protected string $modelName = 'user';

    /**
     * Test's main entry point
     *
     * @return void
     */
    public function test_start()
    {
        $this->getTest();
        $this->postTest([['name' => 'user_new']]);
    }
}
