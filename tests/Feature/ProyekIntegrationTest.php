<?php

namespace Tests\Feature;

use App\Models\Proyek;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProyekIntegrationTest extends TestCase
{
    use RefreshDatabase;
    /** @test */

 public function user_bisa_membuat_data_proyek()
{
    $proyek = Proyek::create([
        'nama_proyek' => 'Proyek A',
    
        'alamat_proyek' => 'Jl. Industri No. 1, Batam',
        'tanggal_mulai' => now()->toDateString(),
        'tanggal_selesai' => now()->addDays(30)->toDateString(),
        'estimasi_selesai' => now()->addDays(25)->toDateString(),
        'jumlah_manpower' => 20,
    ]);

    $this->assertDatabaseHas('proyeks', [
        'nama_proyek' => 'Proyek A',
 
        'alamat_proyek' => 'Jl. Industri No. 1, Batam',
    ]);
}

    /** @test */
    public function user_bisa_melihat_daftar_proyek()
    {
        $proyek = Proyek::factory()->create([
            'nama_proyek' => 'Proyek B'
        ]);

        $proyeks = Proyek::all();
        $this->assertTrue($proyeks->contains('nama_proyek', 'Proyek B'));
    }

    /** @test */
    public function user_bisa_update_data_proyek()
    {
        $proyek = Proyek::factory()->create([
            'nama_proyek' => 'Proyek Lama'
        ]);

        $proyek->update([
            'nama_proyek' => 'Proyek Baru'
        ]);

        $this->assertDatabaseHas('proyeks', [
            'nama_proyek' => 'Proyek Baru'
        ]);
    }

    /** @test */
    public function user_bisa_menghapus_data_proyek()
    {
        $proyek = Proyek::factory()->create();

        $proyek->delete();

        $this->assertDatabaseMissing('proyeks', [
            'id' => $proyek->id
        ]);
    }
}
