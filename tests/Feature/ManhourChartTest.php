<?php

namespace Tests\Feature\Filament\Widgets;

use Tests\TestCase;
use App\Filament\Widgets\ManhourChart;
use App\Models\Manhour;
use App\Models\Proyek;
use App\Models\ProyekPlan;
use App\Models\Divisi;
use App\Models\Manpower;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

class ManhourChartTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Membuat user dan login sebelum setiap test
        $this->user = \App\Models\User::factory()->create();
        $this->actingAs($this->user);
    }

    /** 
     * @test
     * Test untuk memverifikasi widget menampilkan pesan ketika proyek belum dipilih 
     */
    public function menampilkan_pesan_ketika_proyek_belum_dipilih()
    {
        Livewire::test(ManhourChart::class)
            ->assertSuccessful()
            ->assertSee('Pilih Proyek pada filter di atas.');
    }

    /** 
     * @test
     * Test untuk memverifikasi tampilan data harian 
     */
    public function menampilkan_data_harian_dengan_benar()
    {
        // Membuat data proyek
        $proyek = Proyek::factory()->create([
            'tanggal_mulai' => now()->startOfMonth(),
            'estimasi_selesai' => now()->endOfMonth(),
        ]);

        // Membuat plan proyek untuk bulan ini
        ProyekPlan::factory()->create([
            'proyek_id' => $proyek->id,
            'tahun' => now()->year,
            'bulan' => now()->month,
            'jumlah_plan' => 100,
        ]);

        // Membuat data manhour
        Manhour::factory()->create([
            'proyek_id' => $proyek->id,
            'tanggal' => now(),
            'overtime' => 10,
        ]);

        // Test komponen dengan filter harian
        $component = Livewire::test(ManhourChart::class, [
            'filters' => [
                'proyek_id' => $proyek->id,
                'view_mode' => 'daily',
                'year' => now()->year,
                'month' => now()->month,
            ]
        ]);

        // Verifikasi hasil
        $component->assertSuccessful()
            ->assertSee('Progres Harian: ' . $proyek->nama_proyek);
    }

    /** 
     * @test
     * Test untuk memverifikasi tampilan data bulanan 
     */
    public function menampilkan_data_bulanan_dengan_benar()
    {
        // Membuat data proyek untuk satu tahun
        $proyek = Proyek::factory()->create([
            'tanggal_mulai' => now()->startOfYear(),
            'estimasi_selesai' => now()->endOfYear(),
        ]);

        // Membuat plan proyek untuk bulan Januari
        ProyekPlan::factory()->create([
            'proyek_id' => $proyek->id,
            'tahun' => now()->year,
            'bulan' => 1, // Januari
            'jumlah_plan' => 500,
        ]);

        // Membuat data manhour untuk Februari
        Manhour::factory()->create([
            'proyek_id' => $proyek->id,
            'tanggal' => now()->startOfYear()->addMonth(), // Februari
            'overtime' => 250,
        ]);

        // Test komponen dengan filter bulanan
        $component = Livewire::test(ManhourChart::class, [
            'filters' => [
                'proyek_id' => $proyek->id,
                'view_mode' => 'monthly',
                'year' => now()->year,
            ]
        ]);

        // Verifikasi hasil
        $component->assertSuccessful()
            ->assertSee('Rekap Bulanan: ' . $proyek->nama_proyek);
    }

    /** 
     * @test
     * Test untuk memverifikasi tampilan data tahunan 
     */
    public function menampilkan_data_tahunan_dengan_benar()
    {
        // Membuat data proyek untuk 3 tahun (2023-2025)
        $proyek = Proyek::factory()->create([
            'tanggal_mulai' => '2023-01-01',
            'estimasi_selesai' => '2025-12-31',
        ]);

        // Membuat plan proyek untuk tahun 2023
        ProyekPlan::factory()->create([
            'proyek_id' => $proyek->id,
            'tahun' => 2023,
            'jumlah_plan' => 1000,
        ]);

        // Membuat data manhour untuk pertengahan 2023
        Manhour::factory()->create([
            'proyek_id' => $proyek->id,
            'tanggal' => '2023-06-15',
            'overtime' => 500,
        ]);

        // Test komponen dengan filter tahunan
        $component = Livewire::test(ManhourChart::class, [
            'filters' => [
                'proyek_id' => $proyek->id,
                'view_mode' => 'yearly',
            ]
        ]);

        // Verifikasi hasil
        $component->assertSuccessful()
            ->assertSee('Rekap Tahunan Manhour: ' . $proyek->nama_proyek);
    }

   
    /** 
     * @test
     * Test untuk memverifikasi pesan status budget muncul dengan benar 
     */
    public function menampilkan_pesan_status_budget_dengan_benar()
    {
        // Membuat data proyek
        $proyek = Proyek::factory()->create();
        
        // Kasus 1: Over budget
        ProyekPlan::factory()->create([
            'proyek_id' => $proyek->id,
            'tahun' => now()->year,
            'bulan' => now()->month,
            'jumlah_plan' => 100,
        ]);

        Manhour::factory()->create([
            'proyek_id' => $proyek->id,
            'overtime' => 120, // 20 jam over budget
        ]);

        $component = Livewire::test(ManhourChart::class, [
            'filters' => [
                'proyek_id' => $proyek->id,
                'view_mode' => 'daily',
                'year' => now()->year,
                'month' => now()->month,
            ]
        ]);

        $component->assertSee('❌ Status: Over Budget 20 Jam');

        // Kasus 2: Under budget
        Manhour::where('proyek_id', $proyek->id)->delete();
        Manhour::factory()->create([
            'proyek_id' => $proyek->id,
            'overtime' => 80, // 20 jam under budget
        ]);

        $component = Livewire::test(ManhourChart::class, [
            'filters' => [
                'proyek_id' => $proyek->id,
                'view_mode' => 'daily',
                'year' => now()->year,
                'month' => now()->month,
            ]
        ]);

        $component->assertSee('✅ Status: Sesuai Target (Hemat 20 Jam)');
    }
}