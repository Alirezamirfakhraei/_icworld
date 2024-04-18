<?php

namespace Modules\Products\App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Categories\App\Models\CategoryBranch;
use Modules\Categories\App\Models\CategorySub;
use Modules\Products\App\Http\Requests\GetProductsRequest;
use Modules\Products\App\Http\Requests\SearchProductsRequest;
use Modules\Products\App\Models\Product;
use Responses;

class ProductsController extends Controller
{
    public function getAllProducts(GetProductsRequest $request): JsonResponse
    {
        $result = null;
        $getParam = $request->route()->parameters();
        $encodedIc = $request->input('ic');
        $decodedIc = base64_decode($encodedIc);
        $page = explode(':', $decodedIc)[0] ?? '1';
        $perPage = explode(':', $decodedIc)[1] ?? '25';
        $validPerPage = in_array($perPage, ['25', '50', '100']);
        if (!$validPerPage) {
            return response()->json(['mode' => Responses::FORBIDDEN]);
        }
        //---> get sub category
        $getCategorySub = CategorySub::query()->where(CategorySub::COL_LINK, $getParam)->first();
        if (empty($getCategorySub)) {
            //---> get branch category
            $getCategoryBranch = CategoryBranch::query()->where(CategoryBranch::COL_LINK, $getParam)->first();
            if (empty($getCategoryBranch)) {
                return response()->json(['mode' => Responses::PRODUCTS_EMPTY]);
            } else {
                //--->if is Exist -> get products
                $getProducts = Product::query()
                    ->where(Product::COL_CATEGORY_BRANCH, $getCategoryBranch['id'])
                    ->paginate($perPage, ['*'], 'page', $page);
                if (!empty($getProducts->getCollection())) {
                    $products = $getProducts->getCollection();
                    foreach ($products as $branchProduct) {
                        $result[] = [
                            Product::COL_DK_PART_NUMBER => $branchProduct[Product::COL_DK_PART_NUMBER],
                            Product::COL_MFR_PART_NUMBER => $branchProduct[Product::COL_MFR_PART_NUMBER],
                            Product::COL_ICE_PART_NUMBER => $branchProduct[Product::COL_ICE_PART_NUMBER],
                            Product::COL_STATUS => $branchProduct[Product::COL_STATUS],
                            Product::COL_CURRENCY => $branchProduct[Product::COL_CURRENCY],
                            Product::COL_MFR => $branchProduct[Product::COL_MFR],
                            Product::COL_PRICE => $branchProduct[Product::COL_DK_PART_NUMBER],
                            Product::COL_DATASHEET => $branchProduct[Product::COL_DATASHEET],
                            Product::COL_IMAGE => $branchProduct[Product::COL_IMAGE],
                        ];
                    }
                } else {
                    return response()->json(['mode' => Responses::PRODUCTS_EMPTY]);
                }
            }
        } else {
            //--->if is Exist -> get products
            $getProducts = Product::query()
                ->where(Product::COL_CATEGORY_SUB, $getCategorySub['id'])
                ->paginate($perPage, ['*'], 'page', $page);
            if (!empty($getProducts->getCollection())) {
                $products = $getProducts->getCollection();
                foreach ($products as $branchProduct) {
                    $result[] = [
                        Product::COL_DK_PART_NUMBER => $branchProduct[Product::COL_DK_PART_NUMBER],
                        Product::COL_MFR_PART_NUMBER => $branchProduct[Product::COL_MFR_PART_NUMBER],
                        Product::COL_ICE_PART_NUMBER => $branchProduct[Product::COL_ICE_PART_NUMBER],
                        Product::COL_STATUS => $branchProduct[Product::COL_STATUS],
                        Product::COL_CURRENCY => $branchProduct[Product::COL_CURRENCY],
                        Product::COL_MFR => $branchProduct[Product::COL_MFR],
                        Product::COL_PRICE => $branchProduct[Product::COL_DK_PART_NUMBER],
                        Product::COL_DATASHEET => $branchProduct[Product::COL_DATASHEET],
                        Product::COL_IMAGE => $branchProduct[Product::COL_IMAGE],
                    ];
                }
            } else {
                return response()->json(['mode' => Responses::PRODUCTS_EMPTY]);
            }
        }
        return response()->json(['mode' => Responses::OK, 'result' => $result]);
    }

    public function searchProducts(SearchProductsRequest $request , $mode): JsonResponse
    {
        $result = null;
        if ($mode == 'ptn'){

        }else{

        }
    }
}
