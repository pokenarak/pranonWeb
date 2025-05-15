<x-guest-layout>
    <div style="background: linear-gradient(90deg, #e3ffe7 0%, #d9e7ff 100%);width: 100%;height: 100%;position: fixed;left: 0;top: 0;z-index: -1;"></div>
    <div class="container pt-4 pb-4 rounded-3" style="margin-top: 90px;height: 90%;">
        <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2">
            <div class="col p-4">
                @if ($person->path)
                    <img src="{{ asset($person->path) }}" alt="" style="filter: grayscale({{ $person->active == 1 ? '0%' : '100%' }})" class="rounded-3">
                @else
                    <img src="{{ url('images/person/no.png') }}" alt="" style="filter: grayscale({{ $person->active == 1 ? '0%' : '100%' }})">
                @endif
            </div>
            <div class="col mt-4 text-center">
                <div class="rounded-3 p-2 pt-4" style="background: rgba(255,255,255,0.5);">
                    @if ($person->rank->count()>0)
                        <figure class="text-center">
                            <blockquote class="blockquote">
                                <p class="display-6 fw-bold text-primary" style=" text-shadow: -1px -1px 0px #dea9f755, 3px 3px 0px #ca7dee55;"> {{ $person->lastestRank->name }}</p>
                            </blockquote>
                            <figcaption class="blockquote-footer">
                                {{ $person->name }} <cite title="Source Title">{{ $person->lastname }}</cite> {{ $person->ordianation_name }} 
                            </figcaption>
                        </figure>
                    @else
                        <p class="display-6 fw-bold text-primary" style=" text-shadow: -1px -1px 0px #dea9f755, 3px 3px 0px #ca7dee55;">  {{ $person->name }} <small class="text-muted">{{ $person->lastname }}</small> {{ $person->ordianation_name }}</p>
                       
                    @endif
                    @if ($person->ordain_monk)
                        <b>พรรษา : </b>{{ Carbon\Carbon::parse($person->ordain_monk)->age }} พรรษา
                    @endif
                    <b>อายุ : </b>{{ Carbon\Carbon::parse($person->birthday)->age }} ปี
                    <p><b>ที่อยู่ : </b>{{ $person->address }}</p>
                </div>
                @php
                    $rank = $person->rank->sortBy('date');
                    $type = $person->type->sortBy('date');
                    $regis = $person->register->whereNotNull('result')->sortBy('date');
                    $teacher = $person->teacher;
                @endphp
                @if (!$rank->isEmpty())
                    <div class="rounded-3 p-2 mt-2" style="background: rgba(255,255,255,0.5);">
                        <h3 class="mt-3 text-success">สมณศักดิ์</h3>
                    
                        @foreach ($rank as $item)
                            <p><b>{{ $item->name }}</b> แต่งตั้งในปี พ.ศ.{{ \Carbon\Carbon::parse($item->date)->addYear(543)->locale('th')->year }}</p>
                        @endforeach
                    </div>
                @endif
                @if (!$type->isEmpty())
                    <div class="rounded-3 p-2 mt-2" style="background: rgba(255,255,255,0.5);">
                        <h3 class="mt-3 text-success">การปกครอง</h3>
                        @foreach ($type as $item)
                            <p><b>{{ $item->personnel_type->name }}</b> แต่งตั้งในปี พ.ศ.{{ \Carbon\Carbon::parse($item->date)->addYear(543)->locale('th')->year }}</p>
                        @endforeach
                    </div>
                @endif
                @if (!$teacher->isEmpty())
                    <div class="rounded-3 p-2 mt-2" style="background: rgba(255,255,255,0.5);">
                        <h3 class="mt-3 text-success">งานสอน</h3>
                        @foreach ($teacher as $item)
                            <p>สอน <b>{{ $item->course->supject->name }}</b> ในปี พ.ศ.{{ $item->course->year+543 }}</p>
                        @endforeach
                    </div>
                @endif
                @if (!$regis->isEmpty())
                    <div class="rounded-3 p-2 mt-2" style="background: rgba(255,255,255,0.5);">
                        <h3 class="mt-3 text-success">การศึกษา</h3>
                        @foreach ($regis as $item)
                            <p><b>{{ $item->course->supject->name }}</b> สอบผ่านในปี พ.ศ.{{ $item->course->year+543 }}</p>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-guest-layout>