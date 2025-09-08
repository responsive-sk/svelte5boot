// boot pre Svelte ostrovy
export function bootIslands(root: HTMLElement = document.body) {
  const islands = root.querySelectorAll('[data-component]');

  islands.forEach(async (element) => {
    const componentName = element.getAttribute('data-component');
    const props = element.getAttribute('data-props');

    if (!componentName) return;

    try {
      // Dynamický import komponentu
      const componentModule = await import(
        `../components/islands/${componentName}.svelte`
      );
      const Component = componentModule.default;

      // Mount komponentu
      const instance = new Component({
        target: element,
        props: props ? JSON.parse(props) : {},
      });

      // Uloženie inštancie pre prípadné neskoršie odpojenie
      (element as any).__svelte_component = instance;
    } catch (error) {
      console.error(`Failed to load island ${componentName}:`, error);
    }
  });
}

// Initial boot
bootIslands();

// Re-boot po HTMX swapoch

document.addEventListener('htmx:afterSwap', (event: CustomEvent) => {
  const target = ((event.detail as any)?.target as HTMLElement) ?? document.body;
  bootIslands(target);
});

document.addEventListener('htmx:afterSettle', () => {
  bootIslands();
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
