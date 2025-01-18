<template>
  <BallotPageSkeleton v-if="authStore.isLoading" />
  <div id="Ballot Page" v-if="!authStore.isLoading">
    <q-page
      class="row justify-center items-center"
      style="background: linear-gradient(#f3f3f5, #b4b4b4)"
      :class="{ 'bg-grey-9': $q.dark.isActive }"
    >
      <div
        :class="{ 'q-pa-lg': !$q.platform.is.mobile }"
        v-if="authStore.user != null"
      >
        <div class="row">
          <q-card
            square
            :class="{ 'shadow-24': !$q.dark.isActive }"
            style="min-height: 350px"
            :style="{
              minWidth: mobileW + 'px',
              minHeight: mobileH + 'px',
            }"
          >
            <!--Header-->
            <q-card-section
              class="bg-dark"
              :class="{ 'bg-black': $q.dark.isActive }"
            >
              <div
                :class="{
                  'row justify-center': $q.screen.width >= widthBreakPoint,
                  'row justify-start': $q.screen.width <= widthBreakPoint,
                }"
              >
                <!--Title -->
                <h4 class="text-h5 text-white text-center q-my-xs">
                  {{ $t('ballot.title') }}
                </h4>
                <!--Balloty-->

                <!--Search Bar-->
                <q-input
                  style="bottom: 0; right: 18px; transform: translateY(-15px)"
                  dark
                  dense
                  standout
                  v-model="searchInput"
                  input-class="text-right"
                  class="q-ml-md absolute"
                >
                  <template v-slot:append>
                    <q-icon v-if="searchInput === ''" name="search" />
                    <q-icon
                      v-else
                      name="clear"
                      class="cursor-pointer"
                      @click="searchInput = ''"
                    />
                  </template>
                </q-input>
              </div>
            </q-card-section>

            <!--Nav Tabs-->
            <div
              class="row bg-dark justify-center"
              :class="{ 'bg-black': $q.dark.isActive }"
            >
              <q-tabs
                v-model="tab"
                inline-label
                outside-arrows
                mobile-arrows
                dense
                class="text-white"
                :style="{ maxWidth: $q.screen.width / 1.1 + 'px' }"
              >
                <q-tab
                  name="All"
                  icon="select_all"
                  :label="$t('ballot.tab.all')"
                /><!--Vše-->

                <q-tab
                  name="Tournaments"
                  icon="emoji_events"
                  :label="$t('ballot.tab.tournaments')"
                /><!--Turnaje-->

                <q-tab
                  name="Motions"
                  icon="history_edu"
                  :label="$t('ballot.tab.motions')"
                /><!--Teze-->

                <q-tab
                  name="Timeline"
                  icon="timeline"
                  :label="$t('ballot.tab.timeline')"
                /><!--Časová řada-->
              </q-tabs>
            </div>

            <q-card-section>
              <q-tab-panels v-model="tab" animated>
                <!--Tab All-->
                <q-tab-panel name="All">
                  <BallotList :ballotList="search(ballotStore.ballots)" />
                </q-tab-panel>

                <!--Tab Tournaments-->
                <q-tab-panel name="Tournaments">
                  <q-splitter
                    v-model="splitterTournaments"
                    :horizontal="$q.screen.width < widthBreakPoint"
                  >
                    <!--The list of Tournaments (categories - inner tabs)-->
                    <template v-slot:before>
                      <q-tabs
                        inline-label
                        outside-arrows
                        mobile-arrows
                        dense
                        v-model="innerTabTournaments"
                        :vertical="$q.screen.width > widthBreakPoint"
                        :style="{ maxWidth: $q.screen.width / 1.1 + 'px' }"
                      >
                        <q-tab
                          v-for="(tournament, index) in tournaments"
                          :name="index"
                          :label="tournament.name"
                          :key="index"
                        />
                      </q-tabs>
                    </template>

                    <!--The list of Tournaments (Tab Contents)-->
                    <template v-slot:after>
                      <q-tab-panels
                        v-model="innerTabTournaments"
                        animated
                        transition-prev="slide-down"
                        transition-next="slide-up"
                      >
                        <q-tab-panel
                          v-for="(tournament, index) in tournaments"
                          :name="index"
                          :label="tournament.name"
                          :key="index"
                        >
                          <div class="text-h5 q-mb-md">
                            {{ tournament.name }}
                          </div>
                          <!--This can be problematic, depends on how well it will work once user makes changes to ballots-->
                          <BallotList
                            :ballotList="search(ballotFilterT(tournament))"
                          />
                        </q-tab-panel>
                      </q-tab-panels>
                    </template>
                  </q-splitter>
                </q-tab-panel>

                <!--Tab Motions-->
                <q-tab-panel name="Motions">
                  <q-splitter
                    v-model="splitterMotions"
                    :horizontal="$q.screen.width < widthBreakPoint"
                    :style="{ maxWidth: $q.screen.width / 1.1 + 'px' }"
                  >
                    <!--The list of Motions (categories - inner tabs)-->
                    <template v-slot:before>
                      <q-tabs
                        inline-label
                        outside-arrows
                        mobile-arrows
                        dense
                        v-model="innerTabMotions"
                        :vertical="$q.screen.width > widthBreakPoint"
                      >
                        <q-tab
                          v-for="(motion, index) in motions"
                          :name="index"
                          :label="motion.name"
                          :key="index"
                        />
                      </q-tabs>
                    </template>

                    <!--The list of Motions (Tab Contents)-->
                    <template v-slot:after>
                      <q-tab-panels
                        v-model="innerTabMotions"
                        animated
                        transition-prev="slide-down"
                        transition-next="slide-up"
                      >
                        <q-tab-panel
                          v-for="(motion, index) in motions"
                          :name="index"
                          :label="motion.name"
                          :key="index"
                        >
                          <div class="text-h5 q-mb-md">
                            {{ motion.name }}
                          </div>
                          <!--This can be problematic, depends on how well it will work once user makes changes to ballots-->
                          <BallotList
                            :ballotList="search(ballotFilterM(motion))"
                          />
                        </q-tab-panel>
                      </q-tab-panels>
                    </template>
                  </q-splitter>
                </q-tab-panel>

                <!--Tab Timeline-->
                <q-tab-panel name="Timeline">
                  <BallotTimeLine />
                </q-tab-panel>
              </q-tab-panels>
            </q-card-section>

            <q-card-actions class="row justify-center" style="min-height: 50px">
              <!--My ballots toggle button-->
              <q-toggle
                v-if="authStore.user.person != null"
                class="q-pa-lg absolute"
                style="bottom: 0; left: 0"
                v-model="userBallot"
                checked-icon="check"
                unchecked-icon="clear"
                :label="
                  $q.screen.width < widthBreakPoint
                    ? ''
                    : $t('ballot.button.toggle')
                "
                left-label
                color="light-blue-13"
                @click="userBallots()"
              /><!--Mnou vypsané balloty-->

              <!--Saved ballot card-->
              <q-card
                flat
                bordered
                class="q-pa-xs"
                v-if="ballotStore.ballot != null"
              >
                <q-card-section horizontal>
                  <q-item v-if="$q.screen.width > widthBreakPoint + 450">
                    <q-item-section avatar>
                      <q-icon name="edit_document" />
                    </q-item-section>

                    <q-item-section>
                      <q-item-label>{{ motionName }}</q-item-label>
                      <q-item-label caption>{{
                        ballotStore.ballot.Ballot.tournament?.name +
                        ' - ' +
                        new Date(
                          ballotStore.ballot.Ballot?.date
                        ).toLocaleDateString()
                      }}</q-item-label>
                    </q-item-section>
                  </q-item>

                  <q-card-actions horizontal class="justify-around">
                    <q-btn
                      :to="{
                        name: 'ballotEdit',
                        params: { id: ballotStore.ballot.Ballot.id },
                      }"
                      flat
                      color="light-blue-13"
                      :label="$t('ballot.button.open')"
                      v-if="$q.screen.width > widthBreakPoint + 450"
                    /><!--Otevřít-->

                    <q-btn
                      :to="{
                        name: 'ballotEdit',
                        params: { id: ballotStore.ballot.Ballot.id },
                      }"
                      flat
                      round
                      icon="file_open"
                      color="light-blue-13"
                      v-else
                    />

                    <q-icon
                      name="edit_document"
                      size="32px"
                      v-if="$q.screen.width < widthBreakPoint + 450"
                    />

                    <q-btn
                      @click="removeSavedBallot()"
                      flat
                      color="negative"
                      :label="$t('ballot.button.delete')"
                      v-if="$q.screen.width > widthBreakPoint + 450"
                    /><!--Zahodit-->

                    <q-btn
                      @click="removeSavedBallot()"
                      flat
                      round
                      icon="delete"
                      color="negative"
                      v-else
                    />
                  </q-card-actions>
                </q-card-section>
              </q-card>

              <!--Motion add button-->
              <q-btn
                v-if="authStore.user.person != null"
                class="absolute"
                style="bottom: 0; right: 18px; transform: translateY(-18px)"
                fab
                icon="add"
                color="orange-13"
                @click="onAddClick"
              />
            </q-card-actions>
          </q-card>
        </div>
      </div>
    </q-page>
  </div>
