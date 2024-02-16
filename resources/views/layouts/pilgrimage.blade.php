<div class="uk-timeline-item">
    <div class="uk-timeline-icon">
        <span class="fw-bold fs-5 uk-badge {{ $item->pilgrimage->stage == 'ในประเทศ' ? 'uk-badge-in':'uk-badge-out' }}">
            @if ($item->stopImage->count()>0 )
                <span>&#10003;</span>
            @else
                {{ $index+1 }}
            @endif
        </span>
    </div>
    <div class="uk-timeline-content">
        <a href="{{ route('showPilgrimage',['id'=>$item->id]) }}" style="text-decoration: none">
            <div class="card border-0 shadow-sm mb-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="คลิกเพื่อชมรูปภาพ">
                <div class="card-body ">
                    <div class="d-flex justify-content-between align-items-start">
                        <blockquote class="blockquote mb-0">
                            <p>{{ \Carbon\Carbon::parse($item->date)->addYear(543)->locale('th')->isoFormat(' D MMM YY') }}</p>
                            <footer class="blockquote-footer">จุดหมาย : {{ $item->detail }}</footer>
                        </blockquote>
                        @if ($item->stopImage->count()>0)
                            <span class="badge bg-success rounded-pill">ผ่าน</span>
                        @else
                            <span class="badge bg-warning rounded-pill">ยังไม่ผ่าน</span>
                        @endif
                    </div>
                    <p class="card-text">รูป : {{ $item->stopImage->count() }}</p>
                </div>
            </div>
        </a>
    </div>
</div>

