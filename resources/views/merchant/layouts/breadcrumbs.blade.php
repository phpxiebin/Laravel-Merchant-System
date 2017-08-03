<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        @if ($breadcrumbs)
            <h2>{{ end($breadcrumbs)->title }}</h2>
            <ul class="breadcrumb">
                @foreach ($breadcrumbs as $breadcrumb)
                    @if (!$breadcrumb->last)
                        <li><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
                    @else
                        <li class="active">{{ $breadcrumb->title }}</li>
                    @endif
                @endforeach
            </ul>
        @endif
    </div>
    <div class="col-lg-2">

    </div>
</div>