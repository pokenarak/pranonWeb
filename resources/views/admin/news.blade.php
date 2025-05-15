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
                    <h2>ประชาสัมพันธ์</h2>
                </div>
                <div class="row row-cols-1 row-cols-md-4 g-4 justify-content-center">
                    @foreach ($news as $item)
                        <div class="col">
                            <div class="card" style="max-width: 300px">
                                <img src={{ asset($item->image) }} class="card-img-top" alt="...">
                                <div class="card-body">
                                    <div style="display: inline-flex">
                                        <h5 class="card-title ">{{ $item->topic }}</h5>:
                                        <small class="text-muted" style="display: contents">{{ \Carbon\Carbon::parse($item->created_at)->addYear(543)->locale('th')->isoFormat('dd D MMM YY') }}</small>
                                    </div>
                                    <p class="card-text" style="max-height: 150px;overflow: auto;">{{ $item->detail }}</p>
                                </div>
                                <div class="card-footer text-muted text-center">
                                    @php
                                        $data = (string)$item->id.','.$item->topic.','.$item->detail.','.$item->image;
                                    @endphp
                                    <form action="{{ route('destroyNews',['id'=>$item->id]) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editNewsModal" data-bs-whatever="{{ $data }}">แก้ไข</button>
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">ลบ</button>
                                    </form>
                                </div>
                                </div>
                        </div>
                    @endforeach
                </div>
                @if ($news->total()>$news->perPage())
                    {{ $news->links('pagination::bootstrap-5') }}
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
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddNewsModal">
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
    {{-- Add News Modal --}}
    <form action="/addNews" method="POST" enctype="multipart/form-data" id="addNews">
        @csrf
        <div class="modal fade" id="AddNewsModal" tabindex="-1" aria-labelledby="AddNewsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="AddNewsModalLabel">เพิ่ม</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" required name="topic">
                            <label for="floatingInput">หัวข้อข่าวประชาสัมพันธ์</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 300px" name="detail"></textarea>
                            <label for="floatingTextarea2">รายละเอียด</label>
                        </div>
                        <div class="mb-3">
                            <input class="form-control" type="file" id="formFile" accept="image/png, image/jpeg, image/jpg" name="image" required>
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
    <form action="/updateNews" method="POST" enctype="multipart/form-data" id="editNews">
        @csrf
        @method('PUT')
        <div class="modal fade" id="editNewsModal" tabindex="-1" aria-labelledby="editNewsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="editNewsModalLabel">แก้ไข</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="hidden" name="id" id="id">
                            <input type="text" class="form-control" id="topic" placeholder="name@example.com" required name="topic">
                            <label for="floatingInput">หัวข้อข่าวประชาสัมพันธ์</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" placeholder="Leave a comment here" id="detail" style="height: 300px" name="detail"></textarea>
                            <label for="floatingTextarea2">รายละเอียด</label>
                        </div>
                        <div class="mb-3">
                            <input class="form-control" type="file" id="file" accept="image/png, image/jpeg, image/jpg" name="image">
                            <img src="" id="imageFile" class="img-thumbnail" alt="..." width="200px">
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
        var editNewsModal = document.getElementById('editNewsModal')
        editNewsModal.addEventListener('show.bs.modal', function (event) {
            // Button that triggered the modal
            var button = event.relatedTarget
            // Extract info from data-bs-* attributes
            var recipient = button.getAttribute('data-bs-whatever')
            var textArray = recipient.split(',');
            editNewsModal.querySelector('.modal-body #id').value = textArray[0];
            editNewsModal.querySelector('.modal-body #topic').value = textArray[1];
            editNewsModal.querySelector('.modal-body #detail').value = textArray[2];
            editNewsModal.querySelector('.modal-body #imageFile').src = textArray[3];
        })
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script>
        $(function () {
            $(document).ready(function () {
                $('#addNews, #editNews').ajaxForm({
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
