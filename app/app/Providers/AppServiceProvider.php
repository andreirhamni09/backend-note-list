<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

# -- NoteListInterface
    use App\Repositories\NoteList\NoteListRepositoryInterface;
    use App\Repositories\NoteList\NoteListRepository;
# -- NoteListInterface

# -- AuthListInterface
    use App\Repositories\Auth\AuthRepositoryInterface;
    use App\Repositories\Auth\AuthRepository;
# -- AuthListInterface

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(NoteListRepositoryInterface::class, NoteListRepository::class);
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
