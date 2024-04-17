<?php

namespace Modules\Products\App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Categories\App\Models\Category;
use Modules\Categories\App\Models\CategoryBranch;
use Modules\Categories\App\Models\CategorySub;
use Modules\Products\App\Models\Product;
use Responses;

class ProductsController extends Controller
{
    public function getAllProducts(Request $request)
    {
        $result = null;
        $getParam = $request->route()->parameters();
        $encodedIc = $request->query('ic');
        $decodedIc = base64_decode($encodedIc);
        $page = explode(':', $decodedIc)[0] ?? '25';
        $perPage = explode(':', $decodedIc)[1] ?? '1';
        $getCategorySub = CategorySub::query()->where(CategorySub::COL_LINK, $getParam)->get()->toArray();
        if (empty($getCategorySub)) {
            $getCategoryBranch = CategoryBranch::query()->where(CategoryBranch::COL_LINK, $getParam)->get()->toArray();
            if (empty($getCategoryBranch)) {
                return response()->json(['mode' => Responses::PRODUCTS_EMPTY]);
            } else {
                $getProducts = Product::query()->where()->paginate($perPage, ['*'], 'page', $page);
                foreach ($getCategoryBranch as $branchProduct) {
                    $result[] = [

                    ];
                }
            }
        } else {
            foreach ($getCategorySub as $subProduct) {
                $result[] = [

                ];
            }
        }
        return response()->json(['mode' => Responses::OK, 'result' => $result]);
    }
}
