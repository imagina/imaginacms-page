<div class="page page-{{$page->id}}" data-icontenttype="page" data-icontentid="{{$page->id}}">
  <div class="top-banner position-relative">
    <h1 class="position-absolute text-white al-center text-center">
      <div class="title-cat">{{$page->title}}</div>
      <a class="text-white" href="{{url('/')}}">Inicio</a> <i class="fa fa-angle-right text-primary"
                                                              aria-hidden="true"></i>
      {{$page->title}}
    </h1>
    @if (isset($page) && empty($page->breadcrumb) && strpos($page->mediaFiles()->breadcrumbimage->extraLargeThumb, 'default.jpg') == false)
      <x-media::single-image :title="$page->title" :isMedia="true" width="100%" :mediaFiles="$page->mediaFiles()"
                             zone="breadcrumbimage"/>
    @else
      <img class="img-fluid w-100 h-100" src="{{ Theme::url('img/banner-page.jpg') }}" alt="img-{{$page->title}}">
    @endif
  </div>
  <div class="page-content">
    <div class="container pt-5 py-3 py-md-5">
      <div class="row">
        <div class="col-12">
          <div class="page-body mb-5">
            {!! $page->body !!}
          </div>
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
          <figure>
            <x-media::single-image imgClasses="img-fluid w-100" :title="$page->title" :isMedia="true" width="100%"
                                   :mediaFiles="$page->mediaFiles()"
                                   zone="mainimage"/>
          </figure>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
    .top-banner {
        margin-bottom: 3rem;
        height: 235px;
        text-align: center;
    }

    .top-banner h1 {
        margin-top: 100px;
        margin-left: auto;
        margin-right: auto;
        left: 0;
        right: 0;
        font-size: 17px;
        font-weight: 300;
    }

    .top-banner h1 .title-cat {
        font-size: 40px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .top-banner img {
        object-fit: cover;
    }

    @media (min-width: 576px) {
        .top-banner h1 .title-cat {
            font-size: 31px;
        }
    }

    @media (min-width: 576px) {
        .top-banner h1 .title-cat {
            font-size: 25px;
        }
    }

    .page .contact .col-form-label {
        display: none;
    }

    .page .contact .form-control {
        border-radius: 10px;
        color: #6c6659;
        font-size: 18px;
        font-weight: 300;
    }

    .page .contact .form-control:focus {
        box-shadow: none;
        border: 2px solid var(--primary);
    }

    .page .contact input, .page .contact select, .page .contact textarea {
        height: 55px;
    }

    .page .contact .btn {
        font-size: 18px;
        font-weight: bold;
        color: #fff !important;
        border-radius: 50rem;
        padding: 10.5px 35px;
        background-color: var(--secondary);
        border: 1px solid var(--secondary);
    }

    .page .contact .btn:hover {
        background-color: #f5bd36;
        border-color: #f5bd36;
    }

    .page .page-body {
        font-size: 19px;
        color: #6c6659;
        text-align: justify;
    }

    .page .page-body h1 {
        font-size: 35px;
        position: relative;
        color: var(--primary);
        font-weight: 500;
        text-align: center;
    }

    .page .page-body h1:before {
        content: '';
        position: absolute;
        font-family: 'FontAwesome';
        content: "\f078";
        height: 20px;
        width: 20px;
        bottom: -15px;
        left: 0;
        right: 0;
        margin: 0 auto;
        font-size: 19px;
    }

    .page .page-body h2 {
        color: #353328;
        font-size: 27px;
    }

    .page .page-body h3 {
        color: #353328;
        font-size: 27px;
    }

    .page .page-body h4 {
        color: #353328;
        font-size: 24px;
    }

    .page .page-body h5 {
        color: #353328;
        font-size: 22px;
    }

    .page .page-body h6 {
        color: #353328;
        font-size: 19px;
    }

    .page .page-body h3, .page .page-body h4, .page .page-body h5, .page .page-body h6 {
        position: relative;
        padding-left: 25px;
    }

    .page .page-body h3:before, .page .page-body h4:before, .page .page-body h5:before, .page .page-body h6:before {
        content: "\f101";
        position: absolute;
        font-family: 'FontAwesome';
        color: var(--primary);
        left: 0;
    }

    .page .page-body .btn {
        font-size: 18px;
        font-weight: bold;
        color: #fff !important;
        border-radius: 50rem;
        padding: 8px 30px;
    }
</style>