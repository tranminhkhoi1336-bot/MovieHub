<div class="relative mt-3 md:mt-0" x-data="{ isOpen: true }" @click.away="isOpen = false">
    <input
        wire:model.debounce.500ms="search"
        type="text"
        class="bg-gray-800 text-sm rounded-full w-64 px-4 pl-8 py-1 focus:outline-none focus:shadow-outline" placeholder="Search (Press '/' to focus)"
        x-ref="search"
        @keydown.window="
            if (event.keyCode === 191) {
                event.preventDefault();
                $refs.search.focus();
            }
        "
        @focus="isOpen = true"
        @keydown="isOpen = true"
        @keydown.escape.window="isOpen = false"
        @keydown.shift.tab="isOpen = false"
    >
    <div class="absolute top-0">
        <svg class="fill-current w-4 text-gray-500 mt-2 ml-2" viewBox="0 0 24 24"><path class="heroicon-ui" d="M16.32 14.9l5.39 5.4a1 1 0 01-1.42 1.4l-5.38-5.38a8 8 0 111.41-1.41zM10 16a6 6 0 100-12 6 6 0 000 12z"/></svg>
    </div>

    <div wire:loading class="spinner top-0 right-0 mr-4 mt-3"></div>

    @if (strlen($search) >= 2)
        
<div
    class="z-50 absolute bg-gray-800 text-sm rounded-lg mt-4"
    style="
        right:0;
        width:min(380px, calc(100vw - 32px));
        max-height:440px;
        overflow-y:auto;
        box-shadow:0 12px 28px rgba(0,0,0,0.35);
    "
    x-show.transition.opacity="isOpen"
>

        
<!-- KET QUA TIM KIEM PHIM MOVIEHUB -->

@if($cinemaSearchResults->count() > 0)

    <div style="padding:12px;
                color:#ff914d;
                font-weight:bold;
                border-bottom:1px solid #475569;">
        PHIM TẠI MOVIEHUB
    </div>

    @foreach($cinemaSearchResults as $cinemaMovie)

        <a href="{{ url('/cinema/movies/' . $cinemaMovie->id) }}"
           style="display:flex;
                  align-items:center;
                  gap:12px;
                  padding:12px;
                  color:white;
                  text-decoration:none;
                  border-bottom:1px solid #475569;">

            @if($cinemaMovie->poster)

                <img src="{{ $cinemaMovie->poster }}"
                     alt="{{ $cinemaMovie->title }}"
                     style="width:45px;
                            height:65px;
                            object-fit:cover;
                            border-radius:5px;">

            @endif

            <div style="flex:1; min-width:0;">

                <div style="font-weight:bold;
                            color:#ffffff;
                            margin-bottom:5px;">
                    {{ $cinemaMovie->title }}
                </div>

                <div style="font-size:12px;
                            color:#cbd5e1;">
                    {{ $cinemaMovie->genre }}
                </div>

                <div style="font-size:12px;
                            color:#ff914d;
                            margin-top:5px;">
                    Xem chi tiết - Đặt vé
                </div>

            </div>

        </a>

    @endforeach

@endif

<!-- KET THUC KET QUA MOVIEHUB -->

            @if ($searchResults->count() > 0)
            
<div style="
    padding:12px;
    color:#ff914d;
    font-weight:bold;
    border-bottom:1px solid #475569;
">
    PHIM TỪ TMDb
</div>

                <ul>
                    @foreach ($searchResults as $result)
                        <li class="border-b border-gray-700">
                            <a
                                href="{{ route('movies.show', $result['id']) }}" class="block hover:bg-gray-700 px-3 py-3 flex items-center transition ease-in-out duration-150"
                                @if ($loop->last) @keydown.tab="isOpen = false" @endif
                            >
                            @if ($result['poster_path'])
                                <img src="https://image.tmdb.org/t/p/w92/{{ $result['poster_path'] }}" alt="poster" class="w-8">
                            @else
                                <img src="https://via.placeholder.com/50x75" alt="poster" class="w-8">
                            @endif
                            <span class="ml-4">{{ $result['title'] }}</span>
                        </a>
                        </li>
                    @endforeach

                </ul>
            
@elseif($cinemaSearchResults->isEmpty())

                <div class="px-3 py-3">No results for "{{ $search }}"</div>
            @endif
        </div>
    @endif
</div>
