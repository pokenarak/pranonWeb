<div id="circleDiv">
    @if ($item->path != '')
        <img src="{{ asset($item->path) }}" alt="" style="filter: grayscale({{ $item->active == 1 ? '0%' : '100%' }})">
    @else
        <img src="{{ url('images/person/no.png') }}" alt="" style="filter: grayscale({{ $item->active == 1 ? '0%' : '100%' }})">
    @endif
</div>
@php
    $regis = $item->register->whereNotNull('result');
           $regis->has('course',function($q){
                $q->where('supject',function($que){
                    $que->where('name','like','%ป.ธ. ๓%');
                });
            });
    if($item->ordain_monk != ''){
        if(!$regis->isEmpty()){
            $item->name = "พระมหา".$item->name;
        }else{
            $item->name = "พระ".$item->name;
        }
    }else if($item->ordain_novice != ''){
        $item->name = "สามเณร".$item->name;
    }else{
        $item->name = "คุณ".$item->name;
    }
@endphp
<div class="row text-center mt-2">
    <div class="col-sm-12">
        @if ($item->rank->count()>0)
            <h5 class="{{ $item->active == 1 ? 'text-primary' : 'text-dark' }}  fw-bold">{{ $item->lastestRank->name }}</h5>
        @else
            <h5 class="{{ $item->active == 1 ? 'text-primary' : 'text-dark' }}  fw-bold">{{ $item->name }} <small class="text-muted">{{ $item->lastname }}</small> {{ $item->ordianation_name }}</h5>
        @endif

    </div>
</div>