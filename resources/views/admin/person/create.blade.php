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
     <div class="container-lg">
        <div class="card border-0">
            <div class="card-body">
                <div class="pb-4 text-center text-primary">
                    <h2>เพิ่มบุคลากร</h2>
                </div>
                <div class="card border-0">
                    <div class="card-body">
                        <form action="{{ route('personnel.store') }}" method="POST" enctype="multipart/form-data" id="addPerson" onkeydown="return event.key != 'Enter';">
                            @csrf
                            <div class="row mt-2">
                                <div class="mb-3 row">
                                    <div class="col-md-4">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="inputName" placeholder="อภิสิทธิ์" name="name" required>
                                            <label for="inputName">ชื่อ</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="inputLastname" placeholder="สมพงษ์" name="lastname" required>
                                            <label for="inputLastname">นามสกุล</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="inputOrdianName" placeholder="ฉายา" name="ordianname">
                                            <label for="inputOrdianName">ฉายา</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating mb-3">
                                            <input type="date" class="form-control border-primary" id="inputBirthday" placeholder="ฉายา" name="birthday">
                                            <label for="inputBirthday">วันเกิด</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating mb-3">
                                            <input type="date" class="form-control border-warning" id="inputNovicDate" placeholder="วันบวชเป็นสามเณร" name="noviceDate" data-bs-toggle="tooltip" data-bs-placement="top" title="วันบวชเป็นสามเณร" >
                                            <label for="inputNovicDate">วันบรรพชา</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating mb-3">
                                            <input type="date" class="form-control border-warning" id="inputOrdianDate" placeholder="วันบวชเป็นพระ" name="ordianDate" data-bs-toggle="tooltip" data-bs-placement="top" title="วันบวชเป็นพระภิกษุ" >
                                            <label for="inputOrdianDate">วันอุปสมบท</label>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="inputPeopleId" placeholder="เลขประจำตัวประชาชน" name="peopleId" maxlength="13" data-bs-toggle="tooltip" data-bs-placement="top" title="เลขประจำตัวประชาชนหรือเลขหนังสือเดินทาง">
                                            <label for="inputPeopleId">เลขประจำตัวประชาชน</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating mb-3">
                                            <input type="tel" class="form-control" id="inputTel" placeholder="เบอร์โทร" name="tel">
                                            <label for="inputTel">เบอร์โทร</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating mb-3">
                                            <textarea class="form-control" id="inputAddress" placeholder="ที่อยู่" rows="5" name="address" wrap="soft" style="height: 100px;resize: none" required>เลขที่ 1 หมู่ 2 วัดพระนอนจักรสีห์ วรวิหาร ต.จักรสีห์ อ.เมือง จ.สิงห์บุรี 16000</textarea>
                                            <label for="inputAddress">ที่อยู่</label>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="inputOldTemple" placeholder="เข่น วัดธาตุ จ.ขอนแก่น" name="oldTemple"  data-bs-toggle="tooltip" data-bs-placement="top" title="เข่น วัดธาตุ จ.ขอนแก่น">
                                            <label for="inputOldTemple">วัดเดิม</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating mb-3">
                                            <input type="tel" class="form-control" id="inputoldTempleTel" placeholder="เบอร์โทรติดต่อวัดเดิม" name="oldTempleTel">
                                            <label for="inputoldTempleTel">เบอร์โทรติดต่อวัดเดิม</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center mb-3">
                                        <div id="typeChips"></div>
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addTypeModal">
                                            เพิ่มตำแหน่ง
                                        </button>
                                    </div>
                                    <div class="col-md-12 text-center mb-3">
                                        <div id="rankChips"></div>
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addRankModal">
                                            เพิ่มสมณศักดิ์
                                        </button>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="formFile" class="form-label">กรุณาเลือกรูปภาพ</label>
                                            <input class="form-control" type="file" id="formFile" name="image" accept="image/png, image/jpeg">
                                        </div>
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <div class="col">
                                        <a name="" id="" class="btn btn-secondary" href="{{ URL::previous() }}" role="button">ยกเลิก</a>
                                        <input type="submit" value="บันทึก" class="btn btn-primary">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="form-group mt-3" id="progressBar" style="display: none">
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
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
            var id = select.value;
            var text = select.options[select.selectedIndex].text;
            var date = addModal.querySelector('.modal-body #date').value;
            if(type.length>0 && date.length>0){
                createChip(text,id,date,'typeChips');
            }
            ClearAddTypeModal();
        }
        function AddRank(){
            var addModal = document.getElementById('addRankModal');
            var rank = addModal.querySelector('.modal-body #rank').value;
            var date = addModal.querySelector('.modal-body #date').value;
            if(rank.length>0 && date.length>0){
                createChip(rank,-1,date,'rankChips');
            }
            ClearAddRankModal();
        }
        function ClearAddTypeModal(){
            var addModal = document.getElementById('addTypeModal');
            addModal.querySelector('.modal-body #type').options[0].selected = true;
            addModal.querySelector('.modal-body #date').value = '';
        }
        function ClearAddRankModal(){
            var addModal = document.getElementById('addRankModal');
            addModal.querySelector('.modal-body #rank').value = '';
            addModal.querySelector('.modal-body #date').value = '';
        }
    </script>
</x-app-layout>
