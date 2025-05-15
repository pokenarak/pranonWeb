<x-app-layout>
    <div class="container-fluid">
        <div class="card border-0">
            <div class="card-body">
                <div class="pb-4 mt-2 text-center">
                    <h2>ปฏิทินการศึกษา</h2>
                </div>
                <div class=" text-center">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ลำดับ</th>
                                <th scope="col">ไฟล์</th>
                                <th scope="col">ปี</th>
                                <th scope="col">ลบ</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach ($calendars as $index => $item)
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td><a href="{{ route('calendar.show',['calendar'=>$item]) }}">{{ $item->path }}</a></td>
                                        <td>{{ $item->year+543 }}</td>
                                        <td>
                                            <form action="{{ route('calendar.destroy',['calendar'=>$item]) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">ลบ</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($calendars->total()>$calendars->perPage())
                    {{ $calendars->links('pagination::bootstrap-5') }}
                @endif
            </div>
        </div>
    </div>
   <div class="container-lg">
        <div class="card border-0 mt-3">
            <div class="card-body d-grid gap-1">
                <form action="{{ route('calendar.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="hstack gap-3">
                        <input class="form-control me-auto" type="file" accept=".pdf" aria-label="กรุณาเลือกไฟล์ pdf เท่านั้น" name="file" required>
                        <div class="vr"></div>
                        <select class="form-select" aria-label="ปีพ.ศ." name="year" style="width: 100px">
                            @php
                                $year =  Carbon\Carbon::now()->year;
                            @endphp
                            @for ($i = 0; $i <100; $i++)
                                <option value="{{ $year-$i }}">{{ $year-$i+543 }}</option>
                            @endfor
                          </select>
                        <button type="submit" class="btn btn-primary">เพิ่ม</button>
                    </div>
                </form>
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
        const toastTrigger = document.getElementById('liveToastBtn')
        const toastLiveExample = document.getElementById('liveToast')

        if (toastTrigger) {
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
        toastTrigger.addEventListener('click', () => {
            toastBootstrap.show()
        })
        }
    </script>
</x-app-layout>
