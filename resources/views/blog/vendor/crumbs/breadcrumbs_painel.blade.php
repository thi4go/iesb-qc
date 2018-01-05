<div class="jumbotron no-margin" data-pages="parallax">
    <div class="container-fluid container-fixed-lg sm-p-l-5 sm-p-r-5">
        <div class="inner">
            <ol class="breadcrumb">
                @foreach ($crumbs as $crumb)
                <li>
                    @if($crumb->isActive())
                        <a {!! $crumb->active() !!} href="{{ $crumb->url }}" title="{{ $crumb->title }}">{!! $crumb->title !!}</a>
                    @else
                        <a href="{{ $crumb->url }}" title="{{ $crumb->title }}">{!! $crumb->title !!}</a>
                    @endif
                </li>
                @endforeach
            </ol>
        </div>
    </div>
</div>