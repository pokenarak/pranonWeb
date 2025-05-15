<x-guest-layout>
    <div class="container-fluid pt-4 pb-4 rounded-3" style="margin-top: 90px;height: 90%;">
        <div class="pb-4 text-center" style="display: flex;justify-content: center">
            <div class="container-lg">
                <div class="card border-0">
                    <div class="card-body">
                        <h2>{{ $news->topic }}</h2>
                        <div class="clearfix">
                            <div class="col-md-6 float-md-end mb-3 ms-md-3">

                                <figure class="figure">
                                    <img src="{{ asset($news->image) }}"  alt="..." class="figure-img img-fluid rounded" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <figcaption class="figure-caption text-end">{{ \Carbon\Carbon::parse($news->date)->addYear(543)->locale('th')->isoFormat('D MMMM YYYY') }} <i>เมื่อ</i> {{ \Carbon\Carbon::parse($news->created_at)->locale('th')->diffForHumans() }}</figcaption>
                                  </figure>
                            </div>

                            <p class="mt-3">{{ $news->detail }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <img alt="" style="overflow: auto" class="imageShow w-100" >
                </div>
            </div>
        </div>
    </div>
    <script>
        var exampleModal = document.getElementById('exampleModal')
        exampleModal.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
            var button = event.relatedTarget
            var img = exampleModal.querySelector('.imageShow');
            img.src = button.src;
        })
    </script>
</x-guest-layout>
