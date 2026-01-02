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
            src: url("<?php echo e(asset('fonts/monofonto rg.otf')); ?>") format('opentype');
            font-weight: normal;
            font-style: normal;
        }

        /* 1. ZMIENNE KOLORYSTYCZNE */
        :root {
            /* Domyślny wygląd (Terminal) */
            --pip-green: #14f61b;
            --pip-dim: rgba(20, 246, 27, 0.2);
            --pip-bg: #0b1409;
            --pip-shadow: 0 0 5px var(--pip-green);
        }

        /* Tryb Wysokiego Kontrastu (WCAG AAA) */
        body.high-contrast {
            /* Żółty na Czarnym - najlepszy kontrast dla słabowidzących */
            --pip-green: #FFFF00; 
            --pip-dim: rgba(255, 255, 0, 0.2);
            --pip-bg: #000000;
            --pip-shadow: none; /* Usuwamy poświatę dla czytelności */
        }

        body {
            font-family: 'Monofonto', monospace; 
            background-color: #111;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: var(--pip-green);
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
            background: rgba(11, 20, 9, 0.95); /* Ciemniejsze tło dla czytelności */
            /* Używamy zmiennych! */
            color: var(--pip-green);
            text-shadow: var(--pip-shadow);
            
            border-radius: 5%;
            padding: 1.5rem;
            overflow-y: auto;
            box-shadow: inset 0 0 40px #000;
        }

        /* W trybie kontrastowym tło ekranu staje się idealnie czarne */
        body.high-contrast .pipboy-screen {
            background: #000000;
            box-shadow: none;
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 12px; } /* Szerszy dla łatwiejszego klikania */
        ::-webkit-scrollbar-thumb { background: var(--pip-green); border-radius: 4px; }
        ::-webkit-scrollbar-track { background: #000; }

        /* Niewidzialne przyciski */
        .pip-knob {
            position: absolute;
            background-color: transparent;
            border-radius: 50%;
            cursor: pointer;
            z-index: 50;
            border: 2px solid transparent; /* Rezerwa na focus */
        }

        /* WAŻNE: Focus indicator dla nawigacji klawiaturą (Tab) */
        .pip-knob:focus-visible {
            border-color: var(--pip-green);
            background-color: var(--pip-dim);
            outline: none;
            box-shadow: 0 0 20px var(--pip-green);
        }
        
        /* Focus styles dla list wewnątrz ekranu */
        li:focus-visible, a:focus-visible {
            outline: 2px solid var(--pip-green);
            background-color: var(--pip-dim);
        }
    </style>
</head>
<body class=""> <button id="accessibility-btn" 
            onclick="toggleContrast()" 
            class="fixed top-4 right-4 bg-black text-[#14f61b] border-2 border-[#14f61b] p-3 text-lg font-bold z-50 hover:bg-[#14f61b] hover:text-black focus:outline-none focus:ring-4 focus:ring-white uppercase tracking-widest"
            aria-pressed="false"
            aria-label="Przełącz tryb wysokiego kontrastu">
        👁️ High Contrast
    </button>

    <div class="pipboy-case" style="background-image: url('<?php echo e(asset($bg)); ?>');">
        
        <main class="pipboy-screen" id="main-content" aria-live="polite">
            <?php echo $__env->yieldContent('content'); ?>
        </main>

        <nav class="nav-menu" aria-label="Główna nawigacja Pip-Boya">
            <a href="<?php echo e(route('stats')); ?>" class="pip-knob" title="Stats" aria-label="Statystyki"
               style="width: 50px; height: 50px; top: 78.5%; left: 47%;"></a>

            <a href="<?php echo e(route('items')); ?>" class="pip-knob" title="Items" aria-label="Przedmioty"
               style="width: 50px; height: 50px; top: 78.5%; left: 53.5%;"></a>

            <a href="<?php echo e(route('data')); ?>" class="pip-knob" title="Data" aria-label="Dane i Zadania"
               style="width: 50px; height: 50px; top: 78.5%; left: 60%;"></a>
        </nav>
    </div>

    <script>
        // 1. Sprawdź zapisane ustawienia przy załadowaniu strony
        document.addEventListener('DOMContentLoaded', () => {
            const isHighContrast = localStorage.getItem('pipboy-contrast') === 'true';
            if (isHighContrast) {
                document.body.classList.add('high-contrast');
                document.getElementById('accessibility-btn').setAttribute('aria-pressed', 'true');
            }
        });

        // 2. Funkcja przełączania
        function toggleContrast() {
            const body = document.body;
            const btn = document.getElementById('accessibility-btn');
            
            body.classList.toggle('high-contrast');
            
            // Zapisz stan w przeglądarce
            const isActive = body.classList.contains('high-contrast');
            localStorage.setItem('pipboy-contrast', isActive);
            
            // Aktualizuj ARIA dla czytników
            btn.setAttribute('aria-pressed', isActive);
        }
    </script>
</body>
</html><?php /**PATH C:\Users\BoheN\Downloads\Aplikacje Internetowe projekt\pipboy\resources\views/layout.blade.php ENDPATH**/ ?>