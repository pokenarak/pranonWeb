<x-guest-layout>
    <div class="card text-center bg-dark text-white" style="position: fixed;top:0;left: 0;bottom: 0;right: 0;">
        <div class="card-body text-center">
            <div style="position: absolute;top: 50%;left: 50%;margin-top: -15rem;margin-left: -15rem;">
                <form method="POST" action="{{ route('login') }}" style="width: 30rem;" >
                    @csrf
                    <h1>วัดพระนอนจักรสีห์ วริวหาร</h1>
                    <h4 class="mb-3">ยินดีต้อนรับ</h4>
                    <div class="input-group mb-3 input-group-lg">
                        <span class="input-group-text" id="inputGroup-sizing-default">@</span>
                        <input type="email" name="email" :value="old('email')" required autofocus autocomplete="email" class="form-control" id="exampleDropdownFormEmail2" placeholder="email@example.com">
                    </div>
                    <div class="input-group mb-3 input-group-lg">
                        <span class="input-group-text" id="inputGroup-sizing-default">รหัสผ่าน</span>
                        <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" required>
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
        </div>
    </div>
</x-guest-layout>
