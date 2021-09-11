<?php

namespace Drewdan\AssetHandler\Tests\Feature\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Drewdan\AssetHandler\Tests\TestCase;

class MarkdownAssetControllerTest extends TestCase {

	/** @test */
	public function testCanStoreAnAsset() {
		Storage::fake('public');

		$response = $this->json('POST', '/markdown-assets/upload', [
			'file' => UploadedFile::fake()->image('image.jpg'),
		])
			->assertStatus(200)
			->assertJsonCount(1);

		$fileName = Str::after($response['url'], 'storage/');

		Storage::disk('public')->assertExists($fileName);

		$visibility = Storage::disk('public')->getVisibility($fileName);
		$this->assertEquals('public', $visibility);
	}

	/** @test */
	public function testCanStoreAnAssetWithOriginalFileName() {
		Config::set('prometheus-markdown.store_original_filename', true);
		Storage::fake('public');

		$response = $this->json('POST', '/markdown-assets/upload', [
			'file' => UploadedFile::fake()->image('image.jpg'),
		])
			->assertStatus(200)
			->assertJsonCount(1);

		$fileName = Str::after($response['url'], 'storage/');

		$this->assertEquals('assets/image.jpg', $fileName);

		Storage::disk('public')->assertExists($fileName);

		$visibility = Storage::disk('public')->getVisibility($fileName);
		$this->assertEquals('public', $visibility);
	}

	/** @test */
	public function testCanStoreAssetOnDifferentDisk() {
		Config::set('prometheus-markdown.disk', 's3');
		Storage::fake('s3');

		$response = $this->json('POST', '/markdown-assets/upload', [
			'file' => UploadedFile::fake()->image('image.jpg'),
		])
			->assertStatus(200)
			->assertJsonCount(1);

		$fileName = Str::after($response['url'], 'storage/');

		Storage::disk('s3')->assertExists($fileName);

		$visibility = Storage::disk('s3')->getVisibility($fileName);
		$this->assertEquals('public', $visibility);
	}

	/** @test */
	public function testCanStoreAnAssetOnLocalDisk() {
		Config::set('prometheus-markdown.disk', 'local');
		Storage::fake('local');

		$response = $this->json('POST', '/markdown-assets/upload', [
			'file' => UploadedFile::fake()->image('image.jpg'),
		])
			->assertStatus(200)
			->assertJsonCount(1);

		$fileName = Str::after($response['url'], 'storage/');

		Storage::disk('local')->assertExists($fileName);

		$visibility = Storage::disk('local')->getVisibility($fileName);
		$this->assertEquals('public', $visibility);
	}

	/** @test */
	public function testCanStoreAssetInDifferentLocation() {
		Config::set('prometheus-markdown.storage_path', 'images');
		Storage::fake('public');

		$response = $this->json('POST', '/markdown-assets/upload', [
			'file' => UploadedFile::fake()->image('image.jpg'),
		])
			->assertStatus(200)
			->assertJsonCount(1);

		$fileName = Str::after($response['url'], 'storage/');
		Storage::disk('public')->assertExists($fileName);
		$this->assertTrue(Str::startsWith($fileName, 'images/'));

		$visibility = Storage::disk('public')->getVisibility($fileName);
		$this->assertEquals('public', $visibility);
	}

}
