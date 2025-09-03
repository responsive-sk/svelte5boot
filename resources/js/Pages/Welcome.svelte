<script lang="ts">
  import { Link, router } from "@inertiajs/svelte";
  export let greeting: string;
  let count = 0;
  function refresh() {
      router.get(window.location.pathname + window.location.search, {}, {
          replace: true,
          preserveScroll: true,
          preserveState: false,
      });
  }
</script>

<svelte:head>
  <title>Welcome</title>
</svelte:head>

<div class="min-h-screen flex flex-col items-center justify-center gap-6 p-6 text-center">
  <h1 class="text-3xl font-bold">Welcome to Mezzio + Inertia + Svelte</h1>
  <p class="text-lg">Greeting from server: <span class="font-mono">{greeting}</span></p>

  <div class="flex gap-4 items-center justify-center">
    <button class="px-4 py-2 rounded bg-emerald-600 text-white" on:click={() => count++}>
      Clicked {count} {count === 1 ? "time" : "times"}
    </button>
    <button class="px-4 py-2 rounded bg-slate-700 text-white" on:click={refresh}>
      Reload via Inertia
    </button>
  </div>

  <p class="opacity-80">This page demonstrates an Inertia-rendered Svelte component in a Mezzio app.</p>

  <nav class="mt-4">
    <Link href="/" class="text-blue-400 underline">Back to Home</Link>
  </nav>
</div>
