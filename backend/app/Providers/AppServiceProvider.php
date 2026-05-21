<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::addLocation(base_path('../frontend/views'));

        View::composer('frontend.*', function ($view): void {
            try {
                $categories = DB::table('categories')
                    ->select('id', 'parent_id', 'name', 'slug')
                    ->where('status', 1)
                    ->orderByRaw('parent_id IS NOT NULL')
                    ->orderBy('name')
                    ->get();

                $menuCategories = $categories
                    ->whereNull('parent_id')
                    ->map(function ($category) use ($categories) {
                        $category->children = $categories
                            ->where('parent_id', $category->id)
                            ->values();

                        return $category;
                    })
                    ->values();
            } catch (\Throwable) {
                $menuCategories = collect();
            }

            $cartItemCount = 0;

            if (auth()->check()) {
                try {
                    $activeCartId = DB::table('carts')
                        ->where('user_id', auth()->id())
                        ->where('status', 'active')
                        ->latest('updated_at')
                        ->value('id');

                    if ($activeCartId) {
                        $cartItemCount = (int) DB::table('cart_items')
                            ->where('cart_id', $activeCartId)
                            ->count();
                    }
                } catch (\Throwable) {
                    $cartItemCount = 0;
                }
            }

            $view->with([
                'menuCategories' => $menuCategories,
                'cartItemCount' => $cartItemCount,
            ]);
        });
    }
}
