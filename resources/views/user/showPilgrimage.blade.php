<x-guest-layout>
    <style>
        .uk-timeline .uk-timeline-item .uk-card {
            max-height: 300px;
        }

        .uk-timeline .uk-timeline-item {
            display: flex;
            position: relative;
        }

        .uk-timeline .uk-timeline-item::before {
            background: #dadee4;
            content: "";
            height: 100%;
            left: 19px;
            position: absolute;
            top: 20px;
            width: 2px;
                z-index: -1;
        }

        .uk-timeline .uk-timeline-item .uk-timeline-icon .uk-badge {
            margin-top: 20px;
            width: 40px;
            height: 40px;
        }

        .uk-timeline .uk-timeline-item .uk-timeline-content {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            padding: 0 0 0 1rem;
        }

        .uk-badge {
            box-sizing: border-box;
            min-width: 22px;
            height: 22px;
            padding: 0 5px;
            border-radius: 500px;
            vertical-align: middle;
            color: #fff;
            font-size: .875rem;
            display: inline-flex;
            justify-content: center;
            align-items: center
        }
        .uk-badge-in {
            background: #1e87f0;
        }
        .uk-badge-out {
            background: #8ab100;
        }
        ::-webkit-scrollbar {
            width: 0px;
            background: transparent; /* make scrollbar transparent */
        }
    </style>
    <div class="container pt-4" style="margin-top: 90px;height: 90%;">
        <div class="card border-0">
            <div class="card-body">
                <div class="container-fluid" >
                    <div class="row">
                        <div class="col">
                            <div class="pb-4 text-center">
                                {{-- <h2>ธุดงค์{{ $stops->pilgrimage->stage }}</h2> --}}
                                <h3 class="{{ $stops->pilgrimage->stage =='ในประเทศ' ? 'text-primary':'text-warning' }}">{{ $stops->pilgrimage->name }}</h3>
                                <h5>{{ $stops->pilgrimage->detail }}</h5>
                                <h4>{{ \Carbon\Carbon::parse($stops->pilgrimage->start)->addYear(543)->locale('th')->isoFormat('D MMMM พ.ศ.YYYY') }}
                                -
                                {{ \Carbon\Carbon::parse($stops->pilgrimage->end)->addYear(543)->locale('th')->isoFormat('D MMMM พ.ศ.YYYY') }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="container-fluid">
                            <div class="row">
                                @php
                                    $data = $pilgrimage->stop->sortDesc();
                                @endphp
                                <div class="cols col-md-4" style="height: 70vh;overflow: auto;">
                                    <div class="uk-container uk-padding">
                                        <div class="uk-timeline">
                                            @foreach ($data as $index => $item)
                                                @include('layouts.pilgrimage')
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    @php
                                        $dataGallery = $stops->stopImage;
                                    @endphp
                                    @include('layouts.gallery')
                                </div>
                            </div>                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
