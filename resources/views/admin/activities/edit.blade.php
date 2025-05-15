<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    <div class="container-lg">
        <div class="card border-0">
            <div class="card-body">
                <div class="pb-4 text-center" >
                    <h2>แก้ไขกิจกรรม</h2>
                </div>
                <div class="card border-0">
                    <div class="card-body">
                        @foreach ($activities as $item)
                            <form action="/updateActivity" method="post" enctype="multipart/form-data" id="updateActivity">
                                @csrf
                                @method('PUT')
                                <div class="form-floating mb-3">
                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                    <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" required name="topic" value="{{ $item->topic }}">
                                    <label for="floatingInput">ชื่อกิจกรรม</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" name="date" id="" value="{{ $item->date }}">
                                    <label for="inputBirthday">วันที่</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name='type'>
                                        <option value="การศึกษา" {{ $item->type =='การศึกษา'?'selected':'' }}>การศึกษา</option>
                                        <option value="เผยแพร่" {{ $item->type =='เผยแพร่'?'selected':'' }}>เผยแพร่</option>
                                        <option value="วัฒนธรรมและประเพณี" {{ $item->type =='วัฒนธรรมและประเพณี'?'selected':'' }}>วัฒนธรรมและประเพณี</option>
                                        <option value="ศาสนสงเคราะห์" {{ $item->type =='ศาสนสงเคราะห์'?'selected':'' }}>ศาสนสงเคราะห์</option>
                                    </select>
                                    <label for="floatingSelect">ประเภทกิจกรรม</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" name="detail">{{ $item->detail }}</textarea>
                                    <label for="floatingTextarea2">รายละเอียด</label>
                                </div>
                                <div class="contrainer mb-3">
                                    <small class="text-muted">เลือกเพื่อลบ</small>
                                    <div class="list-group">
                                        <div class="row">
                                            @foreach ($item->image as $image)
                                                <div class="col-md-2">
                                                    <label class="list-group-item border-0">
                                                        <input type="checkbox" class="form-check-input" name="deleteImage[]" value="{{ $image->id }}">
                                                        <img src="{{ url($image->path) }}" alt="">
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">เพิ่มรูปภาพ</small>
                                    <input class="form-control" type="file" id="formFile" accept="image/png, image/jpeg, image/jpg" name="image[]" multiple>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-warning" >แก้ไข</button>
                                </div>
                            </form>
                        @endforeach
                        @include('layouts.progressBar')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="position-fixed bottom-0 end-0 p-3 bg-wa" style="z-index: 11;display: none" id="alert">
        <div class="toast align-items-center bg-warning" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    แก้ไขข้อมูลกิจกรรมเรียบร้อย
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <script>
        window.onload = (event)=> {
            let myAlert = document.querySelector('.toast');
            let bsAlert = new  bootstrap.Toast(myAlert);
            bsAlert.show();
        }
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script>
        $(function () {
            $(document).ready(function () {
                $('#updateActivity').ajaxForm({
                    beforeSend: function () {
                        $('#progressBar').css('display','block');
                        var percentage = '0';
                    },
                    uploadProgress: function (event, position, total, percentComplete) {
                        var percentage = percentComplete;
                        $('.progress .progress-bar').css("width", percentage+'%', function() {
                          return $(this).attr("aria-valuenow", percentage) + "%";
                        })
                    },
                    complete: function (xhr) {
                        $('#alert').show();
                        setTimeout(function () {
                            window.location.reload();
                        }, 800);

                    }
                });
            });
        });
    </script>
</x-app-layout>
