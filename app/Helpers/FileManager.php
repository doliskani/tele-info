<?php


namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class FileManager
{

    /**
     * save external file into temp storage
     *
     * @param string $fileUrl
     * @return string
     */
    function saveFileByAddress(string $fileUrl) : string
    {
        $name = time() . substr($fileUrl , strrpos($fileUrl , '.'));
        Storage::disk("temp")->put($name, file_get_contents($fileUrl));
        return $name;
    }

    /**
     * get type of file
     *
     * @param string $path
     * @return string
     */
    function getMimeType(string $path) : string
    {
        return substr(File::mimeType($path), 0, 5);
    }


    /**
     * save uploaded file 
     * @param Request $request
     * @param UploadedFile $file
     * @param string $dir
     * @param string $disk
     * @return void
     */
    public function saveFile($request , $file , string $dir , string $disk = "public"):?string
    {
        $uploadedFile = $file instanceof UploadedFile ? $file : $request->file($file);
        if($uploadedFile){
            $name = rand(5000000 , 20000000) . $uploadedFile->getClientOriginalName();
            return Storage::disk($disk)->putFileAs($dir, $uploadedFile, $name);
        }
        return null;
    }

    

    /**
     * delete file from storage
     *
     * @param string|null $newPath
     * @param string|array $preFiles
     * @param string $disk
     * @return void
     */
    public function deleteFile(?string $newPath , $preFiles , string $disk = "public")
    {
        $preFiles = is_string($preFiles) ? [$preFiles] : $preFiles;
        if($newPath){
            foreach ($preFiles as $filePath) {
                $filePath = str_replace("api/" , "" , $filePath);
                if(Storage::disk($disk)->exists($filePath))
                    Storage::disk($disk)->delete($filePath);
            }
        }
    }

    /**
     * upload file to stream server or file server
     *
     * it didn't work with Http client!
     * 
     * @param array $postFields
     * @param array $headers
     * @param string $api
     * @return string|object
     */
    public static function uploadFile(array $postFields, array $headers, string $api): string|object
    {
        return Http::withHeaders($headers)->post($api , $postFields)->json();
    }

    /**
     * get default headers
     *
     * @param string $token
     * @return array
     */
    public static function getDefaultHeaders(string $token): array
    {
        return [
            'Content-Type: multipart/form-data',
            'Authorization: ' . $token
        ];
    }

}