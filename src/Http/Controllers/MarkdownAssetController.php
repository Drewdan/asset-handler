<?php

namespace Drewdan\AssetHandler\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class MarkdownAssetController extends Controller {

	/**
	 * Stores the asset
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(Request $request): JsonResponse {
		//TODO: Make this a request validator and make the options configurable
		$request->validate(['file' => 'required']);

		$srcFile = $request->file('file');
		$filename = config('prometheus-markdown.store_original_filename')
			? $srcFile->getClientOriginalName()
			: Str::uuid()->toString();

		$file = Storage::disk(config('prometheus-markdown.disk'))
			->putFileAs(
				config('prometheus-markdown.storage_path', 'assets'),
				$srcFile,
				$filename
			);

//		Storage::setVisibility($file, 'public');

		return response()->json([
			'url' => Storage::url($file),
		]);
	}
}
