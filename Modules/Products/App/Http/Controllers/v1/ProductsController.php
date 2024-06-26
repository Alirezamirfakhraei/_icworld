<?php

namespace Modules\Products\App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Categories\App\Models\Category;
use Modules\Categories\App\Models\CategoryBranch;
use Modules\Categories\App\Models\CategorySub;
use Modules\Products\App\Http\Requests\GetProductPtnRequest;
use Modules\Products\App\Http\Requests\GetProductRequest;
use Modules\Products\App\Http\Requests\GetProductsRequest;
use Modules\Products\App\Models\Manufacture;
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

        $branchCat = null;
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
            } else {
                $subCat = $category['title'];
            }
        } else {
            $branchCat = $category['title'];
            $subcategories = $category->subcategories()->where(CategorySub::COL_STATUS, CategorySub::STATUS_ACTIVE)->get();
            $subCat = $subcategories->pluck('title')->first() ?? null;
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

        $isValid = false;
        $filters = $request->only(['price', 'mfr', 'image', 'datasheet']);
        if ($filters && count($filters) > 0) {
            $isValid = true;
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
                        $productsQuery->whereNotNull('image');
                    }
                    break;
                case 'datasheet':
                    if ($value == "1") {
                        $productsQuery->whereNotNull('datasheet');
                    }
                    break;
            }
        }

        $products = $productsQuery->paginate($perPage, ['*'], 'page', $page);
        if ($products->isEmpty()) {
            return response()->json(['mode' => Responses::PRODUCTS_EMPTY]);
        }

        $res = [];
        $manufactures = Product::with('manufacture')
            ->where($category instanceof CategorySub ? Product::COL_CATEGORY_SUB : Product::COL_CATEGORY_BRANCH, $category->id)
            ->get()->toArray();
        foreach ($manufactures as $manufacture) {
            if ($manufacture['manufacture'] != null) {
                $res[] = [
                    'id' => $manufacture['manufacture']['id'],
                    'mfr' => $manufacture['manufacture']['mfr'],
                ];
            }
        }

        if ($isValid) {
            $result = [
                'cat' => [
                    'title' => 'test',
                    'sub' => $subCat,
                    'branch' => $branchCat,
                ],
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
                        Product::COL_PRICE => $product->getAttribute(Product::COL_PRICE),
                        Product::COL_DATASHEET => $product->getAttribute(Product::COL_DATASHEET),
                        Product::COL_IMAGE => $product->getAttribute(Product::COL_IMAGE),
                        Product::COL_DESCRIPTION => $product->getAttribute(Product::COL_DESCRIPTION),
                    ];
                }),
                'mfr' => $res
            ];
        } else {
            $result = [
                'cat' => [
                    'title' => 'test',
                    'sub' => $subCat,
                    'branch' => $branchCat,
                ],
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
                        Product::COL_PRICE => $product->getAttribute(Product::COL_PRICE),
                        Product::COL_DATASHEET => $product->getAttribute(Product::COL_DATASHEET),
                        Product::COL_IMAGE => $product->getAttribute(Product::COL_IMAGE),
                        Product::COL_DESCRIPTION => $product->getAttribute(Product::COL_DESCRIPTION),
                    ];
                }),
                'mfr' => $res
            ];
        }

        return response()->json(['mode' => Responses::OK, 'result' => $result]);
    }

    public function getProduct(GetProductRequest $request): JsonResponse
    {
        $findProduct = Product::query()->where(Product::COL_ICE_PART_NUMBER, $request[Product::REQ_DEC_IC])->first();
        if ($findProduct != null) {
            $findCatBranch = CategoryBranch::query()->where('id', $findProduct['categoryBranchID'])->first();
            if ($findCatBranch != null) {
                $findSubCat = CategorySub::query()->where('id', $findCatBranch['subCatID'])->first();
                if ($findSubCat != null) {
                    $findCat = Category::query()->where('id', $findSubCat['catID'])->first();
                    if ($findCat != null) {
                        $findMfr = Manufacture::query()->where(Manufacture::COL_MFR, $findProduct['mfr'])->first();
                        if ($findMfr) {
                            $result = [
                                'category' => $findCat[Category::COL_TITLE],
                                'categorySub' => $findSubCat[categorySub::COL_TITLE],
                                'categoryBranch' => $findCatBranch[categoryBranch::COL_TITLE],
                                'cat_logo' => $findProduct[Product::COL_IMAGE],
                                'mfr_logo' => $findProduct[Product::COL_IMAGE],
                                'mfr' => $findMfr[Manufacture::COL_MFR],
                                'mfr_pn' => $findProduct[Product::COL_MFR_PART_NUMBER],
                                'ice_pn' => $findProduct[Product::COL_ICE_PART_NUMBER],
                                'price' => $findProduct[Product::COL_PRICE],
                                'currency' => $findProduct[Product::COL_CURRENCY],
                                'status' => $findProduct[Product::COL_STATUS],
                                'datasheet' => $findProduct[Product::COL_DATASHEET],
                                'image' => $findProduct[Product::COL_IMAGE],
                                'description' => $findProduct[Product::COL_DESCRIPTION],
                            ];
                            return response()->json(['mode' => Responses::OK, 'result' => $result]);
                        } else {
                            return response()->json(['mode' => Responses::PRODUCTS_EMPTY]);
                        }
                    } else {
                        return response()->json(['mode' => Responses::PRODUCTS_EMPTY]);
                    }
                } else {
                    return response()->json(['mode' => Responses::PRODUCTS_EMPTY]);
                }
            } else {
                return response()->json(['mode' => Responses::PRODUCTS_EMPTY]);
            }
        }else {
            return response()->json(['mode' => Responses::PRODUCTS_EMPTY]);
        }
    }

    public function getProductWithPtn(GetProductPtnRequest $request): JsonResponse
    {
        $decodedIc = base64_decode($request[Product::REQ_DEC_IC]);
        [$page, $perPage] = explode(':', $decodedIc) + [1, 25];

        $validPerPage = in_array($perPage, ['25', '50', '100']);
        if (!$validPerPage) {
            return response()->json(['mode' => Responses::FORBIDDEN]);
        }
        $products = self::getProductsByPartNumber($request, $perPage, $page);
        if ($products->isEmpty()) {
            return response()->json(['mode' => Responses::PRODUCTS_EMPTY]);
        }

        $array = null;
        foreach ($products as $product) {
            $array[] = [
                Product::COL_MFR_PART_NUMBER => $product->getAttribute(Product::COL_MFR_PART_NUMBER),
                Product::COL_ICE_PART_NUMBER => $product->getAttribute(Product::COL_ICE_PART_NUMBER),
                Product::COL_STATUS => $product->getAttribute(Product::COL_STATUS),
                Product::COL_CURRENCY => $product->getAttribute(Product::COL_CURRENCY),
                Product::COL_MFR => $product->getAttribute(Product::COL_MFR),
                Product::COL_PRICE => $product->getAttribute(Product::COL_PRICE),
                Product::COL_DATASHEET => $product->getAttribute(Product::COL_DATASHEET),
                Product::COL_IMAGE => $product->getAttribute(Product::COL_IMAGE),
            ];
        }
        return response()->json(['mode' => Responses::OK, 'result' => $array]);
    }

    public static function getProductsByPartNumber($request, $perPage, $page): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $searchWord = $request->input(Product::REQ_SEARCH_KEY);
        $productsQuery = Product::query()
            ->where(Product::COL_MFR_PART_NUMBER, 'LIKE', "%$searchWord%")
            ->orWhere(Product::COL_ICE_PART_NUMBER, 'LIKE', "%$searchWord%");
        return $productsQuery->paginate($perPage, ['*'], 'page', $page);
    }


}

