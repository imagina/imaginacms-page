<div class="page page-{{$page->id}} page-our page-contact-layout-7" id="pageContactLayout7">
  <div class="page-banner banner-breadcrumb-category position-relative">
    <div class="position-absolute h-100 w-100 content-title">
      <div class="container d-flex flex-column align-items-center w-100 h-100 justify-content-center">
        <h1 class="text-white text-center text-uppercase title-page">
          {{$page->title}}
        </h1>
        <div class="d-flex justify-content-center">
          @include('page::frontend.partials.breadcrumb')
        </div>
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
          <div class="title-section py-3">
            <p class="h2 title1-section">
              {{trans('page::common.layouts.layoutContact.layout7.title1SectionForm')}}
            </p>
            <p class="h2 title2-section text-secondary">
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
          <div class="title-section py-3">
            <p class="h2 title1-section">
              {{trans('page::common.layouts.layoutContact.layout7.title1SectionMap')}}
            </p>
            <p class="h2 title2-section text-secondary">
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

<style>
  .page-contact-layout-7 .page-banner {
    height: 320px;
  }

  .page-contact-layout-7 .page-banner img {
    height: 100%;
    object-fit: cover;
  }

  .page-contact-layout-7 .content-page .title-section .title1-section {
    color: var(--primary);
    font-size: 18px;
    font-weight: 400;
    text-align: justify;
  }

  .page-contact-layout-7 .content-page .title-section .title2-section {
    font-size: 30px;
    font-weight: 700;
    color: var(--secondary);
    position: relative;
  }

  .page-contact-layout-7 .content-page form .form-group label {
    display: none;
  }

  .page-contact-layout-7 .content-page form .form-group .input-group {
    background: #eee;
    border-radius: 14px;
    border: 0;
  }

  .page-contact-layout-7 .content-page form .form-group .input-group .input-group-text {
    border-radius: 14px;
    border: 0;
  }

  .page-contact-layout-7 .content-page form .form-group .input-group textarea {
    height: 120px;
  }

  .page-contact-layout-7 .content-page form .form-group .input-group .input-group-prepend i {
    color: var(--secondary) !important;
  }

  .page-contact-layout-7 .content-page form .form-group .form-control {
    background: #eee;
    height: 52px;
    border-radius: 0 14px 14px 0;
    border: 0;
  }

  .page-contact-layout-7 .content-page form .form-group button {
    margin-top: 10px;
    border-radius: 25px;
    height: 45px;
    z-index: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: auto;
    padding: 0px 25px;
    font-size: 16px;
    color: #fff;
    background: var(--primary);
    box-shadow: 9px 9px 56px -13px var(--primary);
  }
</style>
