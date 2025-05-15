<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>วัดพระนอนจักรสีห์</title>
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">

        <link href="https://fonts.googleapis.com/css2?family=Krub:wght@200;300;500;700&display=swap" rel="stylesheet">
        @vite(['resources/css/welcome.css', 'resources/js/app.js', 'resources/scss/app.scss'])

        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </head>
    <body style="font-family:Krub;">
        @include('user.navbaruser')
        <div class="container-xxl" style="margin-top: 56px">
            <div class="row justify-content-md-center">
                <div class="col-lg-9">
                    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            @for ($i = 0; $i < $news->count(); $i++)
                                <button type="button" data-bs-target="#carouselExampleCaptions" class="{{ $i == 0 ? 'active' :'' }}" data-bs-slide-to="{{ $i }}" aria-label="Slide {{ $i }}"></button>
                            @endfor
                        </div>
                        <div class="carousel-inner">
                          @foreach ($news as $i=> $item)
                            <div class="carousel-item {{ $i == 0 ? 'active' :'' }}" data-bs-interval="3000">
                                <a class="text-decoration-none" href="{{ route('showNews',['id'=>$item->id]) }}">
                                    <img src="{{ asset($item->image) }}" class="d-block w-100" alt="..." style="height: 35rem; object-fit: cover;">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5><span class="badge bg-primary-subtle text-primary-emphasis">{{ $item->topic }}</span></h5>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <div class="col col-lg-3">
                    <div class="row">
                        @if ($video)
                            <div class="ratio ratio-16x9">
                                <iframe width="560" height="315" src="{{ $video->link }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                            </div>
                        @endif
                    </div>
                    <div class="row mt-4">
                        <div class="card text-center border-0">
                            <h3><div class="badge rounded-pill text-bg-warning text-wrap"> มหาทานบดี</div></h3>
                            <div class="card-body">
                                <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach ($donation as $i=> $item)
                                            <div class="carousel-item {{ $i == 0 ? 'active' :'' }}">
                                                <img src="{{ asset('images/'.$item->path) }}" class="d-block w-100" alt="...">
                                                <div class="carousel-caption d-none d-md-block">
                                                    <h5>{{ $item->name }}</h5>
                                                    <p>{{ $item->detail }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <a href="{{ route('donationUser') }}" class="stretched-link"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-1 p-2" style="background-color: rgb(246, 244, 244)">
            <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 m-5 align-items-center" >
                <div class="col text-center">
                    <div class="text">
                        <span>กิ</span>
                        <span>จ</span>
                        <span>ก</span>
                        <span>ร</span>
                        <span>ร</span>
                        <span>ม</span>
                      </div>
                    <p id="detail">สืบสาน เผยแพร่และส่งเสริมวัฒนธรรม</p>
                    <small><a href="{{ route('activityUser',['year'=>'0','type'=>'all']) }}" class="nav-link">เพิ่มเติม...</a></small>
                </div>
                <div class="col">
                    <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-5 justify-content-center">
                        @if ($activities->count()>0)
                            @foreach ($activities as $i => $item)
                                <div class="col mt-3">
                                    @include('layouts.activityCard')
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-1 p-2 container-fluid">
            <div class="row align-items-center" >
                <div class="col">
                    <div class="row mt-3">
                        <div class="col text-center">
                            <div class="text">
                                <span>ธ</span>
                                <span>ร</span>
                                <span>ร</span>
                                <span>ม</span>
                                <span>ย</span>
                                <span>า</span>
                                <span>ต</span>
                                <span>ร</span>
                                <span>า</span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <div class="container-fluid">
                                <div class="row row-cols-1 row-cols-lg-2">
                                    <div class="col-md-auto" >
                                        @if ($pilgrimageInside)
                                            @php
                                                $data = $pilgrimageInside->stop->sortDesc();
                                                $data->values()->all();
                                            @endphp
                                            <div class="p-3">
                                                <p style="font-size: 2rem;" class="text-center">ในประเทศ<sup> : {{ \Carbon\Carbon::parse($pilgrimageInside->start)->addYear(543)->locale('th')->year }}</sup></p>
                                                <div class="row" >
                                                    <div class="uk-container uk-padding overflow-auto" style="max-height: 400px">
                                                        <div class="uk-timeline">
                                                            @foreach ($data as $index => $item)
                                                                @include('layouts.pilgrimage')
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col">
                                        @if ($pilgrimageOutside)
                                            @php
                                                $data = $pilgrimageOutside->stop->sortDesc();
                                                $data->values()->all();
                                            @endphp
                                            <div class="p-3">
                                                <p style="font-size: 2rem;" class="text-center"><sub>{{ \Carbon\Carbon::parse($pilgrimageOutside->start)->addYear(543)->locale('th')->year }} :</sub> ต่างประเทศ</p>
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="uk-container uk-padding overflow-auto" style="max-height: 400px">
                                                            <div class="uk-timeline">
                                                                @foreach ($data as $index => $item)
                                                                    @include('layouts.pilgrimage')
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($success->count() > 0)
            <div class="mt-1 p-2 container-fluid" style="background-color: #111828">
                <div class="row align-items-center" >
                    <div class="col text-center">
                        <div class="row mt-3">
                            <div class="col">
                                <div class="text text-white text-opacity-75">
                                    <span>ค</span>
                                    <span>ว</span>
                                    <span>า</span>
                                    <span>ม</span>
                                    <span>สำ</span>
                                    <span>เ</span>
                                    <span>ร็</span>
                                    <span>จ</span>
                                </div>
                                <p id="detail" class="text-white text-opacity-50">มุทิตายินดีกับผู้สอบผ่านบาลีและนักธรรม ประจำปีการศึกษา {{ $year }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                @include('layouts.success')
                                {{-- <div class="row justify-content-lg-center">
                                    @foreach ($success as $item)
                                        <div class="col-sm-3 p-3 m-2 bg-white bg-opacity-10 rounded" style="max-width: 150px" id="person">
                                            <div style="height: 120px;overflow: hidden;width: 100%;" class="text-center rounded-circle">
                                                @if ($item->personnel->path != '')
                                                    <img src="{{ asset($item->personnel->path) }}" alt="" width="100%">
                                                @else
                                                    <img src="{{ asset('storage/person/no.png') }}" alt="" width="100%">
                                                @endif
                                            </div>
                                            <div class="text-white text-start mt-2">
                                                @php
                                                    $flagName = '';
                                                    $flagLastname = '';
                                                    if ($item->personnel->ordain_monk != '' ) {
                                                        if ($item->course->supject->name == 'ประโยค ๑-๒') {
                                                            $flagName = 'พระ';
                                                        } else {
                                                            $flagName = 'พระมหา';
                                                        }
                                                        $flagLastname = $item->personnel->ordianation_name;
                                                    } else {
                                                        if ($item->personnel->ordain_novice != '') {
                                                            $flagName = 'สามเณร';

                                                        } else {
                                                            $flagName = 'คุณ';
                                                        }
                                                        $flagLastname = $item->personnel->lastname;
                                                    }

                                                @endphp
                                                <a href="{{ route('personInfo',['id'=>$item->personnel->id]) }}" class="nav-link">
                                                    {{ $flagName }}{{ $item->personnel->name }} {{ $flagLastname }}
                                                </a>
                                            </div>
                                            <div class="text-start" style="color: #8492ea"><small>{{ $item->course->supject->name }}</small></div>
                                        </div>
                                    @endforeach
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="mt-1 p-2">
            <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 m-5 align-items-center" >
                <div class="col text-center">
                    <div class="container">
                        <div class="row row-cols-2 justify-content-center text-center">
                            @php
                                $color = ['#f5f500','#ebeb00','#e0e000','#d6d600'];
                                $i=0;
                            @endphp
                            @foreach ($count as $index => $item)
                                <div class="col-4 text-center p-3" style="background-color: {{ $color[$i] }};" id="displayCount">
                                    <div class="row align-items-center"> <div class="col align-self-center"><img src="{{ asset('images/icon/education'.$i.'.png') }}" alt="" height="40rem" style="width: auto"></div> </div>
                                    <div class="row align-items-center"><div class="col align-self-center"><h5>{{ $index }}</h5></div></div>
                                </div>
                                <div class="col align-self-center" style="background-image: linear-gradient(to right, {{ $color[$i] }}, #ffffff);">
                                    <h2 id="textCount">{{ $item }}</h2>
                                </div>
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col text-center">
                    <div class="text">
                        <span>ก</span>
                        <span>า</span>
                        <span>ร</span>
                        <span>ศึ</span>
                        <span>ก</span>
                        <span>ษ</span>
                        <span>า</span>
                    </div>
                    <p id="detail">สืบต่ออายุพระศาสนา</p>
                </div>
            </div>
        </div>
    </body>
    <footer>
        <div class="container-fluid p-3" style="background-color: #292929;color: gray">
            <div class="row justify-content-lg-around">
                <div class="col-lg-auto m-2" style="border-right: 1px solid darkgray;height: 100%;">
                    
                    <h4 class="fw-bold">
                        <a href="https://goo.gl/maps/rdkWdzgQrUiq5dug7" target="_blank" style="text-decoration: none">
                            <img src="{{ asset('images/icon/location.png') }}" alt="" style="width: 2rem" class="rounded float-start">
                            วัดพระนอนจักรสีห์ วรวิหาร
                        </a>
                    </h4>
                    <p>เลขที่ 1 หมู่ 2 ตำบลจักรสีห์
                        <br> อำเภอเมืองสิงห์บุรี จังหวัดสิงห์บุรี
                        <br>16000
                    </p>
                </div>
                <div class="col-lg-auto m-2">
                    <h5 id="footerTopic">
                        <a href="https://maps.app.goo.gl/D6x6zALszB67cdWq7" target="_blank" style="text-decoration: none">
                            <img src="{{ asset('images/icon/location.png') }}" alt="" style="width: 2rem" class="rounded float-start">
                            สำนักเรียนฯ
                        </a>
                    </h5>
                    <p>
                        พระครูอนุกูลวิริยกิจ <sup>อาจารย์สำนักเรียนฯ</sup>
                        <br><i>โทร 0817809313</i>
                        <br>พระมหาบดินทร์ ชยานันโท <sup>เลขานุการ</sup>
                        <br><i>โทร 0983425016</i>
                    </p>
                </div>
                <div class="col-lg-auto m-2">
                    <h5>
                        <a href="https://maps.app.goo.gl/gHZHMqWKTCRTMqD97" target="_blank" style="text-decoration: none">
                            <img src="{{ asset('images/icon/location.png') }}" alt="" style="width: 2rem" class="rounded float-start">
                            สำนักงานเลขา
                        </a>
                    </h5>
                    <p>
                        <ins>สำนักงานเลขาเจ้าคณะจังหวัดสิงห์บุรี</ins>
                        <br>พระครูสุตวชิราภรณ์<sup>เลขานุการ</sup>
                        <br><ins>สำนักงานเลขาเจ้าคณะตำบล</ins>
                        <br>พระมหาอาทร ฐิตปสาโท <sup>เลขานุการ</sup>
                    </p>
                </div>
                <div class="col-lg-auto m-2">
                    <h5>
                        <a href="https://maps.app.goo.gl/pbNSwjyN6ubGyWUx5" target="_blank" style="text-decoration: none">
                            <img src="{{ asset('images/icon/location.png') }}" alt="" style="width: 2rem" class="rounded float-start">
                            สำนักปฏิบัติธรรม
                        </a>
                    </h5>
                    <p>
                        พระครูสุตวชิราภรณ์
                    </p>
                </div>
                <div class="col-lg-auto m-2">
                    <h5>
                        <a href="https://www.facebook.com/profile.php?id=100066846924558" target="_blank" style="text-decoration: none">
                            <img src="{{ asset('images/icon/facebook.png') }}" alt="" style="width: 2rem" class="rounded float-start">
                            โครงการธรรมยาตรา <br><i>ธุดงค์ต่างประเทศ</i>
                        </a>
                    </h5>
                    <p>
                        พระครูปลัดสิริวัฒน์(พี่อั้ม)
                        <br><i>โทร 0993265555</i>
                    </p>
                </div>
            </div>
        </div>
    </footer>
</html>
