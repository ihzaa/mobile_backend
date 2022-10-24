<div class="alert alert-{{ session()->get('alert-bg') }} alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-{{ session()->get('alert-icon') }}"></i> {{ session()->get('alert-title') }}</h5>
    {{ session()->get('alert-text') }}
</div>
