<x-app-layout>
    <div class="container-lg">
        <div class="card border-0">
            <div class="card-body">
                <div class="pb-4 mt-2 text-center">
                    <h2>นักเรียน</h2>
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
                                            <li><a class="dropdown-item" href="{{ route('student',['year'=> $year->year]) }}">{{ $year->year+543 }}</a></li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-end mb-2">
                    <a class="btn btn-primary btn-sm" href="{{ route('exportPali',['year'=>request()->route()->parameter('year'),'type'=>'บาลี' ]) }}" role="button" style="display: inline-flex">
                        <img src="{{ url('images/icon/save.svg') }}" alt="" style="filter: invert(1)"> บาลี
                    </a>
                    <a class="btn btn-primary btn-sm" href="{{ route('exportPali',['year'=>request()->route()->parameter('year'),'type'=>'ธรรม' ]) }}" role="button" style="display: inline-flex">
                        <img src="{{ url('images/icon/save.svg') }}" alt="" style="filter: invert(1)"> ธรรม
                    </a>
                </div>
                <div class="accordion mb-3 overflow-auto" id="accordionExample" style="max-height: 70vh">
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
                                                ห้อง {{ $course->room }}
                                            </div>
                                            <div class="col">
                                                <span class="badge rounded-pill bg-info text-dark">จำนวน : {{ $course->register->count() }}</span>
                                                <span class="badge rounded-pill bg-success">ผ่าน : {{ $course->register_count  }}</span>
                                                <span class="badge rounded-pill bg-danger">ไม่ผ่าน : {{ $course->register->count() - $course->register_count  }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapse{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $index }}" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <form action="/destroyStudent" method="POST">
                                        @csrf
                                        <div class="list-group list-group-flush">
                                            <input type="hidden" name="id" value="{{ $course->id }}">
                                            @foreach ($course->register as $student)
                                                @php
                                                    
                                                    $flag = '';
                                                    if(!$student->personnel->ordain_monk && !$student->personnel->ordain_novice){
                                                        $flag = 'คุณ';
                                                    }
                                                    else if(Str::length($student->personnel->ordain_monk)>0){
                                                        $flag = 'พระ';
                                                    }else {
                                                        $flag = 'สามเณร';
                                                    }
                                                    $id = $student->id;
                                                    $result = $student->result;
                                                    $detail = $student->detail;
                                                    $data = $id.','.$result.','.$detail;
                                                @endphp
                                                <label class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <input class="form-check-input" type="checkbox" name="student[]" value="{{ $student->personnel_id }}" id="flexCheckDefault">
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="fw-bold">{{ $flag }}{{ $student->personnel->name }} <small>{{ $student->personnel->lastname }}</small> {{ $student->personnel->ordianation_name}}</div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <span class="{{ $student->result !='' ? 'badge bg-success' : 'badge bg-danger' }} rounded-pill">{{ $student->result !=''? $student->result:'ไม่ผ่าน' }}</span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#EditStudentModal" data-bs-whatever="{{ $data }}">แก้ไข</button>
                                                        </div>
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>
                                        @php
                                            if($course->supject->type ==='บาลี'){
                                                $idDiv = 'Pali';
                                            }else {
                                                $idDiv = 'Dham';
                                            }
                                            
                                        @endphp
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="{{ '#AddStudentModal'.$idDiv  }}" data-bs-whatever="{{ $course->id }}">
                                            เพิ่มนักเรียน
                                        </button>
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#AddCourse">
                                            ลบนักเรียน
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
    {{-- Add Student Pali --}}
    <form action="/addStudent" method="POST">
        @csrf
        <div class="modal fade" id="AddStudentModalPali" tabindex="-1" aria-labelledby="AddStudentModalPaliLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title"> เพิ่มนักเรียนบาลี</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">ภิกษุ</button>
                                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">สามเณร</button>
                                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">อุบาสกอุบาสิกา</button>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                                    @php
                                        $persons = $monkPali;
                                    @endphp
                                    @include('layouts.studentList')
                                </div>
                                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                                    @php
                                        $persons = $novicePali;
                                    @endphp
                                    @include('layouts.studentList')
                                </div>
                                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
                                    @php
                                        $persons = $nunPali;
                                    @endphp
                                    @include('layouts.studentList')
                                </div>
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

    {{-- Add Student Dhamma --}}
    <form action="/addStudent" method="POST">
        @csrf
        <div class="modal fade" id="AddStudentModalDham" tabindex="-1" aria-labelledby="AddStudentModalDhamLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title"> เพิ่มนักเรียนนักธรรม</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id">
                            <nav>
                                <div class="nav nav-tabs" id="nav-t" role="tablist">
                                    <button class="nav-link active" id="monkDhamma-tab" data-bs-toggle="tab" data-bs-target="#monkDhamma" type="button" role="tab" aria-controls="monkDhamma" aria-selected="true">ภิกษุ</button>
                                    <button class="nav-link" id="noviceDhamma-tab" data-bs-toggle="tab" data-bs-target="#noviceDhamma" type="button" role="tab" aria-controls="noviceDhamma" aria-selected="false">สามเณร</button>
                                    <button class="nav-link" id="nunDhamma-tab" data-bs-toggle="tab" data-bs-target="#nunDhamma" type="button" role="tab" aria-controls="nunDhamma" aria-selected="false">อุบาสกอุบาสิกา</button>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tContent">
                                <div class="tab-pane fade show active" id="monkDhamma" role="tabpanel" aria-labelledby="monkDhamma-tab" tabindex="0">
                                    @php
                                        $persons = $monkDhamma;
                                    @endphp
                                    @include('layouts.studentList')
                                </div>
                                <div class="tab-pane fade" id="noviceDhamma" role="tabpanel" aria-labelledby="noviceDhamma-tab" tabindex="0">
                                    @php
                                        $persons = $noviceDhamma;
                                    @endphp
                                    @include('layouts.studentList')
                                </div>
                                <div class="tab-pane fade" id="nunDhamma" role="tabpanel" aria-labelledby="nunDhamma-tab" tabindex="0">
                                    @php
                                        $persons = $nunDhamma;
                                    @endphp
                                    @include('layouts.studentList')
                                </div>
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
    {{-- Edit Student --}}
    <form action="/updateStudent" method="post">
        @csrf
        @method('PUT')
        <div class="modal fade" id="EditStudentModal" tabindex="-1" aria-labelledby="EditStudentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="EditStudentModalLabel">แก้ไขนักเรียน</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="hidden" name="id" id="id">
                            <label for="result" class="col-form-label">เลขที่ใบประกาศ(สอบผ่าน)</label>
                            <input type="text" class="form-control" id="result" name="result">
                        </div>
                        <div class="mb-3">
                            <label for="detail" class="col-form-label">รายละเอียด</label>
                            <input type="text" class="form-control" id="detail" name="detail" >
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
        var AddStudentModal = document.getElementById('AddStudentModalPali')
        AddStudentModal.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
            var button = event.relatedTarget
            // Extract info from data-bs-* attributes
            var recipient = button.getAttribute('data-bs-whatever')

            AddStudentModal.querySelector('.modal-body #id').value = recipient;
        })
        var AddStudentModalDhamma = document.getElementById('AddStudentModalDham')
        AddStudentModalDhamma.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
            var button = event.relatedTarget
            // Extract info from data-bs-* attributes
            var recipient = button.getAttribute('data-bs-whatever')

            AddStudentModalDhamma.querySelector('.modal-body #id').value = recipient;
        })

        var EditStudentModal = document.getElementById('EditStudentModal')
        EditStudentModal.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
            var button = event.relatedTarget
            // Extract info from data-bs-* attributes
            var recipient = button.getAttribute('data-bs-whatever');
            var textArray = recipient.split(',');
            EditStudentModal.querySelector('.modal-body #id').value = textArray[0];
            EditStudentModal.querySelector('.modal-body #result').value = textArray[1];
            if(textArray[2].length>0)
            {
                EditStudentModal.querySelector('.modal-body #detail').value = textArray[2];
            }
        })
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
</x-app-layout>