</template>

<script lang="ts">
import { useAuthStore } from 'src/stores/AuthStore';
import { useBallotStore } from 'src/stores/BallotStore';
import { mapStores } from 'pinia';
import { BallotData, Speaker, Tournament, Motion } from 'components/models';
import BallotList from 'components/BallotList.vue';
import BallotTimeLine from 'components/BallotTimeLine.vue';
import BallotPageSkeleton from 'src/components/skeletons/BallotPageSkeleton.vue';

export default {
  name: 'BallotPage',

  props: ['user'],

  components: {
    BallotList,
    BallotTimeLine,
    BallotPageSkeleton,
  },

  data: function () {
    return {
      searchInput: '',
      userBallot: false,
      tab: 'All',
      innerTabTournaments: 0,
      innerTabMotions: 0,
      splitterTournaments: 20,
      splitterMotions: 20,
      widthBreakPoint: 1150,
    };
  },

  mounted() {
    //Checking if the user is logged in
    if (this.authStore.user === null) this.$router.push({ path: '/auth/0' });

    //loading the ballots
    if (this.ballotStore.ballots.length == 0) this.loadBallots();
    if (this.user == 1) this.userBallot = !this.userBallot;
  },

  methods: {
    //function for loading the list of ballots
    async loadBallots() {
      if (!(await this.ballotStore.loadBallots())) {
        this.$q.notify({
          icon: 'warning',
          color: 'negative',
          message: this.$t('ballot.load.failure'), //Při načítání ballotů došlo k chybě
        });
      }
    },
    //Function for loading only the Ballots user created (called by a toggle button)
    async userBallots() {
      await this.loadBallots();
      var newList = [] as BallotData[];
      if (!this.userBallot) {
        this.ballotStore.ballots.forEach((ballot: BallotData) => {
          newList.push(ballot);
        });
      } else {
        //Ballots where user is as an author of the ballot
        this.ballotStore.ballots.forEach((ballot: BallotData) => {
          ballot.People.forEach((speaker: Speaker) => {
            if (
              this.authStore.user?.person.id === speaker.person_id.id &&
              speaker.author == 1
            ) {
              newList.push(ballot);
            }
          });
        });
      }
      this.ballotStore.ballotList = newList;
    },

    //function that allows starting creation of the ballot
    onAddClick() {
      if (this.authStore.user != null && this.authStore.user.person == null) {
        //if user isn't logged in or has no personal info they can't add a ballot
        this.$q.dialog({
          title: this.$t('ballot.add.warning.user.title'), //Upozornění
          message: this.$t('ballot.add.warning.user.message'), //Pro vytvoření Ballotu musíte mít v profilu vyplněno alespoň jméno a příjmení
          ok: {
            flat: true,
            color: 'light-blue-13',
          },
        });
      } else {
        if (this.ballotStore.ballot != null) {
          this.$q
            .dialog({
              title: this.$t('ballot.add.warning.autosave.title'), //Upozornění
              message: this.$t('ballot.add.warning.autosave.message'), //Už máte jeden ballot rozpracovaný, přejete si v jeho úpravách pokračovat nebo si přejete vytvořit nový ballot a rozpracovaný přemazat ?
              persistent: true,
              ok: {
                flat: true,
                color: 'orange-13',
                label: this.$t('ballot.add.warning.autosave.button.ok'), //Vytvořit nový
              },
              cancel: {
                flat: true,
                color: 'light-blue-13',
                label: this.$t('ballot.add.warning.autosave.button.cancel'), //Otevřít rozpracovaný
              },
            })
            .onOk(() => {
              this.removeSavedBallot();
              this.$router.push({ path: '/ballot/edit/0' });
            })
            .onCancel(() => {
              this.$router.push({
                path: '/ballot/edit/' + this.ballotStore.ballot.Ballot.id,
              });
            });
        } else this.$router.push({ path: '/ballot/edit/0' });
      }
    },

    //function for searching through given array of ballots
    search(ballots: BallotData[]) {
      const input = this.searchInput.toLowerCase();

      return ballots.filter(
        (ballot) =>
          //This could also search deeper (for example through all properties of team_AFF and so on)
          ballot.Ballot.motion.name.toLowerCase().includes(input) ||
          ballot.Ballot.tournament.name.toLowerCase().includes(input) ||
          ballot.Ballot.date.toString().toLowerCase().includes(input) ||
          ballot.Ballot.team_AFF.name.toLowerCase().includes(input) ||
          ballot.Ballot.team_NEG.name.toLowerCase().includes(input) ||
          ballot.Ballot.decision.toLowerCase().includes(input) ||
          ballot.Ballot.adjucations
            .toLowerCase()
            .includes(this.searchInput.toLowerCase())
        //this was here to search through speakers but didn't work
        /*
             ||
          ballot.People.filter(
            (speaker) =>
              speaker.person_id.name.toLowerCase().includes(input) ||
              speaker.person_id.surname.toLowerCase().includes(input) ||
              speaker.role.toLowerCase().includes(input) ||
              speaker.comment?.toLowerCase().includes(input)
          )
          */
      );
    },

    //Function that returns only those ballots that have a given Tournament
    ballotFilterT(tournament: Tournament): BallotData[] {
      var result = [] as BallotData[];
      this.ballotStore.ballots.forEach((ballot: BallotData) => {
        if (ballot.Ballot.tournament.id === tournament.id) {
          result.push(ballot);
        }
      });
      return result;
    },

    //Function that returns only those ballots that have a given Motion
    ballotFilterM(motion: Motion): BallotData[] {
      var result = [] as BallotData[];
      this.ballotStore.ballots.forEach((ballot: BallotData) => {
        if (ballot.Ballot.motion.id === motion.id) {
          result.push(ballot);
        }
      });
      return result;
    },

    //function that deletes the autosaved ballot from the store and storage
    removeSavedBallot(): void {
      localStorage.removeItem('ballot');
      this.ballotStore.savedBallot = null;
    },
  },

  computed: {
    ...mapStores(useAuthStore, useBallotStore),

    //Function that returns list of unique tournaments mentioned in all bellots (might be better to put into its own array but i mean vue is supposed to cache this so i hope its fine)
    tournaments(): Tournament[] {
      var result = [] as Tournament[];
      var included = false;
      this.ballotStore.ballots.forEach((ballot: BallotData) => {
        result.forEach((tournament: Tournament) => {
          if (tournament.id == ballot.Ballot.tournament.id) {
            included = true;
          }
        });
        if (!included) result.push(ballot.Ballot.tournament);
        included = false;
      });
      return result;
    },

    //Function that returns list of unique motions mentioned in all bellots (might be better to put into its own array but i mean vue is supposed to cache this so i hope its fine)
    motions(): Motion[] {
      var result = [] as Motion[];
      var included = false;
      this.ballotStore.ballots.forEach((ballot: BallotData) => {
        result.forEach((motion: Motion) => {
          if (motion.id == ballot.Ballot.motion?.id) {
            included = true;
          }
        });
        if (!included) result.push(ballot.Ballot?.motion);
        included = false;
      });
      return result;
    },

    //functions that trims the lenght of the motion in autosaved ballot
    motionName(): string {
      let desired_length = 30;
      if (this.ballotStore.ballot.Ballot.motion?.name.length > desired_length) {
        return (
          this.ballotStore.ballot.Ballot.motion?.name.substring(
            0,
            desired_length
          ) + '...'
        );
      } else return this.ballotStore.ballot.Ballot.motion?.name;
    },

    //function that returns screen width when on mobile
    mobileW() {
      if (this.$q.platform.is.mobile) {
        return this.$q.screen.width;
      }
      return this.$q.screen.width / 1.9;
    },
    //function that returns screen height when on mobile
    mobileH() {
      if (this.$q.platform.is.mobile) {
        return this.$q.screen.height - 50;
      }
      return 0;
    },
  },
};
</script>
