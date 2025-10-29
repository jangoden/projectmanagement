<?php

namespace App\Filament\Resources\KaderisasiEventResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\AttachAction;
use App\Models\Kader;

class KadersRelationManager extends RelationManager
{
    protected static string $relationship = 'kaders';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // No form needed for attaching existing kaders
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Kader'),
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
                            ->default(function (?Kader $record) {
                                $event = $this->getOwnerRecord();
                                if (!$event) {
                                    return null;
                                }
                                $count = $event->kaders()->count() + 1;
                                return str_replace('[nomor]', $event->certificate_start_number + $count - 1, $event->certificate_format);
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
