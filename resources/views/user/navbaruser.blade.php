<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container-xxl">
        <a class="navbar-brand {{ Route::is('home')?'active':'' }}" href="{{ route('home') }}">วัดพระนอนจักรสีห์ วรวิหาร</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0" >
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    ประวัติ
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item {{  Route::is('templeHistory')?'active':'' }}"  href="{{ route('templeHistory')}}">วัดพระนอนจักรสีห์</a></li>
                        <li><a class="dropdown-item {{  Route::is('buddhaHistory')?'active':'' }}"  href="{{ route('buddhaHistory')}}">หลวงพ่อพระนอน</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    บุคลากร
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item {{ URL::current()==route('showPerson',['year'=>'*','type'=>'monk'])?'active':'' }}"  href="{{ route('showPerson',['year'=>'0','type'=>'monk']) }}">พระภิกษุ</a></li>
                        <li><a class="dropdown-item {{ URL::current()==route('showPerson',['year'=>'*','type'=>'novice'])?'active':'' }}"  href="{{ route('showPerson',['year'=>'0','type'=>'novice']) }}">สามเณร</a></li>
                        <li><a class="dropdown-item {{ URL::current()==route('showPerson',['year'=>'*','type'=>'nun'])?'active':'' }}"  href="{{ route('showPerson',['year'=>'0','type'=>'nun']) }}">อุบาสกอุบาสิกา</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('activityUser')?'active':'' }}"  href="{{ route('activityUser',['year'=>'0','type'=>'all']) }}">กิจกรรม</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('pilgrimageUser')?'active':'' }}"  href="{{ route('pilgrimageUser') }}">ธรรมยาตรา</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    ประชาสัมพันธ์
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item {{  Route::is('newsUser')?'active':'' }}"  href="{{ route('newsUser')}}">ข่าว</a></li>
                        <li><a class="dropdown-item {{  Route::is('donationUser')?'active':'' }}"  href="{{ route('donationUser')}}">มหาทานบดี</a></li>
                        <li><a class="dropdown-item {{  Route::is('videoUser')?'active':'' }}"  href="{{ route('videoUser')}}">วีดีทัศน์</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    โรงเรียนพระปริยัติธรรม
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item {{  URL::current()==route('courseUser',['year'=>'*','type'=>'pali'])?'active':'' }}"  href="{{ route('courseUser',['year'=>'0','type'=>'pali'])}}">แผนกบาลี</a></li>
                        <li><a class="dropdown-item {{  URL::current()==route('courseUser',['year'=>'*','type'=>'Dhamma'])?'active':'' }}"  href="{{ route('courseUser',['year'=>'0','type'=>'dhamma'])}}">แผนกธรรม</a></li>
                        <li><a class="dropdown-item {{  Route::is('calendarUser')?'active':'' }}"  href="{{ route('calendarUser')}}">ปฏิทินการศึกษา</a></li>
                        <li><a class="dropdown-item {{  Route::is('lv9')?'active':'' }}"  href="{{ route('lv9')}}">ทำเนียบเปรียญธรรม ๙ ประโยค</a></li>
                        <li><a class="dropdown-item {{  Route::is('activityUser')?'active':'' }}"  href="{{ route('activityUser',['year'=>'0','type'=>'academy']) }}">กิจกรรม</a></li>
                    </ul>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link {{ Route::is('unseen')?'active':'' }}"  href="{{ route('unseen') }}">สถานที่สำคัญ</a>
                </li> --}}
            </ul>
            <div class="d-flex">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    {{-- @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a href="{{ route('person', ['type'=>'monk']) }}" class="nav-link ">แอดมิน</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <div class="dropdown">
                                    <a class="btn btn-primary" href="{{ route('login') }}" role="button">แอดมิน</a>
                                    <button type="button" class="btn" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                      ผู้ดูแล
                                    </button>
                                    <form class="dropdown-menu p-3" method="POST" action="{{ route('login') }}" style="min-width: 250px">
                                        @csrf
                                        <div class="form-floating mb-3">
                                            <input type="email" name="email" :value="old('email')" required autofocus autocomplete="email" class="form-control" id="exampleDropdownFormEmail2" placeholder="email@example.com">
                                            <label for="exampleDropdownFormEmail2">อีเมลล์</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" required>
                                            <label for="floatingPassword">รหัสผ่าน</label>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <x-checkbox id="remember_me" name="remember" />
                                                <label class="form-check-label" for="dropdownCheck2">
                                                    อยู่ในระบบ
                                                </label>
                                            </div>
                                        </div>
                                        @if (Route::has('password.request'))
                                            <a style="text-decoration: none" href="{{ route('password.request') }}">
                                                {{ __('ลืมรหัสผ่าน') }}
                                            </a>
                                        @endif
                                        <button type="submit" class="btn btn-primary">เข้าสู่ระบบ</button>
                                    </form>
                                </div>
                            </li>
                        @endauth
                    @endif --}}
                </ul>
            </div>
        </div>
    </div>
</nav>

