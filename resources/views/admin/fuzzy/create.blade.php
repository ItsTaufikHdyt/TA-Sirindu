<div class="modal fade bs-example-modal-lg" id="createFuzzyModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{route('admin.storeFuzzy')}}">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Himpunan Fuzzy</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label>Nama</label>
                        <input name="name" class="form-control" type="text" placeholder="Nama">
                        @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Fuzzy Set</label>
                        <select class="form-control" name="fuzzy_set">
                            <option value="1">BB/U</option>
                            <option value="2">PB/U atau TB/U</option>
                            <option value="3">BB/PB atau BB/TB</option>
                            <option value="4">IMT/U</option>
                        </select>
                        @error('type') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select class="form-control" name="type" id="type">
                            <option value="">--- Pilih Kurva ---</option>
                            <option value="1">Naik</option>
                            <option value="2">Turun</option>
                            <option value="3">Segitiga</option>
                            <option value="4">Trapesium</option>
                        </select>
                        @error('type') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group" id="a">
                        <label>Domain (a)</label>
                        <input name="a"  class="form-control" type="text" placeholder="a">
                        @error('a') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group" id="b">
                        <label>Domain (b)</label>
                        <input name="b"  class="form-control" type="text" placeholder="b">
                        @error('b') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group" id="c">
                        <label>Domain (c)</label>
                        <input name="c"  class="form-control" type="text" placeholder="c">
                        @error('c') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group" id="d">
                        <label>Domain (d)</label>
                        <input name="d"  class="form-control" type="text" placeholder="d">
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

