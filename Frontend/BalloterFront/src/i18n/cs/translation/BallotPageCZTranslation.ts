export default {
  //Ballot
  title: 'Balloty',
  tab: {
    all: 'Vše',
    tournaments: 'Turnaje',
    motions: 'Teze',
    timeline: 'Timeline',
  },
  button: {
    toggle: 'Mnou vypsané balloty',
    open: 'Otevřít',
    delete: 'Zahodit',
  },
  add: {
    warning: {
      autosave: {
        title: 'Upozornění',
        message:
          'Už máte jeden ballot rozpracovaný, přejete si v jeho úpravách pokračovat nebo si přejete vytvořit nový ballot a rozpracovaný přemazat ?',
        button: {
          ok: 'Vytvořit nový',
          cancel: 'Otevřít rozpracovaný',
        },
      },
      user: {
        title: 'Upozornění',
        message:
          'Pro vytvoření Ballotu musíte mít v profilu vyplněno alespoň jméno a příjmení',
      },
    },
  },
  load: {
    failure: 'Při načítání ballotů došlo k chybě',
  },
  list: {
    empty: 'Žádné výsledky',
    winner: 'Vítěz: ',
    motion: 'Teze: ',
    tournament: 'Turnaj: ',
    teamAFF: 'Tým Afirmace: ',
    teamNEG: 'Tým Negace: ',
    judge: 'Rozhodčí: ',
    author: 'Autor: ',
    createdAt: 'Vypsáno dne: ',
    editedAt: 'Upraveno dne: ',
    button: {
      view: 'Zobrazit',
      edit: 'Upravit',
      delete: 'Smazat',
    },
    delete: {
      title: 'Upozornění',
      message:
        'Tato akce smaže tento ballot. Jste si jisti, že chcete pokračovat ?',
      button: {
        ok: 'Ano',
        cancel: 'Zrušit',
      },
      failure: 'Ballot se nepodařilo smazat',
      success: 'Úspěšně smazáno',
    },
  },
  timeline: {
    title: 'Vaše Debatní Historie',
    tournament: 'Na turnaji ',
    authorMotion: 'jste rozhodoval/a debatu na tezi ',
    participantMotion: 'jste se účastnil/a debaty na tezi ',
    winner: 'Vítězem se stal tým: ',
    judge: 'Debatu rozhodoval/i/y: ',
  },
};
