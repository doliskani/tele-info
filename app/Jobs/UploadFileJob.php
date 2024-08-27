<?php

namespace App\Jobs;

use App\Helpers\Constant;
use App\Helpers\SendFile;
use Facades\App\Helpers\FileManager;
use App\Models\Nava;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UploadFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param Nava $nava
     * @param string $fieldName
     */
    public function __construct(public Nava $nava, public string $fieldName)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        try {
            if ($this->fieldName == "file_urls") {
                foreach ($this->nava->file_urls as $file_url) {
                    // save file in local and get the file mime type
                    list($fileType, $path) = $this->getFileAttrs($file_url);
                    // upload file to video stream server or file server
                    new SendFile($this->nava, "file_urls", $fileType, $path);
                }
            } 
            else {
                if($this->nava->{$this->fieldName}){
                    list($fileType, $path) = $this->getFileAttrs($this->nava->{$this->fieldName});
                    new SendFile($this->nava, $this->fieldName, $fileType, $path);
                }
            }

        } catch (\Throwable $th) {
            // if an error occured, save done as failed
            $this->nava->log_info = $th->getMessage();
            $this->nava->done = Constant::IS_FAILED;
            $this->nava->save();
        }
    }

    /**
     * get file attributes: file type and path
     *
     * @param string $file_url
     * @return array
     */
    function getFileAttrs(string $file_url) : array
    {
        $filename = FileManager::saveFileByAddress($file_url);
        $path = Storage::disk("temp")->path($filename);
        $fileType = FileManager::getMimeType($path);
        return [$fileType , $path];
    }
}
