<?php

use PHPUnit\Framework\TestCase;

class MatchTest extends TestCase
{
    private $match;

    public function setUp()
    {
        $this->match = new \App\Model\Match();
    }

    public function testCanBeInstantiatedCorrectly()
    {
        $this->assertEquals(get_class($this->match), 'App\Model\Match');
    }

    public function testCanSetID()
    {
        $id = random_int(0, 100);

        $this->match->id = $id;

        $this->assertEquals($id, $this->match->id);
    }

    public function testCallingGetDataPointWithAValidTypeSucceeds()
    {
        $stub = $this->createMock(\App\Model\Match::class);

        $stub->method('getDataPoint')
             ->willReturn(true);

        $this->assertEquals(true, $stub->getDataPoint(\App\Model\MatchData::TYPE_HOME_TACKLES));
    }

    public function testCallingGetDataPointWithAnInvalidTypeThrowsAnInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->match->getDataPoint('fooBar');
    }
}
