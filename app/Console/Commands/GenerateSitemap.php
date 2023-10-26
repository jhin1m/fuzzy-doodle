<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

use App\Models\Manga;

class GenerateSitemap extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = "sitemap:generate";

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = "Automatically Generate an XML Sitemap";

  /**
   * Execute the console command.
   *
   * @return int
   */
  public function handle()
  {
    $mangasitemap = Sitemap::create();

    Manga::get()->each(function (Manga $manga) use ($mangasitemap) {
      $mangasitemap->add(
        Url::create("/{$manga->slug}")
          ->setPriority(0.9)
          ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
      );
    });

    $mangasitemap->writeToFile(public_path("sitemap.xml"));
  }
}
