<?php

use PHPUnit\Framework\TestCase;

class SubmitValidatorTest extends TestCase
{
    public function testCanBeInstantiated()
    {
        $middleware = new \App\Middleware\SubmitValidator();

        $this->assertEquals(get_class($middleware), 'App\Middleware\SubmitValidator');
    }

    public function testCantBeInvokedWithoutRequestOrResponse()
    {
        $middleware = new \App\Middleware\SubmitValidator();

        $this->expectException(TypeError::class);

        $middleware->__invoke();
    }
}
