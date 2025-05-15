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
                    <h2>มหาทานบดี</h2>
                </div>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
                    @foreach ($donation as $i => $item)
                        <div class="col mb-2">
                            <div class="card text-center">
                                <img src="{{ asset('images/'.$item->path) }}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->name }}</h5>
                                    <div class="card-text">{{ $item->detail }}</div>
                                    <div class="card-text"><small class="text-body-secondary fst-italic">{{ \Carbon\Carbon::parse($item->date)->addYear(543)->locale('th')->isoFormat('dddd D MMMM YYYY') }}</small></div>
                                </div>
                                <div class="card-footer">
                                    <form action="{{ route('donation.destroy',['donation'=>$item->id]) }}" method="post">
                                        @csrf
                                        <button type="button" class="btn btn-outline-warning btn-sm" onclick="editDonation('{{ $i }}')" data-bs-toggle="modal" data-bs-target="#editDonationModal">แก้ไข</button>
                                        {{-- <a href="{{ route('editActivity',['id'=>$item->id]) }}" class="btn btn-outline-warning btn-sm">แก้ไข</a> --}}
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">ลบ</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if ($donation->total()>$donation->perPage())
                    {{ $donation->links('pagination::bootstrap-5') }}
                @endif
            </div>
        </div>
        <div class="card border-0 mt-3">
            <div class="card-body d-grid gap-1">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDonationModal">
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
    <div class="modal fade" id="addDonationModal" tabindex="-1" aria-labelledby="addDonationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('donation.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h1 class="modal-title fs-5" id="addDonationModalLabel">เพิ่ม ผู้บริจาค</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="name" required>
                            <label for="floatingInput">ชื่อ-นามสกุล</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 200px" name="detail" required></textarea>
                            <label for="floatingTextarea2">รายละเอียด</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" name="date" id="" required>
                            <label for="inputBirthday">วันที่</label>
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">รูปภาพผู้บริจาค</label>
                            <input class="form-control" type="file" id="formFile" name="file" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- edit Activity Modal --}}
    <div class="modal fade" id="editDonationModal" tabindex="-1" aria-labelledby="editDonationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('donation.update',['donation'=>'1']) }}" method="POST" enctype="multipart/form-data" id="updateForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-warning">
                        <h1 class="modal-title fs-5" id="editDonationModalLabel">แก้ไข ผู้บริจาค</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInputName" placeholder="name@example.com" name="name" required>
                            <label for="floatingInputName">ชื่อ-นามสกุล</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextareaDetail" style="height: 200px" name="detail"></textarea>
                            <label for="floatingTextareaDetail">รายละเอียด</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" name="date" id="inputDate" required>
                            <label for="inputDate">วันที่</label>
                        </div>
                        <div class="mb-3">
                            <label for="formFileNew" class="form-label">รูปภาพผู้บริจาค</label>
                            <input class="form-control" type="file" id="formFileNew" name="file">
                        </div>
                        <img src="" alt="" id="image" class="card-img-top" style="width: 100px">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-warning">แก้ไข</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
    const something_var = <?php echo json_encode($donation) ?>;
    function editDonation(id){
        const data =  something_var.data[id];
        const name = document.getElementById("floatingInputName");
        const form = document.getElementById("updateForm");
        const detail = document.getElementById("floatingTextareaDetail");
        const date = document.getElementById("inputDate");
        const file = document.getElementById("image");
        form.action = 'http://127.0.0.1:8000/donation/'+data.id;
        name.value = data.name;
        detail.value = data.detail;
        date.value = data.date;
        file.src = window.location.protocol+"//"+window.location.host +'/images/'+data.path;


    }
</script>

</x-app-layout>
