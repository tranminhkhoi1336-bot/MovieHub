<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class SearchDropdown extends Component
{
    public $search = '';

    public function render()
    {
        $searchResults = [];

        $cinemaSearchResults = collect();

        if (strlen($this->search) >= 2) {
            $searchResults = Http::withToken(config('services.tmdb.token'))
                ->get('https://api.themoviedb.org/3/search/movie?query='.$this->search)
                ->json()['results'];
                
                $cinemaSearchResults = \App\Movie::where(
                    'title',
                    'like',
                    '%' . trim($this->search) . '%'
                )
                ->orderBy('id', 'desc')
                ->limit(5)
                ->get();

        }

        // dump($searchResults);

        
return view('livewire.search-dropdown', [
    'searchResults' => collect($searchResults)->take(7),
    'cinemaSearchResults' => $cinemaSearchResults,
]);

    }
}
