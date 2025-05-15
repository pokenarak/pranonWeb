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
        #person{
            transition: .3s;
        }
        #person:hover {
            transform: scale(1.1);
            box-shadow: 0 0 25px -5px #ccc;
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
                            <h3>{{ $type }}: <sup>{{ $data->total() }}</sup></h3>
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
                                @php
                                    $type = "";
                                @endphp
                                @foreach ($data as $item)
                                    @php
                                        $allType = $item->type;
                                        $mainType = $allType->whereIn('personnel_type_id',['1','2','3'])->first()
                                    @endphp
                                    @if($mainType)
                                        @if ($mainType->personnel_type->name != $type)
                                            @php
                                                $type = $mainType->personnel_type->name;
                                            @endphp
                                            </div>
                                            <div class="row row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 justify-content-center " >
                                        @endif
                                    @else
                                        @if ($type != '')
                                            </div>
                                            <div class="row row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 justify-content-center " >
                                            @php
                                                $type = '';
                                            @endphp
                                        @endif
                                    @endif
                                    <div class="col mb-3 text-center rounded-4 p-2" id="{{ 'person '.$item->name }}">
                                        <a href="{{ route('personInfo',['id'=>$item->id]) }}" class="nav-link">
                                            @include('layouts.personDetail')
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @if ($data->total()>$data->perPage())
                        {{ $data->links('pagination::bootstrap-5') }}
                    @endif
                </div>
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
