<x-app-layout>
    <div class="container-lg">
        <div class="card border-0">
            <div class="card-body">
                <div class="pb-4 text-center">
                    <h2>{{ $pilgrimage->name }}</h2>
                </div>
                <div class="card border-0">
                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <ul class="list-group list-group-flush ">
                                        @foreach ($pilgrimage->stop as $index => $item)
                                            <a href="{{ route('stopImage.edit',['stopImage'=>$item->id]) }}" style="text-decoration: none" class="list-group-item list-group-item-action">
                                                <input class="form-check-input me-1" type="radio" name="listGroupRadio" value="{{ $index }}" id="{{ $index }}" {{ URL::current()==route('stopImage.edit',['stopImage'=> $item->id])?'checked':'' }}>
                                                <label class="form-check-label" for="firstRadio">{{ $item->detail }}</label>
                                            </a>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="col-md-9">
                                    <form action="{{ route('stopImage.update',['stopImage'=>$stop->id]) }}" method="POST" enctype="multipart/form-data" id="addStopImage">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-floating">
                                            <input class="form-control" type="text" id="destination" placeholder="สถานที่" required value="{{ $stop->detail }}" name="destination">
                                            <label for="floatingInputGrid">สถานที่</label>
                                        </div>
                                        <div class="form-floating mt-3">
                                            <input class="form-control" type="date" id="date" placeholder="วันที่" required value="{{ $stop->date }}" name="date">
                                            <label for="floatingInputGrid">วันที่</label>
                                        </div>
                                        @if ($stop->stopImage->count()>0)
                                            <div class="contrainer mb-3">
                                                <small class="text-muted">เลือกเพื่อลบ</small>
                                                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-5">
                                                    @foreach ($stop->stopImage as $image)
                                                        <div class="col">
                                                            <input type="checkbox" class="form-check-input" name="deleteImage[]" value="{{ $image->id }}">
                                                            <img src="{{ asset($image->path) }}" alt="">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                        <div class="mb-3">
                                            <small class="text-muted">เพิ่มรูปภาพ</small>
                                            <input class="form-control" type="file" id="formFile" accept="image/png, image/jpeg, image/jpg" name="image[]" multiple>
                                        </div>
                                        <div class="text-center">
                                            <a class="btn btn-outline-secondary" href="{{ route('pilgrimage.edit',['pilgrimage'=>$pilgrimage->id]) }}" role="button">กลับ</a>
                                            <input type="submit" class="btn btn-warning" value="แก้ไข">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @include('layouts.progressBar')
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
    <script>
        window.onload = (event)=> {
            let myAlert = document.querySelector('.toast');
            let bsAlert = new  bootstrap.Toast(myAlert);
            bsAlert.show();
        }
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        })
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script>
        $(function () {
            $(document).ready(function () {
                $('#addStopImage').ajaxForm({
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
