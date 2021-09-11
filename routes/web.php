<?php

use Drewdan\AssetHandler\Http\Controllers\MarkdownAssetController;

Route::post('/upload', [MarkdownAssetController::class, 'store'])->name('markdown-assets.store');
