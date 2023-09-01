<?php
namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\File;
use Ramsey\Uuid\Uuid;

trait UploadFile {
    private function uploadFile($fileName, $destination)
    {
        $filenameSimpanPhoto = null;
        if (request()->hasFile($fileName)) {
            try {
                $extensionPhoto = File::guessExtension(request()->file($fileName));
                $filenameSimpanPhoto = $fileName.'_'.Uuid::uuid4()->toString(). '.' . $extensionPhoto;
                request()->file($fileName)->storeAs($destination, $filenameSimpanPhoto);
            } catch (Exception  $e) {
                \Log::error($e->getMessage());
            }
        }
        return $filenameSimpanPhoto;
    }
}
