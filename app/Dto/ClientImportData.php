<?php

namespace App\Dto;

class ClientImportData
{
    public function __construct(
        public string $filePath,
        public string $extension
    ) {
    }
}
