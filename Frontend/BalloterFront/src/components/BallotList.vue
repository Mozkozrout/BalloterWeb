<template>
  <!--Infinite Scroll yeah i know i am not really using it like infinite scroll - could be utilised if i was loading motions in more efficient way - per parts-->
  <q-infinite-scroll
    :offset="250"
    style="max-width: 1000px; overflow: auto"
    :style="{
      height: mobileH + 'px',
    }"
    :class="{ 'q-pa-md': !$q.platform.is.mobile }"
  >
    <q-list separator bordered class="rounded-borders">
      <!--Placeholder item when the search bar doesn't find anything-->
      <q-item v-if="ballotList.length == 0">
        <q-item-section class="text-subtitle1">{{
          $t('ballot.list.empty')
        }}</q-item-section> </q-item
      ><!--Žádné výsledky-->

      <!--Cycle for each of the ballot-->
      <q-expansion-item
        v-for="(ballot, index) in ballotList"
        :icon="iconStyle(ballot)"
        :header-class="headerStyle(ballot)"
        :key="index"
        :label="ballot.Ballot.motion.name"
        :caption="
          ballot.Ballot.tournament.name +
          ' - ' +
          new Date(ballot.Ballot.date).toLocaleDateString()
        "
      >
        <!--Body for the accordion motion-->
        <q-card>
          <q-card-section>
            <div class="col-grow">
              <div class="row">
                <!--Winner-->
                <q-chip
                  :class="{
                    'bg-lime-2': !$q.dark.isActive,
                    'bg-light-blue-10': $q.dark.isActive,
                  }"
                >
                  <q-avatar
                    v-if="$q.dark.isActive"
                    icon="military_tech"
                    color="light-blue-13"
                  />
                  <q-avatar v-else icon="military_tech" color="lime-6" />
                  {{ $t('ballot.list.winner') }}
                  {{
                    $q.screen.width > widthBreakPoint
                      ? ballot.Ballot.winning_team.id ==
                        ballot.Ballot.team_AFF.id
                        ? 'Afirmace - ' + ballot.Ballot.winning_team.name
                        : 'Negace - ' + ballot.Ballot.winning_team.name
                      : ballot.Ballot.winning_team.id ==
                        ballot.Ballot.team_AFF.id
                      ? 'Afirmace'
                      : 'Negace'
                  }}
                </q-chip>
                <!--Vítěz:-->
              </div>

              <div class="row">
                <!--Motion-->
                <q-chip :class="{ 'bg-white': !$q.dark.isActive }">
                  <q-avatar
                    v-if="$q.dark.isActive"
                    icon="history_edu"
                    color="light-blue-13"
                  />
                  <q-avatar v-else icon="history_edu" color="lime-6" />
                  {{ $t('ballot.list.motion') }}
                  {{ ballot.Ballot.motion.name }}
                </q-chip>
                <!--Teze:-->
              </div>

              <div class="row">
                <!--Tournament with duration-->
                <q-chip :class="{ 'bg-white': !$q.dark.isActive }">
                  <q-avatar
                    v-if="$q.dark.isActive"
                    icon="emoji_events"
                    color="light-blue-13"
                  />
                  <q-avatar v-else icon="emoji_events" color="lime-6" />
                  {{ $t('ballot.list.tournament') }}
                  {{ ballot.Ballot.tournament.name }}
                  {{
                    $q.screen.width > widthBreakPoint
                      ? ' - (Od: ' +
                        new Date(
                          ballot.Ballot.tournament.beginning
                        ).toLocaleDateString() +
                        ' Do: ' +
                        new Date(
                          ballot.Ballot.tournament.end
                        ).toLocaleDateString() +
                        ')'
                      : ''
                  }}
                </q-chip>
                <!--Turnaj:-->
              </div>

              <div class="row">
                <!--Team Aff-->
                <q-chip :class="{ 'bg-white': !$q.dark.isActive }">
                  <q-avatar
                    v-if="$q.dark.isActive"
                    icon="group_add"
                    color="light-blue-13"
                  />
                  <q-avatar v-else icon="group_add" color="lime-6" />
                  {{ $t('ballot.list.teamAFF') }}
                  {{ ballot.Ballot.team_AFF.name }}
                  {{
                    $q.screen.width > widthBreakPoint
                      ? ' - (' + teamMembers(ballot, true) + ')'
                      : ''
                  }}
                </q-chip>
                <!--Tým Afirmace:-->
              </div>

              <div class="row">
                <!--Team Neg-->
                <q-chip :class="{ 'bg-white': !$q.dark.isActive }">
                  <q-avatar
                    v-if="$q.dark.isActive"
                    icon="group_remove"
                    color="light-blue-13"
                  />
                  <q-avatar v-else icon="group_remove" color="lime-6" />
                  {{ $t('ballot.list.teamNEG') }}
                  {{ ballot.Ballot.team_NEG.name }}
                  {{
                    $q.screen.width > widthBreakPoint
                      ? ' - (' + teamMembers(ballot, false) + ')'
                      : ''
                  }}
                </q-chip>
                <!--Tým Negace:-->
              </div>

              <div class="row">
                <!--Participants-->
                <q-chip :class="{ 'bg-white': !$q.dark.isActive }">
                  <q-avatar
                    v-if="$q.dark.isActive"
                    icon="gavel"
                    color="light-blue-13"
                  />
                  <q-avatar v-else icon="gavel" color="lime-6" />
                  {{ $t('ballot.list.judge') }} {{ judges(ballot) }}
                </q-chip>
                <!--Rozhodčí:-->
              </div>

              <br />

              <div class="row">
                <!--Added by name and surname-->
                <q-chip :class="{ 'bg-white': !$q.dark.isActive }">
                  <q-avatar
                    v-if="$q.dark.isActive"
                    icon="person"
                    color="light-blue-13"
                  />
                  <q-avatar v-else icon="person" color="lime-6" />
                  {{ $t('ballot.list.author') }}
                  {{ author(ballot)?.name }}
                  {{ author(ballot)?.surname }}
                </q-chip>
                <!--Autor:-->

                <!--Created at date-->
                <q-chip :class="{ 'bg-white': !$q.dark.isActive }">
                  <q-avatar
                    v-if="$q.dark.isActive"
                    icon="calendar_month"
                    color="light-blue-13"
                  />
                  <q-avatar v-else icon="calendar_month" color="lime-6" />
                  {{ $t('ballot.list.createdAt') }}
                  {{ new Date(ballot.Ballot.created_at).toLocaleDateString() }}
                </q-chip>
                <!--Vypsáno dne:-->

                <!--Updated at date-->
                <q-chip
                  :class="{ 'bg-white': !$q.dark.isActive }"
                  v-if="
                    ballot.Ballot.updated_at != null &&
                    ballot.Ballot.updated_at !== ballot.Ballot.created_at
                  "
                >
                  <q-avatar
                    v-if="$q.dark.isActive"
                    icon="edit_calendar"
                    color="light-blue-13"
                  />
                  <q-avatar v-else icon="edit_calendar" color="lime-6" />
                  {{ $t('ballot.list.editedAt') }}
                  {{ new Date(ballot.Ballot.motion.updated_at).toDateString() }}
                </q-chip>
                <!--Upraveno dne:-->
              </div>
            </div>
          </q-card-section>

          <q-separator inset />

          <q-card-actions>
            <!--View button-->
            <q-btn
              flat
              class="q-pa-sm"
              color="light-blue-13"
              :label="$t('ballot.list.button.view')"
              @click="onViewClick(ballot)"
            /><!--Zobrazit-->

            <!--Edit button-->
            <q-btn
              v-if="
                authStore.user != null &&
                authStore.user.person.id == author(ballot)?.id
              "
              flat
              class="q-pa-sm"
              color="orange-13"
              :label="$t('ballot.list.button.edit')"
              @click="onEditClick(ballot)"
            /><!--Upravit-->

            <!--Delete button-->
            <q-btn
              v-if="
                authStore.user != null &&
                authStore.user.person.id == author(ballot)?.id
              "
              flat
              class="q-pa-sm"
              color="negative"
              :label="$t('ballot.list.button.delete')"
              @click="onDeleteClick(ballot)"
            /><!--Smazat-->
          </q-card-actions>
        </q-card>
      </q-expansion-item>
    </q-list>
    <!--Spinner dots when ballots are loading-->
    <template v-slot:loading>
      <div class="row justify-center q-my-md">
        <q-spinner-dots
          v-if="ballotStore.isLoading"
          color="lime-6"
          size="40px"
        />
        <q-space v-else />
      </div>
    </template>
  </q-infinite-scroll>

  <!--Compononet inside of dialog to show detailed ballot overview-->
  <q-dialog v-model="viewSwitch">
    <BallotView :ballot="viewBallot" />
  </q-dialog>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { useAuthStore } from 'src/stores/AuthStore';
