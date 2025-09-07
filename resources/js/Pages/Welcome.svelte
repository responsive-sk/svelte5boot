<script lang="ts">
  export let greeting: string;
  let count = 0;
</script>

<svelte:head>
  <title>Welcome</title>
</svelte:head>

<div class="min-h-screen flex flex-col items-center justify-center gap-6 p-6 text-center">
  <h1 class="text-3xl font-bold">Welcome to Mezzio + HTMX + Svelte</h1>
  <p class="text-lg">Greeting from server: <span class="font-mono">{greeting}</span></p>

  <div class="flex gap-4 items-center justify-center">
    <button class="px-4 py-2 rounded bg-emerald-600 text-white" on:click={() => count++}>
      Clicked {count} {count === 1 ? "time" : "times"}
    </button>
    <button class="px-4 py-2 rounded bg-slate-700 text-white" data-hx-get="/" data-hx-target="body">
      Reload via HTMX
    </button>
  </div>

  <p class="opacity-80">This page demonstrates an HTMX-enhanced Svelte component in a Mezzio app.</p>

  <nav class="mt-4">
    <a href="/" class="text-blue-400 underline">Back to Home</a>
  </nav>
</div>
