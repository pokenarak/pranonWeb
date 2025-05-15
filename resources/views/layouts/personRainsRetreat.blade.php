<form action="{{ route('deleteRainsRetreat') }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('DELETE')
    <ul class="list-group list-group-flush" style="max-height:70vh;overflow: auto">
        @foreach ($persons as $index => $item)
        @php
            $person = $item->personnel;
        @endphp
            <label class="form-check-label list-group-item align-items-center fw-bold">
                <input class="form-check-input me-2 {{ $item->id }} " type="checkbox" value="{{ $item->id }}" id="{{ $type }}" name="persons[]">
                {{ $index+1 }}.
                @if ($person->rank->count()>0)
                    {{ $person->lastestRank->name }}
                @else
                    {{ $person->name }} <small class="text-muted">{{ $person->lastname }}</small> {{ $person->ordianation_name }}
                @endif
            </label>
        @endforeach
    </ul>
    <div class="row justify-content-end align-items-center mt-3">
        <div class="col col-sm-auto col-md-auto text-end">
            <input class="form-check-input" type="checkbox" role="switch" id="{{ $type }}Switch"  onchange="changSelect('{{ $type }}')" >
            <label class="form-check-label" for="flexSwitchCheckDefault">เลือกทั้งหมด</label>
        </div>
        <div class="col col-sm-2 col-md-1">
            <input type="submit" class="btn btn-outline-danger btn-sm" value="ลบ">
        </div>
    </div>
</form>