<?php

namespace Modules\Categories\App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Categories\App\Http\Requests\RequestGetCategories;
use Modules\Categories\App\Models\Category;
use Modules\Categories\App\Models\CategoryBranch;
use Modules\Categories\App\Models\CategorySub;
use Responses;
use Illuminate\Support\Facades\Config;


class CategoriesController extends Controller
{
    public function getAllCategories(RequestGetCategories $request): JsonResponse
    {
        $returnList = true;
        if (isset($request[Category::REQ_VERSION])) {
            if ($request[Category::REQ_VERSION] == "1.1.0") {
                $returnList = false;
            }
        }
        if ($returnList) {
            $categories =[
                'version' => config('general.version'),
                'categories' => []
            ];

            $result = null;
            $category = Category::with('cat')->where(Category::COL_STATUS, Category::STATUS_ACTIVE)->get()->toArray();
            if ($category != null) {
                foreach ($category as $item) {
                    $catArray = [];
                    foreach ($item['cat'] as $catItem) {
                        $categoryBranch = CategoryBranch::query()->where(CategoryBranch::COL_SUB_ID, $catItem['id'])->where(CategoryBranch::COL_STATUS, CategoryBranch::STATUS_ACTIVE)->get()->toArray();
                        if ($categoryBranch != null) {
                            $subCatArray = [];
                            foreach ($categoryBranch as $subCatItem) {
                                $subCatArray[] = [
                                    'title' => $subCatItem['title'],
                                    'link' => $subCatItem['link'],
                                    'count' => $subCatItem['count'],
                                ];
                            }
                            $catArray[] = [
                                'title' => $catItem['title'],
                                'link' => $catItem['link'],
                                'count' => $catItem['count'],
                                'branch' => $subCatArray
                            ];
                        } else {
                            $catArray[] = [
                                'title' => $catItem['title'],
                                'link' => $catItem['link'],
                                'count' => $catItem['count']
                            ];
                        }
                    }
                    $result[] = [
                        'id' => uniqid(),
                        'master' => $item['title'],
                        'sub' => $catArray
                    ];
                }
                $categories['categories'] = $result;
                return response()->json(['mode' => Responses::OK, 'data' => $categories]);
            } else {
                return response()->json(['mode' => Responses::CATEGORY_EMPTY, 'data' => null]);
            }
        } else {
            return response()->json(['mode' => Responses::CATEGORY_UP_TO_DATE, 'data' => null]);
        }
    }
}
