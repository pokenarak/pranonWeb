<script src="path/from/html/page/to/jquery.min.js"></script>
<script   src="https://code.jquery.com/jquery-3.1.1.min.js"   integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="   crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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
                    <h2>แก้ไขโครงการธุดงค์</h2>
                </div>
                <form action="{{ route('pilgrimage.update',['pilgrimage'=>$pilgrimage->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="name" value="{{ $pilgrimage->name }}" required>
                        <label for="floatingInput">ชื่อโครงการ</label>
                    </div>
                    <div class="row g-3">
                        <div class="col-md">
                            <div class="form-floating">
                                <input class="form-control" type="date" name="start" id="addDateStart" required value="{{ $pilgrimage->start }}">
                                <label for="floatingInputGrid">เริ่มเดินทาง</label>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-floating">
                                <input class="form-control" type="date" name="end" id="addDateEnd" required value="{{ $pilgrimage->end }}">
                                <label for="floatingInputGrid">สิ้นสุด</label>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example" name="stage" required>
                                    <option value="ในประเทศ" {{ $pilgrimage->stage == 'ในประเทศ' ? 'selected':'' }}>ในประเทศ</option>
                                    <option value="ต่างประเทศ" {{ $pilgrimage->stage == 'ต่างประเทศ' ? 'selected':'' }}>ต่างประเทศ</option>
                                </select>
                                <label for="floatingSelectGrid">เลือก</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating mt-3">
                        <textarea class="form-control" placeholder="Leave a comment here" id="addDetail" style="height: 100px" name="detail">{{ $pilgrimage->detail }}</textarea>
                        <label for="addDetail">รายละเอียด</label>
                    </div>
                    <div class="mt-3 text-center">
                        @php
                            $allStop = $pilgrimage->stop;
                            $text='';
                            foreach ($allStop as $value) {
                                $text =$text.$value->detail.','.$value->date.'/';
                            }
                        @endphp
                        <table id="displayStop" class="table">
                            <tbody>
                                @foreach ($allStop as $item)
                                    <form action="{{ route('stop.destroy',['stop'=>$item->id]) }}" method="post">
                                        @csrf
                                        <tr>
                                            <td>{{ $item->detail }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->date)->addYear(543)->locale('th')->isoFormat('วันddddที่ D MMMM YYYY') }}</td>
                                            <td><a href="{{ route('stopImage.edit',['stopImage'=>$item->id]) }}" class="btn btn-outline-warning btn-sm">แก้ไข</a></td>
                                            @method('DELETE')
                                            <td><button type="submit" class="btn btn-outline-danger btn-sm">ลบ</button></td>
                                        </tr>
                                    </form>

                                @endforeach
                            </tbody>
                        </table>
                        <input type="hidden" name="stop" id="stop" value="{{ $text }}">
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addStopModal">
                            เพิ่มเส้นทาง
                        </button>
                    </div>
                    <div class="mt-3 text-center">
                        @method('put')
                        <a class="btn btn-outline-secondary" href="{{ URL::previous() }}" role="button">กลับ</a>
                        <input type="submit" class="btn btn-warning" value="แก้ไข">
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Add Stop --}}
    <form action="{{ route( "stop.store") }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="addStopModal" tabindex="-1" aria-labelledby="addStopModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="addStopModalLabel">เพิ่มเส้นทาง</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating">
                            <input type="hidden" name="pilgrimage_id" value="{{ $pilgrimage->id }}">
                            <input class="form-control" type="text" id="destination" placeholder="สถานที่" name="detail" required >
                            <label for="floatingInputGrid">สถานที่</label>
                        </div>
                        <div class="form-floating mt-3">
                            <input class="form-control" type="date" id="date" placeholder="วันที่" name="date" required >
                            <label for="floatingInputGrid">วันที่</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-app-layout>
