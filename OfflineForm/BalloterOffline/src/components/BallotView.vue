<template>
  <q-layout
    view="Lhh lpR fff"
    container
    items-center
    class="bg-white text-dark"
    :style="$q.screen.width > widthBreakPoint ? 'min-width: 800px' : ''"
  >
    <q-header reveal class="bg-dark text-center">
      <q-toolbar>
        <q-toolbar-title>{{
          ballot.Ballot.motion.name +
          ' - ' +
          ballot.Ballot.tournament.name +
          ' - ' +
          new Date(ballot.Ballot.date).toLocaleDateString()
        }}</q-toolbar-title>
        <q-btn
          flat
          @click="downloadPDF()"
          round
          dense
          icon="download"
          :loading="ballotStore.isLoading"
        />
        <q-btn flat v-close-popup round dense icon="close" />
      </q-toolbar>
    </q-header>
    <q-page-container>
      <q-page padding>
        <!--Ballot-->

        <div class="col-grow">
          <!--Basic Info-->
          <div
            :class="$q.screen.width < widthBreakPoint ? 'col' : 'col q-px-xl'"
          >
            <div class="row items-center">
              <img
                width="135"
                height="63"
                src="../assets/logo_text.png"
                align="right"
                hspace="12"
                v-if="$q.screen.width < widthBreakPoint"
              />
              <div class="col-grow">
                <h6
                  :class="
                    $q.screen.width < widthBreakPoint
                      ? 'text-h7'
                      : 'text-h7 q-ma-md'
                  "
                >
                  LIST ROZHODČÍHO / THE BALLOT
                </h6>
              </div>
              <!--Image in the corner-->
              <div
                :class="
                  $q.screen.width < widthBreakPoint ? 'col' : 'col q-px-md'
                "
              >
                <img
                  width="135"
                  height="63"
                  src="../assets/logo_text.png"
                  align="right"
                  hspace="12"
                  v-if="$q.screen.width > widthBreakPoint"
                />
              </div>
            </div>
            <div class="row">
              <p :class="$q.screen.width < widthBreakPoint ? '' : 'q-px-md'">
                Turnaj / Tournament: {{ ballot.Ballot.tournament.name }}
              </p>
            </div>
            <div class="row">
              <p :class="$q.screen.width < widthBreakPoint ? '' : 'q-px-md'">
                Místo, datum / Place, date:
                {{
                  ballot.Ballot.tournament.institution.name +
                  ', ' +
                  new Date(ballot.Ballot.date).toLocaleDateString()
                }}.
              </p>
            </div>
            <div class="row">
              <p :class="$q.screen.width < widthBreakPoint ? '' : 'q-px-md'">
                Rozhodčí / Adjudicator: {{ judges }}
              </p>
            </div>
            <div class="row">
              <p :class="$q.screen.width < widthBreakPoint ? '' : 'q-px-md'">
                Teze / Motion: {{ ballot.Ballot.motion.name }}
              </p>
            </div>
            <div class="row">
              <p :class="$q.screen.width < widthBreakPoint ? '' : 'q-px-md'">
                Tým af. / Team aff.: {{ ballot.Ballot.team_AFF.name }}
              </p>
            </div>
            <div class="row">
              <p :class="$q.screen.width < widthBreakPoint ? '' : 'q-px-md'">
                Tým neg. / Team neg.: {{ ballot.Ballot.team_NEG.name }}
              </p>
            </div>
          </div>

          <br clear="all" />

          <!--A Table-->
          <div class="row justify-center">
            <table border="1" cellspacing="0" cellpadding="0">
              <tbody>
                <!--Table Header-->
                <tr>
                  <td width="79" rowspan="2" valign="top">
                    <p class="q-px-xs">Jméno / Name:</p>
                  </td>
                  <td width="261" rowspan="2" valign="top">
                    <p class="q-px-xs">
                      Poznámky k jednotlivci / Individual comments:
                    </p>
                  </td>
                  <td width="284" colspan="5" valign="top">
                    <p align="center">Řečnické body / Speaker points:</p>
                  </td>
                </tr>
                <tr>
                  <td width="57" valign="top">
                    <p align="center">Obs. / Cont.</p>
                    <p align="center">20-40</p>
                  </td>
                  <td width="57" valign="top">
                    <p align="center">Str. / Str.</p>
                    <p align="center">15-30</p>
                  </td>
                  <td width="57" valign="top">
                    <p align="center">Styl / Style</p>
                    <p align="center">15-30</p>
                  </td>
                  <td width="57" valign="top">
                    <p align="center">K. v. / C. q.</p>
                    <p align="center">-5-5</p>
                  </td>
                  <td width="57" valign="top">
                    <p align="center">Souč. / Sum</p>
                    <p align="center">50-100</p>
                  </td>
                </tr>
                <tr>
                  <!--Table body-->
                  <td width="79" valign="top">
                    <!--A1 name-->
                    <p class="q-px-xs">
                      {{ A1?.person_id.name + ' ' + A1?.person_id.surname }}
                    </p>
                  </td>
                  <td width="261" rowspan="2" valign="top">
                    <!--A1 comment-->
                    <p class="q-px-xs">{{ A1?.comment }}</p>
                  </td>
                  <td width="57" rowspan="2">
                    <!--A1 content points-->
                    <p align="center">{{ A1?.cont_points }}</p>
                  </td>
                  <td width="57" rowspan="2">
                    <!--A1 strategy points-->
                    <p align="center">{{ A1?.str_points }}</p>
                  </td>
                  <td width="57" rowspan="2">
                    <!--A1 style points-->
                    <p align="center">{{ A1?.style_points }}</p>
                  </td>
                  <td width="57" rowspan="2">
                    <!--A1 cross questions points-->
                    <p align="center">
                      {{
                        A1 != null && A1.cq_points > 0
                          ? '+' + A1.cq_points
                          : A1?.cq_points
                      }}
                    </p>
                  </td>
                  <td width="57" rowspan="2">
                    <!--A1 points sum-->
                    <p align="center" v-if="A1 != null">
                      {{ speakerPointsSum(A1) }}
                    </p>
                    <p v-else>N/A</p>
                  </td>
                </tr>
                <tr>
                  <td width="79" valign="top">
                    <p class="q-px-xs">A1</p>
                  </td>
                </tr>
                <tr>
                  <td width="79" valign="top">
                    <!--A2 name-->
                    <p class="q-px-xs">
                      {{ A2?.person_id.name + ' ' + A2?.person_id.surname }}
                    </p>
                  </td>
                  <td width="261" rowspan="2" valign="top">
                    <!--A2 comment-->
                    <p class="q-px-xs">{{ A2?.comment }}</p>
                  </td>
                  <td width="57" rowspan="2">
                    <!--A2 content points-->
                    <p align="center">{{ A2?.cont_points }}</p>
                  </td>
                  <td width="57" rowspan="2">
                    <!--A2 strategy points-->
                    <p align="center">{{ A2?.str_points }}</p>
                  </td>
                  <td width="57" rowspan="2">
                    <!--A2 style points-->
                    <p align="center">{{ A2?.style_points }}</p>
                  </td>
                  <td width="57" rowspan="2">
                    <!--A2 cross questions points-->
                    <p align="center">
                      {{
                        A2 != null && A2.cq_points > 0
                          ? '+' + A2.cq_points
                          : A2?.cq_points
                      }}
                    </p>
                  </td>
                  <td width="57" rowspan="2">
                    <!--A2 points sum-->
                    <p align="center" v-if="A2 != null">
                      {{ speakerPointsSum(A2) }}
                    </p>
                    <p v-else>N/A</p>
                  </td>
                </tr>
                <tr>
                  <td width="79" valign="top">
                    <p class="q-px-xs">A2</p>
                  </td>
                </tr>
                <tr>
                  <td width="79" valign="top">
                    <!--A3 name-->
                    <p class="q-px-xs">
                      {{ A3?.person_id.name + ' ' + A3?.person_id.surname }}
                    </p>
                  </td>
                  <td width="261" rowspan="2" valign="top">
                    <!--A3 comment-->
                    <p class="q-px-xs">{{ A3?.comment }}</p>
                  </td>
                  <td width="57" rowspan="2">
                    <!--A3 content points-->
                    <p align="center">{{ A3?.cont_points }}</p>
                  </td>
                  <td width="57" rowspan="2">
                    <!--A3 strategy points-->
                    <p align="center">{{ A3?.str_points }}</p>
                  </td>
                  <td width="57" rowspan="2">
                    <!--A3 style points-->
                    <p align="center">{{ A3?.style_points }}</p>
                  </td>
                  <td width="57" rowspan="2">
                    <!--A3 cross questions points-->
                    <p align="center">
                      {{
                        A3 != null && A3.cq_points > 0
                          ? '+' + A3.cq_points
                          : A3?.cq_points
                      }}
                    </p>
                  </td>
                  <td width="57" rowspan="2">
                    <!--A3 points sum-->
                    <p align="center" v-if="A3 != null">
                      {{ speakerPointsSum(A3) }}
                    </p>
                    <p v-else>N/A</p>
                  </td>
                </tr>
                <tr>
                  <td width="79" valign="top">
                    <p class="q-px-xs">A3</p>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <br />

          <!--N Table-->
          <div class="row justify-center">
            <table border="1" cellspacing="0" cellpadding="0">
              <tbody>
                <!--Table Header-->
                <tr>
                  <td width="79" rowspan="2" valign="top">
                    <p class="q-px-xs">Jméno / Name:</p>
                  </td>
                  <td width="261" rowspan="2" valign="top">
                    <p class="q-px-xs">
                      Poznámky k jednotlivci / Individual comments:
                    </p>
                  </td>
                  <td width="284" colspan="5" valign="top">
                    <p align="center">Řečnické body / Speaker points:</p>
                  </td>
                </tr>
                <tr>
                  <td width="57" valign="top">
                    <p align="center">Obs. / Cont.</p>
                    <p align="center">20-40</p>
                  </td>
                  <td width="57" valign="top">
                    <p align="center">Str. / Str.</p>
                    <p align="center">15-30</p>
                  </td>
                  <td width="57" valign="top">
                    <p align="center">Styl / Style</p>
                    <p align="center">15-30</p>
                  </td>
                  <td width="57" valign="top">
                    <p align="center">K. v. / C. q.</p>
                    <p align="center">-5-5</p>
                  </td>
                  <td width="57" valign="top">
                    <p align="center">Souč. / Sum</p>
                    <p align="center">50-100</p>
                  </td>
                </tr>
                <tr>
                  <!--Table Body-->
                  <td width="79" valign="top">
                    <!--N1 Name-->
                    <p class="q-px-xs">
                      {{ N1?.person_id.name + ' ' + N1?.person_id.surname }}
                    </p>
                  </td>
                  <td width="261" rowspan="2" valign="top">
                    <!--N1 comment-->
                    <p class="q-px-xs">{{ N1?.comment }}</p>
                  </td>
                  <td width="57" rowspan="2">
                    <!--N1 content points-->
                    <p align="center">{{ N1?.cont_points }}</p>
                  </td>
                  <td width="57" rowspan="2">
                    <!--N1 strategy points-->
                    <p align="center">{{ N1?.str_points }}</p>
                  </td>
                  <td width="57" rowspan="2">
                    <!--N1 style points-->
                    <p align="center">{{ N1?.style_points }}</p>
                  </td>
                  <td width="57" rowspan="2">
                    <!--N1 cross questions points-->
                    <p align="center">
                      {{
                        N1 != null && N1.cq_points > 0
                          ? '+' + N1.cq_points
                          : N1?.cq_points
                      }}
                    </p>
                  </td>
                  <td width="57" rowspan="2">
                    <!--N1 points sum-->
                    <p align="center" v-if="N1 != null">
                      {{ speakerPointsSum(N1) }}
                    </p>
                    <p v-else>N/A</p>
                  </td>
                </tr>
                <tr>
                  <td width="79" valign="top">
                    <p class="q-px-xs">N1</p>
                  </td>
                </tr>
                <tr>
                  <td width="79" valign="top">
                    <!--N2 Name-->
                    <p class="q-px-xs">
                      {{ N2?.person_id.name + ' ' + N2?.person_id.surname }}
                    </p>
                  </td>
                  <td width="261" rowspan="2" valign="top">
                    <!--N2 comment-->
                    <p class="q-px-xs">{{ N2?.comment }}</p>
                  </td>
                  <td width="57" rowspan="2">
                    <!--N2 content points-->
                    <p align="center">{{ N2?.cont_points }}</p>
                  </td>
                  <td width="57" rowspan="2">
                    <!--N2 strategy points-->
                    <p align="center">{{ N2?.str_points }}</p>
                  </td>
                  <td width="57" rowspan="2">
                    <!--N2 style points-->
                    <p align="center">{{ N2?.style_points }}</p>
                  </td>
                  <td width="57" rowspan="2">
                    <!--N2 cross questions points-->
                    <p align="center">
                      {{
                        N2 != null && N2.cq_points > 0
                          ? '+' + N2.cq_points
                          : N2?.cq_points
                      }}
                    </p>
                  </td>
                  <td width="57" rowspan="2">
                    <!--N2 points sum-->
                    <p align="center" v-if="N2 != null">
                      {{ speakerPointsSum(N2) }}
                    </p>
                    <p v-else>N/A</p>
                  </td>
                </tr>
                <tr>
                  <td width="79" valign="top">
                    <p class="q-px-xs">N2</p>
                  </td>
                </tr>
                <tr>
                  <td width="79" valign="top">
                    <!--N3 Name-->
                    <p class="q-px-xs">
                      {{ N3?.person_id.name + ' ' + N3?.person_id.surname }}
                    </p>
                  </td>
                  <td width="261" rowspan="2" valign="top">
                    <!--N3 comment-->
                    <p class="q-px-xs">{{ N3?.comment }}</p>
                  </td>
                  <td width="57" rowspan="2">
                    <!--N3 content points-->
                    <p align="center">{{ N3?.cont_points }}</p>
                  </td>
                  <td width="57" rowspan="2">
                    <!--N3 strategy points-->
                    <p align="center">{{ N3?.str_points }}</p>
                  </td>
                  <td width="57" rowspan="2">
                    <!--N3 style points-->
                    <p align="center">{{ N3?.style_points }}</p>
                  </td>
                  <td width="57" rowspan="2">
                    <!--N3 cross questions points-->
                    <p align="center">
                      {{
                        N3 != null && N3.cq_points > 0
                          ? '+' + N3.cq_points
                          : N3?.cq_points
                      }}
                    </p>
                  </td>
                  <td width="57" rowspan="2">
                    <!--N3 points sum-->
                    <p align="center" v-if="N3 != null">
                      {{ speakerPointsSum(N3) }}
                    </p>
                    <p v-else>N/A</p>
                  </td>
                </tr>
                <tr>
                  <td width="79" valign="top">
                    <p class="q-px-xs">N3</p>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <br />

          <!--Decision table-->
          <div class="row justify-center">
            <table border="1" cellspacing="0" cellpadding="0">
              <tbody>
                <tr>
                  <td width="626" valign="top">
                    <div>
                      <p align="center" lass="q-px-xs">
                        Konkrétní a podrobné vysvětlení rozhodnutí / Concrete
                        and detailed justification of the decision:
                      </p>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
            <table border="1" cellspacing="0" cellpadding="0">
              <tbody>
                <tr>
                  <td width="626" valign="top">
                    <!--Decision-->
                    <p class="q-px-xs">{{ ballot.Ballot.decision }}</p>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <br />

          <!--More General Info-->
          <div
            :class="$q.screen.width < widthBreakPoint ? 'col' : 'col q-px-xl'"
          >
            <div class="row">
              <p :class="$q.screen.width < widthBreakPoint ? '' : 'q-px-md'">
                Rozhodčího vítězný tým / Adjudicator’s winning team:
                {{ ballot.Ballot.adj_winning_team.name }}
              </p>
            </div>
            <div class="row">
              <p :class="$q.screen.width < widthBreakPoint ? '' : 'q-px-md'">
                Vítězný tým / Winning team:
                {{ ballot.Ballot.winning_team.name }}
              </p>
            </div>
            <div class="row">
              <p :class="$q.screen.width < widthBreakPoint ? '' : 'q-px-md'">
                Rozhodnutím / Adjudications: {{ ballot.Ballot.adjucations }}
              </p>
            </div>
            <div class="row">
              <p :class="$q.screen.width < widthBreakPoint ? '' : 'q-px-md'">
                Nejlepší řečník / Best speaker:
                {{
                  best_speaker?.role +
                  ' - ' +
                  best_speaker?.person_id.name +
                  ' ' +
                  best_speaker?.person_id.surname
                }}
              </p>
            </div>
            <div class="row">
              <p :class="$q.screen.width < widthBreakPoint ? '' : 'q-px-md'">
                Součet řečnických bodů / Sum of speaker points: A:
                {{ teamPointsSum('AFF') }} N: {{ teamPointsSum('NEG') }}
              </p>
            </div>
          </div>
        </div>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { useAuthStore } from 'src/stores/AuthStore';
