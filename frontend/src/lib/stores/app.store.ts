// frontend/src/lib/stores/app.store.ts
import { untrack } from 'svelte';

export interface User {
  id: number;
  name: string;
  email: string;
}

export interface CartItem {
  id: number;
  name: string;
  price: number;
  quantity: number;
}

export interface Notification {
  id: number;
  message: string;
  type: 'success' | 'error';
}

export interface AppState {
  user: User | null;
  cart: CartItem[];
  theme: 'light' | 'dark';
  notifications: Notification[];
}

export class AppStore {
  private state = $state<AppState>({
    user: null,
    cart: [],
    theme: 'light',
    notifications: [],
  });
  
  // Public interface
  get user() { return this.state.user; }
  get cart() { return this.state.cart; }
  get theme() { return this.state.theme; }
  
  // Actions
  login(user: User) {
    this.state.user = user;
  }
  
  addToCart(item: CartItem) {
    this.state.cart.push(item);
  }
  
  addNotification(message: string, type: 'success' | 'error' = 'success') {
    this.state.notifications.push({ id: Date.now(), message, type });
  }
}

export const appStore = new AppStore();
