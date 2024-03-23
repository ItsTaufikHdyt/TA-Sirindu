<div class="modal fade destroyAbout" id="confirmationModal{{$data->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" action="{{route('admin.destroyFuzzy', $data->id)}}">
                @csrf
                {{ method_field('DELETE')}}
                <div class="modal-body text-center font-18">
                    <input type="hidden" id="id" name="id" value="">
                    <h4 class="padding-top-30 mb-30 weight-500">Are you sure you want to continue?</h4>
                    <div class="padding-bottom-30 row" style="max-width: 170px; margin: 0 auto;">

                        <div class="col-6">
                            <button type="button" class="btn btn-secondary border-radius-100 btn-block confirmation-btn" data-dismiss="modal"><i class="fa fa-times"></i></button>
                            NO
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary border-radius-100 btn-block confirmation-btn"><i class="fa fa-check"></i></button>
                            YES
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>