<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

use App\Repositories\NoteList\NoteListRepositoryInterface;
use App\Repositories\NoteList\NoteListRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(NoteListRepositoryInterface::class, NoteListRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
