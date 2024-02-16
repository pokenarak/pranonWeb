<div class="display">
    <div class="portfolio-item row">
        @foreach ($dataGallery as $item)
            <div class="item selfie col-lg-2 col-md-4 col-6 col-sm">
                <img src="{{ asset($item->path) }}" alt="" style="overflow: auto" data-bs-toggle="modal" data-bs-target="#exampleModal">
            </div>
        @endforeach
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <img alt="" style="overflow: auto" class="imageShow w-100" >
                </div>
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

