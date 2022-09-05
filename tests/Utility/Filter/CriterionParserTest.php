<?php

namespace NoLoCo\Core\Tests\Utility\Filter;

use NoLoCo\Core\Utility\Filter\CriterionStringParser;
use NoLoCo\Core\Utility\Filter\Exception\FilterParserException;
use NoLoCo\Core\Utility\Filter\PeriscopeNotationParser;
use PHPUnit\Framework\TestCase;

class CriterionParserTest extends TestCase
{
    protected CriterionStringParser $parser;

    protected function setUp(): void
    {
        $this->parser = new CriterionStringParser(new PeriscopeNotationParser());
    }

    public function testParse()
    {
        $criteria = $this->parser->parse('key((op))value');
        $this->assertEquals('key', $criteria->getKey());
        $this->assertEquals('op', $criteria->getOperator());
        $this->assertEquals('value', $criteria->getValue());
    }

    public function testParseEmptyKeyException()
    {
        $this->expectException(FilterParserException::class);
        $this->parser->parse(' ((op))value');
    }

    public function testParseEmptyOperatorException()
    {
        $this->expectException(FilterParserException::class);
        $this->parser->parse('key(())value');
    }
}