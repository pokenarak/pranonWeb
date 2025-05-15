<x-guest-layout>
    <style>
        img{
            width: 12rem; 
            height:12rem; 
            object-fit: cover; 
        }
        #person{
            transition: .3s;
            background-image: linear-gradient(120deg, #fdfbfb 0%, #ebedee 100%);
        }
        #person:hover {
            transform: scale(1.1);
            box-shadow: 0 0 25px -5px #ccc;
        }
    </style>
    <div class="container-fluid pt-4 pb-4 rounded-3" style="margin-top: 90px;height: 90%;">
        <div class="pb-4 text-center" style="display: flex;justify-content: center">
            <div class="container-lg">
                <div class="card border-0">
                    <div class="card-body">
                        <h2>ทำเนียบประโยค ๙ &nbsp;&nbsp;</h2>
                        <div class="constant mt-5">
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
                                @foreach ($registers as $register)
                                    @php
                                        $person = $register->personnel;    
                                        $course = $register->course;    
                                        $nameTitle='คุณ';
                                        if ($person->ordain_monk != '') {
                                            $nameTitle = 'พระมหา';
                                        } else if ($person->ordain_novice != ''){
                                            $nameTitle = 'สามเณร';
                                        }
                                        $person->name = $nameTitle.$person->name;
                                    @endphp
                                    <div class="col m-2 text-center p-3 rounded-3" id="person">
                                    
                                        @if ($person->path != '')
                                            <img src="{{ asset($person->path) }}" alt="" class="rounded-circle">
                                        @else
                                            <img src="{{ assret('images/person/no.png') }}" alt="" class="rounded-circle">
                                        @endif
                                        <div class="row text-center mt-2">
                                            <div class="col-sm-12">
                                                <h5 class="{{ $person->active == 1 ? 'text-primary' : 'text-dark' }}  fw-bold">{{ $person->name }} <small class="text-muted">{{ $person->lastname }}</small> {{ $person->ordianation_name }}</h5>
                                            </div>
                                        </div>
                                        <div class="row text-center mt-2">
                                            <div class="col">
                                                <small class="text-muted">สอบผ่านปี พ.ศ.</small>
                                                <b>{{ $course->year+543 }}</b>
                                            </div>
                                        </div>
                                        <div class="row text-center mt-2 d-grid gap-2 col-6 mx-auto">
                                            <a class="btn btn-outline-info" href="{{ route('personInfo',['id'=>$person->id]) }}" role="button">รายละเอียด</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
