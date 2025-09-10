import '../../resources/css/app.css';
import { mount } from 'svelte';
import App from './pages/App.svelte';
import CoolIndex from './pages/CoolIndex.svelte';
import TailwindHero from './lib/components/ui/TailwindHero.svelte';
import Header from './lib/components/layout/Header.svelte';

// Mount main app if #svelte-app exists
const appTarget = document.getElementById('svelte-app');
if (appTarget) {
  mount(App, { target: appTarget });
}

// Mount CoolIndex if #cool-app exists
const coolTarget = document.getElementById('cool-app');
if (coolTarget) {
  mount(CoolIndex, { target: coolTarget });
}

// Mount TailwindHero if #tailwind-hero exists
const heroTarget = document.getElementById('tailwind-hero');
if (heroTarget) {
  mount(TailwindHero, { target: heroTarget });
}

// Mount Header if #nav-root exists
const navRoot = document.getElementById('nav-root');
if (navRoot) {
  const urlParams = new URLSearchParams(window.location.search);
  mount(Header, { 
    target: navRoot,
    props: {
      currentRoute: window.location.pathname || "/",
      searchQuery: urlParams.get('q') || ""
    }
  });
}

// Inicializácia ostrovov
import('./lib/boot/islands');
