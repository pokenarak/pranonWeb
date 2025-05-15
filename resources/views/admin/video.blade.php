<x-app-layout>
    <div class="container-fluid">
        <div class="card border-0">
            <div class="card-body">
                <div class="pb-4 mt-2 text-center">
                    <h2>วีดีทัศน์</h2>
                </div>
                <div class=" text-center">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 row-cols-lg-6 g-4">
                        @foreach ($videos as $item)
                            <div class="col">
                                <figure class="figure" style="width: 100%">
                                    <div class="ratio ratio-16x9">
                                        <iframe src="{{ $item->link }}" title="YouTube video" allowfullscreen></iframe>
                                    </div>
                                    <figcaption class="figure-caption text-end mt-2">
                                        <form action="{{ route('video.destroy',$item->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('DELETE')
                                            {{ \Carbon\Carbon::parse($item->date)->locale('th')->diffForHumans() }}
                                            <button type="submit" class="btn btn-danger">ลบ</button>
                                        </form>
                                    </figcaption>
                                </figure>
                            </div>
                        @endforeach
                    </div>
                </div>
                @if ($videos->total()>$videos->perPage())
                    {{ $videos->links('pagination::bootstrap-5') }}
                @endif
            </div>
        </div>
    </div>
   <div class="container-lg">
        <div class="card border-0 mt-3">
            <div class="card-body d-grid gap-1">
                <form action="{{ route('video.store') }}" method="POST" enctype="application/x-www-form-urlencoded">
                    @csrf
                    <div class="hstack gap-3">
                        <input class="form-control me-auto" type="text" placeholder="ตัวอย่าง https://youtu.be/ucfNn0L4BpU?si=rVCqWfsfFfbF5_Gu" aria-label="กรุณาระบุลิงค์เฉพาะ URL จาก Embed Link เท่านั้น" name="link">
                        <button type="submit" class="btn btn-primary">เพิ่ม</button>
                        <div class="vr"></div>
                        <button type="button" class="btn btn-outline-info" id="liveToastBtn">วิธี</button>
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
    {{-- Toasts Embed --}}
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">วิธีการเพิ่มลิงค์</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <ul class="list-unstyled">
                    <li>1. เลือกแชร์</li>
                    <li>2. เลือกฝั่ง หรือ embed</li>
                    <li>3. คัดลอกเฉพาะลิงค์ใน src</li>
                    <img src="{{ asset('images/embed.png') }}" class="img-thumbnail" alt="...">
                    <li>4. ลบอักขระด้านหลังเครื่องหมาย ? </li>
                    <img src="{{ asset('images/embed1.png') }}" class="img-thumbnail" alt="...">
                    <li>5. ให้เพิ่มคำว่า autoplay=1 ด้านหลังเครื่องหมาย ?</li>
                    <img src="{{ asset('images/embed2.png') }}" class="img-thumbnail" alt="...">
                </ul>
                

            </div>
        </div>
    </div>
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
