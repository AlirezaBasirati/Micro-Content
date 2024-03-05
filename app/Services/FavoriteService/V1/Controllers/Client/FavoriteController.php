<?php

namespace App\Services\FavoriteService\V1\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\FavoriteService\V1\Repositories\Client\Favorite\FavoriteServiceInterface;
use App\Services\FavoriteService\V1\Requests\Client\Favorite\CreateRequest;
use App\Services\FavoriteService\V1\Resources\Client\Favorite\FavoriteResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function __construct(private readonly FavoriteServiceInterface $favoriteService)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $listedFavorites = $this->favoriteService->index($request->all());

        return Responser::collection(FavoriteResource::collection($listedFavorites));
    }

    public function store(CreateRequest $request): JsonResponse
    {
        $newFavorite = $this->favoriteService->store($request->validated());

        return Responser::created(new FavoriteResource($newFavorite));
    }

    public function isFavorite(CreateRequest $request): JsonResponse
    {
        $result = $this->favoriteService->isFavorite($request->validated());

        return Responser::info($result);
    }

    public function unfavorite(CreateRequest $request): JsonResponse
    {
        $this->favoriteService->unfavorite($request->validated());

        return Responser::deleted();
    }
}
