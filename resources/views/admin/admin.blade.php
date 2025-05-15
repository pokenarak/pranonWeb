<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}
    <div class="container-lg">
        <div class="card border-0 mb-4">
            <div class="card-body">
                <div class="pb-4 mt-2 text-center">
                    <h2>ผู้ดูแลระบบ</h2>
                </div>
                <div class="container mb-3">
                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        @foreach ($admin as $item)
                            <div class="col">
                                <div class="card rounded-4">
                                    @if ($image = $item->profile_photo_path)
                                        <img src="{{ asset('images/'.$image) }}" class="card-img-top">
                                    @endif
                                    <div class="card-body">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $item->name }}
                                            @if ($item->trashed())
                                                <span class="badge text-bg-danger rounded-pill">ถูกระงับการใช้งาน</span>
                                            @endif
                                        </li>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">{{ $item->email }}</li>
                                        <li class="list-group-item">{{ $item->role }}</li>
                                        @if($name = $item->personnel)
                                            <li class="list-group-item">{{ $name->name }} <small>{{ $name->lastname }}</small></li>
                                        @endif
                                    </ul>
                                    <div class="card-body text-center">
                                        <form action="{{ route('admin.destroy',$item->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @if ($item->role !== 'SUPER_ADMIN')
                                                @if ($item->trashed())
                                                    @method('GET')
                                                    <a href="{{ route('admin.show',$item->id) }}" class="btn btn-outline-warning">กู้คืน</a>
                                                @else
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger">ระงับการใช้งาน</button>
                                                @endif
                                            @else
                                                <a href="#" class="btn btn-outline-danger disabled">ลบ</a>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="modal fade" id="AddAdminModal" tabindex="-1" aria-labelledby="AddAdminModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="modal-header bg-primary text-white">
                                <h1 class="modal-title fs-5" id="AddAdminModalLabel">เพิ่มผู้ดูแลระบบ</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email" required>
                                    <label for="floatingInput">อีเมลล์</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" required>
                                    <label for="floatingPassword">รหัสผ่าน</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="name" required>
                                    <label for="floatingInput">ชื่อทั่วไป(นามแฝง)</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="role" required>
                                            <option value="ADMIN">ผู้ดูแลทั่วไป</option>
                                            <option value="NEWS">ประชาสัมพันธ์</option>
                                            <option value="SCHOOL">สำนักเรียน</option>
                                    </select>
                                    <label for="floatingSelect">ประเภทผู้ดูแล</label>
                                </div>
                                <div class="form-floating">
                                    <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="personnel_id">
                                        <option selected>เลือกเจ้าของบัญชี</option>
                                        @foreach ($persons as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }} <small>{{ $item->lastname }}</small></option>
                                        @endforeach
                                    </select>
                                    <label for="floatingSelect">กรุณาเลือก</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                <button type="submit" class="btn btn-primary">เพิ่ม</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-0 mt-3">
            <div class="card-body d-grid gap-1">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddAdminModal">
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
    <script>
        window.onload = (event)=> {
            let myAlert = document.querySelector('.toast');
            let bsAlert = new  bootstrap.Toast(myAlert);
            bsAlert.show();
        }
    </script>
</x-app-layout>
