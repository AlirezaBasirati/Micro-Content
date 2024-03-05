<?php

namespace App\Services\ProductService\V1\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProductService\V1\Repository\Admin\Search\SearchServiceInterface as SearchServiceRepository;
use App\Services\ProductService\V1\Resources\Admin\Product\ProductResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Celysium\Responser\Responser;

class SearchController extends Controller
{
    public function __construct(private readonly SearchServiceRepository $searchServiceRepository)
    {
        //
    }

    public function index(Request $request): JsonResponse
    {
        $searches = $this->searchServiceRepository->index($request->all());

        return Responser::collection(ProductResource::collection($searches));
    }

}
