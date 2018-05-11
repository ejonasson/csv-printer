<?php

use PHPUnit\Framework\TestCase;
use ejonasson\CSVPrinter\CSVCell;
use ejonasson\CSVPrinter\CSVPrinter;

class CSVCellTest extends TestCase
{
    /** @test */
    public function csv_cell_flattens_array_content_to_json_string()
    {
        $sampleBody = [
            'foo' => 'bar',
            'baz' => 'biz',
            'lala' => [
                'thing',
                'another-thing'
            ]
        ];

        $cell = new CSVCell('SampleHeader', $sampleBody);

        $this->assertEquals(json_encode($sampleBody), $cell->toString());
    }
}
