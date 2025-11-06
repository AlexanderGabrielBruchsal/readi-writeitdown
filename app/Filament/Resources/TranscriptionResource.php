<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TranscriptionResource\Pages;
use App\Filament\Resources\TranscriptionResource\RelationManagers;
use App\Models\Transcription;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TranscriptionResource extends Resource
{
    protected static ?string $model = Transcription::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Transcription';

    protected static ?string $pluralModelLabel = 'Transcriptionen';

    protected static ?string $slug = 'Transcription';





    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('description')->label("Beschreibung")->required(),
                Forms\Components\Select::make("transcription_state_id")->relationship("transcription_state", "title")->disabledOn(["edit"])->visibleOn("edit"),
                Forms\Components\Select::make("user_id")->relationship("user", "name")->disabledOn(["edit"])->visibleOn("edit"),
                Forms\Components\DateTimePicker::make("upload_time")->disabledOn(["edit"])->visibleOn("edit"),
                Forms\Components\DateTimePicker::make("start_time")->disabledOn(["edit"])->visibleOn("edit"),
                Forms\Components\DateTimePicker::make("end_time")->disabledOn(["edit"])->visibleOn("edit"),
                Forms\Components\FileUpload::make('attachment')->visibleOn(["create"])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('transcription_states_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('upload_time')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_time')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_time')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTranscriptions::route('/'),
            'create' => Pages\CreateTranscription::route('/create'),
            'edit' => Pages\EditTranscription::route('/{record}/edit'),
        ];
    }
}
