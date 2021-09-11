<?php

namespace Drewdan\AssetHandler;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AssetHandlerServiceProvider extends ServiceProvider {

	public function register() {
		$this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'prometheus-markdown');
	}

	public function boot() {
		if ($this->app->runningInConsole()) {
			$this->publishes([
				__DIR__ . '/../config/config.php' => config_path('prometheus-markdown.php'),
			], 'config');
		}

		$this->registerRoutes();
	}

	protected function registerRoutes() {
		Route::group($this->routeConfiguration(), function () {
			$this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
		});
	}

	protected function routeConfiguration(): array {
		return [
			'prefix' => config('prometheus-markdown.route.prefix', 'prometheus'),
			'middleware' => config('prometheus-markdown.route.middleware', ''),
		];
	}

}
