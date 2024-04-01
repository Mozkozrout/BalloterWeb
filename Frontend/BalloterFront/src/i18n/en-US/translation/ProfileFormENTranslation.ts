export default {
  title: 'Edit Profile',
  account: {
    title: 'Account information',
    label: {
      name: 'Name',
      surname: 'Surname',
      email: 'Email',
      locale: 'Language',
    },
  },
  person: {
    title: 'Personal Information',
    label: {
      birthdate: 'Date of birth',
      institution: 'Institution',
      note: 'Note',
      street: 'Street',
      number: 'House Number',
      city: 'City',
      state: 'Country',
      zip: 'Zip',
    },
  },
  button: {
    save: 'Save',
    cancel: 'Cancel',
    delete: {
      label: 'Delete',
      person: 'Personal Info',
      account: 'Account',
    },
  },
  submit: {
    title: 'Warning',
    message: 'Adresu vyplňte prosím buď celou, a nebo vůbec.',
    success: 'Uloženo',
    failure: 'Při ukládání informací došlo k chybě.',
  },
  deletePerson: {
    title: 'Warning',
    message:
      'This action deletes all your personal data. Are you sure you want to continue ?',
    button: {
      ok: 'Yes',
      cancel: 'Cancel',
    },
    success: 'Data Deleted',
    failure: 'An error occurred while deleting the data',
  },
  deleteUser: {
    title: 'Warning',
    message:
      'This action deletes your data and your entire user account. \nEnter your email to confirm:',
    button: {
      ok: 'Proceed',
      cancel: 'Abort',
    },
    success: 'Account Deleted',
    failure: 'An error occurred while deleting the account',
  },
  institutions: {
    failure: 'An error occurred while loading institutions',
  },
};
