<?php

namespace App\Filament\Resources\TranscriptionResource\Pages;
use Illuminate\Support\Facades\Auth;

use App\Filament\Resources\TranscriptionResource;
use App\Models\TranscriptionState;
use Carbon\Carbon;
use DateTime;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTranscription extends CreateRecord
{
    protected static string $resource = TranscriptionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['transcription_state_id'] = TranscriptionState::where("name", "=", "uploaded")->first()->id;
        $data['upload_time'] = Carbon::now();
        return $data;
    }

}
