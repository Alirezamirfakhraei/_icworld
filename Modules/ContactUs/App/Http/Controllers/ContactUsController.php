<?php

namespace Modules\ContactUs\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\ContactUs\App\Http\Requests\SetMessageRequest;
use Modules\ContactUs\App\Models\ContactUs;
use Responses;


class ContactUsController extends Controller
{

    public function setMessage(SetMessageRequest $request):JsonResponse
    {
        $data = $request->all();
        if (empty($data)){
            return response()->json(['mode' => Responses::REQUEST_NOT_VALID]);
        }
        try {
            ContactUs::query()->create([
               ContactUs::COL_EMAIL =>  $request[ContactUs::REQ_EMAIL],
               ContactUs::COL_SUBJECT =>  $request[ContactUs::REQ_SUBJECT],
               ContactUs::COL_FULL_NAME =>  $request[ContactUs::REQ_FULL_NAME],
               ContactUs::COL_MESSAGE =>  $request[ContactUs::REQ_MESSAGE],
            ]);
            return response()->json(['mode' => Responses::OK]);
        }catch (\Exception $exception){
            Log::info($exception->getMessage());
            return response()->json(['mode' => Responses::ERROR , 'message' => $exception->getMessage()]);
        }
    }


}
