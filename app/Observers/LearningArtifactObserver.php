<?php

namespace App\Observers;

use App\Models\LearningArtifact;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LearningArtifactObserver
{
    /**
     * Handle the LearningArtifact "creating" event.
     *
     * @param  \App\Models\LearningArtifact  $learningArtifact
     * @return void
     */

    public function creating(LearningArtifact $learningArtifact)
    {
        $this->settingFileInfos($learningArtifact);
    }

    /**
     * Handle the LearningArtifact "updating" event.
     *
     * @param  \App\Models\LearningArtifact  $learningArtifact
     * @return void
     */
    public function updating(LearningArtifact $learningArtifact)
    {
        $this->settingFileInfos($learningArtifact);
    }

    /**
     * Getting the file information by file's name, and setting it on object property to create or update the
     * record
     */
    private function settingFileInfos($model) {
        $mimeType = (empty($model->path)) ? 'externo' : Storage::mimeType('public/' . $model->path);

        $fileType = match (Str::before($mimeType, '/')) {
            'image' => 'image',
            'application' => ($mimeType == 'application/zip') ? 'interactive' : 'document',
            'video' => 'video',
            'audio' => 'audio',
            default => 'externo'
        };

        $model->type = $fileType;
        $model->size = (empty($model->path)) ? 0 : Storage::size('public/' . $model->path);
    }
}
