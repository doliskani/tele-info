<?php

namespace App\Helpers;

use App\Events\SendTaskId;
use App\Models\Nava;
use CURLFile;

class SendFile
{
    protected $token;
    protected $api;
    protected $apiKey;

    /**
     * 
     *
     * @param Nava $nava
     * @param string $fieldName
     * @param string $fileType
     * @param string $path
     */
    public function __construct(public Nava $nava, public string $fieldName, public string $fileType, public string $path)
    {
        $this->token = $this->getUserJwtToken();
        $this->apiKey = $this->getApiConfigValue("apiKey");

        $this->api = $this->getApi($this->fileType);
        $this->upload();
    }


    public function upload()
    {
        switch ($this->fileType) {
            case 'video':
                $this->uploadToVSServer();
                break;
            default:
                $this->uploadToFileServer();
                break;
        }

    }

    /**
     * upload to file server
     *
     * @return void
     */
    public function uploadToFileServer(): void
    {
        $postFields = ['file' => new CURLFile($this->path)];
        $headers = FileManager::getDefaultHeaders($this->token);
        $fileId = FileManager::uploadFile($postFields, $headers , $this->getApi($this->fileType));
        $this->nava->updateField($this->fieldName , $fileId);
    }

    /**
     * upload to stream server
     *
     * @return void
     */
    public function uploadToVSServer(): void
    {
        $parentDirectory = $this->nava->name . "/" . time();
        $postFields = ['parentDirectory' => $parentDirectory, 'video' => new CURLFile($this->path)];
        $headers = array_merge(FileManager::getDefaultHeaders($this->token), ['apiKey: ' . $this->apiKey]);
        $response = FileManager::uploadFile($postFields, $headers , $this->getApi($this->fileType));
        $response = json_decode($response);
        $this->nava->updateLog($response);
    }

    public function getApi(string $fileType): string
    {
        $apiName = ($fileType == "video") ? "vod_server" : "file_server";
        $baseUrl = $this->getApiConfigValue($apiName);
        $api = ($fileType == "video") ? "/task" : "/api/upload/file";
        return $baseUrl . $api;
    }

    protected function getUserJwtToken(): string
    {
        // Implement your logic to retrieve the JWT token
        return CommonService::getUserJwtToken();
    }

    /**
     * Undocumented function
     *
     * @param string $key
     * @return string
     */
    protected function getApiConfigValue(string $key): string
    {
        // Implement your logic to retrieve API config value
        return getApiConfigValue($key);
    }

    
}
