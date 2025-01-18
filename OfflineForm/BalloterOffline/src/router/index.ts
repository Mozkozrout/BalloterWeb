import { route } from 'quasar/wrappers';
import { useAuthStore } from 'src/stores/AuthStore';
import {
  createMemoryHistory,
  createRouter,
  createWebHashHistory,
  createWebHistory,
} from 'vue-router';

import routes from './routes';

/*
 * If not building with SSR mode, you can
 * directly export the Router instantiation;
 *
 * The function below can be async too; either use
 * async/await or return a Promise which resolves
 * with the Router instance.
 */

export default route(function (/* { store, ssrContext } */) {
  const createHistory = process.env.SERVER
    ? createMemoryHistory
    : process.env.VUE_ROUTER_MODE === 'history'
    ? createWebHistory
    : createWebHashHistory;

  const Router = createRouter({
    scrollBehavior: () => ({ left: 0, top: 0 }),
    routes,

    // Leave this as is and make changes in quasar.conf.js instead!
    // quasar.conf.js -> build -> vueRouterMode
    // quasar.conf.js -> build -> publicPath
    history: createHistory(process.env.VUE_ROUTER_BASE),
  });

  // Checking authorisation before redirecting
  Router.beforeEach(async (to) => {
    let authenticated = false;
    const authStore = useAuthStore();

    await authStore.getUser();
    //<-- Getting user before each redirect

    if (authStore.user !== null) authenticated = true; //<-- checking if user is authenticated
    if (!authenticated && to.name === 'home') return true; //<-- allowing the user to access homepage even if unauthenticated
    if (!authenticated && to.name !== 'auth') {
      //forcing the user to redirect to login if unauthenticated and trying to access something else than login page
      return { name: 'auth', params: { register: 0 } };
    }
  });

  return Router;
});
