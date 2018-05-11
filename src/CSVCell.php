<?php

namespace ejonasson\CSVPrinter;

class CSVCell
{
    public $header;
    public $content;

    public function __construct($header, $content)
    {
        $this->header = $header;
        $this->content = $this->normalizeContent($content);
    }

    protected function normalizeContent($content)
    {
        return is_array($content) ? json_encode($content) : $content;
    }

    public function __toString()
    {
        return $this->content;
    }

    public function toString()
    {
        return $this->content;
    }
}
