<?php

namespace App\Services\ProductService\V1\Commands;

use App\Services\ProductService\V1\Models\Category;
use App\Services\ProductService\V1\Models\FlatCategory;
use App\Services\ProductService\V1\Repository\Admin\FlatProduct\FlatProductServiceInterface as FlatProductServiceRepository;
use Illuminate\Console\Command;

class FillFlatCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fill:categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate category Data From MySql into Mongodb.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(private readonly FlatProductServiceRepository $flatProductServiceRepository)
    {
        parent::__construct();
    }

    public function handle()
    {
        FlatCategory::query()->truncate();
        $this->flatProductServiceRepository->massCreationFlatCategory(Category::all());
        $this->info('Completed!');
    }
}
