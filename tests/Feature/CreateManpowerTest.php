<?php

namespace Tests\Feature\Filament\Resources\ManpowerResource\Pages;

use Tests\TestCase;
use App\Models\Proyek;
use App\Models\Manpower_idl;
use App\Models\Manpower_dl;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Models\Manpower; 

class CreateManpowerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create(['email' => 'test@lks.com']);
        $this->actingAs($this->user);
    }

    /** @test */
    public function dapat_mengakses_halaman_create()
    {
        Livewire::test(\App\Filament\Resources\ManpowerResource\Pages\CreateManpower::class)
            ->assertSuccessful()
            ->assertSee('Buat Manpower');
    }

    /** @test */
    public function menampilkan_pesan_jika_proyek_dan_idl_belum_dipilih()
    {
        Livewire::test(\App\Filament\Resources\ManpowerResource\Pages\CreateManpower::class)
            ->assertSee('⚠️ Please Select Proyek and Manpower IDL First');
    }

    /** @test */
    public function menampilkan_daftar_manpower_dl_setelah_memilih_proyek_dan_idl()
    {
        $proyek = Proyek::factory()->create();
        $idl = Manpower_idl::factory()->create(['proyek_id' => $proyek->id]);
        $dl = Manpower_dl::factory()->create([
            'proyek_id' => $proyek->id,
            'manpower_idl_id' => $idl->id,
            'nama' => 'Test DL'
        ]);

        Livewire::test(\App\Filament\Resources\ManpowerResource\Pages\CreateManpower::class)
            ->set('data.proyek_id', $proyek->id)
            ->set('data.manpower_idl_id', $idl->id)
            ->assertSee('Test DL');
    }

    /** @test */
    public function dapat_menyimpan_data_kehadiran()
    {
        $proyek = Proyek::factory()->create();
        $idl = Manpower_idl::factory()->create(['proyek_id' => $proyek->id]);
        $dl = Manpower_dl::factory()->create([
            'proyek_id' => $proyek->id,
            'manpower_idl_id' => $idl->id
        ]);

        Livewire::test(\App\Filament\Resources\ManpowerResource\Pages\CreateManpower::class)
            ->set('data.proyek_id', $proyek->id)
            ->set('data.manpower_idl_id', $idl->id)
            ->set('data.remarks', 'Test remark')
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect('/admin/manpowers');

        $this->assertDatabaseHas('manpowers', [
            'proyek_id' => $proyek->id,
            'manpower_idl_id' => $idl->id,
            'remark' => 'Test remark'
        ]);
    }

    /** @test */
    public function validasi_form_create_manpower()
    {
        Livewire::test(\App\Filament\Resources\ManpowerResource\Pages\CreateManpower::class)
            ->call('save')
            ->assertHasErrors([
                'data.proyek_id' => 'required',
                'data.manpower_idl_id' => 'required',
                'data.remarks' => 'required'
            ]);
    }
    /** @test */
public function user_dengan_email_lks_dapat_melihat_halaman_list_manpower()
{
    $user = User::factory()->create(['email' => 'tes@lks.com']);
    $this->actingAs($user);

    $proyek = Proyek::factory()->create(['nama_proyek' => 'Proyek A']);
    $idl = Manpower_idl::factory()->create(['nama' => 'IDL Test']);
    $dl = Manpower_dl::factory()->create(['nama' => 'DL Test']);

    $manpower = Manpower::factory()->create([
        'proyek_id' => $proyek->id,
        'manpower_idl_id' => $idl->id,
        'manpower_dl_id' => $dl->id,
        'remark' => 'Tepat Waktu',
        'hadir' => true,
        'tanggal' => now(),
    ]);

    Livewire::test(\App\Filament\Resources\ManpowerResource\Pages\ListManpowers::class)
        ->assertSee('Proyek A')
        ->assertSee('IDL Test')
        ->assertSee('DL Test')
        ->assertSee('Tepat Waktu')
        ->assertSee('Hadir');
}
/** @test */
public function data_yang_disimpan_dapat_ditampilkan_kembali_dari_database()
{
    $manpower = Manpower::factory()->create([
        'remark' => 'Uji Integrasi DB',
        'hadir' => true,
    ]);

    Livewire::test(\App\Filament\Resources\ManpowerResource\Pages\ListManpowers::class)
        ->assertSee('Uji Integrasi DB')
        ->assertSee('Hadir');
}
}
