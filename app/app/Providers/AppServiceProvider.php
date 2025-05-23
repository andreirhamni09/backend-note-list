<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

# -- NoteListInterface
    use App\Repositories\NoteList\NoteListRepositoryInterface;
    use App\Repositories\NoteList\NoteListRepository;
# -- NoteListInterface

# -- AuthInterface
    use App\Repositories\Auth\AuthRepositoryInterface;
    use App\Repositories\Auth\AuthRepository;
# -- AuthInterface

# -- NoteTaskInterface
    use App\Repositories\NoteTask\NoteTaskRepositoryInterface;
    use App\Repositories\NoteTask\NoteTaskRepository;    
# -- NoteTaskInterface

#

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(NoteListRepositoryInterface::class, NoteListRepository::class);
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(NoteTaskRepositoryInterface::class, NoteTaskRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
