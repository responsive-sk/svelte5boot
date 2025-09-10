<script>
  import { Header, Footer, AddToCart, ArticleCard } from '$components';
  import { appStore, cartStore } from '$stores';
  import { formatPrice } from '$utils/formatters';

  // Svelte 5 reactivity
  let count = $state(0);
  let user = $derived($appStore?.user);

  function addToCart(item) {
    cartStore.add(item);
  }
</script>

<Header />
<main>
  <h1>Vitajte, {user?.name || 'užívateľ'}!</h1>

  <div class="grid grid-cols-3 gap-4">
    <ArticleCard
      title="Produkt 1"
      price={29.99}
      on:add-to-cart={() => addToCart({ id: '1', name: 'Produkt 1', price: 29.99, quantity: 1 })}
    />
  </div>

  <AddToCart />
</main>
<Footer />
