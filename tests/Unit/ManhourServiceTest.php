<?php

namespace Tests\Unit;

use App\Services\ManhourService;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;

class ManhourServiceTest extends TestCase
{
    public function test_menghitung_selisih_jam_lembur_dengan_benar()
    {
        $checkIn = '08:00';
        $checkOut = '12:00';

        $overtime = ManhourService::calculateOvertime($checkIn, $checkOut);

        $this->assertEquals(4, $overtime);
    }

    public function test_membangun_data_jam_kerja_dengan_benar()
    {
        // Simulasi user login
        Auth::shouldReceive('user')->andReturn((object)['name' => 'Adam']);

        $form = [
            'proyek_id' => 1,
            'manpower_idl_id' => 2,
            'jam_absen' => 'pagi',
            'remarks' => 'Unit test testing',
        ];

        $row = [
            'manpower_dl_id' => 3,
            'check_in' => '09:00',
            'check_out' => '11:00',
        ];

        $result = ManhourService::buildManhourData($form, $row);

        $this->assertEquals(1, $result['proyek_id']);
        $this->assertEquals(2, $result['manpower_idl_id']);
        $this->assertEquals(3, $result['manpower_dl_id']);
        $this->assertEquals('pagi', $result['jam_absen']);
        $this->assertEquals(2, $result['overtime']);
        $this->assertEquals('Adam', $result['pic']);
        $this->assertEquals('Unit test testing', $result['remark']);
        $this->assertEquals(now()->toDateString(), $result['tanggal']);
    }
}
