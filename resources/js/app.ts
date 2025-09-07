import "../css/app.css";
import "./bootstrap";
import Welcome from "./Pages/Welcome.svelte";
import CoolIndex from "./Pages/CoolIndex.svelte";
import TailwindHero from "./Components/TailwindHero.svelte";
import Nav from "./Components/Nav.svelte";
import { mount } from "svelte";

const appTarget = document.getElementById("app");

let app: any = null;

if (appTarget) {
  app = mount(Welcome, {
    target: appTarget,
    props: {
      greeting: (window as any).__APP_GREETING__ ?? "HTMX PSR-15",
      currentRoute: window.location.pathname || "/",
    },
  });
}

// Mount TailwindHero on the index page hero container (uses component defaults)
const heroTarget = document.getElementById("tailwind-hero");
let heroApp: any = null;
if (heroTarget) {
  heroApp = mount(TailwindHero, {
    target: heroTarget,
    props: {},
  });
}

// Mount navigation into layout header
const navRoot = document.getElementById("nav-root");
if (navRoot) {
  mount(Nav, { target: navRoot });
}

// Mount CoolIndex page if present
const coolTarget = document.getElementById("cool-app");
if (coolTarget) {
  mount(CoolIndex, { target: coolTarget, props: {} });
}

export default app;
