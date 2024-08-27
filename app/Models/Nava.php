<?php

namespace App\Models;

use App\Helpers\Constant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Response;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class Nava extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "type",
        "content",
        "file_urls",

        "channel_id",
        "image",
        "person",

        "sound_id",
        "lecture_sound_id",
        "qari_sound_id",
        "style_sound_id",
        "video_stream",
        

        "person_id",
        "language_id",
        "subject_ids",
        "style_ids",
        "kind_id",
        "weight_id",
        "persone_id",
        "session_id",
        "content_type_id",
        "year_id",
        "occasion_id",
        "association_id",
        "poem_format_id",
        "rhythm_id",
        "melody_id",
        "dialect_id",
        "surah_id",
        "surah_page_id",
        "surah_part_id",
        "hizb_id",
        "album_id",


        "done",
        "log_info",
    ];

    const NAVA_TYPE = "nava";
    const LECTURE_TYPE = "lecture";
    const QARI_TYPE = "qari";
    const STYLE_TYPE = "style";
    const VIDEO_STEAM_TYPE = "video_stream";

    const ARRAY_CONTENT_TYPE = [
        self::NAVA_TYPE,
        self::STYLE_TYPE,
        self::LECTURE_TYPE,
        self::QARI_TYPE,
        self::VIDEO_STEAM_TYPE,
    ];

    protected $casts = [
        'subject_ids' => 'array',
        'style_ids' => 'array',
        'type' => 'array',
        'file_urls' => 'array'
    ];


     /**
     * Boot the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Set the field value when saving the model
        static::saving(function ($model) {
            if (empty($model->done)) {
                $model->done = [];
            }
            if (empty($model->log_info)) {
                $model->log_info = [];
            }
        });
    }


    /**
     * set sound id based on nava type
     *
     * @param string $soundId
     * @param string $field
     * @return void
     */
    function updateField(string $field , string $fileId)
    {
        if($field == "file_urls"){
            if(in_array(self::NAVA_TYPE , $this->type))
                $this->sound_id = $fileId;
            elseif(in_array(self::LECTURE_TYPE , $this->type))
                $this->lecture_sound_id = $fileId;
            elseif(in_array(self::QARI_TYPE , $this->type))
                $this->qari_sound_id = $fileId;
            elseif(in_array(self::STYLE_TYPE , $this->type))
                $this->style_sound_id = $fileId;
        }else{
            $this->$field = $fileId;
        }

        $this->save();
    }


    /**
     * 
     *
     * @param SendTaskId $event
     * @param object $response
     * @return array
     */
    function updateLog(object $response)
    {
        $done = Constant::IS_SUCCESS;
        $logInfo = null;

        if (!isset($response->taskId)) {
            $done = Constant::IS_FAILED;
            $logInfo = $response->message ?? null;
        }

        $this->update([
            'done' => $done,
            'log_info' => $logInfo,
            'video_stream' => $response->taskId ?? null,
        ]);
    }
}
