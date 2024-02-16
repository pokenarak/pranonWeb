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
                    บุคลากร
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item {{ URL::current()==route('showPerson',['year'=>'*','type'=>'monk'])?'active':'' }}"  href="{{ route('showPerson',['year'=>'0','type'=>'monk']) }}">พระภิกษุ</a></li>
                        <li><a class="dropdown-item {{ URL::current()==route('showPerson',['year'=>'*','type'=>'novice'])?'active':'' }}"  href="{{ route('showPerson',['year'=>'0','type'=>'novice']) }}">สามเณร</a></li>
                        <li><a class="dropdown-item {{ URL::current()==route('showPerson',['year'=>'*','type'=>'nun'])?'active':'' }}"  href="{{ route('showPerson',['year'=>'0','type'=>'nun']) }}">อุบาสกอุบาสิกา</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('activityUser')?'active':'' }}"  href="{{ route('activityUser',['year'=>'0']) }}">กิจกรรม</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('pilgrimageUser')?'active':'' }}"  href="{{ route('pilgrimageUser') }}">ธรรมยาตรา</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('newsUser')?'active':'' }}"  href="{{ route('newsUser') }}">ข่าว</a>
                </li>
            </ul>
            <div class="d-flex">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a href="{{ route('person', ['type'=>'monk']) }}" class="nav-link ">แอดมิน</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <div class="dropdown">
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
                            {{-- @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="nav-link ">Register</a>
                                </li>
                            @endif --}}
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </div>
</nav>

