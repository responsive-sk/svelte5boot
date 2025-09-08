import { PageProps as AppPageProps } from "../../types";

declare global {
  interface Window {
    htmx: any;
  }
  
  const htmx: any;
}

export {};