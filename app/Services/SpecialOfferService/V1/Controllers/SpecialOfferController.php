<?php

namespace App\Services\SpecialOfferService\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Imports\SpecialOfferImport;
use App\Services\SpecialOfferService\V1\Models\SpecialOffer;
use App\Services\SpecialOfferService\V1\Repository\SpecialOfferServiceInterface;
use App\Services\SpecialOfferService\V1\Resources\SpecialOfferResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Celysium\Responser\Responser;

class SpecialOfferController extends Controller
{
    public function __construct(private readonly SpecialOfferServiceInterface $specialOfferService)
    {
        //
    }

    public function index(Request $request): JsonResponse
    {
        $specialOffers = $this->specialOfferService->index($request->all());

        return Responser::collection(SpecialOfferResource::collection($specialOffers));
    }

    public function assignProducts(Request $request): JsonResponse
    {
        $productIds = $request->get('product_ids');
        $specialOffer = $this->specialOfferService->syncProducts($productIds);

        return Responser::info(new SpecialOfferResource($specialOffer));
    }

    public function destroy(SpecialOffer $specialOffer): JsonResponse
    {
        $this->specialOfferService->destroy($specialOffer);

        return Responser::deleted();
    }

    public function syncProductsViaFile(Request $request): JsonResponse
    {
        $uploadedFile = $request->file('file');
        $filename = time() . '_' . $uploadedFile->getClientOriginalName();
        $filePath = 'specialOffers/' . $filename;

        Storage::disk('local')->putFileAs(
            $filePath,
            $uploadedFile,
            $filename
        );

        Excel::import(new SpecialOfferImport($this->specialOfferService), $request->file('file'), readerType: \Maatwebsite\Excel\Excel::CSV);

        return Responser::success();
    }
}
