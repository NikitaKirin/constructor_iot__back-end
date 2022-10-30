<?php

use App\Http\Controllers\Api\v1\SocialNetworksBlockController;

Route::as('socialNetworksBlocks.')->group(function () {

    /*Route::get('socialNetworkBlock{institute?}', [SocialNetworksBlockController::class, 'showDefinite'])
         ->name('show-definite');*/

    Route::get('socialNetworksBlock', [SocialNetworksBlockController::class, 'index'])
         ->name('index');

});
