export default {
  //Menus and Dialogs

  //User Menu
  userMenu: {
    darkMode: 'Darkmód',
    profile: 'Profil',
    myBallots: 'Moje Balloty',
    myMotions: 'Moje Teze',
    logout: {
      label: 'Odhlásit',
      success: 'Odhlášeno',
      failure: 'Při odhlašování došlo k chybě',
    },
  },

  //Main Menu
  mainMenu: {
    title: 'Hlavní Menu',
    profile: 'Profil',
    ballots: 'Balloty',
    newBallot: 'Nový Ballot',
    motions: 'Teze',
    greybox: 'GreyBox',
    autosave: 'Otevřít Rozpracovaný Ballot',
  },

  //Messages for Form Validation Rules
  prompt: {
    required: 'Něco tam napište, pls',
    diffPassword: 'Hesla se neshodují',
    shortEmail: 'Zadaná hodnota je příliš krátká',
    shortPWD: 'Zadaná hodnota je příliš krátká',
    isEmail: 'Zadejte platnou emailovou adresu, pls',
    isValidPWD: 'Heslo musí obsahovat velká i malá písmena a číslice',
    noNumbers: 'Nepište tam číslíčka ani divný znaky, pls',
    noLetters: 'Pište tam jenom číslíčka, pls',
    isDate: 'Zadejte platné datum, pls',
    isBirthdate: 'Zadejte platné datum narození, pls',
    isZip: 'Zadejte platné PSČ, pls',
    contPoints: 'Body za obsah musí být v rozmezí (20 - 40)',
    strPoints: 'Body za strategii musí být v rozmezí (15 - 30)',
    stylePoints: 'Body za styl musí být v rozmezí (15 - 30)',
    cqPoints:
      'Body za křížový výslech musí být v rozmezí (-5 - +5) nebo (1 - 10)',
    isCq: 'Zadejte platný formát křížových otázek, pls',
  },

  //Warning dialog about Unauthorized action (often used at multiple places)
  warning: {
    title: 'Upozornění',
    message: 'Na tuto akci nemáte dostatečná oprávnění',
  },
};
