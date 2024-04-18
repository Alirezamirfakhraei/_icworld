<?php

namespace Modules\ContactUs\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Logs;
use Modules\ContactUs\App\Http\Requests\GetProductsRequest;
use Modules\ContactUs\App\Models\ContactUs;
use Responses;


class ContactUsController extends Controller
{

    public function setMessage(GetProductsRequest $request):JsonResponse
    {
        $data = $request->all();
        try {
            ContactUs::query()->create([
               ContactUs::COL_EMAIL =>  $data[ContactUs::REQ_EMAIL],
               ContactUs::COL_SUBJECT =>  $data[ContactUs::REQ_SUBJECT],
               ContactUs::COL_FULL_NAME =>  $data[ContactUs::REQ_FULL_NAME],
               ContactUs::COL_MESSAGE =>  $data[ContactUs::REQ_MESSAGE],
            ]);
            return response()->json(['mode' => Responses::OK]);
        }catch (\Exception $exception){
            Logs::error($request , 'Validation Regex (' . $exception->getMessage() . ') is Not Allowed!' , __CLASS__ . ' -> line:' . __LINE__);
            return response()->json(['mode' => Responses::ERROR]);
        }
    }
}
