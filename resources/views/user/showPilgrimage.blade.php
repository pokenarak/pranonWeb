<x-guest-layout>
    <style>
        h4{
            text-shadow: 1px 1px 2px black;
            padding: 10px
        }
        .timeline-steps {
            display: flex;
            justify-content: center;
            flex-wrap: wrap
        }

        .timeline-steps .timeline-step {
            align-items: center;
            display: flex;
            flex-direction: column;
            position: relative;
            margin: 1rem
        }

        @media (min-width:768px) {
            .timeline-steps .timeline-step:not(:last-child):after {
                content: "";
                display: block;
                border-top: .25rem dotted hsla(335, 87%, 30%, 0.842);
                width: 3.46rem;
                position: absolute;
                left: 7.5rem;
                top: .3125rem
            }
            .timeline-steps .timeline-step:not(:first-child):before {
                content: "";
                display: block;
                border-top: .25rem dotted hsla(335, 87%, 30%, 0.842);
                width: 3.8125rem;
                position: absolute;
                right: 7.5rem;
                top: .3125rem
            }
        }

        .timeline-steps .timeline-content {
            width: 10rem;
            text-align: center
        }

        .timeline-steps .timeline-content .inner-circle {
            border-radius: 1.5rem;
            height: 1rem;
            width: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            /* background-color: #3b82f6 */
        }

        .timeline-steps .timeline-content .inner-circle:before {
            content: "";
            background-color: hsla(335, 78%, 45%, 0.842);
            display: inline-block;
            height: 3rem;
            width: 3rem;
            min-width: 3rem;
            border-radius: 6.25rem;
            opacity: .5
        }
        span {
            content: "\2713";
        }
    </style>


    <div class="container-fluid pt-4" style="margin-top: 90px;height: 90%;">
        <div class="card border-0">
            <div class="card-body">
                <div class="container-fluid " >
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
                                    $data->values()->all();
                                @endphp
                                <div class="timeline-steps aos-init aos-animate" data-aos="fade-up">
                                    @foreach ($data->sortBy('date')->all() as $index => $item)
                                    <div class="timeline-step">
                                        <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2003">
                                            <a href="{{ route('showPilgrimage',['id'=>$item->id]) }}" class="text-decoration-none mt-3">
                                                <div class="inner-circle">
                                                    <div style="position: absolute" class="fs-3 fw-bold {{ URL::current()==route('showPilgrimage',['id'=> $item->id])?'text-danger':'text-white' }}">
                                                        @if ($item->stopImage->count()>0 )
                                                            <span>&#10003;</span>
                                                        @else
                                                           {{ $index+1 }}
                                                        @endif

                                                    </div>
                                                </div>
                                            </a>
                                            <p class="h6 mt-3 mb-1">
                                                {{ $item->detail }}
                                            </p>
                                            <p class="h6 text-muted mb-0 mb-lg-0">{{ \Carbon\Carbon::parse($item->date)->addYear(543)->locale('th')->isoFormat('D MMM YY') }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row">
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
</x-guest-layout>
