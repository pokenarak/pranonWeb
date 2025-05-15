<div class="card border-0 shadow-sm mb-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="คลิกเพื่อชมรูปภาพ">
    <div class="card-body ">
        <div class="d-flex justify-content-between align-items-start">
            <blockquote class="blockquote mb-0">
                <p>{{ \Carbon\Carbon::parse($item->date)->addYear(543)->locale('th')->isoFormat(' D MMMM YY') }}</p>
                <footer class="blockquote-footer">จุดหมาย : {{ $item->detail }}</footer>
            </blockquote>
            @if ($item->stopImage->count()>0)
                <span class="badge bg-success rounded-pill">ผ่าน</span>
            @else
                <span class="badge bg-warning rounded-pill">รอ</span>
            @endif
        </div>
        <p class="card-text">รูป : {{ $item->stopImage->count() }}</p>
    </div>
</div>