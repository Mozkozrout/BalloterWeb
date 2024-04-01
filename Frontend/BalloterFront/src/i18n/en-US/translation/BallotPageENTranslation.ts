export default {
  //Ballot
  title: 'Ballots',
  tab: {
    all: 'All',
    tournaments: 'Tournaments',
    motions: 'Motions',
    timeline: 'Timeline',
  },
  button: {
    toggle: 'The ballots I wrote',
    open: 'Open',
    delete: 'Delete',
  },
  add: {
    warning: {
      autosave: {
        title: 'Warning',
        message:
          'You already have one ballot in progress, do you wish to continue editing it or do you wish to create a new ballot and delete the one in progress ?',
        button: {
          ok: 'Create a new one',
          cancel: 'Continue Editing',
        },
      },
      user: {
        title: 'Warning',
        message:
          'To create a Ballot, you must have at least your first and last name in your profile',
      },
    },
  },
  load: {
    failure: 'An error occurred while loading the ballots',
  },
  list: {
    empty: 'No Results',
    winner: 'Winner: ',
    motion: 'Motion: ',
    tournament: 'Tournament: ',
    teamAFF: 'Team Affirmation: ',
    teamNEG: 'Team Negation: ',
    judge: 'Judge(s): ',
    author: 'Author: ',
    createdAt: 'Created at: ',
    editedAt: 'Edited at: ',
    button: {
      view: 'View',
      edit: 'Edit',
      delete: 'Delete',
    },
    delete: {
      title: 'Warning',
      message:
        'This action will delete this ballot. Are you sure you want to continue ?',
      button: {
        ok: 'Yes',
        cancel: 'Cancel',
      },
      failure: 'Ballot could not be deleted',
      success: 'Deleted successfully',
    },
  },
  timeline: {
    title: 'Your Debate History',
    tournament: 'At the tournament ',
    authorMotion: ', you refereed the debate on the motion ',
    participantMotion: ', you participated in a debate on the motion ',
    winner: 'The winner was the team: ',
    judge: 'The debate was refereed by: ',
  },
};
