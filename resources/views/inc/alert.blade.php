
@if(Session::has('error'))
    <div class="w-form-fail" style="display: flex; justify-content: center; border-radius: 5px;">
        <div class="">
            <div class="flex align-center gap-column-4px">
                <img src="{{ asset('images/error-message-icon-dashflow-webflow-template.svg')}}" loading="eager" alt="" class="max-w-12px">
                <div class="text-50 medium">{{ Session::get('error') }}</div>
            </div>
        </div>
    </div>
@endif
@if(Session::has('info'))
    <div class="w-form-success" style="display: flex; justify-content: center; border-radius: 5px;">
        <div class="">
            <div class="flex align-center gap-column-4px">
                <img src="{{ asset('images/Yes.svg')}}" loading="eager" alt="" class="max-w-12px">
                <div class="text-50 medium">{{ Session::get('info') }}</div>
            </div>
        </div>
    </div>
@endif
@if(Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa fa-exclamation-circle me-2"></i>{{ Session::get('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
