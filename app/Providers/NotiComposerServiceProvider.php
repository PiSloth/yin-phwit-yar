<?php

namespace App\Providers;

use App\Models\Notification;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class NotiComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $viewName = $view->getName();
            if (!in_array($viewName, ['auth.login', 'auth.register'])) {
                //Only relevant i meeting count for other user
                $view->with('newHrPostCount', Post::where('audience_level_id', 1)
                    ->whereDoesntHave('comments')
                    ->count());


                // $view->with('notis', DB::table('notifications')
                //     ->leftJoin('users', 'users.id', '=', 'notifications.created_by_id')
                //     ->leftJoin('comments', 'notifications.comment_id', '=', 'comments.id')
                //     ->leftJoin('posts', 'notifications.post_id', '=', 'posts.id')
                //     ->select('notifications.post_id', 'users.name', 'comments.comment')
                //     ->where('posts.user_id',  auth()->user()->id)
                //     ->get());
            }
        });
    }
}
