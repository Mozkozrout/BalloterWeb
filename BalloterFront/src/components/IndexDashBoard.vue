<template>
  <!--The login or register prompt card if user is anonymous-->
  <q-card
    v-if="authStore.user === null"
    square
    :class="{ 'shadow-24': !$q.dark.isActive }"
    style="max-width: 540px"
  >
    <q-card-section>
      <p class="q-px-lg q-pt-md">
        {{ $t('index.unauthorized.message') }}
      </p>
      <!--Pro tvorbu a zobrazení ballotů je nutné se nejdříve přihlásit do
        aplikace. Ještě nemáte účet? Zaregistrujte se!-->
    </q-card-section>

    <q-card-actions class="q-px-lg justify-center">
      <div class="q-pa-md q-gutter-sm">
        <q-btn
          :to="{ name: 'auth', params: { register: 0 } }"
          elevated
          size="lg"
          color="light-blue-13"
          class="text-white q-ma-md hidden-link"
          :label="$t('index.unauthorized.login')"
          icon="login"
        />
        <!--Přihlásit-->
        <q-btn
          :to="{ name: 'auth', params: { register: 1 } }"
          elevated
          size="lg"
          color="orange-13"
          class="text-white q-ma-md hidden-link"
          :label="$t('index.unauthorized.register')"
          icon="person_add"
        />
        <!--Registrovat-->
      </div>
    </q-card-actions>
  </q-card>

  <!--The card for quick navigation to Ballots for logged in users-->
  <q-card
    v-if="authStore.user !== null"
    class="q-ma-lg"
    style="min-width: 340px"
    :class="{ 'shadow-24': !$q.dark.isActive }"
  >
    <!--info button-->
    <q-btn
      flat
      round
      :text-color="!$q.dark.isActive ? 'grey-6' : 'grey-8'"
      icon="info"
    >
      <q-tooltip>
        {{ $t('index.ballots.tooltip') }}
      </q-tooltip>
      <!--Seznam všech vašich ballotů s možností tvořit nové a zobrazovat nebo
        upravovat stávající-->
    </q-btn>

    <!--The Icon-->
    <q-card-section class="row justify-center">
      <div class="col-auto">
        <q-avatar
          :color="!$q.dark.isActive ? 'light-blue-1' : 'light-blue-13'"
          :text-color="!$q.dark.isActive ? 'light-blue-13' : 'light-blue-1'"
          icon="ballot"
          size="50px"
          font-size="30px"
        />
      </div>
    </q-card-section>

    <!--Headings-->
    <q-card-section>
      <h3
        class="text-center text-weight-bold q-my-xs"
        :class="{
          'text-dark': !$q.dark.isActive,
        }"
      >
        {{ $t('index.ballots.title') }}
      </h3>
      <!--Balloty-->
      <p
        class="text-center text-caption"
        :class="{
          'text-dark': !$q.dark.isActive,
        }"
      >
        {{
          $t('index.ballots.totalBallots') +
          countUserBallots +
          (countUserBallots == 1
            ? $t('index.ballots.totalBallots2')
            : countUserBallots > 1 && countUserBallots < 5
            ? $t('index.ballots.totalBallots3')
            : $t('index.ballots.totalBallots4'))
        }}
      </p>
      <!--Máte celkem
             ballot
             balloty
             ballotů-->
    </q-card-section>

    <!--Buttons-->
    <q-card-actions class="q-px-lg justify-center">
      <div class="q-pa-sm q-gutter-sm">
        <q-btn
          :to="{ name: 'ballot', params: { user: 0 } }"
          elevated
          flat
          size="lg"
          color="light-blue-13"
          class="text-white q-ma-md"
          :label="$t('index.ballots.button.redirect')"
          icon-right="arrow_forward"
        />
        <!--Přejít-->

        <q-btn
          @click="onBallotAddClick()"
          fab
          elevated
          size="lg"
          color="light-blue-13"
          class="text-white q-ml-xl q-mb-md"
          icon="add"
        />
      </div>
    </q-card-actions>
  </q-card>

  <!--The card for quick navigation to Motions for logged in users-->
  <q-card
    v-if="authStore.user !== null"
    class="q-ma-lg"
    style="min-width: 340px"
    :class="{ 'shadow-24': !$q.dark.isActive }"
  >
    <!--info button-->
    <q-btn
      flat
      round
      :text-color="!$q.dark.isActive ? 'grey-6' : 'grey-8'"
      icon="info"
    >
      <q-tooltip>
        {{ $t('index.motions.tooltip') }}
      </q-tooltip>
      <!--Seznam všech tezí s možností tvořit nové a zobrazovat nebo upravovat
        stávající-->
    </q-btn>

    <!--The Icon-->
    <q-card-section class="row justify-center">
      <div class="col-auto">
        <q-avatar
          :color="!$q.dark.isActive ? 'orange-2' : 'orange-14'"
          :text-color="!$q.dark.isActive ? 'orange-14' : 'orange-1'"
          icon="history_edu"
          size="50px"
          font-size="30px"
        />
      </div>
    </q-card-section>

    <!--Headings-->
    <q-card-section>
      <h3
        class="text-center text-weight-bold q-my-xs"
        :class="{
          'text-dark': !$q.dark.isActive,
        }"
      >
        {{ $t('index.motions.title') }}
      </h3>
      <!--Teze-->
      <p
        class="text-center text-caption"
        :class="{
          'text-dark': !$q.dark.isActive,
        }"
      >
        {{
          $t('index.motions.totalMotions') +
          countUserMotions +
          (countUserMotions == 1
            ? $t('index.motions.totalMotions2')
            : countUserMotions > 1 && countUserMotions < 5
            ? $t('index.motions.totalMotions3')
            : $t('index.motions.totalMotions4'))
        }}
      </p>
      <!--Máte celkem
             tezi
             teze
             tezí-->
    </q-card-section>

    <!--Buttons-->
    <q-card-actions class="q-px-lg justify-center">
      <div class="q-pa-sm q-gutter-sm">
        <q-btn
          :to="{ name: 'motion', params: { user: 0 } }"
          elevated
          flat
          size="lg"
          color="orange-14"
          class="text-white q-ma-md"
          :label="$t('index.motions.button.redirect')"
          icon-right="arrow_forward"
        />
        <!--Přejít-->

        <q-btn
          @click="onMotionAddClick()"
          fab
          elevated
          size="lg"
          color="orange-13"
          class="text-white q-ml-xl q-mb-md"
          icon="add"
        />
      </div>
    </q-card-actions>
  </q-card>

  <!--The card for quick navigation to Autosaved ballot for logged in users-->
  <q-card
    v-if="authStore.user !== null && ballotStore.ballot != null"
    class="q-ma-lg"
    style="min-width: 340px"
    :class="{ 'shadow-24': !$q.dark.isActive }"
  >
    <!--info button-->
    <q-btn
      flat
      round
      :text-color="!$q.dark.isActive ? 'grey-6' : 'grey-8'"
      icon="info"
    >
      <q-tooltip>
        {{ $t('index.autosave.tooltip') }}
      </q-tooltip>
      <!--Otevřete nebo odstraňte váš poslední rozpracovaný ballot.-->
    </q-btn>

    <!--The Icon-->
    <q-card-section class="row justify-center">
      <div class="col-auto">
        <q-avatar
          :color="!$q.dark.isActive ? 'lime-3' : 'lime-14'"
          :text-color="!$q.dark.isActive ? 'lime-14' : 'lime-1'"
          icon="edit_document"
          size="50px"
          font-size="30px"
        />
      </div>
    </q-card-section>

    <!--Headings-->
    <q-card-section>
      <h3
        class="text-center text-weight-bold q-my-xs"
        :class="{
          'text-dark': !$q.dark.isActive,
        }"
      >
        {{ $t('index.autosave.title') }}
      </h3>
      <!--Pokračovat-->

      <p
        class="text-center text-subtitle2 q-my-xs"
        :class="{
          'text-dark': !$q.dark.isActive,
        }"
      >
        {{ motionName() }}
      </p>
      <p
        class="text-center text-caption q-my-xs"
        :class="{
          'text-dark': !$q.dark.isActive,
        }"
      >
        {{
          ballotStore.ballot.Ballot.tournament?.name +
          ' - ' +
          new Date(ballotStore.ballot.Ballot?.date).toLocaleDateString()
        }}
      </p>
    </q-card-section>

    <!--Buttons-->
    <q-card-actions class="q-px-lg justify-center">
      <div class="q-pa-sm q-gutter-sm">
        <q-btn
          @click="removeSavedBallot()"
          elevated
          flat
          size="lg"
          color="negative"
          class="q-ma-md"
          :label="$t('index.autosave.button.delete')"
          icon="delete"
        />
        <!--Zahodit-->

        <q-btn
          @click="onEditClick()"
          fab
          elevated
          size="lg"
          color="lime-14"
          class="text-white q-ml-xl q-mb-md"
          icon="edit"
        />
      </div>
    </q-card-actions>
  </q-card>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { useAuthStore } from 'src/stores/AuthStore';
