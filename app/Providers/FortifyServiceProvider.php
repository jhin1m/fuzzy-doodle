<?php

namespace App\Providers;

use Exception;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\RateLimiter;
use Laravel\Fortify\Contracts\LogoutResponse;
use App\Actions\Fortify\UpdateUserProfileInformation;

class FortifyServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register(): void
  {
    $this->app->instance(
      LogoutResponse::class,
      new class implements LogoutResponse {
        public function toResponse($request)
        {
          return redirect()->route("home");
        }
      }
    );
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    Fortify::createUsersUsing(CreateNewUser::class);
    Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
    Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
    Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

    RateLimiter::for("login", function (Request $request) {
      $email = (string) $request->email;

      return Limit::perMinute(5)->by($email . $request->ip());
    });

    RateLimiter::for("two-factor", function (Request $request) {
      return Limit::perMinute(5)->by($request->session()->get("login.id"));
    });

    Fortify::loginView(function () {
      return view("auth.login");
    });

    Fortify::registerView(function () {
      return view("auth.register");
    });

    Fortify::verifyEmailView(function () {
      return view("auth.verify-email");
    });

    Fortify::requestPasswordResetLinkView(function () {
      return view("auth.forgot-password");
    });

    Fortify::resetPasswordView(function ($request) {
      return view("auth.reset-password", ["request" => $request]);
    });
  }
}
