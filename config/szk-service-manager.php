<?php

use App\Services\CampaignService\V1\Providers\CampaignServiceProvider;
use App\Services\CommentService\V1\Providers\CommentServiceProvider;
use App\Services\ContentManagerService\V1\Providers\ContentManagerServiceProvider;
use App\Services\ProductService\V1\Providers\ProductServiceProvider;
use App\Services\SpecialOfferService\V1\Providers\SpecialOfferServiceProvider;

return [
    'services' => [
        ContentManagerServiceProvider::class,
        ProductServiceProvider::class,
        CommentServiceProvider::class,
        CampaignServiceProvider::class,
        SpecialOfferServiceProvider::class,
    ]
];
