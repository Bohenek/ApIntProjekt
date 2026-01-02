@extends('layout')

@section('content')
<div class="h-full flex flex-col relative text-[var(--pip-green)] tracking-wide">
    
    <div class="flex-1 flex overflow-hidden pb-8">
        
        <div class="w-1/2 pr-2 border-r border-[var(--pip-green)]/50 overflow-y-auto">
            <ul class="space-y-1" id="items-list" role="listbox">
                @php
                    $currentItems = match($tab) {
                        'weapons' => $weapons,
                        'apparel' => $apparel,
                        'aid' => $aid,
                        'misc' => $misc,
                        'ammo' => $ammo,
                        default => $weapons
                    };
                @endphp

                @foreach($currentItems as $index => $item)
                    <div class="flex group hover:bg-[var(--pip-green)] hover:text-black focus-within:bg-[var(--pip-green)] focus-within:text-black {{ $loop->first ? 'bg-[var(--pip-green)] text-black active-item' : '' }}">
                        
                        <li onclick="selectItem(this)"
                            onkeydown="if(event.key === 'Enter' || event.key === ' ') { selectItem(this); event.preventDefault(); }"
                            tabindex="0"
                            role="option"
                            class="item-row flex-1 flex justify-between px-2 py-0.5 cursor-pointer outline-none"
                            
                            data-name="{{ $item->name }}"
                            data-wg="{{ $item->weight ?? 0 }}"
                            data-val="{{ $item->value ?? 0 }}"
                            data-stat="{{ $tab == 'weapons' ? ($item->damage ?? 0) : ($tab == 'apparel' ? ($item->dr ?? 0) : ($item->effect ?? '-')) }}"
                            data-cond="{{ $item->condition ?? 100 }}"
                            >
                            
                            <span class="truncate">{{ $item->name }}</span>
                            @if(isset($item->quantity))
                                <span>({{ $item->quantity }})</span>
                            @endif
                        </li>

                        @if(Auth::check() && Auth::user()->is_admin)
                            <form action="{{ route('items.delete', $item->id) }}" method="POST" class="border-l border-black/20 flex items-center">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="type" value="{{ $tab }}">
                                <button type="submit" 
                                        class="px-2 h-full text-xs font-bold hover:bg-red-600 hover:text-white focus:bg-red-600 focus:text-white focus:outline-none"
                                        title="Delete Item">
                                    [DEL]
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </ul>
        </div>

        <div class="w-1/2 pl-4 flex flex-col items-center pt-4">
            <div class="w-32 h-32 mb-4 flex items-center justify-center opacity-80">
                <svg viewBox="0 0 24 24" fill="currentColor" class="w-24 h-24">
                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 9h-2V7h2v5zm0 4h-2v-2h2v2z"/>
                </svg>
            </div>

            <div class="w-full text-lg mt-auto mb-4 uppercase">
                <div class="grid grid-cols-3 border-t-2 border-b-2 border-[var(--pip-green)] mb-2">
                    <div class="p-1 border-r border-[var(--pip-green)]">
                        @if($tab == 'weapons') DAM 
                        @elseif($tab == 'apparel') DR 
                        @else EFF @endif 
                        <span class="float-right" id="detail-stat">
                            {{ $currentItems->first() ? ($tab == 'weapons' ? $currentItems->first()->damage : ($tab == 'apparel' ? $currentItems->first()->dr : ($currentItems->first()->effect ?? '-'))) : '-' }}
                        </span>
                    </div>
                    
                    <div class="p-1 border-r border-[var(--pip-green)]">WG <span class="float-right" id="detail-wg">{{ $currentItems->first()->weight ?? 0 }}</span></div>
                    <div class="p-1">VAL <span class="float-right" id="detail-val">{{ $currentItems->first()->value ?? 0 }}</span></div>
                </div>

                @if(in_array($tab, ['weapons', 'apparel']))
                    <div class="flex items-center gap-2">
                        <span>CND</span>
                        <div class="flex-1 h-4 border border-[var(--pip-green)] p-0.5">
                            <div id="detail-cnd" class="h-full bg-[var(--pip-green)]" style="width: {{ $currentItems->first()->condition ?? 100 }}%"></div>
                        </div>
                    </div>
                    <div class="text-right text-sm mt-1 opacity-80 lowercase first-letter:uppercase">Item Condition</div>
                @endif
                
                @if($tab == 'aid')
                    <div class="border-t border-[var(--pip-green)] mt-2 pt-1 text-sm">
                        EFFECTS: <span id="detail-effect-text">{{ $currentItems->first()->effect ?? 'None' }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="flex justify-between text-lg uppercase border-t-2 border-[var(--pip-green)] pt-1" role="tablist">
        @foreach(['weapons', 'apparel', 'aid', 'misc', 'ammo'] as $cat)
            <a href="?tab={{ $cat }}" 
               class="{{ $tab == $cat ? 'bg-[var(--pip-green)] text-black px-1' : 'opacity-70 hover:text-[var(--pip-green)] hover:opacity-100' }}">
               {{ ucfirst($cat) }}
            </a>
        @endforeach
    </div>
</div>

<script>
    function selectItem(el) {
        // Resetowanie styli w wierszach (tylko w części li)
        document.querySelectorAll('.item-row').forEach(li => {
            // Usuwamy klasy z elementu li
            // (Rodzic div obsługuje hover, ale active musimy obsłużyć JS lub CSS)
            li.parentElement.classList.remove('bg-[var(--pip-green)]', 'text-black', 'active-item');
        });

        // Aktywacja rodzica (div)
        el.parentElement.classList.add('bg-[var(--pip-green)]', 'text-black', 'active-item');
        el.focus();

        const wg = el.getAttribute('data-wg');
        const val = el.getAttribute('data-val');
        const stat = el.getAttribute('data-stat');
        const cond = el.getAttribute('data-cond');

        if(document.getElementById('detail-wg')) document.getElementById('detail-wg').innerText = wg;
        if(document.getElementById('detail-val')) document.getElementById('detail-val').innerText = val;
        if(document.getElementById('detail-stat')) document.getElementById('detail-stat').innerText = stat;
        if(document.getElementById('detail-effect-text')) document.getElementById('detail-effect-text').innerText = stat;
        
        const cndBar = document.getElementById('detail-cnd');
        if(cndBar) cndBar.style.width = cond + '%';
    }
</script>
@endsection