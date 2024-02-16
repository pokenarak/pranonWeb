<x-guest-layout>
    <div class="container-xxl pt-4">
        <div class="row">
            <div class="col">
                <div class="pb-4 text-center">
                    <h2>{{ $activities->topic }}</h2>
                    <small class="text-muted">{{ \Carbon\Carbon::parse($activities->date)->addYear(543)->locale('th')->isoFormat('dddd ที่ D MMMM พ.ศ.YYYY') }}</small>
                    <h5>{{ $activities->detail }}</h5>
                </div>
            </div>
        </div>
        @php
            $dataGallery = $activities->image;
        @endphp
        @include('layouts.gallery')
    </div>
</x-guest-layout>
