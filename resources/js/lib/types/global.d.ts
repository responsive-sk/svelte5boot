import { PageProps as InertiaPageProps } from "@inertiajs/core";
import { AxiosInstance } from "axios";
import { PageProps as AppPageProps } from "../../types";

declare global {
  interface Window {
    axios: AxiosInstance;
  }
}

declare module "@inertiajs/core" {
  interface PageProps extends InertiaPageProps, AppPageProps {}
}
