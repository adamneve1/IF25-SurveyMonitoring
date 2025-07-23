<?php

namespace App\Filament\Resources\ManpowerIdlAbsensiResource\Pages;

use App\Filament\Resources\ManpowerIdlAbsensiResource;
use App\Filament\Resources\ManpowerResource;
use App\Models\Manhour;
use App\Models\Manpower;
use App\Models\Manpower_dl;
use App\Models\Manpower_idl;
use App\Models\ManpowerIdlAbsensi;
use App\Models\Proyek;
use App\Services\ManpowerIdlAbsensiService;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Exception;
use Filament\Notifications\Notification;

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
    $data = $this->form->getState();

    try {
        // Panggil service yang bisa melempar exception
        app(ManpowerIdlAbsensiService::class)->create($data);

        // Jika berhasil (tidak ada exception), tampilkan notifikasi sukses
        Notification::make()
            ->title('Absensi berhasil disimpan')
            ->success()
            ->send();

        return redirect()->to($this->getResource()::getUrl('index'));

    } catch (Exception $e) {
        // Jika service melempar exception, tangkap di sini
        // Lalu tampilkan pesan error dari exception tersebut
        Notification::make()
            ->title('Gagal Menyimpan Data')
            ->body($e->getMessage()) // Ambil pesan dari exception
            ->danger()
            ->send();
    }
}}