import { boot } from 'quasar/wrappers';
import { i18n } from './i18n';

//Declaration of all the validation rules for the app forms

//value can't be empty
const required = (val: string): boolean | string => {
  return (val && val.length > 0) || i18n.global.t('menu.prompt.required'); //Něco tam napište, pls
};

//value is needs to be longer than 3 characters (email)
const shortEmail = (val: string): boolean | string => {
  return (val && val.length > 3) || i18n.global.t('menu.prompt.shortEmail'); //Zadaná hodnota je příliš krátká
};

//value needs to be longer than 8 characters (password)
const shortPWD = (val: string): boolean | string => {
  return (val && val.length > 7) || i18n.global.t('menu.prompt.shortPWD'); //Zadaná hodnota je příliš krátká
};

//checking if value is email (has text then @ and then text and then . and then something)
const isEmail = (val: string): boolean | string => {
  const emailPattern =
    /^(?=[a-zA-Z0-9@._%+-]{6,254}$)[a-zA-Z0-9._%+-]{1,64}@(?:[a-zA-Z0-9-]{1,63}\.){1,8}[a-zA-Z]{2,63}$/;
  return emailPattern.test(val) || i18n.global.t('menu.prompt.isEmail'); //Zadejte platnou emailovou adresu, pls
};

//checking if the value (password) contains capital and non-capital letters and numbers
const isValidPWD = (val: string): boolean | string => {
  const pwdPattern = /^\S*(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/;
  return pwdPattern.test(val) || i18n.global.t('menu.prompt.isValidPWD'); //Heslo musí obsahovat velká i malá písmena a číslice
};

//Checking if the value is only text
const noNumbers = (val: string): boolean | string => {
  const pattern = /(^$)|^[a-žA-Ž ]+$/;
  return pattern.test(val) || i18n.global.t('menu.prompt.noNumbers'); //Nepište tam číslíčka ani divný znaky, pls
};

//checking if the value is only numbers
const noLetters = (val: string): boolean | string => {
  const pattern = /(^$)|^\d+$/;
  return pattern.test(val) || i18n.global.t('menu.prompt.noLetters'); //Pište tam jenom číslíčka, pls
};

//checking if the value is a valid date format and the age makes sense (roughly, can be set to something more precise)
const isBirthdate = (val: string): boolean | string => {
  const pattern = /(^$)|^([0-9]{4})-([0-9]{2})-([0-9]{2})$/;
  let result = true;

  //if patterns is ok, age is getting checked if it's lower than 10 or higher than 120
  if (pattern.test(val)) {
    const age = new Date().getFullYear() - new Date(val).getFullYear();
    if (age > 120 || age < 10) result = false;
  } else result = false;

  return result || i18n.global.t('menu.prompt.isBirthdate'); //Zadejte platné datum narození, pls
};

//checking if the value is a valid date format
const isDate = (val: string): boolean | string => {
  const pattern = /(^$)|^([0-9]{4})-([0-9]{2})-([0-9]{2})$/;
  return pattern.test(val) || i18n.global.t('menu.prompt.isDate'); //Zadejte platné datum, pls
};

//checking if the value is a valid zip code
const isZip = (val: string): boolean | string => {
  const pattern = /(^$)|(^\d{5}$)|(^\d{5}-\d{4}$)|(^\d{3} \d{2}$)/;
  return pattern.test(val) || i18n.global.t('menu.prompt.isZip'); //Zadejte platné PSČ, pls
};

//checking if the value is within the boundaries of allowed content points amount
const contPoints = (val: string): boolean | string => {
  const comp = Number(val);
  return (comp >= 20 && comp <= 40) || i18n.global.t('menu.prompt.contPoints'); //Body za obsah musí být v rozmezí (20 - 40)
};

//checking if the value is within the boundaries of allowed strategy points amount
const strPoints = (val: string): boolean | string => {
  const comp = Number(val);
  return (comp >= 15 && comp <= 30) || i18n.global.t('menu.prompt.strPoints'); //Body za strategii musí být v rozmezí (15 - 30)
};

//checking if the value is within the boundaries of allowed style points amount
const stylePoints = (val: string): boolean | string => {
  const comp = Number(val);
  return (comp >= 15 && comp <= 30) || i18n.global.t('menu.prompt.stylePoints'); //Body za styl musí být v rozmezí (15 - 30)
};

//checking if the value is within the boundaries of allowed cross quesions points amount
const cqPoints = (val: string): boolean | string => {
  if (val.toString().includes('+') || val.toString().includes('-')) {
    if (Math.abs(Number(val)) > 5) return i18n.global.t('menu.prompt.cqPoints');
  }
  const comp = Number(val);
  return (comp >= -5 && comp <= 10) || i18n.global.t('menu.prompt.cqPoints'); //Body za křížový výslech musí být v rozmezí (-5 - 5) nebo (1 - 10)
};
//checking if the value is a cross examination format
const isCq = (val: string): boolean | string => {
  const pattern = /^[+-]?[0-9]{1,2}$/; ///^[+-]?[0-9]{1,2}$/
  return pattern.test(val) || i18n.global.t('menu.prompt.isCq'); //Zadejte platný formát křížových otázek, pls
};

//defining cutom types for these rules cause otherwise i can't register the global variable for the app
type Rule = (val: string) => boolean | string;
type Rules = Record<
  | 'required'
  | 'shortEmail'
  | 'shortPWD'
  | 'isEmail'
  | 'isValidPWD'
  | 'noNumbers'
  | 'noLetters'
  | 'isBirthdate'
  | 'isDate'
  | 'isZip'
  | 'contPoints'
  | 'strPoints'
  | 'stylePoints'
  | 'cqPoints'
  | 'isCq',
  Rule
>;

//declaring the ruleset
const rules: Rules = {
  required,
  shortEmail,
  shortPWD,
  isEmail,
  isValidPWD,
  noNumbers,
  noLetters,
  isBirthdate,
  isDate,
  isZip,
  contPoints,
  strPoints,
  stylePoints,
  cqPoints,
  isCq,
};

//Registering the global variable in the app
declare module '@vue/runtime-core' {
  interface ComponentCustomProperties {
    $rules: Rules;
  }
}

//stuffing the global vairable with the ruleset
export default boot(({ app }) => {
  app.config.globalProperties.$rules = rules;
});

//i can also import them manually if i wanted to (instead of using the global variable)
export { rules };
