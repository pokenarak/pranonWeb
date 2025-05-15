<div id="circleDiv">
    @if ($item->path != '')
        <img src="{{ asset($item->path) }}" alt="" style="filter: grayscale({{ $item->active == 1 ? '0%' : '100%' }})">
    @else
        <img src="{{ asset('images/person/no.png') }}" alt="" style="filter: grayscale({{ $item->active == 1 ? '0%' : '100%' }})">
    @endif
</div>
<div class="row text-center mt-2">
    <div class="col-sm-12">
        @if ($item->rank->count()>0)
            <h5 class="{{ $item->active == 1 ? 'text-primary' : 'text-dark' }}  fw-bold">{{ $item->lastestRank->name }}</h5>
        @else
            <h5 class="{{ $item->active == 1 ? 'text-primary' : 'text-dark' }}  fw-bold">{{ $item->name }} <small class="text-muted">{{ $item->lastname }}</small> {{ $item->ordianation_name }}</h5>
        @endif
    </div>
</div>
<div class="row text-center">
    <div class="col">
        @if ($item->ordain_monk)
            <b>พรรษา : </b>{{ Carbon\Carbon::parse($item->ordain_monk)->age }}
        @else
            <b>อายุ : </b>{{ Carbon\Carbon::parse($item->birthday)->age }}
        @endif

    </div>
</div>
<div class="row">
    <div class="col-12">
        @if ($allType)
            @foreach ($allType as $item)
                <small>{{ $item->personnel_type->name }}</small><br>
            @endforeach
        @endif
    </div>
</div>