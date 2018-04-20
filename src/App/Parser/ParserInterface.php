<?php

namespace App\Parser;

interface ParserInterface
{
    public function run(\DOMDocument $xmlObj);
}
