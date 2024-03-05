<?php

namespace App\Services\CommentService\V1\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CommentService\V1\Models\Comment;
use App\Services\CommentService\V1\Repositories\Admin\Comment\CommentServiceInterface;
use App\Services\CommentService\V1\Requests\Admin\Comment\UpdateRequest;
use App\Services\CommentService\V1\Resources\Admin\Comment\CommentResource;
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

    public function destroy(Comment $comment): JsonResponse
    {
        return Responser::deleted($this->serviceRepository->destroy($comment));
    }

    public function update(UpdateRequest $request, Comment $comment): JsonResponse
    {
        $result = $this->serviceRepository->update($comment, $request->validated());

        return Responser::success($result);
    }
}
