<?php

declare(strict_types=1);

namespace Tests\Unit\Services\InitialBalances;

use App\Services\InitialBalances\Data\InflowData;
use App\Services\InitialBalances\Exceptions\FileParsingException;
use App\Services\InitialBalances\InflowsXlsxParser;
use Tests\TestCase;
use Tests\Traits\TestStorage;

class InflowXlsxParserTest extends TestCase
{
    use TestStorage;

    protected InflowsXlsxParser $parser;

    public function setUp(): void
    {
        parent::setUp();
        $this->initTestDisk();
        $this->parser = app(InflowsXlsxParser::class);
    }

    public function testUploadEmptyFile()
    {
        $this->assertThrows(
            fn () => $this->parser->parse(''),
            FileParsingException::class
        );
    }

    public function testUploadInflows()
    {
        $file = $this->testDisk->get('InitialBalances/inflow.xlsx');
        $result = $this->parser->parse($file);

        $this->assertEquals(collect([
            InflowData::from([
                'date' => '25.04.2011 12:00',
                'sum' => 1000,
                'categoryName' => 'Зарплата',
                'partnerName' => 'Экспобанк',
            ]),
            InflowData::from([
                'date' => '25.04.2012',
                'sum' => 1000,
                'categoryName' => 'Зарплата',
                'partnerName' => 'Экспобанк',
            ]),
            InflowData::from([
                'date' => '25.04.2011',
                'sum' => 1000,
                'categoryName' => 'Кэшбэк',
                'partnerName' => 'Тинькофф',
            ])
        ]), $result);
    }
}
