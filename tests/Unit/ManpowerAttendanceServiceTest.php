<?php

namespace Tests\Unit\Services;

use App\Models\Manpower;
use App\Models\ManpowerIdlAbsensi;
use App\Services\ManpowerAttendanceService;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Tests\TestCase;

class ManpowerAttendanceServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        // Bersihkan Mockery setelah setiap test
        Mockery::close();
        parent::tearDown();
    }

    public function test_menyimpan_data_absensi_dengan_benar()
    {
        $formState = [
            'proyek_id' => 1,
            'manpower_idl_id' => 10,
            'remarks' => 'Tes Remarks',
            'manpowern' => [
                ['manpower_dl_id' => 101, 'is_present' => true],
                ['manpower_dl_id' => 102, 'is_present' => false],
            ],
        ];

        // Simulasi user login
        $mockUser = (object)['name' => 'Tester'];
        Auth::shouldReceive('user')->andReturn($mockUser);

        // Mock model Manpower
        $manpowerMock = Mockery::mock('alias:' . Manpower::class);
        $manpowerMock->shouldReceive('insert')
            ->once()
            ->with(Mockery::on(function ($insert) {
                return count($insert) === 2 &&
                    $insert[0]['manpower_dl_id'] === 101 &&
                    $insert[0]['hadir'] === 1 &&
                    $insert[1]['manpower_dl_id'] === 102 &&
                    $insert[1]['hadir'] === 0;
            }));

        // Mock model ManpowerIdlAbsensi
        $idlMock = Mockery::mock('alias:' . ManpowerIdlAbsensi::class);
        $idlMock->shouldReceive('create')
            ->once()
            ->with(Mockery::on(function ($data) {
                return $data['manpower_idl_id'] === 10 &&
                    $data['hadir'] === 1 &&
                    $data['remark'] === 'Tes Remarks';
            }));

        // Jalankan service
        $service = new ManpowerAttendanceService();
        $service->saveAttendance($formState);

        // Tambahkan assertion dummy agar test tidak dianggap risky
        $this->assertTrue(true);
    }
}
