// frontend/src/lib/utils/formatters.ts

export function formatDate(date: Date): string {
  return date.toLocaleDateString();
}

export function formatPrice(price: number): string {
  return `$${price.toFixed(2)}`;
}
