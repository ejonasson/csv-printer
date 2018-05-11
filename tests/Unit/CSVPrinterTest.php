<?php

use PHPUnit\Framework\TestCase;
use ejonasson\CSVPrinter\CSVPrinter;

class CSVPrinterTest extends TestCase
{
    const SAMPLE_DATA = [
        [
            'firstName' => 'Erik',
            'lastName' => 'Jonasson',
            'emailAddress' => 'ejonasson@gmail.com'
        ],
        [
            'firstName' => 'Derek',
            'emailAddress' => 'derek@socialtriggers.com', // This is deliberately flipped to confirm normalization happens
            'lastName' => 'Halpern',
        ],
        [
            'firstName' => 'Foo',
            'lastName' => 'Bar',
            'emailAddress' => 'foobar@example.com'
        ]
    ];

    const NORMALIZED_DATA = [
        [
            'firstName',
            'lastName',
            'emailAddress'
        ],
        [
            'Erik',
            'Jonasson',
            'ejonasson@gmail.com'
        ],
        [
            'Derek',
            'Halpern',
            'derek@socialtriggers.com',
        ],
        [
            'Foo',
            'Bar',
            'foobar@example.com'
        ]
    ];

    /**
     * @test
     */
    public function can_output_CSV_as_array()
    {
        $array = CSVPrinter::fromArray(self::SAMPLE_DATA)->toArray();

        $this->assertTrue(is_array($array));
    }

    /**
     * @test
     */
    public function array_output_is_normalized()
    {
        $array = CSVPrinter::fromArray(self::SAMPLE_DATA)->toArray();

        $this->assertEquals(self::NORMALIZED_DATA, $array);
    }

    /**
     * @test
     */
    public function can_omit_header()
    {
        $printer = CSVPrinter::fromArray(self::SAMPLE_DATA);
        $this->assertContains('lastName', $printer->toArray()[0]);
        $this->assertContains('Jonasson', $printer->toArray()[1]);

        $printer->omitHeader('lastName');
        $this->assertNotContains('lastName', $printer->toArray()[0]);
        $this->assertNotContains('Jonasson', $printer->toArray()[1]);
    }

    /**
     * @test
     */
    public function can_create_file()
    {
        $file = CSVPrinter::fromArray(self::SAMPLE_DATA)->toFile('Test.csv');

        $this->assertFileExists($file);
        $this->assertStringNotEqualsFile($file, '');
    }
}
