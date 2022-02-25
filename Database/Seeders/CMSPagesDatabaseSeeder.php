<?php

namespace Modules\Page\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Page\Entities\PageTranslation;
use Modules\Page\Repositories\PageRepository;

class CMSPagesDatabaseSeeder extends Seeder
{
  /**
   * @var PageRepository
   */
  private $page;
  private $pageTranslation;

  public function __construct(PageRepository $page, PageTranslation $pageTranslation)
  {
    $this->page = $page;
    $this->pageTranslation = $pageTranslation;
  }

  public function run()
  {
    Model::unguard();

    $modules = app('modules');
    $enabledModules = $modules->allEnabled();//Get all modules
    $cmsPages = [];

    //Get cmsPages from enable modules
    foreach (array_keys($enabledModules) as $moduleName) {
      $cmsPages[$moduleName] = config("asgard." . strtolower($moduleName) . ".cmsPages") ?? [];
    }

    //Insert cms pages
    foreach ($cmsPages as $moduleName => $pageTypes) {
      foreach ($pageTypes as $type => $pages) {
        foreach ($pages as $name => $page) {
          //Validate if already exist slug
          $existPage = $this->pageTranslation
            ->leftJoin('page__pages', 'page__pages.id', 'page__page_translations.page_id')
            ->where('page__page_translations.slug', $page['path'])
            ->first();

          if (!$existPage) {
            //Translate page title
            $title = explode('.', $page['title']);
            $prefix = array_shift($title);
            $title = "{$prefix}::" . join('.', $title);

            //Parse Data
            $data = [
              'template' => 'default',
              'is_home' => 0,
              'status' => $page['activated'],
              'type' => 'cms',
              'options' => $page,
              'en' => [
                'title' => trans($title, [], "en"),
                'slug' => $page['path'],
              ],
              'es' => [
                'title' => trans($title, [], "es"),
                'slug' => $page['path'],
              ],
            ];

            //Create page
            $this->page->create($data);
          }
        }
      }
    }
  }
}
