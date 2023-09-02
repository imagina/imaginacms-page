<div class="page page-{{$page->id}} page-our page-contact-layout-7" id="pageContactLayout7">
  <div class="page-banner banner-breadcrumb-category position-relative">
    <div class="position-absolute h-100 w-100 content-title">
      <div class="container d-flex flex-column align-items-center w-100 h-100 justify-content-center">
        <h1 class="text-primary text-center text-uppercase title-page">
          {{$page->title}}
        </h1>
        @include('page::frontend.partials.breadcrumb')
      </div>
    </div>
    <div class="content-title-hidden"></div>
    @if (isset($page) && !empty($page->mediafiles()->breadcrumbimage) && strpos($page->mediaFiles()->breadcrumbimage->extraLargeThumb, 'default.jpg') == false)
      <x-media::single-image :title="$page->title" :isMedia="true" width="100%" :mediaFiles="$page->mediaFiles()"
                             zone="breadcrumbimage"/>
    @else
      <div class="pb-5 pt-5" style="background-color: var(--primary)"></div>
    @endif
  </div>
  <div class="content-page">
    <div class="container">
      <div class="row">
        <div class="col-md-6 image-section py-3">
          <div class="title-form-section py-3">
            <p class="h2 title1-section-form">
              {{trans('page::common.layouts.layoutContact.layout7.title1SectionForm')}}
            </p>
            <p class="h2 title2-section-form text-primary">
              {{trans('page::common.layouts.layoutContact.layout7.title2SectionForm')}}
            </p>
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
        <div class="col-md-6 description-page py-3">
          <div class="title-map-section py-3">
            <p class="h2 title1-section-map">
              {{trans('page::common.layouts.layoutContact.layout7.title1SectionMap')}}
            </p>
            <p class="h2 title2-section-map text-primary">
              {{trans('page::common.layouts.layoutContact.layout7.title2SectionMap')}}
            </p>
          </div>
          <x-isite::Maps/>
          <x-ischedulable::schedule :withIcon="true" layout="schedule-layout-2"
                                    colorIcon="text-primary" colorNameDay="text-primary"
                                    symbolToUniteHours="-" symbolToUniteDays="-"
          />
        </div>
      </div>
    </div>
  </div>
  <hr>
  <div class="description-page py-3">
    <div class="container">
      <div class="row">
        <div class="col-12">
          {!! $page->body !!}
        </div>
      </div>
    </div>
  </div>
</div>