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
        $decodedIc = base64_decode($request->input('ic'));
        [$page, $perPage] = explode(':', $decodedIc) + [1, 25];

        $validPerPage = in_array($perPage, ['25', '50', '100']);
        if (!$validPerPage) {
            return response()->json(['mode' => Responses::FORBIDDEN]);
        }

        $categoryParam = $request->route()->parameters();
        $category = CategorySub::where(CategorySub::COL_LINK, $categoryParam)
            ->orWhere(CategoryBranch::COL_LINK, $categoryParam)
            ->first();

        if (!$category) {
            return response()->json(['mode' => Responses::PRODUCTS_EMPTY]);
        }

        //filters array
        $filterParams = ['price', 'manufacture', 'photo', 'datasheet'];
        $filters = [];
        foreach ($filterParams as $param) {
            if ($request->filled($param)) {
                $filters[$param] = $request->input($param);
            }
        }

        //mfr
        $manufactures = Product::where($category instanceof CategorySub ? Product::COL_CATEGORY_SUB : Product::COL_CATEGORY_BRANCH, $category->id);



        $productsQuery = Product::where($category instanceof CategorySub ? Product::COL_CATEGORY_SUB : Product::COL_CATEGORY_BRANCH, $category->id);
        // filters
        foreach ($filters as $param => $value) {
            $productsQuery->where($param, $value);
        }
        $totalProducts = $productsQuery->count();
        $products = $productsQuery->paginate($perPage, ['*'], 'page', $page);
        if ($products->isEmpty()) {
            return response()->json(['mode' => Responses::PRODUCTS_EMPTY]);
        }

        $result = [
            'data' => [
                'total' => $totalProducts,
                'filter' => $products->total(),
                'price' => '', // Not sure what this is intended for, you may adjust accordingly
            ],
            'products' => $products->map(function ($product) {
                return [
                    Product::COL_MFR_PART_NUMBER => $product->getAttribute(Product::COL_MFR_PART_NUMBER),
                    Product::COL_ICE_PART_NUMBER => $product->getAttribute(Product::COL_ICE_PART_NUMBER),
                    Product::COL_STATUS => $product->getAttribute(Product::COL_STATUS),
                    Product::COL_CURRENCY => $product->getAttribute(Product::COL_CURRENCY),
                    Product::COL_MFR => $product->getAttribute(Product::COL_MFR),
                    Product::COL_PRICE => $product->getAttribute(Product::COL_DK_PART_NUMBER),
                    Product::COL_DATASHEET => $product->getAttribute(Product::COL_DATASHEET),
                    Product::COL_IMAGE => $product->getAttribute(Product::COL_IMAGE),
                ];
            }),
            'mfr' => $manufactures,
        ];

        return response()->json(['mode' => Responses::OK, 'result' => $result]);
    }


    public function searchProducts(SearchProductsRequest $request, $mode): JsonResponse
    {
        $result = null;
        if ($mode == 'ptn') {

        } else {

        }
    }
}
