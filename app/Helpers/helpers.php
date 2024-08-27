<?php

use App\Http\Controllers\V1\Admin\Settings\CacheServerController;
use App\Models\Filters\City;
use App\Models\Editable;
use App\Models\Filters\Province;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Permission;
use Morilog\Jalali\Jalalian;
use Jenssegers\Mongodb\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;




/**
 * get model address
 *
 * @param string $model
 * @return string
 */
function getModelAddr(string $model):string
{
    $arr = explode("_" , $model);
    $model = "";
    foreach ($arr as $val) {
        if(strpos($val , "id") !== 0)
            $model .= $val == "vip" ? strtoupper($val) : ucfirst($val);
    }
    if(!class_exists("App\Models\\" . $model))
        $model = "Filters\\" . $model;
    return "App\Models\\" . $model;
}

/**
 * get model by id
 *
 * @param string $model
 * @param string $id
 * @return object|null
 */
function getModelById(string $model, string $id)
{
    $model = getModelAddr($model);
    return $model::find($id);
}



/**
 * get the plural of model
 * @param string $model
 * @return string
 */
function getPluralModel(string $model):string
{
    return $model . "s";
}

/**
 * convert space to dash
 * @param string $str
 * @return string
 */
function spaceToDash($str):string
{
    $str = str_replace("  " , " " , $str);
    return str_replace(" " , "-" , $str);
}


/*
 * extract some words inside the string
 * @param  string  $str
 * @param  int  $length
 * @param  string  $end
 *  @return string
 */
function getSubString($str , $length , $end = "") :string
{
    $arr = explode(" " , $str);
    $sub = array_slice($arr , 0 , $length);
    return implode(" " , $sub) . $end ?? "";
}

/**
 * limit user actions
 * @return JsonResponse
 */
function notAllowedResponse():JsonResponse
{
    return response()->json(['message' => "شما قادر به انجام چنین عملیاتی نیستید!"], Response::HTTP_FORBIDDEN);
}

/**
 * not found response
 * @return JsonResponse
 */
function notFoundResponse($str = "یافت نشد"):JsonResponse
{
    return response()->json(['message' => $str], 404);
}

/**
 * @return JsonResponse
 */
function successfullyResponse():JsonResponse
{
    return response()->json(['message' => "با موفقیت انجام شد"],);
}
/**
 * @return JsonResponse
 */
function errorOccuredResponse():JsonResponse
{
    return response()->json(['message' => "خطایی رخ داده است"], 500);
}

/**
 * limit un authorized user
 * @return JsonResponse
 */
function notAuthorizedResponse():JsonResponse
{
    return response()->json(['message' => "میبایست ابتدا وارد حساب کاربری خود شوید"], 406);
}

/**
 * throw json response and abort app
 *
 * @param integer $status
 * @param mixed $msg
 * @return HttpResponseException
 */
function throwJsonResponse(int $status , $msg = ""):HttpResponseException
{

    $res = response()->json(['message' => $msg], $status);
    throw new HttpResponseException($res);
}


/**
 * get user ip
 *
 * @return string
 */
function getUserIp():string
{
    if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ip = explode("," , $_SERVER['HTTP_X_FORWARDED_FOR'])[0]; 
    else
        $ip = request()->ip();
    return $ip;
}

/**
 * get value from api config by its key
 *
 * @param string $api_name
 * @return string
 */
function getApiConfigValue(string $api_name): string
{
    return config("api." . $api_name);
}



 /**
  * custom trim
  *
  * @param string $string
  * @return string
*/
function custom_trim(string $string):string
{
    $string = htmlentities($string);
    $string = preg_replace("/&nbsp;/",'',$string);
    $string = html_entity_decode($string);
    return trim(preg_replace("/\s{2,}/",' ',$string));    
}