import { useBallotStore } from 'src/stores/BallotStore';
import { mapStores } from 'pinia';
import { BallotData, Speaker, Person } from 'components/models';
import BallotView from 'components/BallotView.vue';

export default defineComponent({
  name: 'BallotList',

  props: ['ballotList'],

  components: {
    BallotView,
  },

  data: function () {
    return {
      viewSwitch: false,
      viewBallot: null as BallotData | null,
      widthBreakPoint: 1150,
    };
  },

  methods: {
    //function that shows the detailed overview of the Ballot
    onViewClick(ballot: BallotData): void {
      this.viewSwitch = true;
      this.viewBallot = ballot;
    },
    //function that shows dialog for editing the motion name after clicking the add button
    onEditClick(ballot: BallotData): void {
      //Only the author of the ballot can edit it
      if (
        this.authStore.user != null &&
        this.authStore.user.person != null &&
        this.authStore.user.person.id != this.author(ballot)?.id
      ) {
        //if user isn't logged in or has no personal info they can't add a ballot
        this.$dialogs.unauthorized(); //Na tuto akci nemáte dostatečná oprávnění
      } else {
        if (this.ballotStore.ballot != null) {
          this.$q
            .dialog({
              title: this.$t('ballot.add.warning.autosave.title'), //Upozornění
              message: this.$t('ballot.add.warning.autosave.message'), //'Už máte jeden ballot rozpracovaný, přejete si v jeho úpravách pokračovat nebo si přejete upravit vybraný ballot a rozpracovaný přemazat ?
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
              localStorage.removeItem('ballot');
              this.ballotStore.savedBallot = null;
              this.$router.push({ path: '/ballot/edit/' + ballot.Ballot.id });
            })
            .onCancel(() => {
              this.$router.push({
                path: '/ballot/edit/' + this.ballotStore.ballot.Ballot.id,
              });
            });
        } else this.$router.push({ path: '/ballot/edit/' + ballot.Ballot.id });
      }
    },

    //function that shows warning after clicking the delete button and deletes the motion
    onDeleteClick(ballot: BallotData): void {
      this.$q
        .dialog({
          title: this.$t('ballot.list.delete.title'), //Upozornění
          message: this.$t('ballot.list.delete.message'), //Tato akce smaže tento ballot. Jste si jisti, že chcete pokračovat ?
          persistent: true,
          ok: {
            flat: true,
            color: 'negative',
            label: this.$t('ballot.list.delete.button.ok'), //Ano
          },
          cancel: {
            flat: true,
            color: 'light-blue-13',
            label: this.$t('ballot.list.delete.button.cancel'), //Zrušit
          },
        })
        .onOk(async () => {
          if (
            //Only logged in users with personal info that created the Ballot can delete it
            this.authStore.user != null &&
            this.authStore.user.person != null &&
            this.authStore.user.person.id != this.author(ballot)?.id
          ) {
            this.$dialogs.unauthorized(); //Na tuto akci nemáte dostatečná oprávnění
            //The balloter Store is getting called here
          } else {
            if (!(await this.ballotStore.deleteBallot(ballot))) {
              this.$q.notify({
                icon: 'warning',
                color: 'negative',
                message: this.$t('ballot.list.delete.failure'), //Tezi se nepodařilo smazat
              });
            } else {
              this.$q.notify({
                icon: 'done',
                color: 'positive',
                message: this.$t('ballot.list.delete.success'), //Úspěšně smazáno
              });
            }
          }
        });
    },

    //function for switching the colour of the header based on whether the user is the author of the ballot
    //Maybe unnecessary to make the ballots blue, the change in icon might be enough
    headerStyle(ballot: BallotData): string {
      var header = 'text-subtitle2';
      var author = this.author(ballot);
      if (author?.id == this.authStore.user?.person.id) {
        /*
        if (this.$q.dark.isActive) {
          header = header + ' text-lime-6';
        } else {
          header = header + ' text-light-blue-13';
        }
        */
      }

      return header;
    },

    //function for switching the icon of the header based on whether the user is the author of the ballot
    iconStyle(ballot: BallotData): string {
      var icon = 'description';
      var author = this.author(ballot);
      if (author?.id == this.authStore.user?.person.id) {
        icon = 'edit_document';
      }

      return icon;
    },

    //Function that finds the author of the ballot
    author(ballot: BallotData): Person | null {
      var author = null;
      ballot.People.forEach((speaker: Speaker) => {
        if (speaker.author == 1) author = speaker.person_id;
      });
      return author;
    },

    //Function that returns string of names of team members for AFF and NEG
    teamMembers(ballot: BallotData, team: boolean): string {
      var result = '';
      if (team) {
        ballot.Ballot.team_AFF.team_members.forEach((member: Person) => {
          if (result === '') {
            result += member.name + ' ' + member.surname;
          } else result += ', ' + member.name + ' ' + member.surname;
        });
      } else {
        ballot.Ballot.team_NEG.team_members.forEach((member: Person) => {
          if (result === '') {
            result += member.name + ' ' + member.surname;
          } else result += ', ' + member.name + ' ' + member.surname;
        });
      }
      return result;
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

    //function that returns screen height when on mobile
    mobileH() {
      if (this.$q.platform.is.mobile) {
        return (this.$q.screen.height - 50) / 1.5;
      }
      return this.$q.screen.height / 2.2;
    },
  },
});
</script>
