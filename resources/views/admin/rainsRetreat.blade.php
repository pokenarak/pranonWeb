
<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}
    <style>
       #image-cropper {
            border-radius: 50%;
            width: 60px;
            height: 60px;
            object-fit: cover;
            max-width: 60px;
        }
    </style>
   <div class="container-lg">
        <div class="card border-0">
            <div class="card-body">
                <div class="dropdown text-center mb-3">
                    <button class="btn btn-light dropdown-toggle btn-lg" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        ปี : {{ request()->route()->parameters['rainsRetreat']+543}}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        @foreach ($years as $item)
                            <li><a class="dropdown-item" href="{{ route('rainsRetreat.show',['rainsRetreat'=> $item]) }}">{{ $item+543 }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <form action="{{ route('deleteRainsRetreat') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('DELETE')
                    <div>
                        <div class="text-end fst-italic small">
                            อยู่จำพรรษาทั้งสิ้น : <b>{{ $rainsRetreat->count() }}</b> พระภิกษุ : {{ $m }} สามเณร : {{ $n }}
                        </div>
                        <div>
                            <div class=" list-group list-group-flush">
                                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 justify-content-center overflow-auto" style="max-height: 450px">
                                    @foreach ($rainsRetreat as $key => $item)
                                    <div class="col">
                                        <label class="list-group-item align-items-center mb-2 rounded" style="display: flex">
                                            <input class="form-check-input me-2" type="checkbox" value="{{ $item->id }}" id="person" name="persons[]">
                                            @if ($item->personnel->path != '')
                                                <img src="{{ asset($item->personnel->path) }}" alt="" id="image-cropper">
                                            @else
                                                <img src="{{ asset('storage/person/no.png') }}" alt="" id="image-cropper">
                                            @endif
                                            <a href="{{ route('personnel.show',['personnel'=>$item->personnel->id]) }}" style="text-decoration: none;margin-left: 8px">
                                                {{ $item->personnel->ordain_monk != '' ? 'พระ' : 'สามเณร' }} {{ $item->personnel->name }} <small class="text-muted">{{ $item->personnel->ordianation_name }}</small> {{ $item->personnel->lastname }}
                                            </a>
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row justify-content-end align-items-center">
                                <div class="col col-sm-auto col-md-auto text-end">
                                    <input class="form-check-input" type="checkbox" role="switch" id="personSwitch"  onchange="changSelect('person')" >
                                    <label class="form-check-label" for="flexSwitchCheckDefault">เลือกทั้งหมด</label>
                                </div>
                                <div class="col col-sm-2 col-md-1">
                                    <input type="submit" class="btn btn-outline-danger btn-sm" value="ลบ">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 text-center">
                        <div class="col">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#monkModal">เพิ่มพระภิกษุ</button>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#noviceModal">เพิ่มสามเณร</button>
                        </div>
                    </div>
                </form>
                <div class="row mt-3">
                    @if ($rainsRetreat->total()>$rainsRetreat->perPage())
                        {{ $rainsRetreat->links('pagination::bootstrap-5') }}
                    @endif
                </div>
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
    <!-- Add Monk Modal -->
    <form action="{{ route('rainsRetreat.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="monkModal" tabindex="-1" aria-labelledby="monkModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="monkModalLabel">เพิ่มพระภิกษุ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container overflow-auto" style="max-height: 70%">
                            <div class="form-floating mb-3">
                                @php
                                    $y =strftime("%Y", time())+543;
                                    $years = range($y-300, $y);
                                    $years = array_reverse($years,true);
                                @endphp
                                <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example" name="year" required>
                                    @foreach ($years as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                  </select>
                                  <label for="floatingSelectGrid">ประจำปี</label>
                            </div>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="monkSwitch"  onchange="changSelect('monk')" >
                                <label class="form-check-label" for="flexSwitchCheckDefault">เลือกทั้งหมด</label>
                            </div>
                            @foreach ($monks as $item)
                                <div class="row justify-content-md-center">
                                    <div class="col-2">
                                        <input class="form-check-input" type="checkbox" name="persons[]" value="{{ $item->id }}" id="monk" >
                                    </div>
                                    <div class="col-3">
                                        {{ $item->name }}
                                    </div>
                                    <div class="col-3">
                                        {{ $item->lastname }}
                                    </div>
                                    <div class="col-3">
                                        {{ $item->ordianation_name }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <input type="submit" class="btn btn-primary" value="บันทึก">
                    </div>
                </div>
            </div>
        </div>
    </form>
    {{-- Add Novice Modal --}}
    <form action="{{ route('rainsRetreat.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="noviceModal" tabindex="-1" aria-labelledby="noviceModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="noviceModalLabel">เพิ่มสามเณร</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container overflow-auto" style="max-height: 70%">
                            <div class="form-floating mb-3">
                                @php
                                    $y =strftime("%Y", time())+543;
                                    $years = range($y-300, $y);
                                    $years = array_reverse($years,true);
                                @endphp
                                <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example" name="year" required>
                                    @foreach ($years as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                  </select>
                                  <label for="floatingSelectGrid">ประจำปี</label>
                            </div>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="noviceSwitch" onchange="changSelect('novice')">
                                <label class="form-check-label" for="flexSwitchCheckDefault">เลือกทั้งหมด</label>
                            </div>
                            @foreach ($novices as $item)
                                <div class="row justify-content-md-center">
                                    <div class="col-2">
                                        <input class="form-check-input" type="checkbox" name="persons[]" value="{{ $item->id }}" id="novice">
                                    </div>
                                    <div class="col-3">
                                        {{ $item->name }}
                                    </div>
                                    <div class="col-3">
                                        {{ $item->lastname }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <input type="submit" class="btn btn-primary" value="บันทึก">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        window.onload = (event)=> {
            let myAlert = document.querySelector('.toast');
            let bsAlert = new  bootstrap.Toast(myAlert);
            bsAlert.show();

        }
        function changSelect(id){
            var check = document.querySelectorAll("#"+id);
            var switchCheck = document.getElementById(id+'Switch').checked;
            for (var i = 0; i < check.length; i++) {
                check[i].checked = switchCheck;
            }
        }
    </script>
</x-app-layout>
