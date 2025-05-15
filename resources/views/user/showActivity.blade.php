<x-guest-layout>
    <div class="container-xxl pt-4">
        <div class="row">
            <div class="col">
                <div class="text-center">
                    <h2>{{ $activities->topic }}</h2>
                    <span class="badge rounded-pill text-bg-info">{{ $activities->type }}</span> <b>:</b>
                    <small class="text-muted">{{ \Carbon\Carbon::parse($activities->date)->addYear(543)->locale('th')->isoFormat('dddd ที่ D MMMM พ.ศ.YYYY') }}</small>
                    <h5 class="mt-2">{{ $activities->detail }}</h5>
                </div>
            </div>
        </div>
        @php
            $dataGallery = $activities->image;
        @endphp
        @include('layouts.gallery')
    </div>
</x-guest-layout>
