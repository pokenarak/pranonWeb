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
                    <h2>ตำแหน่งบุคลากร</h2>
                </div>
                <ul class="list-group list-group-flush">
                    @foreach ($type as $index => $item)
                        <li class="list-group-item">
                            <form action="{{ route('destroyPersonnelType',$item->id) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-1">
                                        {{ $index+1 }}
                                    </div>
                                    <div class="col-md-7">
                                        {{ $item->name }}
                                    </div>
                                    @php
                                        $flag =(string)$item->id." ".$item->name;
                                    @endphp
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editType" data-bs-whatever="{{ $flag }}">แก้ไข</button>
                                    </div>
                                    @method('DELETE')
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-outline-danger btn-sm">ลบ</button>
                                    </div>
                                </div>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="card border-0 mt-3">
            <div class="card-body d-grid gap-1">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addType" >เพิ่ม</button>
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
    <!-- Modal Add Type -->
    <form action="/addPersonnelType" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="modal fade" id="addType" tabindex="-1" aria-labelledby="addTypeLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="exampleModalLabel">เพิ่มตำแหน่งบุคลากร</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="" class="form-label">ชื่อตำแหน่ง</label>
                            <input type="text" class="form-control" name="name" id="name" aria-describedby="helpId" placeholder="เจ้าอาวาส" required>
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
    {{-- Modal Edit Type --}}
    <form action="/updatePersonnelType" method="post" enctype="multipart/form-data">
    @csrf
        @method('PUT')
        <div class="modal fade" id="editType" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">แก้ไขตำแหน่งบุคลากร</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                            <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">ตำแหน่งบุคลากร</label>
                            <input type="text" class="form-control" id="name" name="name">
                            <input type="hidden" name="id" id="id">
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-warning">แก้ไข</button>
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
        var editType = document.getElementById('editType')
        editType.addEventListener('show.bs.modal', function (event) {
            // Button that triggered the modal
            var button = event.relatedTarget
            // Extract info from data-bs-* attributes
            var recipient = button.getAttribute('data-bs-whatever')
            // If necessary, you could initiate an AJAX request here
            // and then do the updating in a callback.
            //
            // Update the modal's content.
            var nameInput = editType.querySelector('.modal-body #name')
            var idInput = editType.querySelector('.modal-body #id')
            const textArray = recipient.split(" ");
            nameInput.value = textArray[1];
            idInput.value = textArray[0];
        })
    </script>
</x-app-layout>
