<x-guest-layout>
    <style>
        #circleDiv{
            position: relative;
            width: 120px;
            height: 120px;
            overflow: hidden;
            border-radius: 50%;
            display: inline-block;
        }
        img{
            width: 100%;
            height: auto
        }
    </style>
    <div class="container-lg pt-4 pb-4" style="margin-top: 90px;height: 90%;">
        <div class="pb-4 text-center" style="display: flex;justify-content: center">
            @if (request()->route()->parameters['type']=='pali')
                 <h2>ทำเนียบบาลี&nbsp;&nbsp;</h2>
            @else
                <h2>ทำเนียบธรรม&nbsp;&nbsp;</h2>
            @endif
           
            <div class="dropdown text-center mb-3">
                @if ($years->count() > 0)
                    <button class="btn btn-light dropdown-toggle btn-lg" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        ปี : {{ request()->route()->parameters['year'] == 0 ? $years[0]->year+543 : request()->route()->parameters['year']+543}}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        @foreach ($years as $item)
                            <li><a class="dropdown-item" href="{{ route('courseUser',['year'=> $item->year,'type'=>request()->route()->parameters['type']]) }}">{{ $item->year+543 }}</a></li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
            <div class="container-lg">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="container-lg">
                            <div class="row row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 justify-content-center " >
                                @if ($masters)
                                    @php
                                        $type = "";
                                    @endphp
                                    @foreach ($masters as $master)
                                        @php
                                            $item = $master->personnel;
                                            $allType = $item->type;
                                        @endphp
                                        @if ($master->personnel_type->name != $type)
                                            @php
                                                $type = $master->personnel_type->name;
                                            @endphp
                                            </div>
                                            <div class="row row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 justify-content-center " >
                                        @endif
                                        <div class="col mb-3 text-center " id="person {{ $item->name }}">
                                            @include('layouts.teacherDetail')
                                            <div class="row">
                                                <div class="col-12">
                                                    @if ($allType)
                                                        @foreach ($allType as $item)
                                                            <small>{{ $item->personnel_type->name }}</small><br>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="row row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 justify-content-center " >
                                @if ($courses->count()>0)
                                    @foreach ($courses as $course)
                                        @foreach ($course->teacher as $teacher)
                                            @php
                                                $item = $teacher->personnel;
                                                $allType = $item->type;
                                            @endphp
                                            <div class="col mb-3 text-center " id="person {{ $item->name }}">
                                                @include('layouts.teacherDetail')
                                                <div class="row text-center">
                                                    <div class="col">
                                                        <b>{{ $teacher->detail }}</b> {{ $course->supject->name }}
                                                        <p>ห้อง {{ $course->room }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</x-guest-layout>