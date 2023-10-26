<?php

namespace App\Http\Middleware;

use Closure;

class MinifyHtmlMiddleware
{
  /**
   * Minify the HTML response.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    $response = $next($request);

    if ($response->headers->get("Content-Type") === "text/html; charset=UTF-8") {
      $content = $response->getContent();
      $content = $this->minifyHtml($content);
      $response->setContent($content);
    }

    return $response;
  }

  /**
   * Minify the HTML content.
   *
   * @param  string  $content
   * @return string
   */
  protected function minifyHtml($content)
  {
    if (\App::environment("production")) {
      $replace = [
        "/<!--(.|\s)*?-->/" => "", // Remove HTML comments
        "/\s{2,}/" => " ", // Shorten multiple whitespace sequences to a single space
        "/>\s+</" => "><", // Remove spaces between tags
        '/\n/' => "", // Remove line breaks
      ];

      $content = preg_replace(array_keys($replace), array_values($replace), $content);
    }
    return $content;
  }
}
