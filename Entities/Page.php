<?php

namespace Modules\Page\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Icrud\Entities\CrudModel;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Ibuilder\Traits\isBuildable;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Tag\Contracts\TaggableInterface;
use Modules\Tag\Traits\TaggableTrait;
use Modules\Isite\Traits\Typeable;
use Modules\Core\Icrud\Traits\hasEventsWithBindings;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Modules\Ifillable\Traits\isFillable;
use Modules\Core\Support\Traits\AuditTrait;
use Modules\Isite\Traits\RevisionableTrait;
use Modules\Iqreable\Traits\IsQreable;

class Page extends CrudModel implements TaggableInterface
{
  use Translatable, TaggableTrait, NamespacedEntity, MediaRelation,
    Typeable, BelongsToTenant, isFillable, IsQreable, isBuildable;

  public $transformer = 'Modules\Page\Transformers\PageApiTransformer';
  public $entity = 'Modules\Page\Entities\Page';
  public $repository = 'Modules\Page\Repositories\PageRepository';
  public $requestValidation = [
    'create' => 'Modules\Page\Http\Requests\CreatePageRequest',
    'update' => 'Modules\Page\Http\Requests\UpdatePageRequest',
  ];

  protected $table = 'page__pages';

  public $translatedAttributes = [
    'page_id',
    'title',
    'slug',
    'status',
    'body',
    'meta_title',
    'meta_description',
    'og_title',
    'og_description',
    'og_image',
    'og_type',
  ];
  protected $fillable = [
    'is_home',
    'template',
    'organization_id',
    // Translatable fields
    'page_id',
    'record_type',
    'type',
    'system_name',
    'internal',
    'options',
  ];

  protected $casts = [
    'is_home' => 'boolean',
    'options' => 'array',
  ];

  protected $with = [];
  protected static $entityNamespace = 'asgardcms/page';

  public function getCanonicalUrl(): string
  {
    if ($this->is_home === true) {
      return url('/');
    }

    return route('page', $this->slug);
  }

  public function getEditUrl(): string
  {
    return route('admin.page.page.edit', $this->id);
  }

  public function __call($method, $parameters)
  {
    #i: Convert array to dot notation
    $config = implode('.', ['asgard.page.config.relations', $method]);

    #i: Relation method resolver
    if (config()->has($config)) {
      $function = config()->get($config);

      return $function($this);
    }

    #i: No relation found, return the call to parent (Eloquent) to handle it.
    return parent::__call($method, $parameters);
  }



  public function getUrlAttribute($locale=null)
  {

    $currentLocale = $locale ?? locale();
    if(!is_null($locale)){
       $this->slug = $this->getTranslation($locale)->slug;
    }

        return \LaravelLocalization::localizeUrl('/'.$this->slug, $currentLocale);
    }

    public function getOptionsAttribute($value)
    {
      $response = json_decode($value);

      if(is_string($response)) {
        $response = json_decode($response);
      }

      return $response;
    }

  public function setSystemNameAttribute($value)
  {
    $this->attributes['system_name'] = !empty($value) ? $value : \Str::slug($this->title, '-');
  }

    public function getCacheClearableData()
    {
        return [
            'urls' => [
                $this->url
            ]
        ];
    }
}
