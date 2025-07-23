<?php

namespace Tests\Unit\Services;

use App\Models\Manpower_dl;
use App\Services\ManpowerDlService;
use Mockery;
use Tests\TestCase;

class ManpowerDlServiceTest extends TestCase
{
    public function test_membuat_data_dengan_insert_bulk_yang_benar()
    {
        // Persiapan
        $formState = [
            'proyek_id' => 1,
            'divisi_id' => 2,
            'manpower_idl_id' => 3,
            'nama_manpower_dls' => [
                ['nama' => 'Adam'],
                ['nama' => 'Budi'],
            ],
        ];

        // Mock static insert
        $mock = Mockery::mock('alias:' . Manpower_dl::class);
        $mock->shouldReceive('insert')
            ->once()
            ->with([
                ['proyek_id' => 1, 'divisi_id' => 2, 'manpower_idl_id' => 3, 'nama' => 'Adam'],
                ['proyek_id' => 1, 'divisi_id' => 2, 'manpower_idl_id' => 3, 'nama' => 'Budi'],
            ])
            ->andReturn(true); // agar bisa di-assert

        // Eksekusi
        $service = new ManpowerDlService();
        $result = $service->createBulk($formState);

        // Pemeriksaan
        $this->assertTrue($result); // supaya test tidak dianggap risky
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
