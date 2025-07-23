<?php

namespace Tests\Feature\Filament\Proyek;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;
use App\Filament\Resources\ProyekResource\Pages\CreateProyek;
use App\Models\Proyek;

class CreateProyekTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // User yang boleh create
        $this->user = User::factory()->create([
            'email' => 'tes@lks.com',
        ]);

        $this->actingAs($this->user);
    }

    /** @test */
    public function user_lks_bisa_create_proyek()
    {
        Livewire::test(CreateProyek::class)
            ->fillForm([
                'nama_proyek' => 'Proyek Tes',
                'alamat_proyek' => 'Jl. Testing',
                'status' => 'berjalan',
                'tanggal_mulai' => now()->toDateString(),
                'estimasi_selesai' => now()->addDays(5)->toDateString(),
            ])
            ->call('create');

        $this->assertDatabaseHas('proyeks', [
            'nama_proyek' => 'Proyek Tes',
            'alamat_proyek' => 'Jl. Testing',
            'status' => 'berjalan',
        ]);
    }
}
