<x-app-layout>
    <style>
        .chip {
            display: inline-block;
            padding: 0 10px;
            height: 40px;
            font-size: 16px;
            line-height: 40px;
            border-radius: 25px;
            background-color: #f1f1f1;
            margin: 10px
        }
        .closebtn {
            padding-left: 10px;
            color: #888;
            font-weight: bold;
            float: right;
            font-size: 20px;
            cursor: pointer;
        }

        .closebtn:hover {
            color: #000;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <div class="container-lg">
        <div class="card border-0">
            <div class="card-body">
                <div class="pb-4 text-center text-warning">
                    <h2>แก้ไขบุคลากร</h2>
                </div>
                <div class="card border-0">
                    <div class="card-body">
                        <form action="{{ route('personnel.update',['personnel'=> $person->id ]) }}" enctype="multipart/form-data" id="editPerson" method="post">
                            @csrf
                            <div class="row mt-2">
                                <div class="mb-3 row">
                                    <div class="col-md-4">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="inputName" placeholder="อภิสิทธิ์" name="name" required value="{{ $person->name }}">
                                            <label for="inputName">ชื่อ</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="inputLastname" placeholder="สมพงษ์" name="lastname" required value="{{ $person->lastname }}">
                                            <label for="inputLastname">นามสกุล</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="inputOrdianName" placeholder="ฉายา" name="ordianname" value="{{ $person->ordianation_name }}">
                                            <label for="inputOrdianName">ฉายา</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating mb-3">
                                            <input type="date" class="form-control border-primary" id="inputBirthday" placeholder="ฉายา" name="birthday" required value="{{ $person->birthday }}" >
                                            <label for="inputBirthday">วันเกิด</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating mb-3">
                                            <input type="date" class="form-control border-warning" id="inputNovicDate" placeholder="วันบวชเป็นสามเณร" name="noviceDate" data-bs-toggle="tooltip" data-bs-placement="top" title="วันบวชเป็นสามเณร" value="{{ $person->ordain_novice }}" >
                                            <label for="inputNovicDate">วันบรรพชา</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating mb-3">
                                            <input type="date" class="form-control border-warning" id="inputOrdianDate" placeholder="วันบวชเป็นพระ" name="ordianDate" data-bs-toggle="tooltip" data-bs-placement="top" title="วันบวชเป็นพระภิกษุ" value="{{ $person->ordain_monk }}">
                                            <label for="inputOrdianDate">วันอุปสมบท</label>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="inputPeopleId" placeholder="เลขประจำตัวประชาชน" name="peopleId" maxlength="13" required data-bs-toggle="tooltip" data-bs-placement="top" title="เลขประจำตัวประชาชนหรือเลขหนังสือเดินทาง" value="{{ $person->people_id }}">
                                            <label for="inputPeopleId">เลขประจำตัวประชาชน</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating mb-3">
                                            <input type="tel" class="form-control" id="inputTel" placeholder="เบอร์โทร" name="tel" value="{{ $person->phone }}">
                                            <label for="inputTel">เบอร์โทร</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating mb-3">
                                            <textarea class="form-control" id="inputAddress" placeholder="ที่อยู่" rows="5" name="address" wrap="soft" style="height: 100px;resize: none" required>{{ $person->address }}</textarea>
                                            <label for="inputAddress">ที่อยู่</label>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="inputOldTemple" placeholder="เข่น วัดธาตุ จ.ขอนแก่น" name="oldTemple"  data-bs-toggle="tooltip" data-bs-placement="top" title="เข่น วัดธาตุ จ.ขอนแก่น" value="{{ $person->old_temple_name }}">
                                            <label for="inputOldTemple">วัดเดิม</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating mb-3">
                                            <input type="tel" class="form-control" id="inputoldTempleTel" placeholder="เบอร์โทรติดต่อวัดเดิม" name="oldTempleTel" value="{{ $person->old_temple_tel }}">
                                            <label for="inputoldTempleTel">เบอร์โทรติดต่อวัดเดิม</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center mb-3">
                                        <div id="typeChips">
                                            @if ($type = $person->type)
                                                @foreach ($type as $item)
                                                    <div class="chip">
                                                        {{ $item->personnel_type->name }} : {{ \Carbon\Carbon::parse($item->date)->addYear(543)->locale('th')->isoFormat('D MMM YY') }}&nbsp;&nbsp;
                                                        <a href="{{ route('type.show',$item->id) }}" class="btn-close"></a>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addTypeModal">
                                            เพิ่มตำแหน่ง
                                        </button>
                                    </div>
                                    <div class="col-md-12 text-center mb-3">
                                        <div id="rankChips">
                                            @if ($rank = $person->rank)
                                                @foreach ($rank as $item)
                                                    <div class="chip">
                                                        {{ $item->name }} : {{ \Carbon\Carbon::parse($item->date)->addYear(543)->locale('th')->isoFormat('D MMM YY') }}&nbsp;&nbsp;
                                                        @method('DELETE')
                                                        <a href="{{ route('rank.show',$item->id) }}" class="btn-close"></a>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addRankModal">
                                            เพิ่มสมณศักดิ์
                                        </button>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="formFile" class="form-label">กรุณาเลือกรูปภาพ</label>
                                            <input class="form-control" type="file" id="formFile" name="image" accept="image/png, image/jpeg">
                                        </div>
                                        @if ($person->path != '')
                                            <img src="{{ asset($person->path) }}" alt="" class="shadow rounded" style="filter: grayscale({{ $person->active == 1 ? '0%' : '100%' }});width:100px">
                                        @else
                                            <img src="{{ url('images/person/no.png') }}" alt="" class="shadow rounded" style="filter: grayscale({{ $person->active == 1 ? '0%' : '100%' }});width:100px">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" name="active" {{ $person->active == 1 ? 'checked' :'' }}>
                                        <label class="form-check-label" for="flexCheckDefault">เลือกถ้ายังไม่ได้สึกหรือยังไม่ได้ย้ายไปอยู่ที่อื่น</label>
                                        </div>
                                </div>
                                <div class="row text-center">
                                    <div class="col">
                                        @method('PUT')
                                        <a name="" id="" class="btn btn-secondary" href="{{ route('personnel.show',['personnel'=>$person->id]) }}" role="button">ยกเลิก</a>
                                        <input type="submit" value="แก้ไข" class="btn btn-warning">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Add Type --}}
    <div class="modal fade" id="addTypeModal" tabindex="-1" aria-labelledby="addTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addTypeModalLabel">เพิ่มตำแหน่ง</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <select class="form-select" aria-label="Default select example" id="type">
                            @foreach ($types as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-floating mt-3">
                        <input class="form-control" type="date" id="date" placeholder="วันที่" required >
                        <input type="hidden" id="id" value="{{ $person->id }}">
                        <label for="floatingInputGrid">วันที่</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn btn-primary" onclick="AddType()" data-bs-dismiss="modal">บันทึก</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Add Rank --}}
    <div class="modal fade" id="addRankModal" tabindex="-1" aria-labelledby="addRankModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addRankModalLabel">เพิ่มสมณศักดิ์</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating mt-3">
                        <input class="form-control" type="text" id="rank" placeholder="สมณศักดิ์" required >
                        <label for="floatingInputGrid">สมณศักดิ์</label>
                    </div>
                    <div class="form-floating mt-3">
                        <input class="form-control" type="date" id="date" placeholder="วันที่" required >
                        <input type="hidden" id="id" value="{{ $person->id }}">
                        <label for="floatingInputGrid">วันที่</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn btn-primary" onclick="AddRank()" data-bs-dismiss="modal">บันทึก</button>
                </div>
            </div>
        </div>
    </div>

    <script>
         function createChip(text,id,date,idDiv){
            const div = document.createElement('div');
            div.className='chip'
            const options = { day: 'numeric', month: 'narrow',year: '2-digit'  };
            var dateText = new Date(date).toLocaleDateString('th-TH',options);
            if (id >=0) {
                div.innerHTML=text+' : '+dateText+'<input type="hidden" name="'+idDiv+'[]" value="'+id+' : '+date+'"><span class="closebtn" onclick="this.parentNode.parentNode.removeChild(this.parentNode);">&times;</span>';
            }else{
                div.innerHTML=text+' : '+dateText+'<input type="hidden" name="'+idDiv+'[]" value="'+text+' : '+date+'"><span class="closebtn" onclick="this.parentNode.parentNode.removeChild(this.parentNode);">&times;</span>';
            }
            document.getElementById(idDiv).appendChild(div);
        }
        function AddType(){

            var addModal = document.getElementById('addTypeModal');
            var select = addModal.querySelector('.modal-body #type');
            var type_id = select.value;
            var date = addModal.querySelector('.modal-body #date').value;
            var id = addModal.querySelector('.modal-body #id').value;
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ route('type.store') }}",
                type: 'POST',
                dataType: "json",
                data: {
                    personnel_type_id: type_id,
                    date: date,
                    personnel_id: id
                },
                success: function(data) {
                    // log response into console
                    location.reload();
                }
            });
        }
        function AddRank(){
            var addModal = document.getElementById('addRankModal');
            var rank = addModal.querySelector('.modal-body #rank').value;
            var date = addModal.querySelector('.modal-body #date').value;
            var id = addModal.querySelector('.modal-body #id').value;
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ route('rank.store') }}",
                type: 'POST',
                dataType: "json",
                data: {
                    name: rank,
                    date: date,
                    id: id
                },
                success: function(data) {
                    // log response into console
                    location.reload();
                }
            });
        }
    </script>
</x-app-layout>