import { useBallotStore } from 'src/stores/BallotStore';
import { mapStores } from 'pinia';
import { Speaker } from 'components/models';

export default defineComponent({
  name: 'BallotView',

  props: ['ballot'],

  data: function () {
    return {
      A1: null as Speaker | null,
      A2: null as Speaker | null,
      A3: null as Speaker | null,
      N1: null as Speaker | null,
      N2: null as Speaker | null,
      N3: null as Speaker | null,
      judges: '',
      best_speaker: null as Speaker | null,
      widthBreakPoint: 800,
    };
  },

  mounted() {
    this.loadSpeakers();
  },

  methods: {
    //function that loads different people from ballot into variables
    loadSpeakers() {
      this.ballot.People.forEach((speaker: Speaker) => {
        if (speaker.best_speaker === 1) this.best_speaker = speaker;

        switch (speaker.role) {
          case 'A1':
            this.A1 = speaker;
            break;
          case 'A2':
            this.A2 = speaker;
            break;
          case 'A3':
            this.A3 = speaker;
            break;
          case 'N1':
            this.N1 = speaker;
            break;
          case 'N2':
            this.N2 = speaker;
            break;
          case 'N3':
            this.N3 = speaker;
            break;
          case 'Adjudicator':
            if (this.judges === '') {
              this.judges +=
                speaker.person_id.name + ' ' + speaker.person_id.surname;
            } else
              this.judges +=
                ', ' + speaker.person_id.name + ' ' + speaker.person_id.surname;
            break;
        }
      });
    },

    async downloadPDF() {
      if (!(await this.ballotStore.downloadBallotPDF(this.ballot))) {
        this.$q.notify({
          icon: 'warning',
          color: 'negative',
          message: 'Ballot se nepodařilo stáhnout',
        });
      } else {
        this.$q.notify({
          icon: 'done',
          color: 'positive',
          message: 'Staženo',
        });
      }
    },

    //function for calculating sum of speaker's points
    speakerPointsSum(speaker: Speaker): number {
      var cont_points = Number(speaker.cont_points);
      var str_points = Number(speaker.str_points);
      var style_points = Number(speaker.style_points);
      var cq_points = Number(speaker.cq_points);

      return cont_points + str_points + style_points + cq_points;
    },

    //function for calculation the sum of team's points
    teamPointsSum(team: 'AFF' | 'NEG'): number {
      var result = 0;
      if (team === 'AFF') {
        if (this.A1 != null && this.A2 != null && this.A3 != null) {
          result =
            this.speakerPointsSum(this.A1) +
            this.speakerPointsSum(this.A2) +
            this.speakerPointsSum(this.A3);
        }
      } else {
        if (this.N1 != null && this.N2 != null && this.N3 != null) {
          result =
            this.speakerPointsSum(this.N1) +
            this.speakerPointsSum(this.N2) +
            this.speakerPointsSum(this.N3);
        }
      }

      return result;
    },
  },

  computed: {
    ...mapStores(useAuthStore, useBallotStore),
  },
});
</script>
