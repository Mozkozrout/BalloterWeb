export default {
  //ProfileForm
  title: 'Úprava Profilu',
  account: {
    title: 'Informace o účtu',
    label: {
      name: 'Jméno',
      surname: 'Příjmení',
      email: 'Email',
      locale: 'Jazyk',
    },
  },
  person: {
    title: 'Osobní Informace',
    label: {
      birthdate: 'Datum Narození',
      institution: 'Instituce',
      note: 'Poznámka',
      street: 'Ulice',
      number: 'Číslo Popisné',
      city: 'Město',
      state: 'Stát',
      zip: 'Zip',
    },
  },
  button: {
    save: 'Uložit',
    cancel: 'Zrušit',
    delete: {
      label: 'Smazat',
      person: 'Údaje',
      account: 'Účet',
    },
  },
  submit: {
    title: 'Upozornění',
    message: 'Adresu vyplňte prosím buď celou, a nebo vůbec.',
    success: 'Uloženo',
    failure: 'Při ukládání informací došlo k chybě.',
  },
  deletePerson: {
    title: 'Upozornění',
    message:
      'Tato akce smaže všechna vaše osobní data. Jste si jisti, že chcete pokračovat ?',
    button: {
      ok: 'Ano',
      cancel: 'Zrušit',
    },
    success: 'Data Smazána',
    failure: 'Při mazání dat došlo k chybě',
  },
  deleteUser: {
    title: 'Upozornění',
    message:
      'Tato akce smaže vaše data i celý váš uživatelský účet. Pro pokračování zadejte váš email',
    button: {
      ok: 'Potvrdit',
      cancel: 'Zrušit',
    },
    success: 'Účet Smazán',
    failure: 'Při mazání účtu došlo k chybě',
  },
  institutions: {
    failure: 'Při načítání institucí došlo k chybě',
  },
};
