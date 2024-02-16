<x-guest-layout>
    <style>
        #circleDiv{
            position: relative;
            width: 120px;
            height: 120px;
            overflow: hidden;
            border-radius: 50%;
            display: inline-block;
        }
        img{
            width: 100%;
            height: auto
        }
    </style>
    <div class="container-lg pt-4 pb-4" style="margin-top: 90px;height: 90%;">
        <div class="dropdown text-center mb-3">
            @if ($years->count() > 0)
                <button class="btn btn-light dropdown-toggle btn-lg" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    ปี : {{ request()->route()->parameters['year'] == 0 ? $years[0]+543 : request()->route()->parameters['year']+543}}
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    @foreach ($years as $item)
                        <li><a class="dropdown-item" href="{{ route('showPerson',['year'=> $item,'type'=>request()->route()->parameters['type']]) }}">{{ $item+543 }}</a></li>
                    @endforeach
                </ul>
            @endif
        </div>
        @if ($data->count()>0)
        <div class="container-lg">
            <div class="card border-0">
                <div class="card-body">
                    <div class="pb-4 text-center">
                        <h3>{{ $type }}: <sup>{{ $data->count() }}</sup></h3>
                        <div role="search">
                            <input class="form-control" list="datalistOptions" id="exampleDataList" placeholder="ชื่อ..." onKeyup="searchName(this)">
                            <datalist id="datalistOptions">
                                @foreach ($data->pluck('name')->unique()->all() as $item)
                                    <option value={{ $item}}>
                                @endforeach
                            </datalist>
                        </div>
                    </div>
                    <div class="container-lg">
                        <div class="row row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 justify-content-center " >
                            @foreach ($data as $item)
                                <div class="col mb-3 text-center " id="person {{ $item->name }}">
                                    <div id="circleDiv">
                                        @if ($item->path != '')
                                            <img src="{{ asset($item->path) }}" alt="" style="filter: grayscale({{ $item->active == 1 ? '0%' : '100%' }})">
                                        @else
                                            <img src="{{ url('images/person/no.png') }}" alt="" style="filter: grayscale({{ $item->active == 1 ? '0%' : '100%' }})">
                                        @endif
                                    </div>
                                    <div class="row text-center mt-2">
                                        <div class="col-sm-12">
                                            <h5 class="{{ $item->active == 1 ? 'text-primary' : 'text-dark' }}  fw-bold">{{ $item->name }} <small class="text-muted">{{ $item->lastname }}</small> {{ $item->ordianation_name }}</h5>
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
                                            @if ($item->type->count()>0)
                                                @foreach ($item->type->sortBy('personnel_type_id') as $type)
                                                    <div class="row text-center">
                                                        <div class="col-12 fst-italic text-muted">
                                                            <small>{{ $type->personnel_type->name }}</small>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @if ($data->total()>$data->perPage())
                    {{ $data->links('pagination::bootstrap-5') }}
                @endif
            </div>
        @endif
    </div>
    <script>
        function searchName(evt){
            var val = evt.value;
            var person = document.querySelectorAll('[id^="person "]');
            if(val){
                person.forEach(e => e.style.display='none');
                document.querySelectorAll('[id^="person '+val+'"]').forEach(e => e.style.display='block');

            }else{
                person.forEach(e => e.style.display='block');
            }
        }
    </script>
</x-guest-layout>
