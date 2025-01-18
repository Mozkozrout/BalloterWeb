<template>
  <BallotFormSkeleton v-if="authStore.isLoading || ballotStore.isLoading" />
  <div id="Ballot Form" v-if="!authStore.isLoading && !ballotStore.isLoading">
    <q-page
      class="row justify-center items-center"
      style="background: linear-gradient(#f3f3f5, #b4b4b4)"
      :class="{ 'bg-grey-9': $q.dark.isActive }"
    >
      <!--Phone fullscreen div -->
      <div
        :class="{ 'q-pa-lg': !$q.platform.is.mobile }"
        v-if="authStore.user != null"
      >
        <!--The Ballot card window layout thingie -->
        <q-layout
          view="hHh lpR fFf"
          container
          items-center
          class="bg-white text-dark"
          :class="{
            'shadow-24': !$q.dark.isActive,
            'q-pa-lg': !$q.platform.is.mobile,
          }"
          style="min-width: 816px"
          :style="{
            minWidth: mobileW + 'px',
            minHeight: mobileH + 'px',
          }"
        >
          <!--Header -->
          <q-header
            class="bg-dark text-center"
            :class="{ 'bg-black': $q.dark.isActive }"
            :elevated="!$q.platform.is.mobile && !$q.dark.isActive"
          >
            <q-toolbar :class="$q.screen.width < 1630 ? 'column' : ''">
              <!--Preptime Stopwatch A -->
              <StopWatch
                v-if="!loading"
                :hidden="
                  $q.screen.width < 1630 && !showPrepTimeTimers ? true : false
                "
                speach="APrep"
                :toggle="toggleTimer('APrep')"
                :innitData="timers != null ? timers.APrep : null"
                @tick="getTime"
              />

              <q-toolbar-title>
                <div class="col">
                  <!--Heading -->
                  <h4
                    class="text-h5 text-white text-center q-my-sm"
                    style="cursor: pointer"
                    @click="showPrepTimeTimers = !showPrepTimeTimers"
                  >
                    {{ $t('ballotF.title') }}

                    <q-tooltip> {{ $t('ballotF.tooltip') }} </q-tooltip>
                    <!--Kliknutím zobrazte/skryjte časovače na přípravný čas na malých obrazovkách-->
                  </h4>
                  <q-separator dark inset />
                  <!--Stopwatch for current ongoing speach -->
                  <div class="row justify-center">
                    <q-btn
                      dense
                      flat
                      size="10px"
                      color="white"
                      icon="skip_previous"
                      @click="
                        timer != null ? getTimer(timer.index, '-') : void 0,
                          (init = false)
                      "
                    />
                    <div
                      class="q-my-xs text-body2"
                      :class="'text-' + timer?.color"
                    >
                      {{ timer?.label + ' - ' }}
                    </div>
                    <div class="q-my-xs text-body2 text-white q-ml-xs">
                      {{ formattedTime }}
                    </div>

                    <q-btn
                      dense
                      flat
                      size="10px"
                      color="white"
                      :icon="icon"
                      @click="timerToggle = !timerToggle"
                    />
                    <q-btn
                      dense
                      flat
                      size="10px"
                      color="white"
                      icon="skip_next"
                      @click="
                        timer != null ? getTimer(timer.index, '+') : void 0,
                          (init = false)
                      "
                    />
                  </div>
                </div>
              </q-toolbar-title>

              <!--Preptime Stopwatch N -->
              <StopWatch
                v-if="!loading"
                :hidden="
                  $q.screen.width < 1630 && !showPrepTimeTimers ? true : false
                "
                speach="NPrep"
                :toggle="toggleTimer('NPrep')"
                :innitData="timers != null ? timers.NPrep : null"
                @tick="getTime"
              />
            </q-toolbar>
          </q-header>

          <!--Body of the Form -->
          <q-page-container>
            <q-card square>
              <!--Tvorba Ballotu -->
              <q-card-section>
                <!--Ballot info-->
                <h6 class="text-h7 q-my-xs">
                  {{ $t('ballotF.basicInfo.title') }}
                </h6>
                <!--Základní Informace-->

                <q-form class="q-px-sm" ref="ballotForm">
                  <div class="row">
                    <!--Tournament-->
                    <div class="col-grow">
                      <q-select
                        style="min-width: 250px"
                        class="q-pa-sm"
                        :class="hasError('tournament') ? 'q-pb-md' : ''"
                        ref="tournament"
                        outlined
                        v-model="tournament"
                        :label="$t('ballotF.basicInfo.tournament')"
                        :options="ballotStore.tournaments"
                        :option-label="
                          (tournament) =>
                            tournament == null ? '' : tournament.name
                        "
                        @update:model-value="
                          tournament == null
                            ? ''
                            : (place = tournament.institution.name),
                            saveBallot()
                        "
                        ><!--Turnaj-->

                        <template v-slot:prepend>
                          <q-icon name="emoji_events" />
                        </template>
                      </q-select>
                    </div>

                    <!--Motion-->
                    <div class="col-grow">
                      <q-select
                        style="min-width: 250px"
                        class="q-pa-sm"
                        :class="hasError('motion') ? 'q-pb-md' : ''"
                        ref="motion"
                        outlined
                        v-model="motion"
                        :label="$t('ballotF.basicInfo.motion')"
                        :options="ballotStore.motions"
                        :option-label="
                          (motion) => (motion == null ? '' : motion.name)
                        "
                        @update:model-value="saveBallot()"
                        ><!--Teze-->

                        <template v-slot:prepend>
                          <q-icon name="history_edu" />
                        </template>
                      </q-select>
                    </div>
                  </div>

                  <div class="row">
                    <!--Date-->
                    <div class="col-grow">
                      <q-input
                        class="q-pa-sm"
                        :class="hasError('date') ? 'q-pb-md' : ''"
                        outlined
                        ref="date"
                        v-model="date"
                        lazy-rules
                        :rules="[$rules.isDate]"
                        :label="$t('ballotF.basicInfo.date')"
                        @update:model-value="saveBallot()"
                        ><!--Datum-->

                        <template v-slot:prepend>
                          <q-icon name="event" class="cursor-pointer">
                            <q-popup-proxy
                              cover
                              transition-show="scale"
                              transition-hide="scale"
                            >
                              <q-date
                                v-model="date"
                                color="lime-6"
                                text-color="black"
                                mask="YYYY-MM-DD"
                              >
                                <div class="row items-center justify-end">
                                  <q-btn
                                    v-close-popup
                                    :label="$t('ballotF.basicInfo.date_close')"
                                    color="light-blue-13"
                                    flat
                                  />
                                </div>
                              </q-date>
                            </q-popup-proxy>
                          </q-icon>
                        </template>
                      </q-input>
                    </div>

                    <!--Place-->
                    <div class="col-grow">
                      <q-input
                        class="q-pa-sm"
                        :class="hasError('place') ? 'q-pb-md' : ''"
                        ref="place"
                        outlined
                        clearable
                        v-model="place"
                        type="text"
                        :label="$t('ballotF.basicInfo.place')"
                        lazy-rules
                        :rules="[]"
                        @update:model-value="saveBallot()"
                        ><!--Místo konání-->

                        <template v-slot:prepend>
                          <q-icon name="home" />
                        </template>
                      </q-input>
                    </div>
                  </div>

                  <!--Adjudicator-->
                  <div class="row">
                    <!--Adjudicator name-->
                    <div class="col-grow">
                      <q-input
                        class="q-pa-sm"
                        :class="hasError('adj_name') ? 'q-pb-md' : ''"
                        ref="adj_name"
                        outlined
                        clearable
                        v-model="adj_name"
                        type="text"
                        :label="$t('ballotF.basicInfo.name')"
                        lazy-rules
                        :rules="[$rules.noNumbers]"
                        @update:model-value="saveBallot()"
                        ><!--Jméno rozhodčího-->

                        <template v-slot:prepend>
                          <q-icon name="badge" />
                        </template>
                      </q-input>
                    </div>

                    <!--Adjudicator surname-->
                    <div class="col-grow">
                      <q-input
                        class="q-pa-sm"
                        :class="hasError('adj_surname') ? 'q-pb-md' : ''"
                        ref="adj_surname"
                        outlined
                        clearable
                        v-model="adj_surname"
                        type="text"
                        :label="$t('ballotF.basicInfo.surname')"
                        lazy-rules
                        :rules="[$rules.noNumbers]"
                        @update:model-value="saveBallot()"
                        ><!--Příjmení rozhodčího-->

                        <template v-slot:prepend>
                          <q-icon name="badge" />
                        </template>
                      </q-input>
                    </div>
                  </div>

                  <div class="row">
                    <!--Team Aff.-->
                    <div class="col-grow">
                      <q-select
                        style="min-width: 250px"
                        class="q-pa-sm"
                        :class="hasError('team_AFF') ? 'q-pb-md' : ''"
                        ref="team_AFF"
                        outlined
                        v-model="team_AFF"
                        :label="$t('ballotF.basicInfo.teamAFF')"
                        :options="getTournamentTeams"
                        :option-label="
                          (team) => (team == null ? '' : team.name)
                        "
                        @update:model-value="saveBallot()"
                        ><!--Tým Afirmace -->

                        <template v-slot:prepend>
                          <q-icon name="group_add" />
                        </template>
                      </q-select>
                    </div>

                    <!--Team Neg.-->
                    <div class="col-grow">
                      <q-select
                        style="min-width: 250px"
                        class="q-pa-sm"
                        :class="hasError('team_NEG') ? 'q-pb-md' : ''"
                        ref="team_NEG"
                        outlined
                        v-model="team_NEG"
                        :label="$t('ballotF.basicInfo.teamNEG')"
                        :options="getTournamentTeams"
                        :option-label="
                          (team) => (team == null ? '' : team.name)
                        "
                        @update:model-value="saveBallot()"
                        ><!--Tým Negace -->

                        <template v-slot:prepend>
                          <q-icon name="group_remove" />
                        </template>
                      </q-select>
                    </div>
                  </div>

                  <q-separator spaced inset />
                  <!--Speakers-->
                  <h6 class="text-h7 q-my-xs">
                    {{ $t('ballotF.speakers.title') }}
                  </h6>
                  <!--Jednotlivé Řeči-->

                  <div class="row">
                    <div class="col-grow q-pa-sm">
                      <q-list bordered class="rounded-borders">
                        <!--A1-->
                        <BallotSpeaker
                          v-if="!loading"
                          speaker="A1"
                          :team="team_AFF"
                          :id="id"
                          :innit-data="A1"
                          :toggle-timer="toggleTimer('A1')"
                          :toggle-CQ-timer="toggleTimer('A1xN2')"
                          :timerData="timers != null ? timers.A1 : null"
                          :timerCQData="timers != null ? timers.A1xN2 : null"
                          @timer-tick="getTime"
                          @timer-CQ-tick="getTime"
                          @get-values="
                            (speaker) => (
                              getSpeakerValues(speaker), saveBallot()
                            )
                          "
                        />

                        <!--A2-->
                        <BallotSpeaker
                          v-if="!loading"
                          speaker="A2"
                          :team="team_AFF"
                          :id="id"
                          :innit-data="A2"
                          :toggle-timer="toggleTimer('A2')"
                          :timerData="timers != null ? timers.A2 : null"
                          @timer-tick="getTime"
                          @get-values="
                            (speaker) => (
                              getSpeakerValues(speaker), saveBallot()
                            )
                          "
                        />

                        <!--A3-->
                        <BallotSpeaker
                          v-if="!loading"
                          speaker="A3"
                          :team="team_AFF"
                          :id="id"
                          :innit-data="A3"
                          :toggle-timer="toggleTimer('A3')"
                          :toggle-CQ-timer="toggleTimer('A3xN1')"
                          :timerData="timers != null ? timers.A3 : null"
                          :timerCQData="timers != null ? timers.A3xN1 : null"
                          @timer-tick="getTime"
                          @timer-CQ-tick="getTime"
                          @get-values="
                            (speaker) => (
                              getSpeakerValues(speaker), saveBallot()
                            )
                          "
                        />

                        <!--N1-->
                        <BallotSpeaker
                          v-if="!loading"
                          speaker="N1"
                          :team="team_NEG"
                          :id="id"
                          :innit-data="N1"
                          :toggle-timer="toggleTimer('N1')"
                          :toggle-CQ-timer="toggleTimer('N1xA2')"
                          :timerData="timers != null ? timers.N1 : null"
                          :timerCQData="timers != null ? timers.N1xA2 : null"
                          @timer-tick="getTime"
                          @timer-CQ-tick="getTime"
                          @get-values="
                            (speaker) => (
                              getSpeakerValues(speaker), saveBallot()
                            )
                          "
                        />

                        <!--N2-->
                        <BallotSpeaker
                          v-if="!loading"
                          speaker="N2"
                          :team="team_NEG"
                          :id="id"
                          :innit-data="N2"
                          :toggle-timer="toggleTimer('N2')"
                          :timerData="timers != null ? timers.N2 : null"
                          @timer-tick="getTime"
                          @get-values="
                            (speaker) => (
                              getSpeakerValues(speaker), saveBallot()
                            )
                          "
                        />

                        <!--N3-->
                        <BallotSpeaker
                          v-if="!loading"
                          speaker="N3"
                          :team="team_NEG"
                          :id="id"
                          :innit-data="N3"
                          :toggle-timer="toggleTimer('N3')"
                          :toggle-CQ-timer="toggleTimer('N3xA1')"
                          :timerData="timers != null ? timers.N3 : null"
                          :timerCQData="timers != null ? timers.N3xA1 : null"
                          @timer-tick="getTime"
                          @timer-CQ-tick="getTime"
                          @get-values="
                            (speaker) => (
                              getSpeakerValues(speaker), saveBallot()
                            )
                          "
                        />
                      </q-list>
                    </div>
                  </div>

                  <q-separator spaced inset />
                  <!--Decision Part-->
                  <h6 class="text-h7 q-my-xs">
                    {{ $t('ballotF.decision.title') }}
                  </h6>
                  <!--Rozhodnutí-->

                  <!--Decision-->
                  <div class="row">
                    <div class="col-grow">
                      <q-input
                        class="q-pa-sm q-pb-md"
                        ref="decision"
                        outlined
                        bottom-slots
                        :shadow-text="
                          decision.length == 0
                            ? $t('ballotF.decision.decision_hint')
                            : ''
                        "
                        v-model="decision"
                        type="textarea"
                        :label="$t('ballotF.decision.decision')"
                        :debounce="text_refresh_rate"
                        lazy-rules
                        :rules="[]"
                        @update:model-value="saveBallot()"
                        ><!--Rozhodnutí-->

                        <template v-slot:prepend>
                          <q-icon name="reviews" />
                        </template>

                        <template v-slot:hint>
                          <q-icon
                            v-if="
                              decision.length < decision_char_goal &&
                              decision.length > 0
                            "
                            name="more_horiz"
                            size="50px"
                            style="transform: translateY(-20px)"
                          />
                          <q-icon
                            v-if="decision.length == 0"
                            name="close"
                            size="25px"
                            style="transform: translateY(-8px)"
                            color="negative"
                          />
                          <q-icon
                            v-if="decision.length >= decision_char_goal"
                            name="done"
                            size="25px"
                            style="transform: translateY(-8px)"
                            color="positive"
                          />
                        </template>

                        <template v-slot:counter>
                          <p
                            :class="{
                              'text-negative':
                                decision.length < decision_char_goal,
                              'text-positive':
                                decision.length >= decision_char_goal,
                            }"
                          >
                            {{ decision.length - decision_char_goal }}
                          </p>
                        </template>

                        <template v-slot:append>
                          <q-btn icon="help" flat round dense>
                            <q-tooltip>
                              {{ $t('ballotF.decision.decision_tooltip') }}
                            </q-tooltip>
                            <!--Uh oh, křížové otázky-->
                          </q-btn>
                        </template>
                      </q-input>
                    </div>
                  </div>
                  <div class="row">
                    <!--Adj. Winning Team-->
                    <div class="col-grow">
                      <q-select
                        style="min-width: 250px"
                        class="q-pa-sm"
                        :class="hasError('adj_winning_team') ? 'q-pb-md' : ''"
                        ref="adj_winning_team"
                        outlined
                        v-model="adj_winning_team"
                        :label="$t('ballotF.decision.adjWinner')"
                        :options="
                          team_AFF == null || team_NEG == null
                            ? getTournamentTeams
                            : [team_AFF, team_NEG]
                        "
                        :option-label="
                          (team) => (team == null ? '' : team.name)
                        "
                        @update:model-value="saveBallot()"
                        ><!--Rozhodčího vítězný tým-->

                        <template v-slot:prepend>
                          <q-icon name="sports" />
                        </template>
                      </q-select>
                    </div>

                    <!--Winning Team-->
                    <div class="col-grow">
                      <q-select
                        style="min-width: 250px"
                        class="q-pa-sm"
                        :class="hasError('winning_team') ? 'q-pb-md' : ''"
                        ref="winning_team"
                        outlined
                        v-model="winning_team"
                        :label="$t('ballotF.decision.winner')"
                        :options="
                          team_AFF == null || team_NEG == null
                            ? getTournamentTeams
                            : [team_AFF, team_NEG]
                        "
                        :option-label="
                          (team) => (team == null ? '' : team.name)
                        "
                        @update:model-value="saveBallot()"
                        ><!--Vítězný tým-->

                        <template v-slot:prepend>
                          <q-icon name="military_tech" />
                        </template>
                      </q-select>
                    </div>
                  </div>

                  <!--Adjudications-->
                  <div class="row">
                    <div class="col-grow">
                      <q-select
                        class="q-pa-sm"
                        :class="hasError('adjudications') ? 'q-pb-md' : ''"
                        ref="adjudications"
                        outlined
                        clearable
                        v-model="adjudications"
                        type="text"
                        :label="$t('ballotF.decision.adjudications')"
                        :options="['3:0', '2:1']"
                        @update:model-value="saveBallot()"
                        ><!--Rozhodnutím-->

                        <template v-slot:prepend>
                          <q-icon name="gavel" />
                        </template>
                      </q-select>
                    </div>
                  </div>

                  <!--Best Speaker-->
                  <div class="row">
                    <div class="col-grow">
                      <q-select
                        style="min-width: 250px"
                        class="q-pa-sm"
                        :class="hasError('best_speaker') ? 'q-pb-md' : ''"
                        ref="best_speaker"
                        outlined
                        v-model="best_speaker"
                        :label="$t('ballotF.decision.bestSpeaker')"
                        :options="getSpeakers"
                        :option-label="
                          (speaker) =>
                            speaker == null
                              ? ''
                              : speaker?.name + ' ' + speaker?.surname
                        "
                        @update:model-value="saveBallot()"
                        ><!--Nejlepší řečník-->

                        <template v-slot:prepend>
                          <q-icon name="star" />
                        </template>
                      </q-select>
                    </div>
                  </div>

                  <!--Sum of Speaker Points-->
                  <div class="row">
                    <!--Neg.-->
                    <div class="col-grow">
                      <q-input
                        class="q-pa-sm"
                        :class="hasError('NEG_sum') ? 'q-pb-md' : ''"
                        ref="NEG_sum"
                        outlined
                        readonly
                        v-model="getTeamNPointSum"
                        type="number"
                        :label="$t('ballotF.decision.sumNEG')"
                        lazy-rules
                        :rules="[]"
                        ><!--Součet řečnických bodů N-->

                        <template v-slot:prepend>
                          <q-icon name="functions" />
                        </template>
                      </q-input>
                    </div>

                    <!--Aff.-->
                    <div class="col-grow">
                      <q-input
                        class="q-pa-sm"
                        :class="hasError('AFF_sum') ? 'q-pb-md' : ''"
                        ref="AFF_sum"
                        outlined
                        readonly
                        v-model="getTeamAPointSum"
                        type="number"
                        :label="$t('ballotF.decision.sumAFF')"
                        lazy-rules
                        :rules="[]"
                        ><!--Součet řečnických bodů A-->

                        <template v-slot:prepend>
                          <q-icon name="functions" />
                        </template>
                      </q-input>
                    </div>
                  </div>
                </q-form>
              </q-card-section>

              <q-separator spaced inset />

              <q-card-actions>
                <!--Submit Button-->
                <div class="col-auto q-pa-sm">
                  <q-btn
                    class="q-pa-sm"
                    elevated
                    size="lg"
                    color="light-blue-13"
                    text-color="grey-1"
                    @click="submit"
                    :label="$t('ballotF.button.save')"
                  /><!--Uložit-->
                </div>
                <!--Cancel Button-->
                <div class="col-auto q-pa-sm">
                  <q-btn
                    class="q-pa-sm"
                    elevated
                    size="lg"
                    color="orange-13"
                    text-color="grey-1"
                    :label="$t('ballotF.button.cancel')"
                    @click="deleteSavedBallot()"
                    :to="{ name: 'ballot', params: { user: 0 } }"
                  /><!--Zrušit-->
                </div>
              </q-card-actions>
            </q-card>
          </q-page-container>
        </q-layout>
      </div>
    </q-page>
  </div>
