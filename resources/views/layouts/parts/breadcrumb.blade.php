<ol class="breadcrumb breadcrumb-alt">
    @foreach ($breadcrumbs as $breadcrumb)
        @if (gettype($breadcrumb) != 'array')
            <li class="breadcrumb-item">{{ $breadcrumb }}</li>
        @else
            <li class="breadcrumb-item">
                <a class="link-fx" href="{{ $breadcrumb[1] }}">{{ $breadcrumb[0] }}</a>
            </li>
        @endif
    @endforeach
</ol>
