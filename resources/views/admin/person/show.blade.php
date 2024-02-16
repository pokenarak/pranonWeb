<x-app-layout>
    <div class="container-lg">
        <div class="card border-0">
            <div class="row g-0">
                <div class="col-md-4 text-center">
                    @if ($person->path != '')
                        <img src="{{ asset($person->path) }}" alt="" class="shadow rounded" style="filter: grayscale({{ $person->active == 1 ? '0%' : '100%' }})">
                    @else
                        <img src="{{ url('images/person/no.png') }}" alt="" class="shadow rounded" style="filter: grayscale({{ $person->active == 1 ? '0%' : '100%' }})">
                    @endif
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="fw-bold">{{ $person->name }} <small class="text-muted">{{ $person->lastname }}</small> {{ $person->ordianation_name }}</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h5 class="text-primary ">
                                    @if ($person->type->count()>0)
                                        @foreach ($person->type as $type)
                                            {{ $type->personnel_type->name }}
                                        @endforeach
                                    @endif
                                </h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 ml-4">
                                @if ($person->rank->count()>0)
                                    @foreach ($person->rank as $item)
                                        {{ $item->name }}
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><b>อายุ</b> : {{ Carbon\Carbon::parse($person->birthday)->age }}</li>
                                    <li class="list-group-item"><b>พรรษา</b> : {{ Carbon\Carbon::parse($person->ordain_monk)->age }}</li>
                                    <li class="list-group-item"><b>เลชประจำตัวประชน</b> : {{ $person->people_id }}</li>
                                    <li class="list-group-item"><b>วันเกิด</b> : {{ \Carbon\Carbon::parse($person->birthday)->addYear(543)->locale('th')->isoFormat('dddd ที่ D เดือนMMMM พ.ศ.YYYY') }}</li>
                                    @php
                                        $type = 'nun';
                                    @endphp
                                    @if ($person->ordain_novice)
                                        <li class="list-group-item bg-warning-subtle"><b>วันบรรพชา</b> : {{ \Carbon\Carbon::parse($person->ordain_novice)->addYear(543)->locale('th')->isoFormat('dddd ที่ D เดือนMMMM พ.ศ.YYYY') }}</li>
                                        @php
                                            $type = 'novice';
                                        @endphp
                                    @endif
                                    @if ($person->ordain_monk)
                                        <li class="list-group-item bg-warning"><b>วันอุปสมบท</b> : {{ \Carbon\Carbon::parse($person->ordain_monk)->addYear(543)->locale('th')->isoFormat('dddd ที่ D เดือนMMMM พ.ศ.YYYY') }}</li>
                                        @php
                                            $type = 'monk';
                                        @endphp
                                    @endif
                                    @if ($person->ordain_nun)
                                        <li class="list-group-item bg-info-subtle"><b>วันรับศีล๘</b> : {{ \Carbon\Carbon::parse($person->ordain_nun)->addYear(543)->locale('th')->isoFormat('dddd ที่ D เดือนMMMM พ.ศ.YYYY') }}</li>
                                        @php
                                            $type = 'nun';
                                        @endphp
                                    @endif
                                    <li class="list-group-item"><b>ที่อยู่</b> : {{ $person->address }}</li>
                                    <li class="list-group-item"><b>เบอร์โทร</b> : {{ $person->phone }}</li>
                                    <li class="list-group-item"><b>วัดเดิม</b> : {{ $person->old_temple_name }}</li>
                                    <li class="list-group-item"><b>ติดต่อวัดเดิม</b> : {{ $person->old_temple_tel }}</li>
                                    <li class="list-group-item"><b>สถานะ</b> : {{ $person->active == 1 ? 'ปกติ' : 'ย้ายไปที่อื่น หรือ ลาสิกขา' }}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-12">
                                <form action="{{ route('personnel.destroy',['personnel'=> $person->id]) }}" method="POST">
                                    @csrf
                                    <a class="btn btn-outline-primary" href="{{ route('person',['type'=>$type]) }}" role="button">กลับ</a>
                                    <a class="btn btn-outline-warning" href="{{ route('personnel.edit',['personnel'=>$person->id]) }}" role="button">แก้ไข</a>
                                    @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">ลบ</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
