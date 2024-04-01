export default {
  //Menus and Dialogs

  //User Menu
  userMenu: {
    darkMode: 'Darkmode',
    profile: 'Profile',
    myBallots: 'My Ballots',
    myMotions: 'My Motions',
    logout: {
      label: 'Logout',
      success: 'Logged out',
      failure: 'An error occured while logging out',
    },
  },

  //Main Menu
  mainMenu: {
    title: 'Main Menu',
    profile: 'Profile',
    ballots: 'Ballots',
    newBallot: 'New Ballot',
    motions: 'Motions',
    greybox: 'GreyBox',
    autosave: 'Open Work in Progress Ballot',
  },

  //Messages for Form Validation Rules
  prompt: {
    required: 'Write something, pls',
    diffPassword: "Passwords don't match",
    shortEmail: 'This is way too short',
    shortPWD: 'This is way too short',
    isEmail: 'Write a legitimate email address, pls',
    isValidPWD:
      'Password has to consist of lower and upper case letters and numbers',
    noNumbers: "Don't type numbers or weird characters in there, pls.",
    noLetters: 'Just type in the numbers, pls',
    isDate: 'Enter a valid date, pls',
    isBirthdate: 'Enter a valid date of birth, pls',
    isZip: 'Enter a valid ZIP code, pls',
    contPoints: 'Content points must be in the range (20 - 40)',
    strPoints: 'Strategy points must be in the range (15 - 30)',
    stylePoints: 'Style points must be in the range (15 - 30)',
    cqPoints:
      'Cross Examination points must be in the range (-5 - +5) or (1 - 10)',
    isCq: 'Enter a valid format of Cross Examination points, pls',
  },

  //Warning dialog about Unauthorized action (often used at multiple places)
  warning: {
    title: 'Warning',
    message: 'You do not have sufficient authorization for this action',
  },
};