import { useBallotStore } from 'src/stores/BallotStore';
import { mapStores } from 'pinia';
import { BallotData, Speaker, Motion } from 'components/models';

export default defineComponent({
  name: 'IndexDashBoard',

  mounted() {
    if (this.authStore.user !== null) {
      if (this.ballotStore.ballots.length == 0) this.loadBallots();
      if (this.ballotStore.motions.length == 0) this.loadMotions();
    }
  },

  methods: {
    //function that opens form of autosaved ballot
    onEditClick() {
      this.$router.push({
        path: '/ballot/edit/' + this.ballotStore.ballot.Ballot.id,
      });
    },
    //function that shows dialog for filling the motion name after clicking the add button
    onMotionAddClick() {
      this.$q
        .dialog({
          title: this.$t('motion.add.title'), //Přidat novou tezi
          message: this.$t('motion.add.message'), //Zadejte tezi, kterou si přejete přidat:
          prompt: {
            model: '',
            type: 'text',
          },
          persistent: false,
          ok: {
            flat: true,
            color: 'light-blue-13',
            label: this.$t('motion.add.button.ok'), //Uložit
          },
          cancel: {
            flat: true,
            color: 'orange-13',
            label: this.$t('motion.add.button.cancel'), //Zrušit
          },
        })
        .onOk(async (data) => {
          if (
            this.authStore.user != null &&
            this.authStore.user.person == null
          ) {
            //if user isn't logged in or has no personal info they can't add a motion
            this.$q.dialog({
              title: this.$t('motion.add.warning.title'), //Upozornění
              message: this.$t('motion.add.warning.message'), //Pro přidání teze musíte mít v profilu vyplněno alespoň jméno a příjmení
              ok: {
                flat: true,
                color: 'light-blue-13',
              },
            });
          } else {
            //The balloter Store is getting called here
            if (!(await this.ballotStore.createMotion(data))) {
              this.$q.notify({
                icon: 'warning',
                color: 'negative',
                message: this.$t('motion.add.failure'), //Při ukládání teze došlo k chybě
              });
            } else {
              this.$q.notify({
                icon: 'done',
                color: 'positive',
                message: this.$t('motion.add.success'), //Uloženo
              });
              this.$router.push({ name: 'motion', params: { user: 0 } });
            }
          }
        });
    },

    //function that allows starting creation of the ballot
    onBallotAddClick() {
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

    //function for loading the list of motions
    async loadMotions() {
      if (!(await this.ballotStore.loadMotions())) {
        this.$q.notify({
          icon: 'warning',
          color: 'negative',
          message: this.$t('motion.load.failure'), //Při načítání tezí došlo k chybě
        });
      }
    },

    //function that deletes the autosaved ballot from the store and storage
    removeSavedBallot(): void {
      localStorage.removeItem('ballot');
      this.ballotStore.savedBallot = null;
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
  },

  computed: {
    ...mapStores(useAuthStore, useBallotStore),

    //function that counts how many ballots is the user involved in
    countUserBallots(): number {
      var result = 0;
      this.ballotStore.ballots.forEach((ballot: BallotData) => {
        ballot.People.forEach((speaker: Speaker) => {
          if (
            this.authStore.user?.person.id === speaker.person_id.id &&
            speaker.author == 1
          ) {
            result++;
          }
        });
      });
      return result;
    },

    //function that counts how many motions is the user involved in
    countUserMotions(): number {
      var result = 0;
      this.ballotStore.motions.forEach((motion: Motion) => {
        if (this.authStore.user?.person.id === motion.added_by.id) result++;
      });
      return result;
    },
  },
});
</script>
