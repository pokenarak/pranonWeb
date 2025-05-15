<x-guest-layout>
    <div class="container-fluid pt-4 pb-4 rounded-3" style="margin-top: 90px;height: 90%;">
        <div class="pb-4 text-center" style="display: flex;justify-content: center">
            <h2>กิจกรรม&nbsp;&nbsp;</h2>
            <div class="dropdown text-center">
                <button class="btn btn-light dropdown-toggle btn-lg" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    ปี : {{ request()->route()->parameters['year'] == 0 ? 'ทั้งหมด': request()->route()->parameters['year']+543  }}
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="{{ route('activityUser',['year'=> '0','type'=>request()->route()->parameters['type']]) }}">ทั้งหมด</a></li>
                    @foreach ($years as $item)
                        <li><a class="dropdown-item" href="{{ route('activityUser',['year'=> $item->year,'type'=>request()->route()->parameters['type']]) }}">{{ $item->year+543 }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="mt-3">
            <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-5">
                @foreach ($activities as $i => $item)
                    <div class="col border-0">
                        @include('layouts.activityCard')
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
