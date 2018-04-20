<?php

use PHPUnit\Framework\TestCase;

class RequestBodyValidatorTest extends TestCase
{
    public function testCanBeInstantiated()
    {
        $middleware = new \App\Middleware\RequestBodyValidator();

        $this->assertEquals(get_class($middleware), 'App\Middleware\RequestBodyValidator');
    }

    public function testCantBeInvokedWithoutRequestOrResponse()
    {
        $middleware = new \App\Middleware\RequestBodyValidator();

        $this->expectException(TypeError::class);

        $middleware->__invoke();
    }
}
