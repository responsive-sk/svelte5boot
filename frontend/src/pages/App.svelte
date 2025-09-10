<script lang="ts">
    // Declare htmx as global
    declare global {
        interface Window {
            htmx: any;
        }
    }

    let counter = $state(0);

    function loadWithHtmx() {
        // HTMX načíta partial content
        if (typeof window !== 'undefined' && window.htmx) {
            window.htmx.ajax('GET', '/api/partial-content', {
                target: '#partial-content-svelte',
                swap: 'innerHTML'
            });
        }
    }

    function increment() {
        counter++;
    }
</script>

<main class="p-8">
    <h1 class="text-3xl font-bold mb-6 text-green-400">Vitajte v našej appke</h1>
    
    <!-- Svelte interaktivita -->
    <div class="mb-6 p-4 bg-gray-800 rounded-lg">
        <p class="text-lg mb-2">Počítadlo: <span class="font-bold text-blue-400">{counter}</span></p>
        <button 
            onclick={increment}
            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded transition-colors">
            +1
        </button>
    </div>

    <!-- HTMX integration -->
    <div class="mb-6">
        <button 
            onclick={loadWithHtmx}
            class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded transition-colors">
            Načítať cez HTMX
        </button>
    </div>

    <!-- HTMX target element -->
    <div id="partial-content-svelte" class="mt-4"></div>
</main>