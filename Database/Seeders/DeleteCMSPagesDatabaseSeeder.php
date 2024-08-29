<?php

namespace Modules\Page\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Page\Entities\Page;

class DeleteCMSPagesDatabaseSeeder extends Seeder
{
  public function run()
  {
    Model::unguard();
    Page::where('type', 'cms')->forceDelete();
  }
}
