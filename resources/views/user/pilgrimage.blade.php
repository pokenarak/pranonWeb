<x-guest-layout>
    <div class="container-fluid pt-4 " style="margin-top: 90px;height: 90%;">
        <div class="pb-4 text-center">
            <h2>ธุดงค์</h2>
        </div>
        <div class="mt-3">
            <div class="row justify-content-center  row-cols-1 row-cols-sm-2 row-cols-md-4">
                @foreach ($pilgrimage as $item)
                    <div class="col mt-3 ">
                        <div class="card rounded-2 shadow">
                            <div class="row g-0">
                                <div class="rounded-start col-1 text-center {{ $item->stage =='ในประเทศ' ? 'bg-primary text-white':'bg-warning' }}" style=" writing-mode: vertical-lr;text-orientation: mixed;font-size:1.5rem;">
                                    {{ $item->stage }}
                                </div>
                                <div class="col-11">
                                    <div class="card-body">
                                        <blockquote class="blockquote mb-1">
                                            <p class="card-text"><a href="{{ route('showPilgrimage',['id'=>$item->firstStop]) }}" style="text-decoration: none;" class="w-100 fw-bold {{ $item->stage =='ในประเทศ' ? 'link-primary':'link-warning' }}">{{ $item->name }}</a></p>
                                            <footer class="blockquote-footer cuttext"> {{ $item->detail }}</footer>
                                        </blockquote>
                                        <hr>
                                        <b>เริ่ม :</b> {{ \Carbon\Carbon::parse($item->start)->addYear(543)->locale('th')->isoFormat('D MMMM YYYY') }}
                                        <b>ถึง :</b> {{ \Carbon\Carbon::parse($item->end)->addYear(543)->locale('th')->isoFormat('D MMMM YYYY') }}
                                        <div><small class="text-muted">จุดหมาย <b>{{ $item->stop->count() }}</b> จุด</small></div>
                                    </div>
                                    @if ($stops = $item->stop)
                                        <ul class="list-group list-group-flush overflow-auto rounded" style="max-height: 250px">
                                            @foreach ($stops as $stop)
                                            <a href="{{ route('showPilgrimage',['id'=>$stop->id]) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start text-wrap">
                                                <div class="ms-2 me-auto">
                                                    <div class="fw-bold">{{ $stop->detail }}</div>
                                                    <small class="text-muted">{{ \Carbon\Carbon::parse($stop->date)->addYear(543)->locale('th')->isoFormat('D MMMM YYYY') }}</small>
                                                </div>
                                                <span class="badge bg-info rounded-pill"> รูป : {{ $stop->stopImage->count() }}</span>
                                            </a>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-3">
                @if ($pilgrimage->total()>$pilgrimage->perPage())
                    {{ $pilgrimage->links('pagination::bootstrap-5') }}
                @endif
            </div>
        </div>
    </div>
</x-guest-layout>
