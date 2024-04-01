import { defineStore } from 'pinia';
import { useAuthStore } from 'src/stores/AuthStore';
import {
  Motion,
  BallotData,
  Team,
  Tournament,
  Speaker,
} from 'components/models';

export const useBallotStore = defineStore('ballotStore', {
  state: () => ({
    motionList: [] as Motion[],
    ballotList: [] as BallotData[],
    teamList: [] as Team[],
    tournamentList: [] as Tournament[],
    savedBallot: localStorage.getItem('ballot'),
    loading: false,
  }),

  getters: {
    motions: (state) => state.motionList,
    ballots: (state) => state.ballotList,
    teams: (state) => state.teamList,
    tournaments: (state) => state.tournamentList,
    isLoading: (state) => state.loading,
    ballot: (state) => {
      if (state.savedBallot != null) {
        return JSON.parse(state.savedBallot);
      } else return null;
    },
  },

  actions: {
    //Function for loading the list of Ballots from the API
    async loadBallots(): Promise<boolean> {
      //It could probably load the data only once and then work with their local version which would then get synced with API periodically
      //instead of just making a full refresh with every change.
      this.loading = true;
      this.ballotList = [];

      const authStore = useAuthStore();

      try {
        this.api.defaults.headers.common['Authorization'] = authStore.token;
        const response = await this.api.get('ballot');

        response.data.forEach((ballot: BallotData) => {
          this.ballotList.push(ballot);
        });
      } catch {
        this.loading = false;
        return false;
      }

      this.loading = false;
      return true;
    },

    async loadAllBallots(): Promise<boolean> {
      //It could probably load the data only once and then work with their local version which would then get synced with API periodically
      //instead of just making a full refresh with every change. - This loads all the ballots and its admin only feature
      this.loading = true;
      this.ballotList = [];

      const authStore = useAuthStore();

      try {
        this.api.defaults.headers.common['Authorization'] = authStore.token;
        const response = await this.api.get('ballots');

        response.data.forEach((ballot: BallotData) => {
          this.ballotList.push(ballot);
        });
      } catch {
        this.loading = false;
        return false;
      }

      this.loading = false;
      return true;
    },

    //functions that creates or updates the ballot in the database
    async createOrUpdateBallot(
      ballot_id: number,
      tournament: Tournament,
      date: string,
      motion: Motion,
      team_AFF: Team,
      team_NEG: Team,
      decision: string,
      adj_winning_team: Team,
      winning_team: Team,
      adjudications: string,
      Adjudicator: Partial<Speaker>,
      A1: Partial<Speaker>,
      A2: Partial<Speaker>,
      A3: Partial<Speaker>,
      N1: Partial<Speaker>,
      N2: Partial<Speaker>,
      N3: Partial<Speaker>
    ) {
      this.loading = true;

      const authStore = useAuthStore();

      //This could get updated so that it can accept an array of speakers so that there can be multiple judges added
      const pivot = {
        Adjudicator: Adjudicator,
        A1: A1,
        A2: A2,
        A3: A3,
        N1: N1,
        N2: N2,
        N3: N3,
      };

      try {
        this.api.defaults.headers.common['Authorization'] = authStore.token;
        if (ballot_id === 0) {
          //creating new ballot
          await this.api.post('ballot', {
            tournament: tournament.id,
            date: date,
            motion: motion.id,
            team_AFF: team_AFF.id,
            team_NEG: team_NEG.id,
            decision: decision,
            adj_winning_team: adj_winning_team.id,
            winning_team: winning_team.id,
            adjucations: adjudications, //yes its a typo
            pivot: pivot,
          });
        } else {
          //updating existing ballot
          await this.api.put('ballot/' + ballot_id, {
            tournament: tournament.id,
            date: date,
            motion: motion.id,
            team_AFF: team_AFF.id,
            team_NEG: team_NEG.id,
            decision: decision,
            adj_winning_team: adj_winning_team.id,
            winning_team: winning_team.id,
            adjucations: adjudications,
            pivot: pivot,
          });
        }
        await this.loadBallots();
      } catch {
        this.loading = false;
        return false;
      }

      this.loading = false;
      return true;
    },

    //function for deleting the ballot from the database
    async deleteBallot(ballot: BallotData): Promise<boolean> {
      this.loading = true;

      const authStore = useAuthStore();

      try {
        this.api.defaults.headers.common['Authorization'] = authStore.token;
        await this.api.delete('ballot/'.concat(ballot.Ballot.id));
        await this.loadBallots();
      } catch {
        this.loading = false;
        return false;
      }

      this.loading = false;
      return true;
    },

    async downloadBallotPDF(ballot: BallotData): Promise<boolean> {
      this.loading = true;

      const authStore = useAuthStore();

      try {
        this.api.defaults.headers.common['Authorization'] = authStore.token;
        const response = await this.api.get(
          'ballot/pdf/'.concat(ballot.Ballot.id),
          {
            responseType: 'blob',
          }
        );
        const link = document.createElement('a');
        link.href = window.URL.createObjectURL(new Blob([response.data]));
        link.setAttribute(
          'download',
          ballot.Ballot.motion.name.concat(
            ' - ',
            ballot.Ballot.tournament.name,
            ' - ',
            new Date(ballot.Ballot.date).toLocaleDateString(),
            '.pdf'
          )
        );
        document.body.appendChild(link);
        link.click();
        await this.loadBallots();
      } catch {
        this.loading = false;
        return false;
      }

      this.loading = false;
      return true;
    },

    //Function for loading the list of Teams from the API
    async loadTeams(): Promise<boolean> {
      this.loading = true;
      this.teamList = [];

      const authStore = useAuthStore();

      try {
        this.api.defaults.headers.common['Authorization'] = authStore.token;
        const response = await this.api.get('teams');

        response.data.forEach((team: Team) => {
          this.teamList.push(team);
        });
      } catch {
        this.loading = false;
        return false;
      }

      this.loading = false;
      return true;
    },

    //Function for loading the list of Tournaments from the API
    async loadTournaments(): Promise<boolean> {
      this.loading = true;
      this.tournamentList = [];

      const authStore = useAuthStore();

      try {
        this.api.defaults.headers.common['Authorization'] = authStore.token;
        const response = await this.api.get('tournaments');

        response.data.forEach((tournament: Tournament) => {
          this.tournamentList.push(tournament);
        });
      } catch {
        this.loading = false;
        return false;
      }

      this.loading = false;
      return true;
    },

    //Function for loading the list of Motions from the API
    async loadMotions(): Promise<boolean> {
      //It could probably load the data only once and then work with their local version which would then get synced with API periodically
      //instead of just making a full refresh with every change.
      this.loading = true;
      this.motionList = [];

      const authStore = useAuthStore();

      try {
        this.api.defaults.headers.common['Authorization'] = authStore.token;
        const response = await this.api.get('motion');

        response.data.forEach((motion: Motion) => {
          this.motionList.push(motion);
        });
      } catch {
        this.loading = false;
        return false;
      }

      this.loading = false;
      return true;
    },

    //function for saving the motion into the database
    async createMotion(motionName: string): Promise<boolean> {
      this.loading = true;

      const authStore = useAuthStore();

      try {
        this.api.defaults.headers.common['Authorization'] = authStore.token;
        await this.api.post('motion', {
          name: motionName,
        });
        await this.loadMotions();
      } catch {
        this.loading = false;
        return false;
      }

      this.loading = false;
      return true;
    },

    //function for updating the motion in the database
    async editMotion(motion: Motion, motionName: string): Promise<boolean> {
      this.loading = true;

      const authStore = useAuthStore();

      try {
        this.api.defaults.headers.common['Authorization'] = authStore.token;
        await this.api.put('motion/'.concat(motion.id), {
          name: motionName,
        });
        await this.loadMotions();
      } catch {
        this.loading = false;
        return false;
      }

      this.loading = false;
      return true;
    },

    //function for deleting the motion from the database
    async deleteMotion(motion: Motion): Promise<boolean> {
      this.loading = true;

      const authStore = useAuthStore();

      try {
        this.api.defaults.headers.common['Authorization'] = authStore.token;
        await this.api.delete('motion/'.concat(motion.id));
        await this.loadMotions();
      } catch {
        this.loading = false;
        return false;
      }

      this.loading = false;
      return true;
    },
  },
});
