<div class="page page-{{$page->id}} page-our page-our-layout-3" id="pageOurLayout3">
  <div class="container">
    <div class="content-breadcrumb">
      @include('page::frontend.partials.breadcrumb')
    </div>
    <div>
      <h1 class="text-center title-page mb-4">
        {{$page->title}}
      </h1>
      @if(isset($page) && empty($page->mainimage) &&
        (strpos($page->mediafiles()->mainimage->extraLargeThumb, 'default.jpg')) == false)
        <div class="content-image col-md-8 m-auto">
          <x-media::single-image :mediaFiles="$page->mediaFiles()" imgClasses="image-page" :isMedia="true"
                                 :alt="$page->title" zone="mainimage"/>
        </div>
      @endif
      <div id="descriptionPage py-3">
        {!!$page->body!!}
      </div>
      <div class="social-share d-flex justify-content-end align-items-center" style="margin-bottom: 2%; margin-right: 9%;">
        <div class="mr-2">{{trans('iblog::common.social.share')}}:</div>
        <div class="sharethis-inline-share-buttons"></div>
      </div>
    </div>
  </div>
  @if(count($page->mediaFiles()->gallery) > 0)
    <hr class="line-footer">
    <div class="gallery-section py-3">
      <x-media::gallery :mediaFiles="$page->mediaFiles()"
                        :responsive="[0 => ['items' => 1], 640 => ['items' => 2], 992 => ['items' => 5]]"/>
    </div>
  @endif
</div>
