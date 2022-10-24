@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
        <span class="sr-only">Error:</span>
        {{ $errors->first() }}
    </div>
@endif
@if (session()->has('alert-class'))
    <div class="alert {{ session()->get('alert-class') }} alert-dismissible fade show" role="alert">
        @if (session()->get('alert-icon'))
            <i class="fas fa-{{session()->get('alert-icon')}}" aria-hidden="true"></i>
        @endif
        <span class="ml-2">{{ session()->get('alert-text') }}</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
{{-- To use this alert, just include in the master template or certain element.
    Then to show this allert, in your controller use :
        session()->flash('alert-icon', 'SUCCESS|ERROR|INFO');
        session()->flash('alert-color','YOUR_ALERT_COLOR');
        session()->flash('alert-text','YOUR_ALERT_TEXT');
    this alert required bootstrap library --}}
