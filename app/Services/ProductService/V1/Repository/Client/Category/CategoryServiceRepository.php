<?php

namespace App\Services\ProductService\V1\Repository\Client\Category;

use App\Services\ProductService\V1\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;
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

    public function query(Builder $query, array $parameters): Builder
    {
        $query->where('status', 1)
            ->where('visible_in_menu', 1);

        return $query;
    }

    public function conditions(Builder $query): array
    {
        return [
            'is_featured'   => fn($value) => $query->where('is_featured', 1),
            'attribute_set' => fn($value) => $query->whereIn('attribute_set_id', $value),
            'level'         => fn($value) => $query->where('level', $value),
            'search'        => fn($value) => $query->where(function ($query) use ($value) {
                $query->where('title', 'LIKE', '%' . $value . '%');
                $query->orWhere('slug', 'LIKE', '%' . $value . '%');
            }),
        ];
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
            ->where('status', 1)
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
