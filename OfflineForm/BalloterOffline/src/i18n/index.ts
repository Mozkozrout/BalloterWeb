import enUS from './en-US';
import cs from './cs';

export default {
  'en-US': enUS,
  cs: cs,
};

export const langList = import.meta.glob(
  '../../node_modules/quasar/lang/(cs|en-US).mjs'
);
