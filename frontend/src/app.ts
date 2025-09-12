import './styles/app.css';
import { mount } from 'svelte';
import Header from './lib/components/layout/Header.svelte';
import './lib/boot/islands';

// Function to mount Header
function mountHeader() {
  const navRoot = document.getElementById('nav-root');
  if (navRoot && !navRoot.hasChildNodes()) {
    const urlParams = new URLSearchParams(window.location.search);
    mount(Header, {
      target: navRoot,
      props: {
        currentRoute: window.location.pathname || "/",
        searchQuery: urlParams.get('q') || ""
      }
    });
  }
}

// Mount Header initially
mountHeader();

// Re-mount Header after HTMX swaps
document.body.addEventListener('htmx:afterSwap', mountHeader);
