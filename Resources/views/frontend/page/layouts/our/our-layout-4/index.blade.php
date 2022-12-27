{{-- Page Contact --}}
<div class="page-{{ $page->id }}" id="contactSection">
  {{-- Top Banner --}}
  <div
    class="page-banner banner-breadcrumb-category position-relative page-contact">
    <div class="position-absolute h-100 w-100 content-title">
      <div class="container d-flex flex-column align-items-center w-100 h-100 justify-content-center">
        {{$page->title}}
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
  <div class="content-page">
    <div class="container">
      @if (isset($page) && empty($page->mainimage) && strpos($page->mediaFiles()->mainimage->extraLargeThumb, 'default.jpg') == false)
        <x-media::single-image :title="$page->title" :isMedia="true" width="100%" :mediaFiles="$page->mediaFiles()"
                               zone="mainimage"/>
      @endif
      {!! $page->body !!}
    </div>
    <div class="gallery-section py-3">
      <x-media::gallery :mediaFiles="$page->mediaFiles()"
                        :responsive="[0 => ['items' => 1], 640 => ['items' => 2], 992 => ['items' => 5]]"/>
    </div>
  </div>
</div>

<style>

</style>