<div class="page page-{{$page->id}} page-our page-our-layout-3" id="pageOurLayout3">
  <div class="container">
    <div class="content-breadcrumb">
      @include('page::frontend.partials.breadcrumb')
    </div>
    <div>
      <h1 class="text-center title-page mb-4">
        {{$page->title}}
      </h1>
      <div class="content-image">
        <x-media::single-image
          imgClasses="w-100 mb-3"
          :mediaFiles="$page->mediaFiles()"
          :isMedia="true"
          :alt="$page->title"/>
      </div>
      <div id="descriptionPage">
        {!!$page->body!!}
      </div>
    </div>
    <hr class="line-footer">
  </div>
  <div class="gallery-section py-3">
    <x-media::gallery :mediaFiles="$page->mediaFiles()"
                      :responsive="[0 => ['items' => 1], 640 => ['items' => 2], 992 => ['items' => 5]]"/>
  </div>
</div>
