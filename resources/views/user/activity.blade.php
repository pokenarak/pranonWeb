<x-guest-layout>
    <div class="container-fluid pt-4 pb-4 rounded-3" style="margin-top: 90px;height: 90%;">
        <div class="pb-4 text-center" style="display: flex;justify-content: center">
            <h2>กิจกรรม&nbsp;&nbsp;</h2>
            <div class="dropdown text-center">
                <button class="btn btn-light dropdown-toggle btn-lg" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    ปี : {{ request()->route()->parameters['year'] == 0 ? 'ทั้งหมด': request()->route()->parameters['year']+543  }}
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="{{ route('activityUser',['year'=> '0']) }}">ทั้งหมด</a></li>
                    @foreach ($years as $item)
                        <li><a class="dropdown-item" href="{{ route('activityUser',['year'=> $item->year]) }}">{{ $item->year+543 }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="mt-3">
            <div class="row justify-content-center">
                @foreach ($activities as $i => $item)
                    <div class="col-md-auto m-3 card-image" style="border-radius: 10px;max-width: 300px">
                        <div class="shadow " style="border-radius: 10px">
                            @if ($image = $item->lastestImage)
                                <img src="{{ asset($image->path) }}" style="border-radius: 10px 10px 0px 0px;">
                            @endif
                            <div class="p-3">
                                <h3 class="mt-3"><a href="{{ route('showActivityUser',['id'=>$item->id]) }}" style="text-decoration: none"><b>{{ $item->topic }}</b></a></h3>
                                <p class="text-break text-muted">{{ $item->detail }}</p>
                                <small class="fst-italic text-muted">{{ \Carbon\Carbon::parse($item->date)->addYear(543)->locale('th')->isoFormat('dddd ที่ D MMMM พ.ศ.YYYY') }}</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="text-center mt-3">
            @if ($activities->total()>$activities->perPage())
                {{ $activities->links('pagination::bootstrap-5') }}
            @endif
        </div>
    </div>

</x-guest-layout>
