<?php namespace TMS;

use Illuminate\Support\ServiceProvider;
use TMS\Repositories\Language\LanguageEloquentRepository;
use TMS\Repositories\Language\LanguageRepositoryInterface;
use TMS\Repositories\Translation\TranslationEloquentRepository;
use TMS\Repositories\Translation\TranslationRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider {

	public function register () {

		$bindings = [
			[ LanguageRepositoryInterface::class, LanguageEloquentRepository::class ],
			[ TranslationRepositoryInterface::class, TranslationEloquentRepository::class ],
		];
		$this->bindInterfacesWithTheirImplementations( $bindings );
	}

	public function bindInterfacesWithTheirImplementations ( $bindings ) {
		foreach ( $bindings as $binding ) {

		    $this->app->bind( $binding[ 0 ], $binding[ 1 ] );
		}

	}
}
