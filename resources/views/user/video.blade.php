<x-guest-layout>
    <div class="container-fluid pt-4 pb-4 rounded-3" style="margin-top: 90px;height: 90%;">
        <div class="pb-4 text-center" style="display: flex;justify-content: center">
            <div class="container-lg">
                <div class="card border-0">
                    <div class="card-body">
                        <h2>วีดีทัศน์&nbsp;&nbsp;</h2>
                        <div class="constant mt-5">
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
                                @foreach ($videos as $video)
                                    <div class="col">
                                        <div class="card mb-3 shadow border-0">
                                            <div class="ratio ratio-16x9">
                                                <iframe width="560" height="315" src="{{ $video->link }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($videos->total()>$videos->perPage())
            {{ $videos->links('pagination::bootstrap-5') }}
        @endif
    </div>
</x-guest-layout>
