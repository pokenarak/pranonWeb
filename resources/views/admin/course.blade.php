<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    <div class="container-lg">
        <div class="card border-0">
            <div class="card-body">
                <div class="pb-4 mt-2 text-center">
                    <h2>ครูสอน</h2>
                </div>
                <div class="container mb-3">
                    <div class="row justify-content-center">
                        <div class="col-6 align-self-center text-center">
                            <div class="dropdown">
                                @if ($years->count() > 0)
                                    <button class="btn btn-light dropdown-toggle btn-lg" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        ปีการศึกษา : {{ request()->route()->parameters['year'] == 0 ? $years[0]['year']+543 : request()->route()->parameters['year']+543}}
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        @foreach ($years as $year)
                                            <li><a class="dropdown-item" href="{{ route('course',['year'=> $year->year]) }}">{{ $year->year+543 }}</a></li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion mb-3" id="accordionExample">
                    @foreach ($courses as $index => $course)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $index }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="false" aria-controls="collapse{{ $index }}">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col">
                                                {{ $course->supject->name }}
                                            </div>
                                            <div class="col">
                                                ห้อง {{ $course->room}}
                                            </div>
                                        </div>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapse{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $index }}" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <ul class="list-group list-group-flush">
                                        @foreach ($course->teacher as $teacher)
                                            <li class="list-group-item">
                                                <form action="{{ route('destroyTeacher',$teacher->id) }}" method="POST">
                                                    @csrf
                                                    <div class="row justify-content-around">
                                                        <div class="col-md-4">{{ $teacher->personnel->name }}  {{ $teacher->personnel->ordianation_name }}</div>
                                                        <div class="col-md-2">{{ $teacher->detail }}</div>
                                                        @php
                                                            $id = $teacher->id;
                                                            $person = $teacher->personnel_id;
                                                            $detail = $teacher->detail;
                                                            $data= (string)$id.','.$person.','.$detail;
                                                        @endphp
                                                        <div class="col-md-2"><button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editTeacherModal" data-bs-whatever="{{ $data }}">แก้ไข</button></div>
                                                        @method('DELETE')
                                                        <div class="col-md-2"><button type="submit" class="btn btn-outline-danger btn-sm">ลบ</button></div>
                                                    </div>
                                                </form>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <form action="{{ route('destroyCourse',$course->id) }}" method="POST">
                                        @csrf
                                        @php
                                            $id = $course->id;
                                            $supject = $course->supject_id;
                                            $room = $course->room;
                                            $year= $course->year;
                                            $data= (string)$id.','.$supject.','.$room.','.$year;
                                        @endphp
                                        <button type="button" class="btn btn-warning " data-bs-toggle="modal" data-bs-target="#editCourseModal" data-bs-whatever="{{ $data }}">แก้ไข</button>
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">ลบ</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="card border-0 mt-3">
            <div class="card-body d-grid gap-1">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddCourse">เพิ่ม</button>
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
    {{-- Add Course --}}
    <form action="/addCourse" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="AddCourse" tabindex="-1" aria-labelledby="AddCourseLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="AddCourseLabel">เพิ่มครูสอน</h5>
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
                                    <input type="text" class="form-control" id="floatingInput" placeholder="ก,ข" name="room" required>
                                    <label for="floatingInput">ชื่อห้อง</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="person">
                                <option selected value="">เลือกครูสอน</option>
                                @foreach ($persons as $person)
                                    @php
                                        $flag = '';
                                        if(Str::length($person->ordain_monk)>0){
                                            $flag = 'พระ';
                                        }else if(Str::length($person->ordain_novice)>0){
                                            $flag = 'สามเณร';
                                        }else{
                                            $flag = 'คุณ';
                                        }
                                    @endphp
                                    <option value="{{ $person->id }}">{{ $flag }} {{ $person->name }} {{ $person->ordianation_name }} {{ $person->lastname }}</option>
                                @endforeach
                            </select>
                            <label for="floatingSelect">ครูสอน</label>
                            {{-- <small class="text-muted">ต้องเพิ่มตำแหน่ง "ครูสอน" ในข้อมูลบุคลากร</small> --}}
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="detail">
                                <option selected value="">เลือกตำแหน่ง</option>
                                <option value="ครูสอน">ครูสอน</option>
                                <option value="ครูช่วยสอน">ครูช่วยสอน</option>
                                <option value="กองตรวจ">กองตรวจ</option>
                            </select>
                            <label for="floatingSelect">ตำแหน่ง</label>
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
    {{-- Edit Course --}}
    <form action="{{ route('updateCourse') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="editCourseModalModalLabel">แก้ไข</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="yearInput" placeholder="name@example.com" name="year" required>
                            <label for="yearInput">ปีการศึกษา</label>
                        </div>
                        <div class="row">
                            <div class="col-7">
                                <div class="form-floating mb-3">
                                    <input type="hidden" name="id" id="id">
                                    <select class="form-select" id="supjectSelect" aria-label="Floating label select example" name="supject" required>
                                        <option selected>เลือกวิชา</option>
                                        @foreach ($supjects as $supject)
                                            <option value="{{ $supject->id }}">{{ $supject->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="supjectSelect">วิชา</label>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="roomInput" placeholder="ก,ข" name="room" required >
                                    <label for="floatingInput">ชื่อห้อง</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <input type="submit" class="btn btn-warning" value="แก้ไข">
                    </div>
              </div>
            </div>
          </div>
    </form>
    {{-- Edit Teacher --}}
    <form action="{{ route('updateTeacher') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal fade" id="editTeacherModal" tabindex="-1" aria-labelledby="editTeacherModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTeacherModalLabel">แก้ไข</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="hidden" name="id" id="id">
                            <select class="form-select" id="personSelect" aria-label="Floating label select example" name="person" required>
                                <option selected>เลือกครูสอน</option>
                                @foreach ($persons as $person)
                                    <option value="{{ $person->id }}">{{ $person->name }} {{ $person->ordianation_name }}</option>
                                @endforeach
                            </select>
                            <label for="personSelect">ครูสอน</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="detailSelect" aria-label="Floating label select example" name="detail" required>
                                <option selected>เลือกตำแหน่ง</option>
                                <option value="ครูสอน">ครูสอน</option>
                                <option value="ครูช่วยสอน">ครูช่วยสอน</option>
                                <option value="กองตรวจ">กองตรวจ</option>
                            </select>
                            <label for="detailSelect">ตำแหน่ง</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <input type="submit" class="btn btn-warning" value="แก้ไข">
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
        var editCourseModal = document.getElementById('editCourseModal')
        editCourseModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget
            var recipient = button.getAttribute('data-bs-whatever')
            var textArray = recipient.split(',');
            editCourseModal.querySelector('.modal-body #id').value = textArray[0];
            editCourseModal.querySelector('.modal-body #supjectSelect').value = textArray[1];
            editCourseModal.querySelector('.modal-body #roomInput').value = textArray[2];
            editCourseModal.querySelector('.modal-body #yearInput').value = Number(textArray[3])+543;
        })

        var editTeacherModal = document.getElementById('editTeacherModal')
        editTeacherModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget
            var recipient = button.getAttribute('data-bs-whatever')
            var textArray = recipient.split(',');
            editTeacherModal.querySelector('.modal-body #id').value = textArray[0];
            editTeacherModal.querySelector('.modal-body #personSelect').value = textArray[1];
            editTeacherModal.querySelector('.modal-body #detailSelect').value = textArray[2];
        })
    </script>
</x-app-layout>
