<template>
  <q-timeline
    color="light-blue-13"
    style="max-width: 1000px; overflow: auto"
    :style="{
      height: $q.screen.height / 2.1 + 'px',
    }"
    class="q-pa-md"
  >
    <q-timeline-entry heading>
      {{ $t('ballot.timeline.title') }}
    </q-timeline-entry>
    <!-- Debatní Historie -->

    <!--I could also make it add headings every year-->
    <q-timeline-entry
      @click="onViewClick(ballot)"
      style="cursor: pointer"
      v-for="(ballot, index) in sortedBallots"
      :key="index"
      :title="ballot.Ballot.tournament.name + ' - ' + ballot.Ballot.motion.name"
      :subtitle="
        new Date(ballot.Ballot.date).toLocaleDateString($i18n.locale, {
          dateStyle: 'full',
        })
      "
      :icon="
        author(ballot)?.id === authStore.user?.person.id
          ? 'edit_document'
          : 'description'
      "
    >
      <div v-if="author(ballot)?.id === authStore.user?.person.id">
        {{ $t('ballot.timeline.tournament') }}
        {{ ballot.Ballot.tournament.name }}
        {{ $t('ballot.timeline.authorMotion') }}
        {{ '"' + ballot.Ballot.motion.name + '"' }}<br />
        {{ $t('ballot.timeline.winner') }}
        {{ ballot.Ballot.winning_team.name }}.<br />
        {{ $t('ballot.timeline.judge') }}
        {{ judges(ballot) }}
      </div>
      <!--Na turnaji ??? jste rozhodoval/a debatu na tezi ???
                Vítězem se stal tým: ???
                Debatu rozhodoval/i/y: ???  -->
      <div v-else>
        {{ $t('ballot.timeline.tournament') }}
        {{ ballot.Ballot.tournament.name }}
        {{ $t('ballot.timeline.participantMotion') }}
        {{ '"' + ballot.Ballot.motion.name + '"' }}<br />
        {{ $t('ballot.timeline.winner') }}
        {{ ballot.Ballot.winning_team.name }}.<br />
        {{ $t('ballot.timeline.judge') }}
        {{ judges(ballot) }}
      </div>
      <!--Na turnaji ??? jste se účastnil/a debaty na tezi ???
                Vítězem se stal tým: ???
                Debatu rozhodoval/i/y: ???  -->
    </q-timeline-entry>
  </q-timeline>

  <!--Compononet inside of dialog to show detailed ballot overview-->
  <q-dialog v-model="viewSwitch">
    <BallotView :ballot="viewBallot" />
  </q-dialog>
</template>
<script lang="ts">
import { defineComponent } from 'vue';
import { useAuthStore } from 'src/stores/AuthStore';
import { useBallotStore } from 'src/stores/BallotStore';
import { BallotData, Speaker, Person } from 'components/models';
import { mapStores } from 'pinia';
import BallotView from 'components/BallotView.vue';

export default defineComponent({
  name: 'BallotTimeLine',

  components: {
    BallotView,
  },

  data: function () {
    return {
      viewSwitch: false,
      viewBallot: null as BallotData | null,
    };
  },

  methods: {
    //function that shows the detailed overview of the Ballot
    onViewClick(ballot: BallotData): void {
      this.viewSwitch = true;
      this.viewBallot = ballot;
    },
    //Function that finds the author of the ballot
    author(ballot: BallotData): Person | null {
      var author = null;
      ballot.People.forEach((speaker: Speaker) => {
        if (speaker.author == 1) author = speaker.person_id;
      });
      return author;
    },

    //Function that returns string of names of debate judges
    judges(ballot: BallotData): string {
      var result = '';
      ballot.People.forEach((speaker: Speaker) => {
        if (speaker.role === 'Adjudicator') {
          if (result === '') {
            result += speaker.person_id.name + ' ' + speaker.person_id.surname;
          } else
            result +=
              ', ' + speaker.person_id.name + ' ' + speaker.person_id.surname;
        }
      });
      return result;
    },
  },

  computed: {
    ...mapStores(useAuthStore, useBallotStore),

    //Function that returns array of ballots sorted by date
    sortedBallots() {
      var result = this.ballotStore.ballots;
      result.sort(function (a, b) {
        const date1 = new Date(a.Ballot.date).getTime();
        const date2 = new Date(b.Ballot.date).getTime();
        return date2 - date1;
      });
      return result;
    },
  },
});
</script>
