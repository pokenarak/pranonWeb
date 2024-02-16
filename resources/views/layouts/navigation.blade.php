<nav class="navbar navbar-expand-md navbar-light bg-light mb-3">
    <div class="container-xl">
        <a class="navbar-brand {{ Route::is('dashboard')?'active':'' }}" href="/">หน้าหลัก</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0" >
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    บุคลากร
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item {{ URL::current()==route('person',['type'=>'monk'])?'active':'' }}"  href="{{ route('person',['type'=>'monk']) }}">พระภิกษุ</a></li>
                        <li><a class="dropdown-item {{ URL::current()==route('person',['type'=>'novice'])?'active':'' }}"  href="{{ route('person',['type'=>'novice']) }}">สามเณร</a></li>
                        <li><a class="dropdown-item {{ URL::current()==route('person',['type'=>'nun'])?'active':'' }}"  href="{{ route('person',['type'=>'nun']) }}">อุบาสกอุบาสิกา</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item {{ Route::is('personnelType')?'active':'' }}"  href="{{ route('personnelType') }}">ตำแหน่ง</a></li>
                        <li><a class="dropdown-item {{ Route::is('rainsRetreat.*')?'active':'' }}"  href="{{ route('rainsRetreat.show',['rainsRetreat'=> \Carbon\Carbon::now()->year ]) }}">จำพรรษา</a></li>
                        {{-- <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item {{ Route::is('personnel')?'active':'' }}"  href="">อุบาสก-อุบาสิกา</a></li> --}}

                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    การศึกษา
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item {{ Route::is('student') ? 'active' : '' }}"  href="{{ route('student',['year'=>'0']) }}">นักเรียน</a></li>
                        <li><a class="dropdown-item {{ Route::is('course') ?'active':'' }}"  href="{{ route('course',['year'=>'0']) }}">ครูสอน</a></li>
                    </ul>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ (Route::is('pilgrimage')) ? 'active' : '' }}" aria-current="page" href="{{ route('pilgrimage.index') }}">ธุดงค์</a>
                </li>
                <li class="nav-item" >
                    <a class="nav-link {{ Route::is('activity')?'active':'' }}" aria-current="page" href="{{ route('activity',['year'=> '0']) }}">กิจกรรม</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ Route::is('news')?'active':'' }}"  href="{{ route('news') }}">ประชาสัมพันธ์</a>
                </li>
            </ul>
            <div class="d-flex">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                @if (Auth::user()->profile_photo_path)
                                    <img src="{{ asset('images/'.Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}" class="rounded-circle object-fit-cover" style="height: 30px;width: 30px;">
                                @else
                                    <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="rounded-circle object-fit-cover" width="30px">
                                @endif
                            </a>
                        @else
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                        @endif

                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item btn" href="{{ route('profile.show') }}">ตั้งค่า</a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" class="dropdown-item btn" action="{{ route('logout') }}" x-data>
                                    @csrf
                                    <button type="submit" class="text-danger">ออกจากระบบ</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

