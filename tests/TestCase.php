<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        // Reset database: drop semua tabel lalu migrate ulang
        $this->artisan('migrate:fresh');

        // (Opsional) Jalankan seeder kalau perlu
        // $this->artisan('db:seed');
    }
}
