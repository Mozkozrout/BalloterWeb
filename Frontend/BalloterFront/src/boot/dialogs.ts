import { boot } from 'quasar/wrappers';
import { i18n } from './i18n';
import { Dialog } from 'quasar';

//Unauthorized dialog that is used pretty often - if there will be more of these it would be probably worth it to put them into their own file
function unauthorized() {
  Dialog.create({
    title: i18n.global.t('menu.warning.title'), //Upozornění
    message: i18n.global.t('menu.warning.message'), //Na tuto akci nemáte dostatečná oprávnění
    ok: {
      flat: true,
      color: 'light-blue-13',
    },
  });
}

//declaration of custom types cause i can't register global variable without these
type CustomDialog = typeof unauthorized;
type Dialogs = Record<'unauthorized', CustomDialog>;

//declaring the set of dialogs (now there is just one here)
const dialogs: Dialogs = {
  unauthorized,
};

//Registering the global variable in the app
declare module '@vue/runtime-core' {
  interface ComponentCustomProperties {
    $dialogs: Dialogs;
  }
}

//stuffing the global vairable with the ruleset
export default boot(({ app }) => {
  app.config.globalProperties.$dialogs = dialogs;
});

//i can also import them manually if i wanted to (instead of using the global variable)
export { dialogs };
