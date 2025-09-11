import '../styles/app.css';
// Odstráň starý spôsob a importuj mount
import { mount } from 'svelte';
import Welcome from '$pages/Welcome.svelte';
import CoolIndex from '$pages/CoolIndex.svelte';
import TailwindHero from '$components/ui/TailwindHero.svelte';
import Header from '$components/layout/Header.svelte';

// Mount hlavnú appku
const appTarget = document.getElementById('svelte-app');
if (appTarget) {
  mount(Welcome, {
    target: appTarget,
    props: {
      greeting: (window as any).__APP_GREETING__ ?? "HTMX PSR-15",
    },
  });
}

// Mount TailwindHero
const heroTarget = document.getElementById('tailwind-hero');
if (heroTarget) {
  mount(TailwindHero, {
    target: heroTarget,
  });
}

// Mount header
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

// Mount CoolIndex page
const coolTarget = document.getElementById('cool-app');
if (coolTarget) {
  mount(CoolIndex, { target: coolTarget });
}
