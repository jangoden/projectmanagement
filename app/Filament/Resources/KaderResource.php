<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KaderResource\Pages;
use App\Filament\Resources\KaderResource\RelationManagers;
use App\Models\Kader;
use App\Models\Pac;
use App\Enums\KaderStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Exports\KaderExport;
use App\Imports\KaderImport;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Notifications\Notification;

class KaderResource extends Resource
{
    protected static ?string $model = Kader::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Database Anggota';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('pac_id')
                    ->label('Asal PAC')
                    ->options(Pac::all()->pluck('name', 'id'))
                    ->required()
                    ->searchable(),
                TextInput::make('nia')
                    ->label('Nomor Induk Anggota')
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('nik')
                    ->label('Nomor Induk Kependudukan')
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('username')
                    ->label('Username')
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('phone_number')
                    ->label('No HP')
                    ->tel()
                    ->maxLength(255),
                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),
                TextInput::make('place_of_birth')
                    ->label('Tempat Lahir')
                    ->maxLength(255),
                DatePicker::make('date_of_birth')
                    ->label('Tanggal Lahir'),
                TextInput::make('hobby')
                    ->label('Hobi')
                    ->maxLength(255),
                Textarea::make('address')
                    ->label('Alamat Lengkap / Dusun')
                    ->maxLength(65535),
                TextInput::make('village')
                    ->label('Kelurahan / Desa')
                    ->maxLength(255),
                TextInput::make('city')
                    ->label('Kabupaten')
                    ->maxLength(255),
                TextInput::make('province')
                    ->label('Provinsi')
                    ->maxLength(255),
                Select::make('status')
                    ->label('Status Anggota')
                    ->options(KaderStatus::class)
                    ->required()
                    ->default(KaderStatus::Aktif),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('pac.name')
                    ->label('Asal PAC')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nia')
                    ->label('NIA')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone_number')
                    ->label('No HP')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('pac_id')
                    ->label('Filter by PAC')
                    ->options(Pac::all()->pluck('name', 'id')),
                SelectFilter::make('status')
                    ->label('Filter by Status')
                    ->options(KaderStatus::class),
            ])
            ->headerActions([
                Action::make('Export')
                    ->label('Export Kader')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function () {
                        return Excel::download(new KaderExport, 'kaders.xlsx');
                    }),
                Action::make('Import')
                    ->label('Import Kader')
                    ->color('primary')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->form([
                        FileUpload::make('attachment')
                            ->label('Excel File')
                            ->acceptedFileTypes(['.xlsx', '.xls'])
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        try {
                            Excel::import(new KaderImport, $data['attachment']);
                            Notification::make()
                                ->title('Import successful')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Import failed')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\KaderisasiEventsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKaders::route('/'),
            'create' => Pages\CreateKader::route('/create'),
            'edit' => Pages\EditKader::route('/{record}/edit'),
        ];
    }
}
