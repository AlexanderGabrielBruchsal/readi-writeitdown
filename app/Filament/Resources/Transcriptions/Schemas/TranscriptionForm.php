<?php

namespace App\Filament\Resources\Transcriptions\Schemas;

use Filament\Facades\Filament;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TranscriptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('description')->label("Beschreibung")->required(),
                Select::make("transcription_state_id")->relationship("transcription_state", "title")->disabledOn(["edit"])->visibleOn("edit"),
                Select::make("user_id")->relationship("user", "name")->disabledOn(["edit"])->visibleOn("edit")->default(Filament::auth()->id()),
                DateTimePicker::make("upload_time")->disabledOn(["edit"])->visibleOn("edit"),
                DateTimePicker::make("start_time")->disabledOn(["edit"])->visibleOn("edit"),
                DateTimePicker::make("end_time")->disabledOn(["edit"])->visibleOn("edit"),
                FileUpload::make('attachment')->visibleOn(["create"])->storeFileNamesIn('attachment_filename'),
                TextInput::make('attachment_filename')->visibleOn(["edit"])->label("Dateiname")->readOnly()
            ]);
    }
}
