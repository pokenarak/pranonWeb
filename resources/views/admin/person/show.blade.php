<x-app-layout>
    <div class="container-lg">
        <div class="card border-0">
            <div class="row g-0">
                <div class="col-md-4 text-center">
                    <div class="row">
                        @if ($person->path != '')
                            <img src="{{ asset($person->path) }}" alt="" class=" rounded" style="filter: grayscale({{ $person->active == 1 ? '0%' : '100%' }})">
                        @else
                            <img src="{{ url('images/person/no.png') }}" alt="" class=" rounded" style="filter: grayscale({{ $person->active == 1 ? '0%' : '100%' }});">
                        @endif
                    </div>
                    @if ($files)
                        <div class="row g-2">
                            <small>อัลบั้มรูป</small> 
                            @foreach ($files as $item)
                                <div class="col-3">
                                    <img src="{{ asset('images/'.$item) }}" alt="" data-bs-toggle="modal" data-bs-target="#showImage" data-bs-whatever="{{ $person->path }}">
                                </div> 
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="fw-bold">{{ $person->name }} <small class="text-muted">{{ $person->lastname }}</small> {{ $person->ordianation_name }}</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h5 class="text-primary ">
                                    @if ($person->type->count()>0)
                                        @foreach ($person->type as $type)
                                            {{ $type->personnel_type->name }}
                                        @endforeach
                                    @endif
                                </h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 ml-4">
                                @if ($person->rank->count()>0)
                                    {{ $person->lastestRank->name }}
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><b>อายุ</b> : {{ Carbon\Carbon::parse($person->birthday)->age }}</li>
                                    <li class="list-group-item"><b>พรรษา</b> : {{ Carbon\Carbon::parse($person->ordain_monk)->age }}</li>
                                    <li class="list-group-item"><b>เลชประจำตัวประชน</b> : {{ $person->people_id }}</li>
                                    <li class="list-group-item"><b>วันเกิด</b> : {{ \Carbon\Carbon::parse($person->birthday)->addYear(543)->locale('th')->isoFormat('dddd ที่ D เดือนMMMM พ.ศ.YYYY') }}</li>
                                    @php
                                        $type = 'nun';
                                    @endphp
                                    @if ($person->ordain_novice)
                                        <li class="list-group-item bg-warning-subtle"><b>วันบรรพชา</b> : {{ \Carbon\Carbon::parse($person->ordain_novice)->addYear(543)->locale('th')->isoFormat('dddd ที่ D เดือนMMMM พ.ศ.YYYY') }}</li>
                                        @php
                                            $type = 'novice';
                                        @endphp
                                    @endif
                                    @if ($person->ordain_monk)
                                        <li class="list-group-item bg-warning"><b>วันอุปสมบท</b> : {{ \Carbon\Carbon::parse($person->ordain_monk)->addYear(543)->locale('th')->isoFormat('dddd ที่ D เดือนMMMM พ.ศ.YYYY') }}</li>
                                        @php
                                            $type = 'monk';
                                        @endphp
                                    @endif
                                    @if ($person->ordain_nun)
                                        <li class="list-group-item bg-info-subtle"><b>วันรับศีล๘</b> : {{ \Carbon\Carbon::parse($person->ordain_nun)->addYear(543)->locale('th')->isoFormat('dddd ที่ D เดือนMMMM พ.ศ.YYYY') }}</li>
                                        @php
                                            $type = 'nun';
                                        @endphp
                                    @endif
                                    <li class="list-group-item"><b>ที่อยู่</b> : {{ $person->address }}</li>
                                    <li class="list-group-item"><b>เบอร์โทร</b> : {{ $person->phone }}</li>
                                    <li class="list-group-item"><b>วัดเดิม</b> : {{ $person->old_temple_name }}</li>
                                    <li class="list-group-item"><b>ติดต่อวัดเดิม</b> : {{ $person->old_temple_tel }}</li>
                                    <li class="list-group-item"><b>สถานะ</b> : {{ $person->active == 1 ? 'ปกติ' : 'ย้ายไปที่อื่น หรือ ลาสิกขา' }}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="row m-2">
                            <h4>
                                ประวัติการศึกษา
                            </h4>
                            <ul class="list-group list-group-flush">
                                @foreach ($success as $item)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $item->course->supject->name }}
                                        <span class="badge text-bg-primary rounded-pill">{{ $item->course->year+543 }}</span>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="card border-0 mt-3">
                                <div class="card-body d-grid gap-1">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddCourse">เพิ่มการศึกษานอกวัด</button>
                                </div>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-12">
                                <form action="{{ route('personnel.destroy',['personnel'=> $person->id]) }}" method="POST">
                                    @csrf
                                    <a class="btn btn-outline-primary" href="{{ route('person',['type'=>$type]) }}" role="button">กลับ</a>
                                    <a class="btn btn-outline-warning" href="{{ route('personnel.edit',['personnel'=>$person->id]) }}" role="button">แก้ไข</a>
                                    @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">ลบ</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="showImage" tabindex="-1" aria-labelledby="showImageLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <img alt="" class="imageShow">
                </div>
                <div class="modal-footer">
                    <a class="btn btn-danger" href="" id="deleteImage">ลบรูปภาพ</a>
                </div>
            </div>
            
        </div>
    </div>
    @include('layouts.alert')
    <form action="/addNonFormal" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="AddCourse" tabindex="-1" aria-labelledby="AddCourseLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="AddCourseLabel">เพิ่มการศึกษา</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            @php
                                $date = Carbon\Carbon::now()->addYear(543)->locale('th')->year;
                                $i =1;
                            @endphp
                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="year" required>
                                <option selected>{{ $date }}</option>
                                @while ($i<100)
                                    <option value="{{ $date-$i }}">{{ $date-$i }}</option>
                                    @php
                                        $i++;
                                    @endphp
                                @endwhile

                            </select>
                            <label for="floatingSelect">ปี</label>
                        </div>
                        <div class="row">
                            <div class="col-7">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="supject" required>
                                        <option selected>เลือกวิชา</option>
                                        @foreach ($supjects as $supject)
                                            <option value="{{ $supject->id }}">{{ $supject->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="floatingSelect">วิชา</label>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInput" placeholder="125" name="no">
                                    <label for="floatingInput">เลขที่ใบประกาศ</label>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="room" value="นอกวัด">
                        <input type="hidden" name="id" value="{{ $person->id }}">
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
        var exampleModal = document.getElementById('showImage')
        exampleModal.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
            
            var button = event.relatedTarget;
            const recipient = button.getAttribute('data-bs-whatever');
            var img = exampleModal.querySelector('.imageShow');
            var src = button.src;
            img.src = src;
            var url = new URL(src);
            var path = url.pathname.replace('/images/person/',"");
            var pathSplit = path.split('/');
            var id = pathSplit[0];
            var file = pathSplit[1];
            var a = document.getElementById('deleteImage');
            a.href = "/deleteImagePerson/"+id+"/"+file;
            if(url.pathname.replace('/',"") == recipient){
                a.classList.add("disabled");
            }else{
                a.classList.remove("disabled");
            }

        })
    </script>
</x-app-layout>
