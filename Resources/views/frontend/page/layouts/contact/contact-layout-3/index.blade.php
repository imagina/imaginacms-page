<div class="page page-{{$page->id}}" data-icontenttype="page" data-icontentid="{{$page->id}}">
  @include('partials.top-banner')
  <div
    class="page-banner banner-breadcrumb-category position-relative">
    <div class="position-absolute h-100 w-100 content-title d-flex align-items-center">
      <div class="container">
        <h1 class="text-white  text-uppercase">
          {{ $page->title }}
        </h1>
      </div>
    </div>
    <div class="content-title-hidden"></div>
    @if (isset($page) && empty($page->breadcrumb) && strpos($page->mediaFiles()->breadcrumbimage->extraLargeThumb, 'default.jpg') == false)
      <x-media::single-image :title="$page->title" :isMedia="true" width="100%" :mediaFiles="$page->mediaFiles()"
                             zone="breadcrumbimage"
      />
    @else
      <div class="page-banner"></div>
    @endif
  </div>
  <div class="container pb-5">
    <div class="content-breadcrumb-center">
      <div id="breadcrumbSection" class="py-2">
        @include('page::frontend.partials.breadcrumb')
      </div>
    </div>
    <div class="row justify-content-between">
      <div class="col-md-4">
        <div class="page-body mb-3">
          {!! $page->body !!}
        </div>
        @php
          $formRepository = app("Modules\Iforms\Repositories\FormRepository");
          $params = [
                  "filter" => [
                    "field" => "system_name",
                  ],
                  "include" => [],
                  "fields" => [],
          ];
          $form = $formRepository->getItem("contact_form", json_decode(json_encode($params)));
        @endphp
        <x-iforms::form id="{{$form->id}}"/>
      </div>
      <div class="col-md-8">
        @php
          $location = json_decode(setting('isite::locationSite'));
        @endphp
        <x-isite::Maps lat="{{$location->lat}}" lng="{{$location->lng}}"/>
        <div class="col-12">
          <div class="row">
            <div class="col-md-6">
              <div class="py-2">
                <x-isite::contact.addresses/>
                <x-isite::contact.phones/>
                <x-isite::contact.emails/>
              </div>
            </div>
            <div class="col-md-6">
              <div class="d-flex justify-content-end py-2">
                <x-isite::social/>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

