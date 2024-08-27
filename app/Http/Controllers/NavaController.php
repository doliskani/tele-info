<?php

namespace App\Http\Controllers;

use App\Events\UploadFile;
use App\Helpers\Constant;
use App\Http\Requests\NavaRequest;
use App\Models\Nava;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NavaController extends Controller
{
    /**
     *
     * @param Request $request
     * @return JsonResponse
     */
    function index(Request $request):JsonResponse
    {
        $navas = Nava::latest()->paginate(Constant::ADMIN_LIST_COUNT);
        
        return response()->json(['navas' => $navas]);
    }

    /**
     * 
     *
     * @param NavaRequest $request
     * @return JsonResponse
     */
    function store(NavaRequest $request):JsonResponse
    {
        $nava = Nava::create($request->validated());
        
        return response()->json(['status' => true , 'id' => $nava->id]);
    }


    /**
     * 
     *
     * @param Nava $nava
     * @return JsonResponse
     */
    function show(Nava $nava):JsonResponse
    {
        return response()->json(['nava' => $nava]);
    }

    /**
     * 
     *
     * @param NavaRequest $request
     * @param Nava $nava
     * @return void
     */
    function update(NavaRequest $request , Nava $nava):JsonResponse
    {
        if($nava->done == 1)
            return response()->json(['message' => "It has already been updated" , 'nava' => $nava]);


        $nava->update($request->validated());

        event(new UploadFile($nava , "file_urls"));
        event(new UploadFile($nava , "image"));
        
        $nava = $nava->fresh();

        return response()->json(['message' => "updated successfully" , 'nava' => $nava]);
    }
}
