import { RouteRecordRaw } from 'vue-router';

const routes: RouteRecordRaw[] = [
  {
    path: '',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      {
        path: '',
        name: 'home',
        component: () => import('pages/IndexPage.vue'),
      },
      {
        path: '/auth/:register',
        name: 'auth',
        props: true,
        component: () => import('pages/AuthPage.vue'),
      },
      {
        path: '/profile',
        name: 'profile',
        component: () => import('pages/ProfilePage.vue'),
      },
      {
        path: '/profile/edit',
        name: 'profileEdit',
        component: () => import('pages/ProfileForm.vue'),
      },
      {
        path: '/motion/:user',
        name: 'motion',
        props: true,
        component: () => import('pages/MotionPage.vue'),
      },
      {
        path: '/ballot/:user',
        name: 'ballot',
        props: true,
        component: () => import('pages/BallotPage.vue'),
      },
      {
        path: '/ballot/edit/:id',
        name: 'ballotEdit',
        props: true,
        component: () => import('pages/BallotForm.vue'),
      },
    ],
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue'),
  },
];
export default routes;
