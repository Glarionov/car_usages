<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @param $uri
     * @param array $data
     * @param array $headers
     * @return \Illuminate\Testing\TestResponse
     */
    public function post($uri, array $data = [], array $headers = [])
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        return parent::post($uri, $data, $headers);
    }

    /**
     * @param $uri
     * @param array $headers
     * @return \Illuminate\Testing\TestResponse|void
     */
    public function get($uri, array $headers = [])
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        return parent::get($uri, $headers);
    }

    /**
     * @param $uri
     * @param array $data
     * @param array $headers
     * @return \Illuminate\Testing\TestResponse
     */
    public function put($uri, array $data = [], array $headers = [])
    {
        $_SERVER['REQUEST_METHOD'] = 'PUT';
        return parent::put($uri, $data, $headers);
    }

    /**
     * @param $uri
     * @param array $data
     * @param array $headers
     * @return \Illuminate\Testing\TestResponse
     */
    public function patch($uri, array $data = [], array $headers = [])
    {
        $_SERVER['REQUEST_METHOD'] = 'PATCH';
        return parent::patch($uri, $data, $headers);
    }

    /**
     * @param $uri
     * @param array $data
     * @param array $headers
     * @return \Illuminate\Testing\TestResponse
     */
    public function delete($uri, array $data = [], array $headers = [])
    {
        $_SERVER['REQUEST_METHOD'] = 'DELETE';
        return parent::delete($uri, $data, $headers);
    }
}
