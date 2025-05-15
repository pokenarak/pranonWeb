<ul class="list-group list-group-flush overflow-auto" style="height: 400px">
    @foreach ($persons as $person)
        @php
            $flag = '';
            if(!$person->ordain_monk && !$person->ordain_novice){
                $flag = 'คุณ';
            }
            else if(Str::length($person->ordain_monk)>0){
                $flag = 'พระ';
            }else {
                $flag = 'สามเณร';
            }
        @endphp
        <label class="list-group-item">
            <div class="row">
                <div class="col-md-auto">
                    <input class="form-check-input" type="checkbox" name="student[]" value="{{ $person->id }}" id="flexCheckDefault">
                </div>
                <div class="col-md-3">
                    {{ $flag }}{{ $person->name }}
                </div>
                <div class="col-md-3">
                    <small>{{ $person->lastname }}</small>
                </div>
                <div class="col-md-3">
                    {{ $person->ordianation_name}}
                </div>
            </div>
        </label>
    @endforeach
</ul>