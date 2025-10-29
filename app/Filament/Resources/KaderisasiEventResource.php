<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KaderisasiEventResource\Pages;
use App\Filament\Resources\KaderisasiEventResource\RelationManagers;
use App\Models\KaderisasiEvent;
use App\Models\Pac;
use App\Enums\EventType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KaderisasiEventResource extends Resource
{
    protected static ?string $model = KaderisasiEvent::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationGroup = 'Database Anggota';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('pac_id')
                    ->label('PAC Penyelenggara')
                    ->options(Pac::all()->pluck('name', 'id'))
                    ->required()
                    ->searchable(),
                Select::make('event_type')
                    ->label('Jenis Event')
                    ->options(EventType::class)
                    ->required(),
                TextInput::make('name')
                    ->label('Nama Kegiatan')
                    ->required()
                    ->maxLength(255),
                TextInput::make('venue')
                    ->label('Tempat Pelaksanaan')
                    ->maxLength(255),
                DatePicker::make('start_date')
                    ->label('Tanggal Mulai')
                    ->required(),
                DatePicker::make('end_date')
                    ->label('Tanggal Selesai')
                    ->required(),
                TextInput::make('certificate_start_number')
                    ->label('Nomor Awal Sertifikat')
                    ->numeric()
                    ->default(1)
                    ->required(),
                TextInput::make('certificate_format')
                    ->label('Format Teks Sertifikat')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('pac.name')
                    ->label('PAC Penyelenggara')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('event_type')
                    ->label('Jenis Event')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Nama Kegiatan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('start_date')
                    ->label('Tanggal Mulai')
                    ->date()
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label('Tanggal Selesai')
                    ->date()
                    ->sortable(),
                TextColumn::make('certificate_start_number')
                    ->label('Nomor Awal Sertifikat')
                    ->sortable(),
                TextColumn::make('certificate_format')
                    ->label('Format Sertifikat')
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
                SelectFilter::make('event_type')
                    ->label('Filter by Event Type')
                    ->options(EventType::class),
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
            RelationManagers\KadersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKaderisasiEvents::route('/'),
            'create' => Pages\CreateKaderisasiEvent::route('/create'),
            'edit' => Pages\EditKaderisasiEvent::route('/{record}/edit'),
        ];
    }
}
