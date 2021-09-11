<?php

namespace Drewdan\AssetHandler\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Drewdan\AssetHandler\AssetHandlerServiceProvider;

class TestCase extends BaseTestCase {

	protected function setUp(): void {
		parent::setUp();
	}

	protected function getPackageProviders($app): array {
		return [
			AssetHandlerServiceProvider::class
		];
	}

	protected function getEnvironmentSetUp($app) {
	}
}
