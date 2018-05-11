<?php

namespace ejonasson\CSVPrinter;

use ejonasson\CSVPrinter\CSVRow;

class CSVPrinter
{
    protected $rows;
    protected $headers;

    public static function fromArray(array $data)
    {
        return new self($data);
    }

    public function __construct(array $data)
    {
        $this->rows = $this->normalizeRows($data);
        $this->headers = $this->extractHeaders($data);
    }

    protected function extractHeaders(array $data)
    {
        $headers = [];

        foreach ($data as $row) {
            foreach ($row as $header => $column) {
                if (!in_array($header, $headers)) {
                    $headers[] = $header;
                }
            }
        }

        return $headers;
    }

    protected function normalizeRows(array $rows)
    {
        foreach ($rows as $key => $row) {
            $rows[$key] = new CSVRow($row);
        }

        return array_values($rows);
    }

    public function toFile($fileName)
    {
        return $this->putCSVInLocation("/tmp/{$fileName}");
    }

    public function toMemory()
    {
        return $this->putCSVInLocation("php://memory");
    }

    public function print()
    {
        $file = $this->toMemory();
        readfile($file);
    }

    public function download($fileName)
    {
        $file = $this->toMemory($fileName);

        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        }
    }

    public function toArray()
    {
        $output = [];

        $output[] = $this->headers;

        foreach ($this->rows as $row) {
            $output[] = $row->forHeaders($this->headers);
        }

        return $output;
    }

    public function omitHeader(string $header)
    {
        $key = array_search($header, $this->headers);
        array_splice($this->headers, $key, 1);

        return $this;
    }

    public function setHeaders(array $headers)
    {
        $this->headers = $headers;

        return $this;
    }


    protected function putCSVInLocation($location)
    {
        $file = fopen($location, 'w+');

        foreach ($this->toArray() as $dataRow) {
            fputcsv($file, $dataRow);
        }

        fclose($file);

        return $location;
    }
}
