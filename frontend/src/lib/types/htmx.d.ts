// htmx.d.ts
declare global {
  interface HTMLElement {
    __svelte_component?: any;
  }

  // HTMX events
  interface Document {
    addEventListener(type: 'htmx:afterSwap', listener: (event: CustomEvent) => void): void;
    addEventListener(type: 'htmx:afterSettle', listener: (event: CustomEvent) => void): void;
    addEventListener(type: 'htmx:configRequest', listener: (event: CustomEvent) => void): void;
  }
}

export {};
