<?php

namespace Lazerg\LaravelResponseHelpers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Testing\TestResponse;

class LaravelResponseHelpersServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        TestResponse::macro('assertJsonData', function (array $data): TestResponse {
            /** @var TestResponse $this */
            return $this->assertJson(compact('data'));
        });

        TestResponse::macro('assertJsonStructureData', function (array $data): TestResponse {
            /** @var TestResponse $this */
            return $this->assertJsonStructure(compact('data'));
        });

        TestResponse::macro('assertJsonCountData', function (int $count, ?string $key = null): TestResponse {
            /** @var TestResponse $this */
            $key = $key ? 'data.' . $key : 'data';

            return $this->assertJsonCount($count, $key);
        });
    }
}
