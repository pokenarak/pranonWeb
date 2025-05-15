
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
                <div class="container">
                    <div class="text-end fst-italic small">
                        @php
                            $countNovice = $n->count();
                            $countMonk = $m->count();
                        @endphp
                        อยู่จำพรรษาทั้งสิ้น : <b>{{ $countNovice+$countMonk}}</b> พระภิกษุ : {{ $countMonk }} สามเณร : {{ $countNovice }}
                    </div>
                    <div class="row">
                        <div class="col-6">
                            @php
                                $persons = $m;
                                $type = 'm';
                            @endphp
                            @include('layouts.personRainsRetreat')
                        </div>
                        <div class="col-6">
                            @php
                                $persons = $n;
                                $type = 'n';
                            @endphp
                            @include('layouts.personRainsRetreat')
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
                                    @if ($item->rank->count()>0)
                                        <div class="class col-9">
                                            {{ $item->lastestRank->name }}
                                        </div>
                                    @else
                                        <div class="col-3">
                                            {{ $item->name }}
                                        </div>
                                        <div class="col-3">
                                            {{ $item->lastname }}
                                        </div>
                                        <div class="col-3">
                                            {{ $item->ordianation_name }}
                                        </div>
                                    @endif

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
