import App from './app.ts';

const app = new App({
  target: document.getElementById('svelte-app')!,
  hydrate: true
});

export default app;