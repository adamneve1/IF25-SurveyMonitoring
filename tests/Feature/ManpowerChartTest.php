<?php

namespace Tests\Feature\Filament\Widgets;

use Tests\TestCase;
use App\Filament\Widgets\ManpowerChart;
use App\Models\Manpower;
use App\Models\ManpowerIdlAbsensi;
use App\Models\Proyek;
use App\Models\Manpower_dl;
use App\Models\Manpower_idl;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

class ManpowerChartTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = \App\Models\User::factory()->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function menampilkan_pesan_ketika_proyek_belum_dipilih()
    {
        Livewire::test(ManpowerChart::class)
            ->assertSuccessful()
            ->assertSee('Pilih Proyek pada filter di atas.');
    }

    /** @test */
    public function menampilkan_data_harian_dengan_benar()
    {
        $proyek = Proyek::factory()->create(['nama_proyek' => 'Proyek Test']);
        $idl = Manpower_idl::factory()->create();
        $dl = Manpower_dl::factory()->create();

        // Data kehadiran
        Manpower::create([
            'proyek_id' => $proyek->id,
            'manpower_idl_id' => $idl->id,
            'manpower_dl_id' => $dl->id,
            'pic' => 'John Doe',
            'tanggal' => now(),
            'remark' => 'Test remark'
        ]);

        // Data kehadiran IDL
        ManpowerIdlAbsensi::create([
            'proyek_id' => $proyek->id,
            'manpower_idl_id' => $idl->id,
            'tanggal' => now(),
            'hadir' => 1
        ]);

        $component = Livewire::test(ManpowerChart::class, [
            'filters' => [
                'proyek_id' => $proyek->id,
                'view_mode' => 'daily',
                'year' => now()->year,
                'month' => now()->month,
            ]
        ]);

        $component->assertSuccessful()
            ->assertSee('Kehadiran Harian: Proyek Test');
    }

    /** @test */
    public function menampilkan_data_bulanan_dengan_benar()
    {
        $proyek = Proyek::factory()->create();
        $idl = Manpower_idl::factory()->create();
        $dl = Manpower_dl::factory()->create();

        Manpower::create([
            'proyek_id' => $proyek->id,
            'manpower_idl_id' => $idl->id,
            'manpower_dl_id' => $dl->id,
            'pic' => 'Jane Doe',
            'tanggal' => now()->startOfMonth(),
            'remark' => 'Test remark'
        ]);

        $component = Livewire::test(ManpowerChart::class, [
            'filters' => [
                'proyek_id' => $proyek->id,
                'view_mode' => 'monthly',
                'year' => now()->year,
            ]
        ]);

        $component->assertSuccessful()
            ->assertSee('Total Kehadiran Bulanan:');
    }

    /** @test */
    public function menampilkan_data_tahunan_dengan_benar()
    {
        $proyek = Proyek::factory()->create([
            'tanggal_mulai' => '2023-01-01',
            'estimasi_selesai' => '2025-12-31'
        ]);
        
        $idl = Manpower_idl::factory()->create();
        $dl = Manpower_dl::factory()->create();

        Manpower::create([
            'proyek_id' => $proyek->id,
            'manpower_idl_id' => $idl->id,
            'manpower_dl_id' => $dl->id,
            'pic' => 'Mike Smith',
            'tanggal' => '2023-06-15',
            'remark' => 'Test remark'
        ]);

        $component = Livewire::test(ManpowerChart::class, [
            'filters' => [
                'proyek_id' => $proyek->id,
                'view_mode' => 'yearly',
            ]
        ]);

        $component->assertSuccessful()
            ->assertSee('Rekap Tahunan Kehadiran:');
    }

    /** @test */
    public function menangani_kasus_tanpa_data_kehadiran()
    {
        $proyek = Proyek::factory()->create();

        $component = Livewire::test(ManpowerChart::class, [
            'filters' => [
                'proyek_id' => $proyek->id,
                'view_mode' => 'daily',
            ]
        ]);

        $component->assertSuccessful()
            ->assertSee('Rata-rata Kehadiran: 0 Orang/Hari');
    }
}