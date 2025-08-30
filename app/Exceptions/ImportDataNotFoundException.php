<?php

namespace App\Exceptions;

use Exception;

class ImportDataNotFoundException extends Exception
{
    protected array $missingData = [];

    public function __construct(string $message = "Data tidak ditemukan", array $missingData = [], int $code = 0, ?Exception $previous = null)
    {
        $this->missingData = $missingData;
        parent::__construct($message, $code, $previous);
    }

    public function getMissingData(): array
    {
        return $this->missingData;
    }

    public function setMissingData(array $data): void
    {
        $this->missingData = $data;
    }
}
