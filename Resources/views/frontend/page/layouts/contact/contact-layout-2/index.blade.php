<div class="page page-{{$page->id}} page-contact page-contact-layout-2" id="pageContactLayout2">
  <div class="top-banner position-relative">
    <div class="position-absolute h-100 w-100">
      <div class="container d-flex flex-column align-items-center w-100 h-100 justify-content-center">
        <h1 class="text-white text-uppercase title-page">
          {{$page->title}}
        </h1>
        @include('page::frontend.partials.breadcrumb')
      </div>
    </div>
    @if (isset($page) && empty($page->breadcrumb) && strpos($page->mediaFiles()->breadcrumbimage->extraLargeThumb, 'default.jpg') == false)
      <x-media::single-image :title="$page->title" :isMedia="true" width="100%" :mediaFiles="$page->mediaFiles()"
                             zone="breadcrumbimage"/>
    @else
      <div class="pb-5 pt-5" style="background-color: var(--primary)"></div>
    @endif
  </div>
  <div class="page-content">
    <div class="container py-3 py-md-5">
      <div class="row">
        <div class="page-body col-12 py-3 mb-2">
          {!! $page->body !!}
        </div>
        <div class="col-lg-6 mb-md-5">
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
          <div class="contact">
            <x-iforms::form id="{{$form->id}}"/>
          </div>
        </div>
        <div class="col-lg-6 mb-md-5">
          @if (isset($page) && !empty($page->mainimage) && strpos($page->mediaFiles()->mainimage->extraLargeThumb, 'default.jpg') == false)
            <figure>
              <x-media::single-image imgClasses="img-fluid w-100" :title="$page->title" :isMedia="true" width="100%"
                                     :mediaFiles="$page->mediaFiles()"
                                     zone="mainimage"/>
            </figure>
          @else
            <x-isite::Maps/>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>