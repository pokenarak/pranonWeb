<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    <div class="container-lg">
        <div class="card border-0">
            <div class="card-body">
                <div class="pb-4 text-center">
                    <h2>ธุดงค์</h2>
                </div>
                <div class="container">
                    <ul class="list-group list-group-flush">
                        <div class="row justify-content-center">
                            @foreach ($pilgrimage as $item)
                                <div class="col col-md-6 rounded mb-3">
                                    <div class="list-group-item" aria-current="true">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="ms-2 me-auto">
                                                <div class="fw-bold">{{ $item->name }}</div>
                                                <div class="text-muted fst-italic">- {{ $item->detail }}</div>
                                                <b>เริ่ม :</b> {{ \Carbon\Carbon::parse($item->start)->addYear(543)->locale('th')->isoFormat('D MMMM YYYY') }}
                                                <b>ถึง :</b> {{ \Carbon\Carbon::parse($item->end)->addYear(543)->locale('th')->isoFormat('D MMMM YYYY') }}
                                                <div><small class="text-muted">จุดหมาย <b>{{ $item->stop->count() }}</b> จุด</small></div>
                                            </div>
                                            <span class="badge {{ $item->stage =='ในประเทศ' ? 'bg-primary':'bg-warning text-dark' }} rounded-pill">{{ $item->stage}}</span>
                                        </div>
                                        <div class="row">
                                            <form action="{{ route('pilgrimage.destroy',['pilgrimage'=>$item->id]) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('DELETE')
                                                <div class="text-center">
                                                    <a href="{{ route('pilgrimage.edit',['pilgrimage'=>$item->id]) }}" class="btn btn-outline-warning btn-sm">แก้ไข</a>
                                                    <button type="submit" class="btn btn-outline-danger btn-sm">ลบ</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card border-0 mt-3">
            <div class="card-body d-grid gap-1">
                <a href="{{ route('pilgrimage.create') }}" class="btn btn-primary">เพิ่ม</a>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                  <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif
    <script>
        window.onload = (event)=> {
            let myAlert = document.querySelector('.toast');
            let bsAlert = new  bootstrap.Toast(myAlert);
            bsAlert.show();
        }
    </script>
</x-app-layout>
