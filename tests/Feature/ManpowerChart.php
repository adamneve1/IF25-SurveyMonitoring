<?php

namespace Tests\Feature\Filament\Widgets;

use Tests\TestCase;
use App\Filament\Widgets\ManpowerChart;
use App\Models\Manpower;
use App\Models\ManpowerIdlAbsensi;
use App\Models\Proyek;
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
        // 1. Persiapan Data
        $proyek = Proyek::factory()->create([
            'tanggal_mulai' => now()->startOfMonth(),
            'estimasi_selesai' => now()->endOfMonth(),
            'nama_proyek' => 'Proyek Konstruksi A'
        ]);

        // Data kehadiran manpower
        Manpower::factory()->create([
            'proyek_id' => $proyek->id,
            'tanggal' => now(),
            'hadir' => 1
        ]);

        // Data kehadiran IDL
        ManpowerIdlAbsensi::factory()->create([
            'proyek_id' => $proyek->id,
            'tanggal' => now(),
            'hadir' => 1
        ]);

        // 2. Eksekusi Test
        $component = Livewire::test(ManpowerChart::class, [
            'filters' => [
                'proyek_id' => $proyek->id,
                'view_mode' => 'daily',
                'year' => now()->year,
                'month' => now()->month,
            ]
        ]);

        // 3. Verifikasi Hasil
        $component->assertSuccessful()
            ->assertSee('Kehadiran Harian: Proyek Konstruksi A')
            ->assertSee('Rata-rata Kehadiran: 2 Orang/Hari');
    }

    /** @test */
    public function menampilkan_data_bulanan_dengan_benar()
    {
        // 1. Persiapan Data
        $tahun = now()->year;
        $proyek = Proyek::factory()->create([
            'tanggal_mulai' => Carbon::create($tahun, 1, 1),
            'estimasi_selesai' => Carbon::create($tahun, 12, 31),
        ]);

        // Data kehadiran bulan Januari
        Manpower::factory()->create([
            'proyek_id' => $proyek->id,
            'tanggal' => Carbon::create($tahun, 1, 15),
            'hadir' => 1
        ]);

        // Data kehadiran IDL bulan Februari
        ManpowerIdlAbsensi::factory()->create([
            'proyek_id' => $proyek->id,
            'tanggal' => Carbon::create($tahun, 2, 15),
            'hadir' => 1
        ]);

        // 2. Eksekusi Test
        $component = Livewire::test(ManpowerChart::class, [
            'filters' => [
                'proyek_id' => $proyek->id,
                'view_mode' => 'monthly',
                'year' => $tahun,
            ]
        ]);

        // 3. Verifikasi Hasil
        $component->assertSuccessful()
            ->assertSee('Total Kehadiran Bulanan: ' . $proyek->nama_proyek)
            ->assertSee('Total Kehadiran (Man-days) Tahun Ini: 2 Orang');
    }

    /** @test */
    public function menampilkan_data_tahunan_dengan_benar()
    {
        // 1. Persiapan Data
        $proyek = Proyek::factory()->create([
            'tanggal_mulai' => '2023-01-01',
            'estimasi_selesai' => '2025-12-31',
        ]);

        // Data kehadiran tahun 2023
        Manpower::factory()->create([
            'proyek_id' => $proyek->id,
            'tanggal' => '2023-06-15',
            'hadir' => 1
        ]);

        // Data kehadiran IDL tahun 2024
        ManpowerIdlAbsensi::factory()->create([
            'proyek_id' => $proyek->id,
            'tanggal' => '2024-06-15',
            'hadir' => 1
        ]);

        // 2. Eksekusi Test
        $component = Livewire::test(ManpowerChart::class, [
            'filters' => [
                'proyek_id' => $proyek->id,
                'view_mode' => 'yearly',
            ]
        ]);

        // 3. Verifikasi Hasil
        $component->assertSuccessful()
            ->assertSee('Rekap Tahunan Kehadiran: ' . $proyek->nama_proyek)
            ->assertSee('Total Kehadiran (Man-days) Selama Proyek: 2 Orang');
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

    /** @test */
    public function menampilkan_grafik_stack_bar_dengan_benar()
    {
        $proyek = Proyek::factory()->create();
        
        Manpower::factory()->create([
            'proyek_id' => $proyek->id,
            'hadir' => 1
        ]);

        $component = Livewire::test(ManpowerChart::class, [
            'filters' => [
                'proyek_id' => $proyek->id,
                'view_mode' => 'daily',
            ]
        ]);

        $chartData = $component->instance()->getData();
        
        $this->assertEquals('bar', $component->instance()->getType());
        $this->assertArrayHasKey('stack', $chartData['datasets'][0]);
    }
}