</template>

<style>
textarea {
  height: 172px;
}
</style>

<script lang="ts">
import { useAuthStore } from 'src/stores/AuthStore';
import { useBallotStore } from 'src/stores/BallotStore';
import { mapStores } from 'pinia';
import { QForm, QInput } from 'quasar';
import {
  Tournament,
  Team,
  Motion,
  Person,
  BallotData,
  Speaker,
  TimerData,
  BallotTimer,
  TimerList,
} from 'components/models';
import BallotFormSkeleton from 'src/components/skeletons/BallotFormSkeleton.vue';
import BallotSpeaker from 'src/components/BallotSpeaker.vue';
import StopWatch from 'src/components/StopWatch.vue';

export default {
  name: 'BallotForm',

  props: ['id'],

  components: {
    BallotFormSkeleton,
    BallotSpeaker,
    StopWatch,
  },

  async created() {
    //Checking if the user is logged in
    if (this.authStore.user === null) this.$router.push({ path: '/auth/0' });

    //Initialising the Adjudicator
    this.Adjudicator = {
      id: this.authStore.user?.person.id,
      role: 'Adjudicator',
      comment: '',
      cont_points: 0,
      str_points: 0,
      style_points: 0,
      cq_points: 0,
      best_speaker: 0,
      author: 1,
      person_id: this.authStore.user?.person,
    };

    //loading the available data
    if (this.ballotStore.motions.length == 0) await this.loadMotions();
    if (this.ballotStore.teams.length == 0) await this.loadTeams();
    if (this.ballotStore.tournaments.length == 0) await this.loadTournaments();
    this.fillStartingValues();
  },

  data: function () {
    return {
      loading: true, //loading state for loading saved data, if there isn't here, speaker components start emiting data faster then its loaded and then it gets overwritten by empty values midway
      decision_char_goal: 300, //target amount of characters for Decision
      text_refresh_rate: 1000, //polling rate for text input fields
      tournament: null as Tournament | null,
      date: '',
      place: '' as string,
      adj_name: '',
      adj_surname: '',
      motion: null as Motion | null,
      team_AFF: null as Team | null,
      team_NEG: null as Team | null,
      decision: '',
      adj_winning_team: null as Team | null,
      winning_team: null as Team | null,
      adjudications: '',
      best_speaker: null as Person | null,
      Adjudicator: null as Partial<Speaker> | null,
      A1: null as Partial<Speaker> | null,
      A2: null as Partial<Speaker> | null,
      A3: null as Partial<Speaker> | null,
      N1: null as Partial<Speaker> | null,
      N2: null as Partial<Speaker> | null,
      N3: null as Partial<Speaker> | null,
      order: [] as string[], //list of order of speaches used by timers
      timerToggle: false,
      timer: null as BallotTimer | null, //timer name and info that is being shown
      currentTime: 0, //timer value that is being shown
      timers: null as TimerList | null, //list of all timer values to save
      showPrepTimeTimers: false, //Togge to show timers in the header on small screens
      init: true, //toggle to safeguard the timer label starting at A1
      set: false, //toggle to safeguard loading running state from timers(so it doesn't get overwrriten every second but sets just once)
      icon: '', //icon for the play/pause button
    };
  },

  methods: {
    //Submit function that stores the ballot into the database
    async submit(): Promise<void> {
      //making sure user is the author of the ballot before submitting
      var ballot = this.findBallot(this.id);
      if (
        (this.id != 0 &&
          ballot != null &&
          this.authStore.user?.person.id === this.author(ballot)?.id &&
          (this.authStore.user?.role.id == '1' ||
            this.authStore.user?.role.id == '2')) ||
        this.id == 0
      ) {
        //validating the form and checking for errors
        let errors = false;
        await (this.$refs.ballotForm as typeof QForm)
          .validate()
          .then((success: boolean) => {
            if (!success) {
              errors = true;
              this.$q.notify({
                icon: 'warning',
                color: 'negative',
                message: this.$t('ballotF.submit.validate.failure'), //Ballot obsahuje neplatné hodnoty
              });
            }
          });
        if (!errors) {
          //finding the best speaker and setting the right variable in the right object
          if (
            //testing if all the speakers are filled correctly
            this.A1 != null &&
            this.A1.person_id != null &&
            this.A2 != null &&
            this.A2.person_id != null &&
            this.A3 != null &&
            this.A3.person_id != null &&
            this.N1 != null &&
            this.N1.person_id != null &&
            this.N2 != null &&
            this.N2.person_id != null &&
            this.N3 != null &&
            this.N3.person_id != null &&
            this.Adjudicator != null &&
            this.Adjudicator.person_id != null
          ) {
            //finding and setting the best speaker
            switch (this.best_speaker?.id) {
              case this.A1.id:
                this.A1.best_speaker = 1;
                break;
              case this.A2.id:
                this.A2.best_speaker = 1;
                break;
              case this.A3.id:
                this.A3.best_speaker = 1;
                break;
              case this.N1.id:
                this.N1.best_speaker = 1;
                break;
              case this.N2.id:
                this.N2.best_speaker = 1;
                break;
              case this.N3.id:
                this.N3.best_speaker = 1;
                break;
            }

            //calling the function for saving the ballot in the ballotStore
            if (
              this.tournament != null &&
              this.motion != null &&
              this.team_AFF != null &&
              this.team_NEG != null &&
              this.adj_winning_team != null &&
              this.winning_team != null &&
              (await this.ballotStore.createOrUpdateBallot(
                Number(this.id),
                this.tournament,
                this.date,
                this.motion,
                this.team_AFF,
                this.team_NEG,
                this.decision,
                this.adj_winning_team,
                this.winning_team,
                this.adjudications,
                this.Adjudicator,
                this.A1,
                this.A2,
                this.A3,
                this.N1,
                this.N2,
                this.N3
              ))
            ) {
              this.$q.notify({
                icon: 'done',
                color: 'positive',
                message: this.$t('ballotF.submit.success'), //Uloženo
              });
              this.deleteSavedBallot();
              this.$router.push({ path: '/ballot/0' });
            } else {
              this.$q.notify({
                icon: 'warning',
                color: 'negative',
                message: this.$t('ballotF.submit.failure'), //Ballot se nepodařilo uložit
              });
            }
          }
          //If one of the speakers isn't filled correctly
          else {
            this.$q.dialog({
              title: this.$t('ballotF.submit.warning.title'), //Upozornění
              message: this.$t('ballotF.submit.warning.speakerMessage'), //Jeden z Řečníků obsahuje chyby, nebo není vyplněn
              ok: {
                flat: true,
                color: 'light-blue-13',
              },
            });
          }
        }
      }
      //If the user doesn't have personal info filled or the correct role
      else {
        this.$q.dialog({
          title: this.$t('ballotF.submit.warning.title'), //Upozornění
          message: this.$t('ballotF.submit.warning.message'), //Pro přidání ballotu musíte mít v profilu vyplněno alespoň jméno a příjmení a musíte mít dostatečná oprávnění
          ok: {
            flat: true,
            color: 'light-blue-13',
          },
        });
      }
    },

    //function for loading the list of motions
    async loadMotions(): Promise<void> {
      if (!(await this.ballotStore.loadMotions())) {
        this.$q.notify({
          icon: 'warning',
          color: 'negative',
          message: this.$t('motion.load.failure'), //Při načítání tezí došlo k chybě
        });
      }
    },

    //function for loading the list of teams
    async loadTeams(): Promise<void> {
      if (!(await this.ballotStore.loadTeams())) {
        this.$q.notify({
          icon: 'warning',
          color: 'negative',
          message: this.$t('ballotF.teams.failure'), //Při načítání týmů došlo k chybě
        });
      }
    },

    //function for loading the list of tournaments
    async loadTournaments(): Promise<void> {
      if (!(await this.ballotStore.loadTournaments())) {
        this.$q.notify({
          icon: 'warning',
          color: 'negative',
          message: this.$t('ballotF.tournaments.failure'), //Při načítání turnajů došlo k chybě
        });
      }
    },

    //function that updates the basic values of the judge name and today's date for the form
    //also loads all the data in case user is editing an existing ballot
    fillStartingValues(): void {
      this.loading = true;
      if (this.id == 0) {
        if (
          this.authStore.user !== null &&
          (this.authStore.user.role.id == '1' ||
            this.authStore.user.role.id == '2')
        ) {
          this.adj_name = this.authStore.user.person.name;
          this.adj_surname = this.authStore.user.person.surname;
        }
        //loading date and place from autosave in case it is being loaded
        if (this.ballotStore.ballot != null) {
          this.date = this.ballotStore.ballot.Ballot.date;
          this.place = this.ballotStore.ballot.Ballot.place;
        } else this.date = new Date(Date.now()).toISOString().substring(0, 10);
      }
      //In case the user is editing the ballot this data is loaded
      if (this.id != 0 || this.ballotStore.ballot != null) {
        var ballot = null;

        //loading the right ballot either from autosave or from databse based on id
        if (this.ballotStore.ballot != null) {
          ballot = this.ballotStore.ballot;
          this.best_speaker = ballot?.Ballot.best_speaker;
        } else ballot = this.findBallot(this.id);

        //if user is the author of the ballot the form gets filled with data
        if (
          ballot != null &&
          this.authStore.user?.person.id === this.author(ballot)?.id
        ) {
          this.date = ballot.Ballot.date;
          this.tournament = ballot.Ballot.tournament;
          this.place = ballot.Ballot.tournament?.institution.name;
          this.motion = ballot.Ballot.motion;
          this.team_AFF = ballot.Ballot.team_AFF;
          this.team_NEG = ballot.Ballot.team_NEG;
          this.decision = ballot.Ballot.decision;
          this.adj_winning_team = ballot.Ballot.adj_winning_team;
          this.winning_team = ballot.Ballot.winning_team;
          this.adjudications = ballot.Ballot.adjucations;

          ballot?.People.forEach((speaker: Speaker) => {
            if (speaker != null && speaker.best_speaker == 1)
              this.best_speaker = speaker.person_id;

            if (speaker != null && speaker.role == 'Adjudicator') {
              this.adj_name = speaker.person_id.name;
              this.adj_surname = speaker.person_id.surname;
            }
            this.getSpeakerValues(speaker);
          });

          //loading the timer data from autosave
          if (ballot.Timers != null) {
            this.timers = {
              APrep: ballot.Timers.APrep,
              NPrep: ballot.Timers.NPrep,
              A1: ballot.Timers.A1,
              A2: ballot.Timers.A1,
              A3: ballot.Timers.A1,
              N1: ballot.Timers.N1,
              N2: ballot.Timers.N2,
              N3: ballot.Timers.N2,
              N3xA1: ballot.Timers.N3xA1,
              A3xN1: ballot.Timers.A3xN1,
              N1xA2: ballot.Timers.N1xA2,
              A1xN2: ballot.Timers.A1xN2,
            };
          }
        }
      }

      //Initiating the timers data
      if (this.timers == null) {
        this.timers = {
          APrep: null,
          NPrep: null,
          A1: null,
          A2: null,
          A3: null,
          N1: null,
          N2: null,
          N3: null,
          N3xA1: null,
          A3xN1: null,
          N1xA2: null,
          A1xN2: null,
        };
      }

      //Inicialising timer
      this.timer = { label: 'A1', index: 0, color: 'lime-6' };

      //Iniciating the order of speaches
      this.order = [
        'A1',
        'NPrep',
        'N3xA1',
        'NPrep',
        'N1',
        'APrep',
        'A3xN1',
        'APrep',
        'A2',
        'NPrep',
        'N1xA2',
        'NPrep',
        'N2',
        'APrep',
        'A1xN2',
        'APrep',
        'A3',
        'NPrep',
        'N3',
      ];

      this.loading = false;
      this.saveBallot(); //manual initial save
    },

    //Function that finds the author of the ballot
    author(ballot: BallotData): Person | null {
      var author = null;
      ballot.People.forEach((speaker: Speaker) => {
        if (speaker != null && speaker.author == 1) author = speaker.person_id;
      });
      return author;
    },

    //function that finds the ballot based on given id
    findBallot(id: string): BallotData | null {
      var result = null;
      for (const ballot of this.ballotStore.ballots) {
        if (ballot.Ballot.id == id) {
          result = ballot;
          break;
        }
      }
      return result;
    },

    //function that saves the work in progress ballot to the storage
    saveBallot(): void {
      //filling the ballot with data from the form
      const savedBallot = {
        Ballot: {
          tournament: this.tournament,
          id: this.id,
          date: this.date,
          motion: this.motion,
          team_AFF: this.team_AFF,
          team_NEG: this.team_NEG,
          decision: this.decision,
          adj_winning_team: this.adj_winning_team,
          winning_team: this.winning_team,
          adjucations: this.adjudications,
          adj_name: this.adj_name,
          adj_surname: this.adj_surname,
          best_speaker: this.best_speaker,
          place: this.place,
        },
        People: [
          this.Adjudicator,
          this.A1,
          this.A2,
          this.A3,
          this.N1,
          this.N2,
          this.N3,
        ],
        Timers: this.timers,
      };

      //ballot is getting saved only when the the page is done loading initial data
      if (!this.loading) {
        //ballot is being saved to the store and the storage
        this.ballotStore.savedBallot = JSON.stringify(savedBallot);
        localStorage.setItem('ballot', JSON.stringify(savedBallot));
      }
    },

    //functions that deletes autosaved ballot from storage and store
    deleteSavedBallot(): void {
      this.loading = true;
      this.ballotStore.savedBallot = null;
      localStorage.removeItem('ballot');
    },

    //function that loads data from speaker components
    getSpeakerValues(speaker: Partial<Speaker>): void {
      if (speaker != null) {
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
        }
      }
    },

    //function that returns the error state of the given qinput element
    hasError(element: keyof typeof QInput): boolean {
      let result = false;
      if (!this.loading)
        try {
          result = (this.$refs[element] as typeof QInput).hasError;
        } catch {}
      return result;
    },

    //function that gets timer information from StopWatch components
    getTime(time: TimerData): void {
      if (this.timer != null) {
        if (time.running) this.init = false;
        //if the selected speach label is the same as the timer, the timer data gets shown
        if (time.speach == this.timer.label) {
          this.setToggle(time.running); //updating play/pause button based off the timer state
          this.currentTime = time.time;
          this.timer.color = time.color;
        } else if (!this.init) {
          this.setToggle(time.running);
          this.timer.index = this.getTimerIndex(time.speach); //updating the table when timer tht isn't focused gets started
          this.timer.label = time.speach;
        }
        //saving the timer values into an object
        if (this.timers != null) {
          this.timers[time.speach as keyof TimerList] = time.time;
        }
      } else {
        this.timer = { label: 'A1', index: 0, color: 'lime-6' };
      }
    },

    //small function for setting the toggle from the feedback of running timers
    setToggle(running: boolean): void {
      if (!running) {
        this.icon = 'play_arrow';
      } else this.icon = 'pause';

      if (!this.set) {
        this.timerToggle = running;
        this.set = true;
      }
    },

    //function that lets the user browse through the array of speaches for timer
    getTimer(currentIndex: number, direction: string): void {
      let index = Number(currentIndex + Number(direction + '1')); //getting the next or previous index based on the user input
      if (index < 0) index = this.order.length - 1; //safeguarding not to get out of the array
      if (index > this.order.length - 1) index = 0;

      //saving the values
      if (this.timer != null) {
        this.timer.label = this.order[index];
        this.timer.index = index;
      }
    },

    //function that returns the index of the timer label (it's wonky for prep times as it always finds the first one in the array)
    getTimerIndex(speach: string): number {
      return this.order.findIndex((val) => {
        return val == speach;
      });
    },

    //function that ensures only the selected timer gets toggled
    toggleTimer(speach: string): boolean {
      if (this.timer == null) return false;

      let timerCheck = false;
      if (speach == this.timer.label) timerCheck = true;
      return this.timerToggle && timerCheck;
    },
  },

  computed: {
    ...mapStores(useAuthStore, useBallotStore),
    //function that finds the teams that are attending selected tournament
    getTournamentTeams(): Team[] {
      var result = [] as Team[];
      if (this.ballotStore.teams.length !== 0) {
        if (this.tournament != null) {
          //go through all the teams and all their tournaments and if there is a match with the selected event, return it
          this.ballotStore.teams.forEach((team) => {
            team.events.forEach((tournament) => {
              if (tournament.id === this.tournament?.id) result.push(team);
            });
          });

          return result;
        } else return this.ballotStore.teams;
      }
      return result;
    },

    //function that returns all the speakers in team neg and team aff
    getSpeakers(): Person[] {
      var result = [] as Person[];

      if (this.team_AFF != null && this.team_NEG != null) {
        result = result.concat(
          this.team_AFF?.team_members,
          this.team_NEG?.team_members
        );
      }
      return result;
    },

    //function that calculates sum of points of team AFF
    getTeamAPointSum(): number {
      return (
        Number(
          Number(this.A1?.cont_points) +
            Number(this.A1?.str_points) +
            Number(this.A1?.style_points) +
            Number(this.A1?.cq_points)
        ) +
        Number(
          Number(this.A2?.cont_points) +
            Number(this.A2?.str_points) +
            Number(this.A2?.style_points) +
            Number(this.A2?.cq_points)
        ) +
        Number(
          Number(this.A3?.cont_points) +
            Number(this.A3?.str_points) +
            Number(this.A3?.style_points) +
            Number(this.A3?.cq_points)
        )
      );
    },

    //function that calculates sum of points of team NEG
    getTeamNPointSum(): number {
      return (
        Number(
          Number(this.N1?.cont_points) +
            Number(this.N1?.str_points) +
            Number(this.N1?.style_points) +
            Number(this.N1?.cq_points)
        ) +
        Number(
          Number(this.N2?.cont_points) +
            Number(this.N2?.str_points) +
            Number(this.N2?.style_points) +
            Number(this.N2?.cq_points)
        ) +
        Number(
          Number(this.N3?.cont_points) +
            Number(this.N3?.str_points) +
            Number(this.N3?.style_points) +
            Number(this.N3?.cq_points)
        )
      );
    },

    //function that returns formatted time values out of amount of seconds
    formattedTime(): string {
      const date = new Date();
      let result = '';
      date.setMinutes(0);
      date.setHours(0);
      date.setSeconds(this.currentTime);
      if (date.getHours() > 0) {
        result =
          date.getHours() +
          ' : ' +
          date.getMinutes() +
          ' : ' +
          date.getSeconds();
      }
      if (date.getMinutes() > 0) {
        result = date.getMinutes() + ' : ' + date.getSeconds();
      } else result = date.getSeconds().toString();
      return result;
    },

    //function that returns screen width when on mobile
    mobileW(): number {
      if (this.$q.platform.is.mobile) {
        return this.$q.screen.width;
      }
      return this.$q.screen.width / 2.3;
    },
    //function that returns screen height when on mobile
    mobileH(): number {
      if (this.$q.platform.is.mobile) {
        return this.$q.screen.height - 50;
      }
      return this.$q.screen.height / 1.2;
    },
  },
};
</script>
