export default {
  //Motion
  title: 'Motions',
  empty: "It's kind of empty here, how about adding some motions ?",
  button: {
    toggle: 'My motions',
  },
  add: {
    title: 'Add a new motion',
    message: 'Enter the motion you wish to add:',
    button: {
      ok: 'Save',
      cancel: 'Cancel',
    },
    warning: {
      title: 'Warning',
      message:
        'To add a motion, you must have at least your first and last name in your profile',
    },
    success: 'Saved',
    failure: 'An error occurred while saving the motion',
  },
  load: {
    failure: 'An error occurred while loading motions',
  },
  list: {
    empty: 'No Results',
    addedBy: 'Added by: ',
    editedBy: 'Edited by: ',
    createdAt: 'Added at: ',
    editedAt: 'Edited at: ',
    button: {
      edit: 'Edit',
      delete: 'Delete',
    },
    edit: {
      title: 'Edit motion',
      message: 'Edit the motion as you wish:',
      button: {
        ok: 'Save',
        cancel: 'Canel',
      },
      success: 'Saved',
      failures: 'An error occurred while saving the motion',
    },
    delete: {
      title: 'Warning',
      message:
        'This action deletes this motion. Are you sure you want to continue ?',
      button: {
        ok: 'Proceed',
        cancel: 'Abort',
      },
      success: 'Deleted Successfully',
      failure: 'Failed to delete the motion',
    },
  },
};
