<x-guest-layout>
    <div class="container-fluid pt-4 pb-4 rounded-3" style="margin-top: 90px;height: 90%;">
        <div class="pb-4 text-center" style="display: flex;justify-content: center">
            <div class="card border-0">
                <div class="card-body">
                    <h2>มหาทานบดี</h2>
                </div>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 row-cols-xl-6 g-4">
                    @foreach ($donation as $i => $item)
                        <div class="col mb-2">
                            <div class="card text-center">
                                <img src="{{ asset('images/'.$item->path) }}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->name }}</h5>
                                    <div class="card-text">{{ $item->detail }}</div>
                                </div>
                                <div class="card-footer">
                                    <div class="card-text"><small class="text-body-secondary fst-italic">{{ \Carbon\Carbon::parse($item->date)->addYear(543)->locale('th')->isoFormat('dddd D MMMM YYYY') }}</small></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if ($donation->total()>$donation->perPage())
                    {{ $donation->links('pagination::bootstrap-5') }}
                @endif
            </div>
        </div>
    </div>
</x-guest-layout>

