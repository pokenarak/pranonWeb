<x-app-layout>

    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}
    <div class="container-lg">
        <div class="card border-0">
            <div class="card-body">
                <div class="pb-4 text-center">
                    <h2>กิจกรรม</h2>
                </div>
                <div class="dropdown text-center mb-3">
                    <button class="btn btn-light dropdown-toggle btn-lg" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        ปี : {{ request()->route()->parameters['year'] == 0 ? 'ทั้งหมด': request()->route()->parameters['year']+543  }}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="{{ route('activity',['year'=> '0']) }}">ทั้งหมด</a></li>
                        @foreach ($years as $item)
                            <li><a class="dropdown-item" href="{{ route('activity',['year'=> $item->year]) }}">{{ $item->year+543 }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="row justify-content-center" >
                    @foreach ($activities as $i => $item)
                        <div class="col col-md-auto m-2 pb-2">
                            <div class="card mt-3" style="max-width: 300px">
                                @if ($image = $item->lastestImage)
                                    <div style="max-height: 180px;overflow: hidden;max-width: 100%" class="rounded">
                                        <img src="{{ asset($image->path) }}">
                                    </div>
                                @endif
                                <div class="card-body">
                                    <div style="display: inline-flex">
                                        <h5 class="card-title text-primary">{{ $item->topic }}</h5>:
                                        <small class="text-muted" style="display: contents">{{ \Carbon\Carbon::parse($item->date)->addYear(543)->locale('th')->isoFormat('dd D MMM YY') }}</small>
                                    </div>
                                    <p class="card-text" style="text-overflow: ellipsis;overflow: hidden;white-space: nowrap;">{{ $item->detail }}</p>
                                </div>
                                <div class="text-center mb-2">
                                    <form action="{{ route('destroyActivity',['id'=>$item->id]) }}" method="post">
                                        @csrf
                                        <a href="{{ route('editActivity',['id'=>$item->id]) }}" class="btn btn-outline-warning btn-sm">แก้ไข</a>
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">ลบ</button>
                                    </form>
                                </div>
                                <div class="card-footer text-center">
                                    <span class="badge text-bg-info">{{ $item->type }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if ($activities->total()>$activities->perPage())
                    {{ $activities->links('pagination::bootstrap-5') }}
                @endif
                <div class="form-group mt-3" id="progressBar" style="display: none">
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-0 mt-3">
            <div class="card-body d-grid gap-1">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddActivityModal">
                    เพิ่ม
                </button>
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
    {{-- Add Activity Modal --}}
    <form action="/addActivity" method="post" enctype="multipart/form-data" id="addActivity">
        @csrf
        <div class="modal fade" id="AddActivityModal" tabindex="-1" aria-labelledby="AddActivityModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="AddActivityModalLabel">เพิ่มกิจกรรม</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" required name="topic">
                            <label for="floatingInput">ชื่อกิจกรรม</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" name="date" id="">
                            <label for="inputBirthday">วันที่</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" name="detail"></textarea>
                            <label for="floatingTextarea2">รายละเอียด</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name='type'>
                                <option value="การศึกษา">การศึกษา</option>
                                <option value="เผยแพร่">เผยแพร่</option>
                                <option value="วัฒนธรรมและประเพณี">วัฒนธรรมและประเพณี</option>
                                <option value="ศาสนสงเคราะห์">ศาสนสงเคราะห์</option>
                            </select>
                            <label for="floatingSelect">ประเภทกิจกรรม</label>
                        </div>
                        <div class="mb-3">
                            <input class="form-control" type="file" id="formFile" accept="image/png, image/jpeg, image/jpg" name="image[]" multiple>
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
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script>
        $(function () {
            $(document).ready(function () {
                $('#addActivity').ajaxForm({
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
                        location.reload();
                    }
                });
            });
        });
    </script>
</x-app-layout>
