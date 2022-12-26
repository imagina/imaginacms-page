{{-- Page Contact --}}
<div class="page-{{ $page->id }}" id="contactSection">
  {{-- Top Banner --}}
  <div
    class="page-banner banner-breadcrumb-category position-relative page-contact">
    <div class="position-absolute h-100 w-100 content-title">
      <div class="container d-flex flex-column align-items-center w-100 h-100 justify-content-center">
        @include('page::frontend.partials.breadcrumb')
      </div>
    </div>
    <div class="content-title-hidden"></div>
    @if (isset($page) && empty($page->breadcrumb) && strpos($page->mediaFiles()->breadcrumbimage->extraLargeThumb, 'default.jpg') == false)
      <x-media::single-image :title="$page->title" :isMedia="true" width="100%" :mediaFiles="$page->mediaFiles()"
                             zone="breadcrumbimage"/>
    @else
      <div class="pb-5 pt-5" style="background-color: var(--primary)"></div>
    @endif
  </div>
  <div style="background: #e6e6e6">
    <div class="container contact-section pt-5 pb-5" id="cardContact">
      <div class="card">
        @if (isset($page) && count($page->mediaFiles()->gallery) > 0)
          <x-media::gallery :mediaFiles="$page->mediaFiles()"
                            :responsive="[0 => ['items' => 1]]"
                            :dots="true" :nav="true"
                            :navText="['<i class=\'fa fa-chevron-left\'></i>', '<i class=\'fa fa-chevron-right\'></i>']"
          />
        @else
          <x-media::single-image :title="$page->title" :isMedia="true" width="100%" :mediaFiles="$page->mediaFiles()"
                                 zone="mainimage"/>
        @endif
      </div>
    </div>
  </div>
  <div class="content-page">
    <div class="container">
      {!! $page->body !!}
    </div>
  </div>
</div>

<style>
    #contactSection .breadcrumb {
        justify-content: center;
        margin-bottom: 27px !important;
    }

    #contactSection .breadcrumb .breadcrumb-item {
        font-size: 18px;
        color: #fff !important;
        font-weight: 100;
        text-transform: uppercase;
    }

    #contactSection .breadcrumb .breadcrumb-item a {
        color: #fff !important;
    }

    @media (max-width: 991.98px) {
        #contactSection .content-title h1 {
            font-size: 25px;
        }

        #contactSection .content-title #breadcrumbSection ol.breadcrumb li.breadcrumb-item {
            color: #fff !important;
            font-size: 14px;
        }

        #contactSection .content-title #breadcrumbSection ol.breadcrumb li.breadcrumb-item:before {
            color: #fff !important;
        }

        #contactSection .content-title #breadcrumbSection ol.breadcrumb li.breadcrumb-item a {
            color: #fff !important;
            font-size: 14px;
        }
    }

    #cardContact {
        position: relative;
        top: -33vw;
    }

    #cardContact .card {
        border-radius: 20px;
        box-shadow: 1px 2px 10px 4px #020202 1 f;
    }

    #cardContact .card .card-body {
        padding: 4.5vw;
    }

    @media (max-width: 991.98px) {
        #cardContact .card-title {
            text-align: center;
            font-size: 22px;
        }

        #cardContact .card-title:after {
            margin: auto !important;
        }

        #cardContact .btn {
            width: 80px;
            font-size: 15px !important;
        }

        #cardContact .contact-section {
            font-size: 15px;
        }

        #cardContact .fa-phone, #cardContact .fa-map-marker, #cardContact .fa-envelope {
            font-size: 15px;
        }

        #cardContact #componentContactAddresses:before, #cardContact #componentContactPhones:before, #cardContact #componentContactEmails:before {
            padding-left: 1.8rem;
        }

        #cardContact #socialIn {
            text-align: center;
        }
    }

    @media (max-width: 767.98px) {
        #cardContact {
            top: -56vw;
        }
    }

    @media (max-width: 767.98px) {
        #sectionMaps {
            margin-top: -56vw;
        }
    }
</style>