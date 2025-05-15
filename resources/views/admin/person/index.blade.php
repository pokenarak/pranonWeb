<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}
    <style>
        #circleDiv{
            position: relative;
            width: 120px;
            height: 120px;
            overflow: hidden;
            border-radius: 50%;
            display: inline-block;
        }
        #person{
            transition: .3s;
        }
        #person:hover {
            transform: scale(1.1);
            box-shadow: 0 0 25px -5px #ccc;
        }
    </style>

    <div class="container-lg">
        <div class="card border-0">
            <div class="card-body">
                <div class="pb-4 mt-2 text-center">
                    <h2>{{ $type }}: <sup>{{ $data->total() }}</sup></h2>
                </div>
                @if ($data->count()>0)
                    <div class="pb-4 text-center">
                        <div role="search">
                            <input class="form-control" list="datalistOptions" id="exampleDataList" placeholder="ชื่อ..." onKeyup="searchName(this)">
                            <datalist id="datalistOptions">
                                @foreach ($data->pluck('name')->unique()->all() as $item)
                                    <option value={{ $item}}>
                                @endforeach
                            </datalist>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 justify-content-center">
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
                                <a href="{{ route('personnel.show',['personnel'=> $item->id ]) }}" style="text-decoration: none;color:black" >
                                    <div class="col mb-3 text-center p-2 rounded-4" id="{{ 'person '.$item->name }} ">
                                        @include('layouts.personDetail')
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            @if ($data->total()>$data->perPage())
                {{ $data->links('pagination::bootstrap-5') }}
            @endif
        </div>

        <div class="card border-0 mt-3">
            <div class="card-body d-grid gap-1">
                <a class="btn btn-primary" href="{{ route('personnel.create') }}" role="button">เพิ่มบุคลากร</a>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif
    <script>
        window.onload = (event)=> {
            let myAlert = document.querySelector('.toast');
            let bsAlert = new  bootstrap.Toast(myAlert);
            bsAlert.show();
        }
        function searchName(evt){
            var val = evt.value;
            var person = document.querySelectorAll('[id^="person"]');
            console.log(val);
            if(val){
                person.forEach(e => e.style.display='none');
                document.querySelectorAll('[id^="person '+val+'"]').forEach(e => e.style.display='block');

            }else{
                person.forEach(e => e.style.display='block');
            }
        }
    </script>
</x-app-layout>
