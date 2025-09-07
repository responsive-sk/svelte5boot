import "../css/app.css";
import "./bootstrap";
import Welcome from "./Pages/Welcome.svelte";
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

export default app;
