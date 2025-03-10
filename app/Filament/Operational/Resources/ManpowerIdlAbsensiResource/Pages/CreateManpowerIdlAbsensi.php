<?php 

namespace App\Filament\Operational\Resources\ManpowerIdlAbsensiResource\Pages;

use App\Filament\Operational\Resources\ManpowerIdlAbsensiResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Carbon;
use App\Models\Manpower_idl;
use App\Models\ManpowerIdlAbsensi;
use App\Models\Proyek;

class CreateManpowerIdlAbsensi extends CreateRecord
{
    protected static string $resource = ManpowerIdlAbsensiResource::class;
    protected static string $view = 'filament.pages.form-manpoweridl';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('proyek_id')
                    ->label('Proyek')
                    ->options(Proyek::query()
                        ->whereNotNull('nama_proyek')
                        ->pluck('nama_proyek', 'id'))
                    ->native(false)
                    ->reactive()
                    ->required(),

                Select::make('manpower_idl_id')
                    ->label('Manpower IDL')
                    ->options(fn ($get) => Manpower_idl::query()
                        ->where('proyek_id', $get('proyek_id'))
                        ->whereNotNull('nama')
                        ->pluck('nama', 'id'))
                    ->native(false)
                    ->searchable()
                    ->reactive()
                    ->required(),

                TextInput::make('remarks')
                  
                    ->label('Remarks'),
            ]);
    }

    public function save()
    {
        $get = $this->form->getState();
        ManpowerIdlAbsensi::create([
            'proyek_id' => $get['proyek_id'],
            'manpower_idl_id' => $get['manpower_idl_id'],
            'tanggal' => Carbon::now()->toDateString(),
            'remark' => $get['remarks'],
            'hadir' => 1, // Default hadir sebagai 1
        ]);

        return redirect()->to('/operational/manpower-idl-absensis');
    }
}
