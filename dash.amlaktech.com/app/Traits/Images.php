<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Images
{
    public function multipleUpload($request): array
    {
        $images = [];

        for ($i = 0; $i < $request->TotalFiles; $i++) {
            $file = $request->file('file-' . $i);
            $filename = Str::slug($file->getClientOriginalName()) . '-' . rand(1111, 9999) . '.' . $file->getClientOriginalExtension();

            if ($file->move(UNIT_GALLERY_TEMP, $filename))
                $images[] = $filename;
        }

        return $images;
    }
}
