<?php
namespace Tests\Feature;

use App\Models\Divisi;
use App\Models\Manpower_dl;
use App\Models\Manpower_idl;
use App\Models\Proyek;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManpowerDlIntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_dapat_menambahkan_beberapa_data_manpower_dl(): void
    {
        $proyek = Proyek::factory()->create();
        $idl = Manpower_idl::factory()->create(['proyek_id' => $proyek->id]);
        $divisi = Divisi::factory()->create();

        $data = [
            ['nama' => 'Agus'],
            ['nama' => 'Budi'],
        ];

        foreach ($data as $item) {
            Manpower_dl::create([
                'proyek_id' => $proyek->id,
                'manpower_idl_id' => $idl->id,
                'divisi_id' => $divisi->id,
                'nama' => $item['nama'],
            ]);
        }

        $this->assertDatabaseHas('manpower_dls', ['nama' => 'Agus']);
        $this->assertDatabaseHas('manpower_dls', ['nama' => 'Budi']);
    }

    public function test_dapat_melihat_data_manpower_dl(): void
    {
        $dl = Manpower_dl::factory()->create(['nama' => 'Joko']);

        $this->assertEquals('Joko', $dl->nama);
    }

    public function test_dapat_memperbarui_data_manpower_dl(): void
    {
        $dl = Manpower_dl::factory()->create(['nama' => 'Tono']);

        $dl->update(['nama' => 'Solehuddin']);

        $this->assertDatabaseHas('manpower_dls', ['nama' => 'Solehuddin']);
    }

    public function test_dapat_menghapus_data_manpower_dl(): void
    {
        $dl = Manpower_dl::factory()->create();

        $dl->delete();

        $this->assertDatabaseMissing('manpower_dls', ['id' => $dl->id]);
    }

    public function test_pengguna_dengan_email_tidak_valid_tidak_bisa_akses(): void
    {
        $respon = $this->sebagaiPenggunaDenganEmail('invalid@example.com')
            ->get('/admin/manpower-dls');

        $respon->assertForbidden(); // 403
    }

    private function sebagaiPenggunaDenganEmail(string $email)
    {
        $pengguna = \App\Models\User::factory()->create(['email' => $email]);
        return $this->actingAs($pengguna);
    }
}
