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
                    <h2>เพิ่มโครงการธุดงค์</h2>
                </div>
                <form action="/pilgrimage" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="name" required>
                        <label for="floatingInput">ชื่อโครงการ</label>
                    </div>
                    <div class="row g-3">
                        <div class="col-md">
                            <div class="form-floating">
                                <input class="form-control" type="date" name="start" id="addDateStart" required >
                                <label for="floatingInputGrid">เริ่มเดินทาง</label>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-floating">
                                <input class="form-control" type="date" name="end" id="addDateEnd" required>
                                <label for="floatingInputGrid">สิ้นสุด</label>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example" name="stage" required>
                                    <option value="ในประเทศ">ในประเทศ</option>
                                    <option value="ต่างประเทศ">ต่างประเทศ</option>
                                </select>
                                <label for="floatingSelectGrid">เลือก</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating mt-3">
                        <textarea class="form-control" placeholder="Leave a comment here" id="addDetail" style="height: 260px" name="detail"></textarea>
                        <label for="addDetail">รายละเอียด</label>
                    </div>
                    <div class="mt-3 text-center">
                        <table id="displayStop" class="table">
                            <tbody></tbody>
                        </table>
                        <input type="hidden" name="stop" id="stop">
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addStopModal">
                            เพิ่มเส้นทาง
                        </button>
                    </div>
                    <div class="mt-3 text-center">
                        <a name="" id="" class="btn btn-secondary" href="{{ route('pilgrimage.index') }}" role="button">ยกเลิก</a>
                        <input type="submit" class="btn btn-primary" value="บันทึก">
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Add Stop --}}
    <div class="modal fade" id="addStopModal" tabindex="-1" aria-labelledby="addStopModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="addStopModalLabel">เพิ่มเส้นทาง</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating">
                        <input class="form-control" type="text" id="destination" placeholder="สถานที่" required >
                        <label for="floatingInputGrid">สถานที่</label>
                    </div>
                    <div class="form-floating mt-3">
                        <input class="form-control" type="date" id="date" placeholder="วันที่" required >
                        <label for="floatingInputGrid">วันที่</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn btn-primary" onclick="AddStop()" data-bs-dismiss="modal">บันทึก</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function AddStop(){
            var table = document.getElementById('displayStop');
            var addModal = document.getElementById('addStopModal');
            var destination = addModal.querySelector('.modal-body #destination').value;
            var date = addModal.querySelector('.modal-body #date').value;
            if(destination.length>0 && date.length>0){
                const options = { day: 'numeric',weekday: 'long', month: 'long',year: 'numeric'  };
                const row = table.insertRow();
                const cell1 = row.insertCell(0);
                const cell2 = row.insertCell(1);
                const cell3 = row.insertCell(2);
                cell1.innerHTML = destination;
                cell2.innerHTML = new Date(date).toLocaleDateString('th',options);
                cell3.innerHTML = '<button class=" btn btn-danger" onclick="deleteStop(this)">ลบ</button>'

                document.getElementById('stop').value += destination+','+date+'/';
            }
            ClearAddStopModal();
        }
        function ClearAddStopModal(){
            var addModal = document.getElementById('addStopModal');
            addModal.querySelector('.modal-body #destination').value = '';
            addModal.querySelector('.modal-body #date').value = '';
        }
        function deleteStop(row){
            var table = document.getElementById('displayStop');
            var j = row.parentNode.parentNode.rowIndex;
            table.deleteRow(j);

            var stop = document.getElementById('stop').value;
            var textSplit = stop.split('/');
            var text = '';
            for (let i = 0; i < textSplit.length-1; i++) {
                if (i!=j) {
                    text+=textSplit[i]+'/';
                }
            }
            document.getElementById('stop').value = text;
        }
    </script>
</x-app-layout>
