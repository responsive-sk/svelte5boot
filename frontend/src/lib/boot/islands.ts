import { mount } from 'svelte';

export function bootIslands(root: HTMLElement = document.body) {
  // Automatická registrácia ostrovov
  const islands = root.querySelectorAll('[data-component]');

  islands.forEach(async (element) => {
    const islandName = element.getAttribute('data-component');
    if (!islandName) return;

    try {
      // Dynamický import
      const component = await import(
        `../islands/${islandName}.svelte`
      );

      mount(component.default, {
        target: element,
        props: (element as HTMLElement).dataset.props ? JSON.parse((element as HTMLElement).dataset.props!) : {}
      });

    } catch (error) {
      console.error(`Island ${islandName} failed to load:`, error);
    }
  });
}

// Initial load
bootIslands();

// Re-boot after HTMX swaps
document.addEventListener('htmx:afterSwap', (event) => {
  bootIslands(event.detail.target as HTMLElement);
});

// Event-based komunikácia medzi HTMX a Svelte
// Po pridaní do košíka obnov všetky CartCounter ostrovy
// Svelte komponent (napr. AddToCart) môže dispatchnúť: window.dispatchEvent(new CustomEvent('cart:updated'))
document.addEventListener('cart:updated', () => {
  document.querySelectorAll('[data-component="CartCounter"]').forEach((el) => {
    el.dispatchEvent(new CustomEvent('refresh'));
  });
});

// Príklad: Svelte komponent môže posielať notifikačný event
// window.dispatchEvent(new CustomEvent('notification:show', {
//   detail: { message: 'Produkt pridaný!', type: 'success' }
// }));
