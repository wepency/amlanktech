<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Models\Attachment;

class UploadService
{
    public function uploadMultiple($files, $folder = 'attachments', $attachable = null)
    {
        $uploads = [];

        if (!is_array($files)) {
            $files = [$files];
        }

        foreach ($files as $file) {

            $uploadData = $this->upload($file, $folder);
            $uploads[] = Attachment::create($uploadData + [
                    'model_id' => optional($attachable)->id,
                    'model_type' => get_class($attachable),
                ]);
        }

        return $uploads;
    }

    public static function upload($file, $folder = '/')
    {
        $filename = (new self())->generateFilename($file);
        $path = $file->storeAs($folder, $filename, 'public');

        return [
            'filename' => $filename,
            'path' => $path,
        ];
    }

    protected function generateFilename($file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = Str::random(25) . '.' . $extension;

        return $filename;
    }
}
