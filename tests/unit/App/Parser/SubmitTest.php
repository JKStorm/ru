<?php

use PHPUnit\Framework\TestCase;

class SubmitTest extends TestCase
{
    private $xmlObj;

    public function setUp()
    {
        $xmlMatchData = file_get_contents(__DIR__ . '/../../../data/fake_xml_match_data.xml');

        $this->xmlObj = new \DOMDocument();
        $this->xmlObj->loadXML($xmlMatchData);
    }

    public function testCanBeInstantiated()
    {
        $processor = new \App\Parser\Submit();

        $this->assertEquals(get_class($processor), 'App\Parser\Submit');
    }

    public function testCantBeRunWithMissingParameter()
    {
        $processor = new \App\Parser\Submit();

        $this->expectException(TypeError::class);

        $processor->run();
    }

    public function testCanBeRunWithValidParameter()
    {
        $processor = new \App\Parser\Submit();

        $this->assertNotEmpty($processor->run($this->xmlObj));
    }

    public function testCanBeRunWithValidParameterAndReturnsValidResult()
    {
        $processor = new \App\Parser\Submit();

        $result = json_encode($processor->run($this->xmlObj));

        $validResult = file_get_contents(__DIR__ . '/../../../data/submit_processor_valid.json');

        $this->assertEquals($validResult, $result);
    }
}
