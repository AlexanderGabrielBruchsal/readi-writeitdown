<?php

namespace App\Console\Commands;

use App\Models\Transcription;
use App\Models\TranscriptionState;
use \Illuminate\Support\Facades\File;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class transcriptionqueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:transcriptionqueue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if(!Storage::exists('staging')) Storage::makeDirectory('staging');
        if(!Storage::exists('output')) Storage::makeDirectory('output');
        $filenamePrefix = "storage/app/private/";
        $stagingPrefix = "../storage/app/private/staging/";
        $outputPrefix = "../storage/app/private/output/";
        $stateUploaded = TranscriptionState::FirstOrFail("name", "uploaded")->first();
        $stateQueued = TranscriptionState::FirstOrFail("name", "queued")->first();
        // Hochgeladene Transcriptionen laden
        $transcriptions = Transcription::where("transcription_state_id", $stateUploaded->id)->get();
        // Dateien ausspielen in Übergabe-Stagingverzeichnis
        // Dateien verschieben in Übergabe-Verzeichnis
        foreach($transcriptions as $transcription) {
            $file = Storage::url($transcription->attachment);
            $filename = $filenamePrefix.basename($file);
            $staging = public_path($stagingPrefix.$transcription->attachment);
            File::copy($filename,$staging);

            $output = public_path($outputPrefix.$transcription->attachment);
            File::move($staging,$output);

            $transcription->transcription_state_id = $stateQueued->id;
            $transcription->save();
        }

        //Eingabe-Verzeichnis laden
        if(!Storage::exists('input')) Storage::makeDirectory('input');
        $inputFiles = Storage::files('input');
        //Dateien (.zip) den Jobs zuordnen
        //Mail mit Downloadlink versenden

    }
}
