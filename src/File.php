<?php

namespace TaNteE\PhpUtilities;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\Mime\MimeTypes;

class File
{
    public static function guessExtension(String $mimeType)
    {
        $guesser = ExtensionGuesser::getInstance();
        $mimeTypes = new MimeTypes();
        $exts = $mimeTypes->getExtensions($mimeType);

        return (count($exts)>0) ? $exts[0] : null;
    }

    public static function base64ToFileContent(String $base64string)
    {
        $returnContent = null;
        $data = explode(',', $base64string);
        $content = (count($data) == 1) ? $data[0] : $data[1];
        $returnContent = base64_decode($content);

        return $returnContent;
    }

    public static function base64ToMimeType(String $base64string)
    {
        $returnMimeType = 'application/octet-stream';
        $data = explode(',', $base64string);
        if (count($data) == 1) {
            $content = $data[0];
            $content = base64_decode($content);
            $returnMimeType = finfo_buffer(finfo_open(), $content, FILEINFO_MIME_TYPE);
        } else {
            $mimeType = explode(';', $data[0]);
            $mimeType = explode(':', $mimeType[0]);
            $returnMimeType = (count($mimeType) == 1) ? $mimeType[0] : $mimeType[1];
        }

        return $returnMimeType;
    }

    public static function base64ToFileExtension(String $base64string)
    {
        return self::guessExtension(self::base64ToMimeType($base64string));
    }

    public static function overwritePut(String $filePath, String $fileContent, String $storage = 'local')
    {
        if (Storage::disk($storage)->exists($filePath)) {
            Storage::disk($storage)->delete($filePath);
        }

        return Storage::disk($storage)->put($filePath, $fileContent);
    }
}
