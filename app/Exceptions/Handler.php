<?php

namespace App\Exceptions;

use Session;
use Throwable;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Mailer\Exception\TransportException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
  /**
   * The list of the inputs that are never flashed to the session on validation exceptions.
   *
   * @var array<int, string>
   */
  protected $dontFlash = ["current_password", "password", "password_confirmation"];

  /**
   * Register the exception handling callbacks for the application.
   */
  public function register(): void
  {
    $this->reportable(function (Throwable $e) {
      //
    });
  }

  public function render($request, Throwable $exception)
  {
    $locale = Session::get("locale");
    app()->setLocale($locale);

    if (!$locale) {
      app()->setLocale(config("app.locale"));
    }

    return parent::render($request, $exception);
  }
}
