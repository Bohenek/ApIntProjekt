@extends('layout')

@section('content')
<div class="h-full flex flex-col relative text-[var(--pip-green)] tracking-wide">

    <div class="flex-1 flex pb-8 overflow-hidden">
        <div class="w-1/2 pr-4 overflow-y-auto border-r border-[var(--pip-green)]/30">
            <h2 class="sr-only">Statystyki: {{ ucfirst($tab) }}</h2>
            <ul class="space-y-1" role="listbox">
                @php
                    $listItems = match($tab) {
                        'special' => $specials,
                        'skills' => $skills,
                        'perks' => $perks,
                        'general' => $users,
                        default => collect()
                    };
                @endphp

                @if($tab == 'status')
                    <li class="px-2 py-1 border-b border-[var(--pip-green)]/30 flex justify-between pip-text-base">
                        <span>USER</span> <span>{{ Auth::check() ? Auth::user()->name : 'GUEST' }}</span>
                    </li>
                    <li class="px-2 py-1 border-b border-[var(--pip-green)]/30 flex justify-between pip-text-base">
                        <span>LEVEL</span> <span>16</span>
                    </li>
                    <li class="px-2 py-1 border-b border-[var(--pip-green)]/30 flex justify-between pip-text-base">
                        <span>HP</span> <span>320/350</span>
                    </li>
                    <li class="px-2 py-1 border-b border-[var(--pip-green)]/30 flex justify-between pip-text-base">
                        <span>XP</span> <span>14500</span>
                    </li>

                @elseif($tab == 'general')
                    <div class="px-2 py-2 pip-text-sm uppercase opacity-70 mb-2 border-b border-[var(--pip-green)]" id="user-label">Select Terminal User:</div>
                    
                    @foreach($users as $user)
                        <li role="none">
                            <a href="{{ route('login.sim', $user->id) }}" 
                               role="option"
                               aria-labelledby="user-label"
                               class="block px-2 py-1 border border-transparent hover:bg-[var(--pip-green)] hover:text-black cursor-pointer flex justify-between items-center group pip-text-base
                                      {{ (Auth::id() == $user->id) ? 'bg-[var(--pip-green)] text-black' : '' }}">
                                <span>{{ $user->name }}</span>
                                @if($user->is_admin)
                                    <span class="pip-text-xs border border-current px-1 group-hover:border-black font-bold" aria-label="Administrator">★ OVERSEER</span>
                                @endif
                            </a>
                        </li>
                    @endforeach

                @else
                    @foreach($listItems as $item)
                        <li onclick="selectStat(this)"
                            onkeydown="if(event.key === 'Enter' || event.key === ' ') { selectStat(this); event.preventDefault(); }"
                            tabindex="0"
                            role="option"
                            class="stat-row flex justify-between px-2 cursor-pointer border border-transparent outline-none hover:bg-[var(--pip-green)] hover:text-black focus:bg-[var(--pip-dim)] focus:border-[var(--pip-green)] group {{ $loop->first ? 'bg-[var(--pip-green)] text-black' : '' }} pip-text-base"
                            data-desc="{{ $item->description ?? ($item->name . ' information.') }}">
                            
                            <span>{{ $item->name }}</span>
                            @if(isset($item->value))
                                <span>{{ $item->value }} @if($tab=='skills') <span class="pip-text-xs opacity-70" aria-hidden="true">(-)</span> @endif</span>
                            @endif
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>

        <div class="w-1/2 flex flex-col items-center justify-between relative pl-4">
            
            <div class="mt-4 animate-pulse" aria-hidden="true">
                <svg class="w-40 h-40 fill-current text-[var(--pip-green)]" viewBox="0 0 100 100">
                     <circle cx="50" cy="50" r="40" stroke="currentColor" stroke-width="2" fill="none" />
                     <path d="M 30 65 Q 50 85 70 65" stroke="currentColor" stroke-width="3" fill="none" />
                     <circle cx="35" cy="40" r="5" />
                     <circle cx="65" cy="40" r="5" />
                </svg>
            </div>

            <div class="border border-[var(--pip-green)] p-2 pip-text-sm mt-auto w-full relative bg-black/80 min-h-[100px]" aria-live="polite">
                <div class="absolute -top-2 left-0 border-l border-t border-[var(--pip-green)] w-4 h-4" aria-hidden="true"></div>
                <div class="absolute -bottom-2 right-0 border-r border-b border-[var(--pip-green)] w-4 h-4" aria-hidden="true"></div>
                
                <p id="stat-description">
                    @if($tab == 'general')
                        @if(Auth::check() && Auth::user()->is_admin)
                            <strong>ACCESS GRANTED:</strong> Administrator clearance recognized. Database modification enabled.
                        @else
                            <strong>ACCESS RESTRICTED:</strong> Standard user privileges. Read-only mode active.
                        @endif
                    @elseif($tab == 'status')
                        Vault-Tec System V. 1.1<br>All systems nominal.
                    @elseif($listItems->isNotEmpty())
                        {{ $listItems->first()->description ?? '' }}
                    @endif
                </p>
            </div>
        </div>
    </div>

    <nav class="flex justify-between pip-text-lg uppercase border-t-2 border-[var(--pip-green)] pt-1" role="tablist" aria-label="Kategorie statystyk">
        @foreach(['status', 'special', 'skills', 'perks', 'general'] as $cat)
            <a href="?tab={{ $cat }}" 
               role="tab"
               aria-selected="{{ $tab == $cat ? 'true' : 'false' }}"
               class="{{ $tab == $cat ? 'bg-[var(--pip-green)] text-black px-1' : 'opacity-70 hover:opacity-100 hover:text-[var(--pip-green)]' }}">
               {{ ucfirst($cat) }}
            </a>
        @endforeach
    </nav>
</div>
@endsection

@section('scripts')
<script>
    function selectStat(el) {
        document.querySelectorAll('.stat-row').forEach(li => {
            li.classList.remove('bg-[var(--pip-green)]', 'text-black');
            li.setAttribute('aria-selected', 'false');
        });
        el.classList.add('bg-[var(--pip-green)]', 'text-black');
        el.setAttribute('aria-selected', 'true');
        el.focus();
        document.getElementById('stat-description').innerText = el.getAttribute('data-desc');
    }
</script>
@endsection