<?php

namespace App\Services\ProductService\V1\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProductService\V1\Models\Widget;
use App\Services\ProductService\V1\Repository\Admin\Widget\WidgetServiceInterface as WidgetServiceRepository;
use App\Services\ProductService\V1\Resources\Admin\Widget\WidgetResource;
use Celysium\Responser\Responser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WidgetController extends Controller
{
    public function __construct(private readonly WidgetServiceRepository $widgetServiceRepository)
    {
        //
    }

    public function index(Request $request): JsonResponse
    {
        $widgets = $this->widgetServiceRepository->index($request->all());

        return Responser::collection(Widgetresource::collection($widgets));
    }

    public function store(Request $request): JsonResponse
    {
        $widget = $this->widgetServiceRepository->store($request->all());

        return Responser::created(new WidgetResource($widget));
    }

    public function update(Request $request, Widget $widget): JsonResponse
    {
        $widget = $this->widgetServiceRepository->update($widget, $request->all());

        return Responser::info(new WidgetResource($widget));
    }

    public function show(Widget $widget): JsonResponse
    {
        $widget = $this->widgetServiceRepository->show($widget);

        return Responser::info(new WidgetResource($widget));
    }

    public function destroy(Widget $widget): JsonResponse
    {
        $this->widgetServiceRepository->destroy($widget);

        return Responser::deleted();
    }

    public function assignProducts(Widget $widget, Request $request): JsonResponse
    {
        $productIds = $request->get('product_ids');
        $widget = $this->widgetServiceRepository->assignProducts($widget, $productIds);

        return Responser::info(new WidgetResource($widget));
    }

    public function unassignProducts(Widget $widget, Request $request): JsonResponse
    {
        $productIds = $request->get('product_ids');
        $widget = $this->widgetServiceRepository->unassignProducts($widget, $productIds);

        return Responser::info(new WidgetResource($widget));
    }
}
