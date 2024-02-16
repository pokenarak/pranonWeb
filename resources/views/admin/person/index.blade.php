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
    </style>

    <div class="container-lg">
        <div class="card border-0">
            <div class="card-body">
                <div class="pb-4 mt-2 text-center">
                    <h2>{{ $type }}: <sup>{{ $data->count() }}</sup></h2>
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
                            @foreach ($data as $item)
                                <div class="col mb-3 text-center " id="person {{ $item->name }}">
                                    <div id="circleDiv">
                                        @if ($item->path != '')
                                            <img src="{{ asset($item->path) }}" alt="" style="filter: grayscale({{ $item->active == 1 ? '0%' : '100%' }});width: 100%;height: auto;" >
                                        @else
                                            <img src="{{ url('images/person/no.png') }}" alt="" style="filter: grayscale({{ $item->active == 1 ? '0%' : '100%' }});width: 100%;height: auto;" >
                                        @endif
                                    </div>
                                    <div class="row text-center mt-2">
                                        <div class="col-sm-12">
                                            <a href="{{ route('personnel.show',['personnel'=> $item->id ]) }}" style="text-decoration: none"><h5 class="{{ $item->active == 1 ? 'text-primary' : 'text-dark' }}  fw-bold">{{ $item->name }} <small class="text-muted">{{ $item->lastname }}</small> {{ $item->ordianation_name }}</h5></a>
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
            var person = document.querySelectorAll('[id^="person "]');
            if(val){
                person.forEach(e => e.style.display='none');
                document.querySelectorAll('[id^="person '+val+'"]').forEach(e => e.style.display='block');

            }else{
                person.forEach(e => e.style.display='block');
            }
        }
    </script>
</x-app-layout>
