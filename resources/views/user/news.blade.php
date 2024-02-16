<x-guest-layout>
    <div class="container-fluid pt-4 pb-4 rounded-3" style="margin-top: 90px;height: 90%;">
        <div class="pb-4 text-center" style="display: flex;justify-content: center">
            <div class="container-lg">
                <div class="card border-0">
                    <div class="card-body">
                        <h2>ข่าวประชาสัมพันธ์&nbsp;&nbsp;</h2>
                        <div class="constant mt-5">
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
                                @foreach ($news as $item)
                                    <div class="col">
                                        <div class="card mb-3 shadow border-0">
                                            <a class="text-decoration-none" href="{{ route('showNews',['id'=>$item->id]) }}">
                                                <img src="{{ asset($item->image) }}" class="card-img-top">
                                                <div class="card-body text-dark">
                                                    <h5 class="card-title">{{ $item->topic }}</h5>
                                                    <p class="card-text overflow-auto" style="max-height: 150px">{{ $item->detail }}</p>
                                                    <p class="card-text"><small class="text-body-secondary">{{ \Carbon\Carbon::parse($item->created_at)->locale('th')->diffForHumans() }}</small></p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($news->total()>$news->perPage())
            {{ $news->links('pagination::bootstrap-5') }}
        @endif
    </div>
</x-guest-layout>
