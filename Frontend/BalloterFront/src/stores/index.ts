import { store } from 'quasar/wrappers';
import { createPinia, setMapStoreSuffix } from 'pinia';
import { Router } from 'vue-router';
import { AxiosInstance } from 'axios';

/*
 * When adding new properties to stores, you should also
 * extend the `PiniaCustomProperties` interface.
 * @see https://pinia.vuejs.org/core-concepts/plugins.html#typing-new-store-properties
 */
declare module 'pinia' {
  export interface PiniaCustomProperties {
    readonly router: Router;
    api: AxiosInstance;
  }
}

/*
 * If not building with SSR mode, you can
 * directly export the Store instantiation;
 *
 * The function below can be async too; either use
 * async/await or return a Promise which resolves
 * with the Store instance.
 */

export default store((/* { ssrContext } */) => {
  const pinia = createPinia();
  setMapStoreSuffix('');

  // You can add Pinia plugins here
  // pinia.use(SomePiniaPlugin)

  return pinia;
});

declare module 'pinia' {
  export interface MapStoresCustomization {
    // set it to the same value as above
    suffix: '';
  }
}
