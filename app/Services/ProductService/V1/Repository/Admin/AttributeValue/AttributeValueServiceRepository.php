<?php

namespace App\Services\ProductService\V1\Repository\Admin\AttributeValue;

use App\Services\ProductService\V1\Models\AttributeValue;
use Celysium\Media\Facades\Media;
use Illuminate\Database\Eloquent\Collection;
use Celysium\Base\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class AttributeValueServiceRepository extends BaseRepository implements AttributeValueServiceInterface
{
    public function __construct(AttributeValue $model)
    {
        parent::__construct($model);
    }

    public function detail($parameters): Collection
    {
        $priorities = array_flip($parameters['ids']);
        return $this->model->query()
            ->with('attribute')
            ->whereIn('id', $parameters['ids'])
            ->get()
            ->sortBy(fn($attributeValue) => $priorities[$attributeValue->id]);
    }

    public function store(array $parameters): Model
    {
        if (isset($parameters['image'])) {
            $parameters['meta']['image'] = Media::upload($parameters['image']);
        }
        if (isset($parameters['name'])) {
            $parameters['meta']['name'] = $parameters['name'];
        }

        return AttributeValue::query()->create($parameters);
    }

    public function update($model, array $parameters): Model
    {
        if (isset($parameters['image'])) {
            $parameters['meta']['image'] = Media::upload($parameters['image']);
        }
        if (isset($parameters['name'])) {
            $parameters['meta']['name'] = $parameters['name'];
        }

        $model->update($parameters);

        return $model->refresh();
    }

    public function groupByAttributes(array $attribute_values): array
    {
        return $this->model->query()
            ->whereIn('id', $attribute_values)
            ->select('id as attribute_value_id', 'attribute_id')
            ->get()
            ->groupBy('attribute_id')
            ->toArray();
    }

    public function getVariantProducts(array $attribute_values): array
    {
        $attributes = $this->groupByAttributes($attribute_values);

        $products = [];

        foreach (array_shift($attributes) as $attribute_value) {
            $products[] = [$attribute_value];
        }

        foreach ($attributes as $attribute_values) {
            $temp_products = [];

            foreach ($attribute_values as $attribute_value) {
                foreach ($products as $product) {
                    $temp_products[] = array_merge((array) $product, [$attribute_value]);
                }
            }

            $products = $temp_products;
        }

        return $products;
    }

    public function isConfigurable(array $attribute_values): bool
    {
        return $this->model->query()
            ->whereIn('id', $attribute_values)
            ->groupBy('attribute_id')
            ->selectRaw('attribute_id, count(attribute_id) as count')
            ->having('count', '>', 1)
            ->exists();
    }

    public function productAttributes(array $attribute_values): array
    {
        return $this->model->query()
            ->whereIn('id', $attribute_values)
            ->select('id as attribute_value_id', 'attribute_id')
            ->get()
            ->toArray();
    }
}
