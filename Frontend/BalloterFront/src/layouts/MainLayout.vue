<template>
  <q-layout view="hHh lpR fFf">
    <q-header
      :class="{ 'bg-black': $q.dark.isActive }"
      class="bg-dark"
      :elevated="!$q.platform.is.mobile && !$q.dark.isActive"
    >
      <!--
      Modra = light-blue-13
      Zelena = lime-6
      Oranzova = orange-13
    -->
      <q-toolbar>
        <!--Button for the Menu on the left-->
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="toggleLeftDrawer"
        />

        <q-toolbar-title>
          <span @mouseover="shakeLogo(true)" @mouseleave="shakeLogo(false)">
            <q-avatar
              size="35px"
              ref="navbarIcon"
              :class="{ bounce: bounce, jello: jello }"
            >
              <img src="../assets/logo.svg" alt="ADK Logo" />
            </q-avatar>
            <!--Main Title and also link home-->
            <router-link
              style="text-decoration: none; color: inherit; padding-left: 10px"
              :to="{ path: '/' }"
            >
              Balloter
            </router-link>
          </span>
        </q-toolbar-title>

        <!--Button for switching languages-->
        <LanguageSwitcher />

        <!--Button for user menu on the right side of the navbar-->
        <UserMenu v-if="!authStore.loading" />
      </q-toolbar>

      <!--Loading bar under the navbar-->
      <q-linear-progress
        v-if="authStore.loading || ballotStore.isLoading"
        indeterminate
        color="lime-6"
        class="q-mt-sm"
      />
    </q-header>

    <!--The Nav Menu on the left side of the navbar-->
    <q-drawer v-model="leftDrawerOpen" overlay elevated>
      <q-list>
        <q-item-label header> {{ $t('menu.mainMenu.title') }} </q-item-label>
        <!--Hlavní Menu-->
        <MenuLink
          v-for="link in menuLinks"
          :key="link.title"
          v-bind="link"
          @click="checkAutoSave(link.title)"
        />
      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import MenuLink from 'components/MenuLink.vue';
import UserMenu from 'components/UserMenu.vue';
import { useAuthStore } from 'src/stores/AuthStore';
import { useBallotStore } from 'src/stores/BallotStore';
import { mapStores } from 'pinia';
import LanguageSwitcher from 'src/components/LanguageSwitcher.vue';

export default defineComponent({
  name: 'MainLayout',

  components: {
    MenuLink,
    UserMenu,
    LanguageSwitcher,
  },

  data() {
    return {
      leftDrawerOpen: false,
      menuLinks: [
        {
          title: this.$t('menu.mainMenu.profile'), //Profil
          icon: 'account_circle',
          link: '/profile',
        },
        {
          title: this.$t('menu.mainMenu.ballots'), //Balloty
          icon: 'ballot',
          link: '/ballot/0',
        },
        {
          title: this.$t('menu.mainMenu.newBallot'), //Nový Ballot
          icon: 'how_to_vote',
          link: '/ballot/edit/0',
        },
        {
          title: this.$t('menu.mainMenu.motions'), //Teze
          icon: 'history_edu',
          link: '/motion/0',
        },
        {
          title: this.$t('menu.mainMenu.greybox'), //GreyBox
          icon: 'emoji_events',
          link: 'https://greybox.debatovani.cz/',
          external: true,
        },
      ],
      bounce: false,
      jello: false,
    };
  },

  mounted() {
    this.addAutoSaveMenuItem();
  },

  methods: {
    //function that adds the abbility to open autosaved ballot into the manu in case user has a ballot saved
    addAutoSaveMenuItem() {
      if (this.ballotStore.ballot != null) {
        this.menuLinks.splice(2, 0, {
          title: this.$t('menu.mainMenu.autosave'), //Otevřít Rozpracovaný Ballot
          icon: 'file_open',
          link: '/ballot/edit/' + this.ballotStore.ballot.Ballot.id,
        });
      }
    },
    //function that deletes ballot autosave if user opens a new one
    checkAutoSave(title: string): void {
      if (
        title === this.$t('menu.mainMenu.newBallot') && //Nový Ballot
        this.ballotStore.ballot != null
      ) {
        this.removeSavedBallot();
      }
    },

    //function that deletes the autosaved ballot from the store and storage
    removeSavedBallot(): void {
      this.menuLinks.splice(2, 1);
      localStorage.removeItem('ballot');
      this.ballotStore.savedBallot = null;
    },
    //function for opening and closing the menu
    toggleLeftDrawer() {
      this.leftDrawerOpen = !this.leftDrawerOpen;
    },
    //function for css animation on logo
    shakeLogo(mouseOn: boolean) {
      if (mouseOn) {
        this.bounce = true;
        this.jello = false;
      } else {
        this.bounce = false;
        this.jello = true;
      }
    },
  },
  computed: {
    ...mapStores(useAuthStore, useBallotStore),
    //function that tracks changes in language
    langChange() {
      return this.$i18n.locale;
    },
    //function that tracks changes in language
    autosaveChange() {
      return this.ballotStore.ballot;
    },
  },

  watch: {
    //function that updates form each time the language changes
    langChange() {
      this.menuLinks.forEach((item) => {
        //yeah checking the items based on icon isn't the most elegant solution
        switch (item.icon) {
          case 'account_circle':
            item.title = this.$t('menu.mainMenu.profile');
            break;
          case 'ballot':
            item.title = this.$t('menu.mainMenu.ballots');
            break;
          case 'how_to_vote':
            item.title = this.$t('menu.mainMenu.newBallot');
            break;
          case 'history_edu':
            item.title = this.$t('menu.mainMenu.motions');
            break;
          case 'emoji_events':
            item.title = this.$t('menu.mainMenu.greybox');
            break;
          case 'file_open':
            item.title = this.$t('menu.mainMenu.autosave');
            break;
        }
      });
    },
    //function that updates Main Menu each time the autosaved ballot changes
    autosaveChange(autosave) {
      if (autosave == null) {
        if (this.menuLinks[2].icon == 'file_open') this.menuLinks.splice(2, 1);
      } else {
        if (this.menuLinks[2].icon != 'file_open') this.addAutoSaveMenuItem();
      }
    },
  },
});
</script>
