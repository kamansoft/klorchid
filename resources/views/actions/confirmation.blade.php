@component($typeForm, get_defined_vars())

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-link" data-toggle="modal" data-target="#confirmbutton-action-modal">
        @isset($icon)<i class="{{ $icon }} mr-2"></i>@endisset
        {{ $name ?? '' }}
    </button>

    @push('modals-container')
        <!-- Modal -->
        <div class="modal fade"
             id="confirmbutton-action-modal"
             tabindex="-1"
             aria-labelledby="confirmLabel"
             aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">


                    <div class="modal-header">
                        <h4 class="modal-title text-black font-weight-light"
                            id="confirmLabel">{{__('Are you absolutely sure ?')}}</h4>
                    </div>


                    <div class="modal-body layout-wrapper">
                        <fieldset class="mb-3">
                            <div class="bg-white rounded shadow-sm p-4 py-4 d-flex flex-column ">
                                <p>
                                    {{__('The data sent might not be able to be edited, or the next action could not be reverted ')}}
                                </p>
                            </div>
                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <div class="row justify-content-start">
                            <div class="col-auto p-0">
                                <button id="post-form-sumbit-btn"
                                        type="submit" class="btn btn-link"
                                        form="post-form"
                                        formaction="{{ $action }}"
                                        onclick="$('#confirmbutton-action-modal').modal('hide')"
                                        data-novalidate="{{ var_export($novalidate) }}"
                                        data-turbolinks="{{ var_export($turbolinks) }}"
                                        @empty(!$confirm)onclick="return confirm('{{$confirm}}');" @endempty
                                        {{ $attributes }}>
                                    @isset($icon)<i class="{{ $icon }} mr-2"></i>@endisset
                                    {{__('Continue')}}
                                </button>
                            </div>
                            <div class="col-auto p-0">
                                <button type="button" class="btn btn-danger"
                                        data-dismiss="modal">{{__('Cancel')}}</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endpush

@endcomponent
