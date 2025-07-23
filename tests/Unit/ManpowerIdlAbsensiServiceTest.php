<?php

namespace Tests\Unit\Services;

use App\Models\ManpowerIdlAbsensi;
use App\Services\ManpowerIdlAbsensiService;
use Carbon\Carbon;
use Mockery;
use Tests\TestCase;

class ManpowerIdlAbsensiServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_membuat_absensi_baru_jika_belum_ada()
    {
        // Persiapan data
        $formState = [
            'manpower_idl_id' => 123,
            'proyek_id' => 1,
            'divisi_id' => 2,
            'remarks' => 'Hadir',
        ];

        // Mock model statis
        $mock = Mockery::mock('alias:' . ManpowerIdlAbsensi::class);

        // Mock builder berlapis
        $mockQuery = Mockery::mock();
        $mockQuery2 = Mockery::mock();

        $mock->shouldReceive('where')
            ->with('manpower_idl_id', 123)
            ->andReturn($mockQuery);

        $mockQuery->shouldReceive('whereDate')
            ->with('tanggal', Mockery::on(function ($value) {
                return $value instanceof Carbon && $value->isToday();
            }))
            ->andReturn($mockQuery2);

        $mockQuery2->shouldReceive('exists')->andReturn(false);

        $mock->shouldReceive('create')
            ->once()
            ->with(Mockery::on(function ($data) {
                return $data['manpower_idl_id'] === 123 &&
                       $data['proyek_id'] === 1 &&
                       $data['remark'] === 'Hadir' &&
                       $data['hadir'] === 1 &&
                       Carbon::parse($data['tanggal'])->isToday();
            }))
            ->andReturnTrue();

        // Jalankan
        $service = new ManpowerIdlAbsensiService();
        $service->create($formState);

        // Dummy assertion agar test tidak dianggap "risky"
        $this->assertTrue(true);
    }

    public function test_membuat_absensi_yang_sudah_ada_melempar_exception()
    {
        // Persiapan data
        $formState = [
            'manpower_idl_id' => 123,
            'proyek_id' => 1,
            'divisi_id' => 2,
            'remarks' => 'Hadir',
        ];

        // Mock
        $mock = Mockery::mock('alias:' . ManpowerIdlAbsensi::class);
        $mockQuery = Mockery::mock();
        $mockQuery2 = Mockery::mock();

        $mock->shouldReceive('where')
            ->with('manpower_idl_id', 123)
            ->andReturn($mockQuery);

        $mockQuery->shouldReceive('whereDate')
            ->with('tanggal', Mockery::on(function ($value) {
                return $value instanceof Carbon && $value->isToday();
            }))
            ->andReturn($mockQuery2);

        $mockQuery2->shouldReceive('exists')->andReturn(true);

        // Harapkan exception
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Manpower ini sudah tercatat absen hari ini.');

        // Jalankan
        $service = new ManpowerIdlAbsensiService();
        $service->create($formState);
    }
}
