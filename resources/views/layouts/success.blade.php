<style>
    .scroll-images {
  width: 100%;
  height: auto;
  display: flex;
  flex-wrap: nowrap;
  overflow-x: auto;
  overflow-y: hidden;
  scroll-behavior: smooth;
  -webkit-overflow-scrolling: touch;
}

.scroll-images::-webkit-scrollbar {
  width: 5px;
  height: 8px;
  background-color: #aaa;
}

.scroll-images::-webkit-scrollbar-thumb {
  background-color: black;
}
</style>
<div style="width: 100%;overflow: auto;display: -webkit-inline-box" class="justify-content-center scroll-images">

    @foreach ($success as $item)
        <div class="p-3 m-2 bg-white bg-opacity-10 rounded" style="max-width: 150px" id="person">
            <div style="height: 120px;overflow: hidden;width: 100%;" class="text-center rounded-circle">
                @if ($item->personnel->path != '')
                    <img src="{{ asset($item->personnel->path) }}" alt="" width="100%">
                @else
                    <img src="{{ asset('storage/person/no.png') }}" alt="" width="100%">
                @endif
            </div>
            <div class="text-white text-start mt-2">
                @php
                    $flagName = '';
                    $flagLastname = '';
                    if ($item->personnel->ordain_monk != '' ) {
                        if ($item->course->supject->name == 'ประโยค ๑-๒') {
                            $flagName = 'พระ';
                        } else {
                            $flagName = 'พระมหา';
                        }
                        $flagLastname = $item->personnel->ordianation_name;
                    } else {
                        if ($item->personnel->ordain_novice != '') {
                            $flagName = 'สามเณร';

                        } else {
                            $flagName = 'คุณ';
                        }
                        $flagLastname = $item->personnel->lastname;
                    }

                @endphp
                <a href="{{ route('personInfo',['id'=>$item->personnel->id]) }}" class="nav-link">
                    {{ $flagName }}{{ $item->personnel->name }} {{ $flagLastname }}
                </a>
            </div>
            <div class="text-start" style="color: #8492ea"><small>{{ $item->course->supject->name }}</small></div>
        </div>
    @endforeach
</div>