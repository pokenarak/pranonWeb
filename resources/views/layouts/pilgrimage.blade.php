<div class="uk-timeline-item">
    <div class="uk-timeline-icon">
        <span class="fw-bold fs-5 uk-badge {{ $item->pilgrimage->stage == 'ในประเทศ' ? 'uk-badge-in':'uk-badge-out' }}">
            @if ($item->stopImage->count()>0 )
                <span>&#10003;</span>
            @else
                {{ $index+1 }}
            @endif
        </span>
    </div>
    <div class="uk-timeline-content">
        @if ($item->stopImage->count()>0)
            <a href="{{ route('showPilgrimage',['id'=>$item->id]) }}" style="text-decoration: none">
                @include('layouts.listOfPilgrimage')
            </a>
        @else
            @include('layouts.listOfPilgrimage')
        @endif
    </div>
</div>

