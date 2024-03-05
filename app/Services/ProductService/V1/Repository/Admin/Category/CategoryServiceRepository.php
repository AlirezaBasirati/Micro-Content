<?php

namespace App\Services\ProductService\V1\Repository\Admin\Category;

use App\Services\ProductService\V1\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Celysium\Base\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use JetBrains\PhpStorm\Pure;

class CategoryServiceRepository extends BaseRepository implements CategoryServiceInterface
{
    #[Pure] public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function conditions(Builder $query): array
    {
        return [
            'status'          => '=',
            'visible_in_menu' => '=',
            'parent_id'       => '=',
            'is_active'       => fn($value) => $query->where('status', 1),
            'is_featured'     => fn($value) => $query->where('is_featured', 1),
            'attribute_set'   => fn($value) => $query->whereIn('attribute_set_id', $value),
            'level'           => fn($value) => $query->where('level', $value),
            'search'          => fn($value) => $query->where(function ($query) use ($value) {
                $query->where('title', 'LIKE', '%' . $value . '%');
                $query->orWhere('slug', 'LIKE', '%' . $value . '%');
            }),
        ];
    }

    public function store($parameters): model
    {
        if (Category::query()->where('id', $parameters['parent_id'])->exists()) {
            $parentCategory = Category::query()->where('id', $parameters['parent_id'])->first(['level', 'path', 'slug'])->toArray();
            $parameters['level'] = $parentCategory['level'] + 1;
        } else {
            $parameters['level'] = 0;
        }

        if (!Arr::exists($parameters, 'visible_in_menu')) {
            $parameters['visible_in_menu'] = true;
        }

        if (!Arr::exists($parameters, 'position')) {
            $parameters['position'] = Category::query()->where('id', $parameters['parent_id'])->with('children')->first()->max('position') + 1;
        } else {
            Category::query()->where('parent_id', $parameters['parent_id'])
                ->where('position', '>=', $parameters['position'])
                ->increment('position');
        }

        /** @var Category $model */
        $model = Category::query()->create($parameters);

        $parameters['path'] = array_merge($model->parent->path, [$model->only(['id', 'title'])]);

        $model->update($parameters);
        return $model->refresh();
    }

    public function update(Category|Model $model, $parameters): model
    {
        if (Arr::exists($parameters, 'parent_id') && Category::query()->where('id', $parameters['parent_id'])->exists()) {
            $parentCategory = Category::query()->where('id', $parameters['parent_id'])->first(['level', 'path', 'slug'])->toArray();
            $parameters['level'] = $parentCategory['level'] + 1;

            if (!Arr::exists($parameters, 'visible_in_menu')) {
                $parameters['visible_in_menu'] = true;
            }

            if (!Arr::exists($parameters, 'position')) {
                $parameters['position'] = Category::query()->where('id', $parameters['parent_id'])->with('children')->first()->max('position') + 1;
            } else {
                Category::query()->where('parent_id', $parameters['parent_id'])
                    ->where('position', '>=', $parameters['position'])
                    ->increment('position');
            }

            $levelDiff = $parameters['level'] - $model->level;

            $categories = Category::query()
                ->get(['id', 'parent_id', 'title', 'level']);

            $categoriesBank = collect();
            $this->addToBackWithChildren($categories, $categoriesBank, $model);

            $children = $categoriesBank->splice(1);

            foreach ($children as $child) {
                $child->update(['level' => $child->level + $levelDiff]);
            }
        }

        if (!Arr::exists($parameters, 'parent_id') && Arr::exists($parameters, 'position')) {
            Category::query()->where('parent_id', $model->parent_id)
                ->where('position', '>=', $parameters['position'])
                ->increment('position');
        }

        $model->update($parameters);

        $parentCategory = Category::query()->where('id', $parameters['parent_id'])->first(['path'])->toArray();
        $parameters['path'] = array_merge($parentCategory['path'], [$model->only(['id', 'title'])]);
        $model->update($parameters);

        return $model->refresh();
    }

    public function getProducts($category): LengthAwarePaginator
    {
        return $category->products()->paginate(16);
    }

    public function breadcrumb(Category $category): array
    {
        $categories = [$category];
        while ($category->parent_id > 2) {
            array_unshift($categories, $category->parent);
            $category = $category->parent;
        }
        return $categories;
    }

    public function getChildren(int $categoryId): Collection
    {
        $categories = Category::query()
            ->get(['id', 'parent_id', 'title']);

        $categoriesBank = collect();

        $this->addToBackWithChildren($categories, $categoriesBank, $categories->find($categoryId));

        return $categoriesBank;
    }

    private function addToBackWithChildren(Collection &$categories, Collection &$categoriesBank, Category $category): void
    {
        $categoriesBank->push($category);

        foreach ($categories->where('parent_id', $category->id) as $childCategory) {
            $this->addToBackWithChildren($categories, $categoriesBank, $childCategory);
        }
    }
}
