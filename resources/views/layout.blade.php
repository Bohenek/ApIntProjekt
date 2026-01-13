<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pip-Boy 3000</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @font-face {
            font-family: 'Monofonto';
            src: url("{{ asset('fonts/monofonto rg.otf') }}") format('opentype');
            font-weight: normal;
            font-style: normal;
        }

        /* --- 1. ZMIENNE GLOBALNE I DOSTĘPNOŚĆ --- */
        :root {
            /* Kolory domyślne */
            --pip-green: #14f61b;
            --pip-dim: rgba(20, 246, 27, 0.2);
            --pip-bg: #0b1409;
            --pip-shadow: 0 0 5px var(--pip-green);
            
            /* Skalowanie czcionki (domyślnie 1.0) */
            --pip-font-scale: 1;
        }

        /* Klasy pomocnicze do skalowania tekstów (używamy ich zamiast sztywnych klas Tailwind) */
        .pip-text-xs   { font-size: calc(0.75rem * var(--pip-font-scale)); }
        .pip-text-sm   { font-size: calc(0.875rem * var(--pip-font-scale)); }
        .pip-text-base { font-size: calc(1rem * var(--pip-font-scale)); }
        .pip-text-lg   { font-size: calc(1.125rem * var(--pip-font-scale)); }
        .pip-text-xl   { font-size: calc(1.25rem * var(--pip-font-scale)); }
        .pip-text-2xl  { font-size: calc(1.5rem * var(--pip-font-scale)); }

        /* Tryb Wysokiego Kontrastu (WCAG AAA) */
        body.high-contrast {
            --pip-green: #FFFF00; 
            --pip-dim: rgba(255, 255, 0, 0.2);
            --pip-bg: #000000;
            --pip-shadow: none; 
        }

        /* --- 2. STYLE BAZOWE --- */
        body {
            font-family: 'Monofonto', monospace; 
            background-color: #111;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: var(--pip-green);
            overflow: hidden; /* Zapobiega scrollowaniu tła */
        }

        .pipboy-case {
            position: relative;
            width: 100%;
            max-width: 1600px;
            aspect-ratio: 16/9;
            background-size: cover;
            background-position: center;
        }

        .pipboy-screen {
            position: absolute;
            top: 14%;
            left: 33.5%;
            width: 43.5%;
            height: 55%;
            background: rgba(11, 20, 9, 0.95);
            color: var(--pip-green);
            text-shadow: var(--pip-shadow);
            border-radius: 5%;
            padding: 1.5rem;
            overflow-y: auto;
            box-shadow: inset 0 0 40px #000;
        }

        body.high-contrast .pipboy-screen {
            background: #000000;
            box-shadow: none;
        }

        /* --- 3. ANIMACJE I POMOCNIKI --- */
        @keyframes blink { 
            0%, 100% { opacity: 1; } 
            50% { opacity: 0.3; } 
        }
        .blink { animation: blink 2s infinite; }

        /* Klasa tylko dla czytników ekranu (Screen Reader Only) */
        .sr-only {
            position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px;
            overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border-width: 0;
        }

        /* --- 4. NAWIGACJA I FOCUS --- */
        ::-webkit-scrollbar { width: 12px; }
        ::-webkit-scrollbar-thumb { background: var(--pip-green); border-radius: 4px; }
        ::-webkit-scrollbar-track { background: #000; }

        .pip-knob {
            position: absolute;
            background-color: transparent;
            border-radius: 50%;
            cursor: pointer;
            z-index: 50;
            border: 2px solid transparent; 
        }

        /* Wyraźny focus dla klawiatury */
        *:focus-visible {
            outline: 2px solid var(--pip-green);
            background-color: var(--pip-dim);
            box-shadow: 0 0 10px var(--pip-green);
        }
    </style>
</head>
<body>

    <div class="fixed top-4 right-4 z-50 flex flex-col gap-2 items-end">
        <button id="contrast-btn" onclick="toggleContrast()" 
            class="bg-black text-[var(--pip-green)] border-2 border-[var(--pip-green)] px-3 py-2 text-sm font-bold uppercase tracking-widest hover:bg-[var(--pip-green)] hover:text-black focus:outline-none focus:ring-2 focus:ring-white"
            aria-pressed="false">
            👁️ High Contrast
        </button>
        
        <div class="flex gap-1" role="group" aria-label="Rozmiar tekstu">
            <button onclick="changeFontSize(0.1)" class="bg-black text-[var(--pip-green)] border border-[var(--pip-green)] px-3 py-1 font-bold hover:bg-[var(--pip-green)] hover:text-black" aria-label="Powiększ tekst">A+</button>
            <button onclick="changeFontSize(-0.1)" class="bg-black text-[var(--pip-green)] border border-[var(--pip-green)] px-3 py-1 font-bold hover:bg-[var(--pip-green)] hover:text-black" aria-label="Pomniejsz tekst">A-</button>
        </div>
    </div>

    <div class="pipboy-case" style="background-image: url('{{ asset($bg) }}');" aria-hidden="true">
        
        <main class="pipboy-screen" id="main-content" role="main" aria-live="polite">
            @yield('content')
        </main>

        <nav class="nav-menu" aria-label="Fizyczne przyciski Pip-Boya">
            <a href="{{ route('stats') }}" class="pip-knob" title="Stats" aria-label="Sekcja Statystyki"
               style="width: 50px; height: 50px; top: 78.5%; left: 47%;"></a>

            <a href="{{ route('items') }}" class="pip-knob" title="Items" aria-label="Sekcja Przedmioty"
               style="width: 50px; height: 50px; top: 78.5%; left: 53.5%;"></a>

            <a href="{{ route('data') }}" class="pip-knob" title="Data" aria-label="Sekcja Dane"
               style="width: 50px; height: 50px; top: 78.5%; left: 60%;"></a>
        </nav>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1. Ładowanie kontrastu
            const isHighContrast = localStorage.getItem('pipboy-contrast') === 'true';
            if (isHighContrast) {
                document.body.classList.add('high-contrast');
                document.getElementById('contrast-btn').setAttribute('aria-pressed', 'true');
            }

            // 2. Ładowanie rozmiaru czcionki
            const savedScale = localStorage.getItem('pipboy-font-scale');
            if (savedScale) {
                document.documentElement.style.setProperty('--pip-font-scale', savedScale);
            }
        });

        function toggleContrast() {
            const body = document.body;
            const btn = document.getElementById('contrast-btn');
            body.classList.toggle('high-contrast');
            
            const isActive = body.classList.contains('high-contrast');
            localStorage.setItem('pipboy-contrast', isActive);
            btn.setAttribute('aria-pressed', isActive);
        }

        function changeFontSize(delta) {
            const root = document.documentElement;
            let currentScale = parseFloat(getComputedStyle(root).getPropertyValue('--pip-font-scale')) || 1;
            
            let newScale = currentScale + delta;
            // Ograniczenia skalowania (min 0.8x, max 1.5x)
            if(newScale < 0.8) newScale = 0.8;
            if(newScale > 1.5) newScale = 1.5;

            root.style.setProperty('--pip-font-scale', newScale);
            localStorage.setItem('pipboy-font-scale', newScale);
        }
    </script>
    
    @yield('scripts')
</body>
</html>