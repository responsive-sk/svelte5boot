<script lang="ts">
  // Main App component for Svelte 5
  import Welcome from './Welcome.svelte';

  // Hydration data from server
  const appData = (window as any).__APP_DATA__ ?? {};

  // Reactive derived state
  let greeting = $state(appData.app?.greeting ?? "HTMX PSR-15");
  let isAuthenticated = $derived(!!appData.user);
  let currentRoute = $derived(appData.app?.route);
  let csrfToken = $state(appData.csrf);
</script>

<main>
  <Welcome {greeting} />
</main>

<style>
  /* Add any global styles if needed */
</style>
