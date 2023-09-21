<?php

declare(strict_types=1);

namespace Tests\Traits;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

trait TestStorage
{
    private Filesystem $testDisk;

    private function initTestDisk(): void
    {
        $this->testDisk = Storage::disk('tests');
    }
}
