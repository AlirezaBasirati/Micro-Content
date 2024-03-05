<?php

namespace App\Services\CommentService\V1\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\CommentService\V1\Models\Comment;
use App\Services\CommentService\V1\Repositories\Client\Comment\CommentServiceInterface;
use App\Services\CommentService\V1\Requests\Client\Comment\CreateRequest;
use App\Services\CommentService\V1\Requests\Client\Rating\CreateRating;
use App\Services\CommentService\V1\Requests\Client\Recommendation\CreateRecommendation;
use App\Services\CommentService\V1\Resources\Client\Comment\CommentResource;
use App\Services\CommentService\V1\Resources\Client\Comment\RatingResource;
use App\Services\CommentService\V1\Resources\Client\Comment\RecommendationResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct(private readonly CommentServiceInterface $serviceRepository)
    {
        //
    }

    public function index(Request $request): JsonResponse
    {
        $listedComments = $this->serviceRepository->index($request->all());

        return Responser::collection(CommentResource::collection($listedComments));
    }

    public function store(CreateRequest $request): JsonResponse
    {
        $createdComment = $this->serviceRepository->store($request->validated());

        return Responser::created(new CommentResource($createdComment));
    }

    public function destroy(Comment $comment): JsonResponse
    {
        return Responser::deleted($this->serviceRepository->destroy($comment));
    }

    public function createRating(Comment $comment, CreateRating $request): JsonResponse
    {
        $createdImage = $this->serviceRepository->createRating($comment, $request->validated());

        return Responser::created(new RatingResource($createdImage));
    }

    public function createRecommendation(Comment $comment, CreateRecommendation $request): JsonResponse
    {
        $createdImage = $this->serviceRepository->createRecommendation($comment, $request->validated());

        return Responser::created(new RecommendationResource($createdImage));
    }
}
