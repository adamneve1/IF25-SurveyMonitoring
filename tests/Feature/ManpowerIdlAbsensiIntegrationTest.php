<?php

namespace Tests\Feature;

use Tests\TestCase;
//use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Proyek;
use App\Models\Manpower_idl;
use App\Models\ManpowerIdlAbsensi;

class ManpowerIdlAbsensiIntegrationTest extends TestCase
{
    //use RefreshDatabase;

    public function test_user_bisa_membuat_absensi_manpower_idl()
    {
        $proyek = Proyek::factory()->create();
        $manpower = Manpower_idl::factory()->create(['proyek_id' => $proyek->id]);

        $absensi = ManpowerIdlAbsensi::create([
            'proyek_id' => $proyek->id,
            'manpower_idl_id' => $manpower->id,
            'tanggal' => now()->toDateString(),
            'hadir' => true,
            'remark' => 'Hadir tepat waktu',
        ]);

        $this->assertDatabaseHas('manpower_idl_absensi', [
            'manpower_idl_id' => $manpower->id,
            'proyek_id' => $proyek->id,
            'hadir' => true,
            'remark' => 'Hadir tepat waktu',
        ]);
    }

   public function test_user_bisa_melihat_absensi_manpower_idl()
{
    $proyek = Proyek::factory()->create();
    $manpower = Manpower_idl::factory()->create(['proyek_id' => $proyek->id]);

    $absensi = ManpowerIdlAbsensi::factory()->create([
        'proyek_id' => $proyek->id,
        'manpower_idl_id' => $manpower->id,
    ]);

    $this->assertModelExists($absensi);
}

   public function test_user_bisa_update_absensi_manpower_idl()
{
    $proyek = Proyek::factory()->create();
    $manpower = Manpower_idl::factory()->create(['proyek_id' => $proyek->id]);
    $absensi = ManpowerIdlAbsensi::factory()->create([
        'proyek_id' => $proyek->id,
        'manpower_idl_id' => $manpower->id,
    ]);

    $absensi->update([
        'hadir' => false,
        'remark' => 'Sakit',
    ]);

    $this->assertDatabaseHas('manpower_idl_absensi', [
        'id' => $absensi->id,
        'hadir' => false,
        'remark' => 'Sakit',
    ]);
}

public function test_user_bisa_menghapus_absensi_manpower_idl()
{
    $proyek = Proyek::factory()->create();
    $manpower = Manpower_idl::factory()->create(['proyek_id' => $proyek->id]);
    $absensi = ManpowerIdlAbsensi::factory()->create([
        'proyek_id' => $proyek->id,
        'manpower_idl_id' => $manpower->id,
    ]);

    $absensi->delete();

    $this->assertDatabaseMissing('manpower_idl_absensi', [
        'id' => $absensi->id,
    ]);
}
}