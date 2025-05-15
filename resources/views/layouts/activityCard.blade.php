<div class="nft shadow">
    <div class='main'>
        <img class='tokenImage' src="{{ asset($item->lastestImage->path) }}" alt="NFT" />
        <h5 class="mt-2">
            <a href="{{ route('showActivityUser',['id'=>$item->id]) }}" class="stretched-link text-decoration-none">
                <b class="description text-truncate">{{ $item->topic }}</b>
            </a>
        </h5>
        <p class='description text-truncate'>{{ $item->detail }}</p>
        <div class='tokenInfo row'>
            <div class="price col">
                <p><cite title="Source Title" class="badge text-bg-primary">{{ $item->type }}</cite></p>
            </div>
            <div class="duration col">
                <ins>◷</ins>
                {{ \Carbon\Carbon::parse($item->date)->locale('th')->diffForHumans() }}
            </div>
        </div>
    </div>
</div>