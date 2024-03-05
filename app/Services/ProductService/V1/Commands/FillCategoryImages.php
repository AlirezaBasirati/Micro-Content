<?php

namespace App\Services\ProductService\V1\Commands;

use App\Services\Migrator\Migrator;
use App\Services\ProductService\V1\Models\Category;
use Celysium\Media\Facades\Media;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use function storage_path;

class FillCategoryImages extends Migrator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:images {--id=} {--chunk=100 : The number of models to retrieve to be synced}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill category images and icons.';


    public function getData(int $page): LengthAwarePaginator
    {
        return Category::query()
            ->when($this->option('id'), fn($query, $id) => $query->where('id', $id))
            ->paginate($this->chunkSize, ['*'], 'page', $page);
    }

    public function reset()
    {
        //
    }

    public function bulkInsert(array $data)
    {
        foreach ($data as $item) {
            if (file_exists(storage_path('/category/images/' . $item->id . '.svg'))) {
                $file_path = storage_path('/category/images/' . $item->id . '.svg');
                $filename = $item->id . '.svg';
                $fileInfo = Storage::mimeType('/category/images/' . $item->id . '.svg');
                $uploadedFile = new UploadedFile(
                    $file_path,
                    $filename,
                    $fileInfo,
                    filesize($file_path),
                );

                Category::query()
                    ->where('id', $item->id)
                    ->update([
                        'image' => Media::upload($uploadedFile),
                    ]);
            } else if (file_exists(storage_path('/category/images/' . $item->id . '.png'))) {
                $file_path = storage_path('/category/images/' . $item->id . '.png');
                $filename = $item->id . '.png';
                $fileInfo = Storage::mimeType('/category/images/' . $item->id . '.png');
                $uploadedFile = new UploadedFile(
                    $file_path,
                    $filename,
                    $fileInfo,
                    filesize($file_path),
                );

                Category::query()
                    ->where('id', $item->id)
                    ->update([
                        'image' => Media::upload($uploadedFile),
                    ]);
            } else if (file_exists(storage_path('/category/images/' . $item->id . '.jpg'))) {
                $file_path = storage_path('/category/images/' . $item->id . '.jpg');
                $filename = $item->id . '.jpg';
                $fileInfo = Storage::mimeType('/category/images/' . $item->id . '.jpg');
                $uploadedFile = new UploadedFile(
                    $file_path,
                    $filename,
                    $fileInfo,
                    filesize($file_path),
                );

                Category::query()
                    ->where('id', $item->id)
                    ->update([
                        'image' => Media::upload($uploadedFile),
                    ]);
            }

            if (file_exists(storage_path('/category/icons/' . $item->id . '.svg'))) {
                $file_path = storage_path('/category/icons/' . $item->id . '.svg');
                $filename = $item->id . '.svg';
                $fileInfo = Storage::mimeType('/category/icons/' . $item->id . '.svg');
                $uploadedFile = new UploadedFile(
                    $file_path,
                    $filename,
                    $fileInfo,
                    filesize($file_path),
                );

                Category::query()
                    ->where('id', $item->id)
                    ->update([
                        'icon' => Media::upload($uploadedFile),
                    ]);
            }
        }
    }

    public function mapper(array $item): ?array
    {
        return $item;
    }

    public function count(): int
    {
        return $this->total;
    }
}
