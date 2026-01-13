@extends('layout')

@section('content')
<div class="h-full flex flex-col relative text-[var(--pip-green)] tracking-wide">

    <div class="flex-1 flex pb-8 overflow-hidden">
        <div class="w-1/2 pr-2 border-r border-[var(--pip-green)]/50 overflow-y-auto">
            <h2 class="sr-only">Lista wpisów</h2>
            <ul class="space-y-2" role="listbox">
                @php
                    $items = ($tab == 'quests') ? $quests : $notes;
                @endphp

                @foreach($items as $item)
                <li onclick="showData(this, 'content-{{ $item->id }}')"
                    onkeydown="if(event.key === 'Enter' || event.key === ' ') { showData(this, 'content-{{ $item->id }}'); event.preventDefault(); }"
                    tabindex="0"
                    role="option"
                    aria-selected="false"
                    aria-controls="content-{{ $item->id }}"
                    class="data-row px-2 cursor-pointer flex items-center border border-transparent outline-none hover:bg-[var(--pip-green)] hover:text-black focus:bg-[var(--pip-dim)] focus:border-[var(--pip-green)]">
                    
                    @if($tab == 'quests') 
                        <span class="mr-2 inline-block w-3 h-3 bg-current square-bullet opacity-0" aria-hidden="true"></span>
                    @endif
                    
                    <span class="truncate pip-text-base">{{ $item->title }}</span>
                </li>
                @endforeach
            </ul>
        </div>

        <div class="w-1/2 pl-4 overflow-y-auto relative" aria-live="polite">
            
            @if($items->isEmpty())
                <p class="pip-text-base">No data found.</p>
            @else
                <div id="empty-state" class="flex h-full items-center justify-center opacity-50">
                    <div class="text-center border border-[var(--pip-green)] p-4">
                        <p class="uppercase tracking-widest blink pip-text-lg">SELECT ENTRY</p>
                    </div>
                </div>
            @endif

            @foreach($items as $item)
                <div id="content-{{ $item->id }}" class="data-content hidden" role="tabpanel">
                    
                    @if($tab == 'quests')
                        <div class="text-right pip-text-sm mb-4 opacity-80 uppercase tracking-widest" aria-hidden="true">Show Location</div>
                        <h3 class="pip-text-xl mb-4 uppercase font-bold border-b border-[var(--pip-green)] pb-1">{{ $item->title }}</h3>
                        
                        <p class="mb-6 pip-text-lg opacity-90 leading-relaxed">{{ $item->description }}</p>

                        <ul class="space-y-4 pip-text-base">
                            <li class="flex items-start gap-2 opacity-60">
                                <span class="border border-[var(--pip-green)] w-4 h-4 block flex-shrink-0 relative mt-1" aria-hidden="true">
                                    <span class="absolute inset-0.5 bg-[var(--pip-green)]"></span>
                                </span>
                                <span>Objective completed.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="border border-[var(--pip-green)] w-4 h-4 block flex-shrink-0 mt-1" aria-hidden="true"></span>
                                <span>Current objective active.</span>
                            </li>
                        </ul>

                    @elseif($tab == 'notes')
                        <div class="text-right pip-text-sm mb-4 opacity-80 uppercase" aria-hidden="true">Audio/Text</div>
                        <h3 class="pip-text-lg mb-4 uppercase font-bold"><span aria-hidden="true">></span> {{ $item->title }}</h3>
                        
                        @if(Auth::check() && Auth::user()->is_admin)
                            <form action="{{ route('notes.update', $item->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <label for="note-edit-{{ $item->id }}" class="sr-only">Edytuj treść</label>
                                <textarea id="note-edit-{{ $item->id }}" name="content" 
                                          class="w-full h-64 bg-black/30 border border-[var(--pip-green)] text-[var(--pip-green)] p-2 pip-text-lg focus:outline-none focus:bg-[var(--pip-dim)]"
                                >{{ $item->content }}</textarea>
                                
                                <div class="flex justify-end mt-2">
                                    <button type="submit" class="border border-[var(--pip-green)] px-4 py-1 hover:bg-[var(--pip-green)] hover:text-black uppercase pip-text-sm font-bold">
                                        Save Override
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="pip-text-xl leading-relaxed whitespace-pre-wrap">{{ $item->content }}</div>
                            <div class="mt-8 opacity-70 text-right pip-text-base" aria-hidden="true">-- END OF MESSAGE --</div>
                        @endif
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <nav class="flex justify-between pip-text-lg uppercase border-t-2 border-[var(--pip-green)] pt-1" role="tablist" aria-label="Zakładki danych">
        <a href="#" class="opacity-50 hover:text-[var(--pip-green)]" role="tab" aria-selected="false">Local Map</a>
        <a href="#" class="opacity-50 hover:text-[var(--pip-green)]" role="tab" aria-selected="false">World Map</a>
        <a href="?tab=quests" class="{{ $tab == 'quests' ? 'bg-[var(--pip-green)] text-black px-1' : 'opacity-70 hover:opacity-100' }}" role="tab" aria-selected="{{ $tab=='quests'?'true':'false'}}">Quests</a>
        <a href="?tab=notes" class="{{ $tab == 'notes' ? 'bg-[var(--pip-green)] text-black px-1' : 'opacity-70 hover:opacity-100' }}" role="tab" aria-selected="{{ $tab=='notes'?'true':'false'}}">Notes</a>
        <a href="#" class="opacity-50 hover:text-[var(--pip-green)]" role="tab" aria-selected="false">Radio</a>
    </nav>
</div>
@endsection

@section('scripts')
<script>
    function showData(el, contentId) {
        // Reset zaznaczenia
        document.querySelectorAll('.data-row').forEach(li => {
            li.classList.remove('bg-[var(--pip-green)]', 'text-black', 'active-data');
            li.setAttribute('aria-selected', 'false');
            const bullet = li.querySelector('.square-bullet');
            if(bullet) bullet.classList.add('opacity-0');
        });

        // Aktywacja
        el.classList.add('bg-[var(--pip-green)]', 'text-black', 'active-data');
        el.setAttribute('aria-selected', 'true');
        
        const bullet = el.querySelector('.square-bullet');
        if(bullet) bullet.classList.remove('opacity-0');

        // Obsługa treści
        const emptyState = document.getElementById('empty-state');
        if(emptyState) emptyState.classList.add('hidden');

        document.querySelectorAll('.data-content').forEach(div => {
            div.classList.add('hidden');
        });
        
        const content = document.getElementById(contentId);
        if(content) content.classList.remove('hidden');
    }
</script>
@endsection