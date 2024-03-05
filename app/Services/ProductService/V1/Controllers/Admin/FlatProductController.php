<?php

namespace App\Services\ProductService\V1\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProductService\V1\Repository\Admin\FlatProduct\FlatProductServiceInterface as FlatProductServiceRepository;
use App\Services\ProductService\V1\Resources\Admin\FlatProduct\FlatProductAdminResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class FlatProductController extends Controller
{
    public function __construct(private readonly FlatProductServiceRepository $flatProductServiceRepository)
    {
        //
    }

    public function index(Request $request): JsonResponse
    {
        $flatProducts = $this->flatProductServiceRepository->index($request->all());

        if (isset($request['group_by'])) {
            $grouped = [];
            foreach ($flatProducts as $key => $flatProduct) {
                $grouped[$key] = FlatProductAdminResource::collection($flatProduct);
            }

            return Responser::collection($grouped);
        }

        return Responser::collection(FlatProductAdminResource::collection($flatProducts));
    }

    public function sync(): void
    {
        Artisan::call('sync:flat_product');
    }
}
