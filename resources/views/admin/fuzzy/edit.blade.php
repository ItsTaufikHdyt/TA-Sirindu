<div class="modal fade bs-example-modal-lg" id="editFuzzyModal{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{route('admin.updateFuzzy',$data->id)}}">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Himpunan Fuzzy</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label>Nama</label>
                        <input name="name" class="form-control" type="text" value="{{$data->name}}" placeholder="Nama">
                        @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Fuzzy Set</label>
                        <select class="form-control" name="fuzzy_set">
                            <option value="1" {{$data->fuzzy_set == '1' ? 'selected' : ''}}>BB/U</option>
                            <option value="2" {{$data->fuzzy_set == '2' ? 'selected' : ''}}>PB/U atau TB/U</option>
                            <option value="3" {{$data->fuzzy_set == '3' ? 'selected' : ''}}>BB/PB atau BB/TB</option>
                            <option value="4" {{$data->fuzzy_set == '4' ? 'selected' : ''}}>IMT/U</option>
                        </select>
                        @error('type') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select class="form-control" name="type" id="typex{{$data->id}}" onclick="updateInputsx({{$data->id}})">
                            <option value="">--- Pilih Kurva ---</option>
                            <option value="1" {{$data->type == '1' ? 'selected' : ''}}>Naik</option>
                            <option value="2" {{$data->type == '2' ? 'selected' : ''}}>Turun</option>
                            <option value="3" {{$data->type == '3' ? 'selected' : ''}}>Segitiga</option>
                            <option value="4" {{$data->type == '4' ? 'selected' : ''}}>Trapesium</option>
                        </select>
                        @error('type') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <input type="hidden" name="idx" id="idx" value="{{$data->id}}">
                    <div class="form-group" id="ax{{$data->id}}">
                        <label>Domain (a)</label>
                        <input name="a"  class="form-control" type="text" value="{{$data->a}}" placeholder="a">
                        @error('a') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group" id="bx{{$data->id}}">
                        <label>Domain (b)</label>
                        <input name="b"  class="form-control" type="text" value="{{$data->b}}" placeholder="b">
                        @error('b') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group" id="cx{{$data->id}}">
                        <label>Domain (c)</label>
                        <input name="c"  class="form-control" type="text" value="{{$data->c}}" placeholder="c">
                        @error('c') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group" id="dx{{$data->id}}">
                        <label>Domain (d)</label>
                        <input name="d"  class="form-control" type="text" value="{{$data->d}}" placeholder="d">
                        @error('d') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

