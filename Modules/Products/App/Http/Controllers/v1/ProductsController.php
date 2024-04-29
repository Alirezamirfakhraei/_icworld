<?php

namespace Modules\Products\App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Categories\App\Models\CategoryBranch;
use Modules\Categories\App\Models\CategorySub;
use Modules\Products\App\Http\Requests\GetProductsRequest;
use Modules\Products\App\Http\Requests\SearchProductsRequest;
use Modules\Products\App\Models\Product;
use Responses;
use function Symfony\Component\VarDumper\Dumper\esc;

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
        $category = CategoryBranch::where(CategoryBranch::COL_LINK, $categoryParam)
            ->where(CategoryBranch::COL_STATUS, CategoryBranch::STATUS_ACTIVE)
            ->first();

        if (empty($category)) {
            $category = CategorySub::where(CategorySub::COL_LINK, $categoryParam)
                ->where(CategorySub::COL_STATUS, CategorySub::STATUS_ACTIVE)
                ->first();

            if (!$category) {
                return response()->json(['mode' => Responses::PRODUCTS_EMPTY]);
            }
        }

        $minMaxPricesQuery = Product::where(function ($query) use ($category) {
            $query->where(Product::COL_CATEGORY_SUB, $category['id'])
                ->orWhere(Product::COL_CATEGORY_BRANCH, $category['id']);
        })->selectRaw('MIN(' . Product::COL_PRICE . ') as min_price, MAX(' . Product::COL_PRICE . ') as max_price')
            ->first();

        $minPrice = $minMaxPricesQuery->min_price ?? 0;
        $maxPrice = $minMaxPricesQuery->max_price ?? 0;

        $productsQuery = Product::where($category instanceof CategorySub ? Product::COL_CATEGORY_SUB : Product::COL_CATEGORY_BRANCH, $category->id);
        $totalCount = $productsQuery->count();


        $isFilter = false;
        if ($request->input('price') || $request->input('mfr') || $request->input('image') || $request->input('datasheet')) {
            $isFilter = true;
            $filterParams = ['price', 'mfr', 'image', 'datasheet'];
            $filters = [];
            foreach ($filterParams as $param) {
                if ($request->filled($param)) {
                    $filters[$param] = $request->input($param);
                }
            }

            foreach ($filters as $param => $value) {
                switch ($param) {
                    case 'mfr':
                        $manufactures = explode(',', $value);
                        $productsQuery->whereIn('mfr', $manufactures);
                        break;
                    case 'price':
                        [$min, $max] = explode(',', $value);
                        $productsQuery->whereBetween(Product::COL_PRICE, [(int)$min, (int)$max]);
                        break;
                    case 'image':
                        if ($value == "1") {
                            $productsQuery = Product::query();
                            $productsQuery->orWhereNotNull('image');
                        }
                        break;
                    case 'datasheet':
                        if ($value == "1") {
                            $productsQuery = Product::query();
                            $productsQuery->orWhereNotNull('datasheet');
                        }
                        break;
                }
            }
        }
        $products = $productsQuery->paginate($perPage, ['*'], 'page', $page);
        if ($products->isEmpty()) {
            return response()->json(['mode' => Responses::PRODUCTS_EMPTY]);
        }

        $manufactures = Product::select(Product::COL_MFR)
            ->where($category instanceof CategorySub ? Product::COL_CATEGORY_SUB : Product::COL_CATEGORY_BRANCH, $category->id)
            ->groupBy(Product::COL_MFR)
            ->pluck(Product::COL_MFR)
            ->unique();

        if ($isFilter) {
            $result = [
                'data' => [
                    'total' => $totalCount,
                    'filter' => $products->total(),
                    'price' => [$minPrice, $maxPrice],
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
        } else {
            $result = [
                'data' => [
                    'total' => $totalCount,
                    'price' => [$minPrice, $maxPrice],
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
        }

        return response()->json(['mode' => Responses::OK, 'result' => $result]);
    }


}
