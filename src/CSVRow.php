<?php

namespace ejonasson\CSVPrinter;

use ejonasson\CSVPrinter\CSVCell;

class CSVRow
{
    protected $cells;

    public function __construct(array $data)
    {
        $this->cells = $this->normalizeRow($data);
    }

    protected function normalizeRow($row)
    {
        foreach ($row as $header => $cell) {
            $row[$header] = new CSVCell($header, $cell);
        }

        return $row;
    }

    public function forHeaders(array $headers)
    {
        $output = [];

        foreach ($headers as $header) {
            $output[] = $this->getCellForHeader($header)->toString();
        }

        return $output;
    }

    public function getCellForHeader(string $header, string $default = '')
    {
        foreach ($this->cells as $cell) {
            if ($cell->header === $header) {
                return $cell;
            }
        }

        return new CSVCell($header, $default);
    }
}
