<?php

namespace App\Filament\Resources\KaderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\AttachAction;
use App\Models\KaderisasiEvent;

class KaderisasiEventsRelationManager extends RelationManager
{
    protected static string $relationship = 'kaderisasiEvents';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // No form needed for attaching existing events
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Kegiatan'),
                Tables\Columns\TextColumn::make('pivot.certificate_number')
                    ->label('Nomor Sertifikat'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                AttachAction::make()
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Forms\Components\TextInput::make('certificate_number')
                            ->label('Nomor Sertifikat')
                            ->required()
                            ->readOnly()
                            ->default(function (?KaderisasiEvent $record) {
                                if (!$record) {
                                    return null;
                                }
                                $count = $record->kaders()->count() + 1;
                                return str_replace('[nomor]', $record->certificate_start_number + $count - 1, $record->certificate_format);
                            }),
                    ])
                    ->using(function (array $data, $relationship) {
                        return [
                            $data['recordId'] => ['certificate_number' => $data['certificate_number']]
                        ];
                    })
                    ->preloadRecordSelect(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
