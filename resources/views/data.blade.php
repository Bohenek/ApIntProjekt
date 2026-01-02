@extends('layout')

@section('content')
<div class="h-full flex flex-col relative text-[var(--pip-green)] tracking-wide">

    <div class="flex-1 flex pb-8 overflow-hidden">
        <div class="w-1/2 pr-2 border-r border-[var(--pip-green)]/50 overflow-y-auto">
            <ul class="space-y-2" role="listbox">
                @php
                    $items = ($tab == 'quests') ? $quests : $notes;
                @endphp

                @foreach($items as $item)
                <li onclick="showData(this, 'content-{{ $item->id }}')"
                    onkeydown="if(event.key === 'Enter' || event.key === ' ') { showData(this, 'content-{{ $item->id }}'); event.preventDefault(); }"
                    tabindex="0"
                    role="option"
                    aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                    
                    class="data-row px-2 cursor-pointer flex items-center
                           border border-transparent outline-none
                           hover:bg-[var(--pip-green)] hover:text-black
                           focus:bg-[var(--pip-dim)] focus:border-[var(--pip-green)]
                           {{ $loop->first ? 'bg-[var(--pip-green)] text-black active-data' : '' }}">
                    
                    @if($tab == 'quests') 
                        <span class="mr-2 inline-block w-3 h-3 bg-current square-bullet {{ $loop->first ? 'opacity-100' : 'opacity-0' }}"></span>
                    @endif
                    
                    <span class="truncate">{{ $item->title }}</span>
                </li>
                @endforeach
            </ul>
        </div>

        <div class="w-1/2 pl-4 overflow-y-auto relative">
            
            @if($items->isEmpty())
                <p>No data found.</p>
            @endif

            @foreach($items as $item)
                <div id="content-{{ $item->id }}" class="data-content {{ $loop->first ? '' : 'hidden' }}">
                    
                    @if($tab == 'quests')
                        <div class="text-right text-sm mb-4 opacity-80 uppercase tracking-widest">Show Location</div>
                        <h3 class="text-xl mb-4 uppercase font-bold border-b border-[var(--pip-green)] pb-1">{{ $item->title }}</h3>
                        
                        <p class="mb-6 text-lg opacity-90 leading-relaxed">{{ $item->description }}</p>

                        <ul class="space-y-4">
                            <li class="flex items-start gap-2 opacity-60">
                                <span class="border border-[var(--pip-green)] w-4 h-4 block flex-shrink-0 relative mt-1">
                                    <span class="absolute inset-0.5 bg-[var(--pip-green)]"></span>
                                </span>
                                <span>Quest objective completed.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="border border-[var(--pip-green)] w-4 h-4 block flex-shrink-0 mt-1"></span>
                                <span>Current objective for {{ $item->title }}.</span>
                            </li>
                        </ul>

                    @elseif($tab == 'notes')
                        <div class="text-right text-sm mb-4 opacity-80 uppercase">Audio/Text</div>
                        <h3 class="text-lg mb-4 uppercase font-bold">> {{ $item->title }}</h3>
                        
                        <div class="text-xl leading-relaxed whitespace-pre-wrap">
{{ $item->content }}
                        </div>
                        <div class="mt-8 opacity-70 text-right">-- END OF MESSAGE --</div>
                    @endif
                </div>
            @endforeach

        </div>
    </div>

    <div class="flex justify-between text-lg uppercase border-t-2 border-[var(--pip-green)] pt-1" role="tablist">
        <a href="#" class="opacity-50 hover:text-[var(--pip-green)]" role="tab" aria-disabled="true">Local Map</a>
        <a href="#" class="opacity-50 hover:text-[var(--pip-green)]" role="tab" aria-disabled="true">World Map</a>
        
        <a href="?tab=quests" role="tab" aria-selected="{{ $tab == 'quests' ? 'true' : 'false' }}"
           class="focus:outline-none focus:bg-[var(--pip-dim)] focus:border focus:border-[var(--pip-green)]
                  {{ $tab == 'quests' ? 'bg-[var(--pip-green)] text-black px-1' : 'opacity-70 hover:opacity-100' }}">
           Quests
        </a>
        
        <a href="?tab=notes" role="tab" aria-selected="{{ $tab == 'notes' ? 'true' : 'false' }}"
           class="focus:outline-none focus:bg-[var(--pip-dim)] focus:border focus:border-[var(--pip-green)]
                  {{ $tab == 'notes' ? 'bg-[var(--pip-green)] text-black px-1' : 'opacity-70 hover:opacity-100' }}">
           Notes
        </a>
        
        <a href="#" class="opacity-50 hover:text-[var(--pip-green)]" role="tab" aria-disabled="true">Radio</a>
    </div>

</div>

<script>
    function showData(el, contentId) {
        document.querySelectorAll('.data-row').forEach(li => {
            li.classList.remove('bg-[var(--pip-green)]', 'text-black', 'active-data');
            li.setAttribute('aria-selected', 'false');
            const bullet = li.querySelector('.square-bullet');
            if(bullet) bullet.classList.add('opacity-0');
        });

        el.classList.add('bg-[var(--pip-green)]', 'text-black', 'active-data');
        el.setAttribute('aria-selected', 'true');
        el.focus();
        
        const bullet = el.querySelector('.square-bullet');
        if(bullet) bullet.classList.remove('opacity-0');

        document.querySelectorAll('.data-content').forEach(div => {
            div.classList.add('hidden');
        });
        
        const content = document.getElementById(contentId);
        if(content) {
            content.classList.remove('hidden');
        }
    }
</script>
@endsection