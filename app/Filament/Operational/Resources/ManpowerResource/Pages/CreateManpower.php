<?php

namespace App\Filament\Operational\Resources\ManpowerResource\Pages;

use App\Filament\Resources\ManpowerResource;
use App\Models\Manpower_dl;
use App\Models\Manpower_idl;
use App\Models\Proyek;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Placeholder;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use App\Services\ManpowerAttendanceService;

class CreateManpower extends CreateRecord
{
    protected static string $resource = ManpowerResource::class;
    protected static string $view = 'filament.pages.form-manppour';

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
                    ->live()
                    ->required(),

                Select::make('manpower_idl_id')
                    ->required()
                    ->native(false)
                    ->label('Manpower IDL')
                    ->reactive()
                    ->searchable()
                    ->options(fn(Get $get) => Manpower_idl::query()
                        ->where('proyek_id', $get('proyek_id'))
                        ->whereNotNull('nama')
                        ->pluck('nama', 'id')),

                TextInput::make('remarks')
                    ->required()
                    ->label('Remarks'),

                Section::make('Manpower DL Attendance')
                    ->schema([
                        Grid::make(1)->schema(function (Get $get, callable $set) {
                            $proyekId = $get('proyek_id');
                            $manpowerIdlId = $get('manpower_idl_id');

                            if (!$proyekId || !$manpowerIdlId) {
                                return [
                                    Placeholder::make('info_message')
                                        ->content('⚠️ Please Select Proyek and Manpower IDL First')
                                        ->columnSpanFull()
                                        ->extraAttributes([
                                            'class' => 'p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700',
                                        ]),
                                ];
                            }

                            $manpowers = Manpower_dl::query()
                                ->where('proyek_id', $proyekId)
                                ->when($manpowerIdlId, fn($query) =>
                                    $query->where('manpower_idl_id', $manpowerIdlId)
                                )
                                ->get();

                            if ($manpowers->isEmpty()) {
                                return [
                                    Placeholder::make('no_data_message')
                                        ->content('⚠️ No Manpower DL available for the selected Proyek and Manpower IDL.')
                                        ->columnSpanFull()
                                        ->extraAttributes([
                                            'class' => 'p-4 bg-gray-100 border-l-4 border-gray-500 text-gray-700',
                                        ]),
                                ];
                            }

                            $currentManpowern = $get('manpowern') ?? [];
                            foreach ($manpowers as $manpower) {
                                if (!isset($currentManpowern[$manpower->id])) {
                                    $currentManpowern[$manpower->id] = [
                                        'manpower_dl_id' => $manpower->id,
                                        'is_present' => true,
                                    ];
                                }
                            }
                            $set('manpowern', $currentManpowern);

                            return [
                                Card::make()->schema(
                                    $manpowers->map(fn($manpower) => Grid::make(2)->schema([
                                        Select::make("manpowern.{$manpower->id}.manpower_dl_id")
                                            ->label('Nama')
                                            ->options([$manpower->id => $manpower->nama])
                                            ->default($manpower->id),

                                        Toggle::make("manpowern.{$manpower->id}.is_present")
                                            ->label('Hadir')
                                            ->default(true)
                                            ->columnSpan(2)
                                            ->inline(false),
                                    ]))->toArray()
                                )->extraAttributes(['class' => 'p-4 bg-white rounded-lg shadow']),
                            ];
                        })->columnSpanFull(),
                    ]),
            ]);
    }

    public function save(ManpowerAttendanceService $attendanceService)
    {
        $get = $this->form->getState();

        try {
            $result = $attendanceService->saveAttendance($get);

            if (!empty($result['skipped'])) {
                $skippedList = implode(', ', $result['skipped']);

                Notification::make()
                    ->title('Sebagian absensi disimpan')
                    ->warning()
                    ->body("Beberapa DL sudah absen hari ini dan dilewati: {$skippedList}")
                    ->send();
            } else {
                Notification::make()
                    ->title('Absensi berhasil')
                    ->success()
                    ->body('Semua absensi DL berhasil disimpan.')
                    ->send();
            }

            $this->form->fill(); // Reset form jika berhasil
        } catch (\Exception $e) {
            Notification::make()
                ->title('Gagal menyimpan absensi')
                ->danger()
                ->body($e->getMessage())
                ->send();
        }
    }
}
