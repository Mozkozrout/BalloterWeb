<template>
  <MotionPageSkeleton v-if="authStore.isLoading" />
  <div id="Motion Page" v-if="!authStore.isLoading">
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
            style="min-height: 250px"
            :style="{
              minWidth: mobileW + 'px',
              minHeight: mobileH * 1.5 + 'px',
            }"
          >
            <!--Header -->
            <q-card-section
              class="bg-dark"
              :class="{ 'bg-black': $q.dark.isActive }"
            >
              <div
                :class="{
                  'row justify-center': $q.screen.width >= 650,
                  'row justify-start': $q.screen.width <= 650,
                }"
              >
                <!--Title -->
                <h4 class="text-h5 text-white text-center q-my-xs">
                  {{ $t('motion.title') }}
                </h4>
                <!--Teze -->

                <!--Search Bar - Should do something-->
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

            <q-card-section>
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
                  <!--Placeholder text when there are no motions available-->
                  <q-item
                    v-if="
                      !ballotStore.isLoading && ballotStore.motions.length == 0
                    "
                  >
                    <q-item-section class="text-subtitle1">
                      {{ $t('motion.empty') }} </q-item-section
                    ><!--Je to tu nějaké prázdné, což takhle přidat nějaké teze ?-->
                  </q-item>

                  <!--List of motions with a cycle fed the result of the search function (list of filtered motions) as a prop-->
                  <MotionList v-else :motionList="search()" />
                </q-list>
                <!--Spinner dots when motions are loading-->
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
            </q-card-section>

            <q-card-actions>
              <!--My motions toggle button-->
              <q-toggle
                v-if="
                  authStore.user.person != null &&
                  (authStore.user.role.id == '1' ||
                    authStore.user.role.id == '2')
                "
                class="q-pa-lg"
                v-model="userMotion"
                checked-icon="check"
                unchecked-icon="clear"
                :label="$t('motion.button.toggle')"
                left-label
                color="light-blue-13"
                @click="userMotions()"
              /><!--Moje teze-->

              <!--Motion add button-->
              <q-btn
                v-if="
                  authStore.user.person != null &&
                  (authStore.user.role.id == '1' ||
                    authStore.user.role.id == '2')
                "
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
import { Motion } from 'components/models';
import MotionList from 'components/MotionList.vue';
import MotionPageSkeleton from 'components/skeletons/MotionPageSkeleton.vue';

export default {
  name: 'MotionPage',

  components: {
    MotionList,
    MotionPageSkeleton,
  },

  props: ['user'],

  data: function () {
    return {
      searchInput: '',
      userMotion: false,
    };
  },

  mounted() {
    //Checking if the user is logged in
    if (this.authStore.user === null) this.$router.push({ path: '/auth/0' });

    //loading the motions
    if (this.ballotStore.motions.length == 0) this.loadMotions();
    if (this.user == 1) this.userMotion = !this.userMotion;
  },

  methods: {
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
    //Function for loading only the Motions user created (called by a toggle button)
    async userMotions() {
      await this.loadMotions();
      var newList = [] as Motion[];
      if (!this.userMotion) {
        this.ballotStore.motions.forEach((motion: Motion) => {
          newList.push(motion);
        });
      } else {
        this.ballotStore.motions.forEach((motion: Motion) => {
          if (this.authStore.user?.person.id === motion.added_by.id)
            newList.push(motion);
        });
      }
      this.ballotStore.motionList = newList;
    },

    //function that shows dialog for filling the motion name after clicking the add button
    onAddClick() {
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
            this.authStore.user.person == null &&
            (this.authStore.user.role.id == '1' ||
              this.authStore.user.role.id == '2')
          ) {
            //if user isn't logged in or has no personal info they can't add a motion
            this.$q.dialog({
              title: this.$t('motion.add.warning.title'), //Upozornění
              message: this.$t('motion.add.warning.message'), //Pro přidání teze musíte mít v profilu vyplněno alespoň jméno a příjmení a musíte mít dostatečná oprávnění
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
            }
          }
        });
    },

    search() {
      return this.ballotStore.motions.filter((motion) =>
        motion.name.toLowerCase().includes(this.searchInput.toLowerCase())
      );
    },
  },

  computed: {
    ...mapStores(useAuthStore, useBallotStore),

    //function that returns screen width when on mobile
    mobileW() {
      if (this.$q.platform.is.mobile) {
        return this.$q.screen.width;
      }
      return this.$q.screen.width / 2;
    },
    //function that returns screen height when on mobile
    mobileH() {
      if (this.$q.platform.is.mobile) {
        return (this.$q.screen.height - 50) / 1.5;
      }
      return this.$q.screen.height / 2.2;
    },
  },
};
</script>
