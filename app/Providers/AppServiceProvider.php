<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// LIBRARIES
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;

// MODELS
use App\Models\Menu;
use App\Models\MenuAuth;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot(Guard $auth)
  {
    // Set Time Zone
    config(['app.locale' => 'id']);
    Carbon::setLocale('id');
    date_default_timezone_set('Asia/Jakarta');

    View::composer('*', function ($view) use ($auth) {
      $view->with('AuthData', $auth->user());
    });

    Blade::directive('currency', function ($money) {
      return "<?php echo number_format($money, 2); ?>";
    });

    $parent_menu = Menu::where('upid_menu', '0')->orderBy('name_menu', 'ASC')->get();
    $menu = new Menu();
    $menu_auth = new MenuAuth();

    View::share('parent_menu', $parent_menu);
    View::share('menu', $menu);
    View::share('menu_auth', $menu_auth);

    Paginator::useBootstrap();
  }
}
