<template>
  <!--Component for logged in user menu on the right of the navbar-->

  <!--The icon if the user isn't logged in-->
  <router-link
    v-if="authStore.user === null"
    style="text-decoration: none; color: inherit"
    :to="{ name: 'auth', params: { register: 0 } }"
  >
    <q-btn round xs flat>
      <q-icon name="account_circle" size="35px"></q-icon>
    </q-btn>
  </router-link>

  <!--Dropdown button when they are logged in-->
  <q-btn-dropdown stretch flat content-class="no-maxwidth-menu" v-else>
    <!--If the user has a person table attached the app shows their name-->
    <template v-slot:label v-if="authStore.user.person != null">
      <!--Icon that takes uses letter of the person name and random colour based on their surname-->

      <UserIcon />

      <span class="q-pl-sm" v-if="$q.screen.width > 650">
        {{ authStore.user.person.name }}
        {{ authStore.user.person.surname }}
      </span>
    </template>

    <!--If the user hasn't a person table attached the app shows their username-->
    <template v-slot:label v-else>
      <!--Icon that takes uses letter of the person name and random colour based on their surname-->

      <UserIcon />

      <span class="q-pl-sm" v-if="$q.screen.width > 650">
        {{ authStore.user.username }}
      </span>
    </template>

    <!--The list of items in the menu-->
    <q-list>
      <!--Darkmode toggle-->
      <q-item>
        <q-item-section avatar>
          <q-toggle
            checked-icon="dark_mode"
            unchecked-icon="light_mode"
            keep-color
            :color="$q.dark.isActive ? 'indigo' : 'cyan'"
            v-model="darkMode"
            @click="toggleDarkMode"
          />
        </q-item-section>
        <q-item-section>{{ $t('menu.userMenu.darkMode') }}</q-item-section>
        <!--Darkmód-->
      </q-item>
      <q-separator />

      <!--Profile Link-->
      <q-item clickable v-ripple :to="{ path: '/profile' }">
        <q-item-section avatar>
          <q-icon name="person" />
        </q-item-section>
        <q-item-section>{{ $t('menu.userMenu.profile') }}</q-item-section>
        <!--Profil-->
      </q-item>

      <!--My Motions link-->
      <q-item clickable v-ripple :to="{ path: '/motion/1' }">
        <q-item-section avatar>
          <q-icon name="history_edu" />
        </q-item-section>
        <q-item-section>{{ $t('menu.userMenu.myMotions') }}</q-item-section>
        <!--Moje Teze-->
      </q-item>

      <!--My Ballots link-->
      <q-item clickable v-ripple :to="{ path: '/ballot/1' }">
        <q-item-section avatar>
          <q-icon name="ballot" />
        </q-item-section>
        <q-item-section>{{ $t('menu.userMenu.myBallots') }}</q-item-section>
        <!--Moje Balloty-->
      </q-item>

      <q-separator />
      <!--Logout Link-->
      <q-item clickable @click="logout" v-ripple>
        <q-item-section avatar>
          <q-icon name="logout" />
        </q-item-section>
        <q-item-section>{{ $t('menu.userMenu.logout.label') }}</q-item-section>
        <!--Odhlásit-->
      </q-item>
    </q-list>
  </q-btn-dropdown>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { useAuthStore } from 'src/stores/AuthStore';
import { mapStores } from 'pinia';
import UserIcon from 'components/UserIcon.vue';

export default defineComponent({
  name: 'UserMenu',

  components: {
    UserIcon,
  },
  computed: {
    ...mapStores(useAuthStore),
  },
  methods: {
    //logout function
    async logout() {
      if (await this.authStore.logout()) {
        this.$router.push({ path: '/' });
        this.$forceUpdate();
        this.$q.notify({
          icon: 'done',
          color: 'positive',
          message: this.$t('menu.userMenu.logout.success'), //Odhlášeno
        });
      } else {
        this.$q.notify({
          icon: 'warning',
          color: 'negative',
          message: this.$t('menu.userMenu.logout.failure'), //Při odhlašování došlo k chybě
        });
      }
    },

    //function that changes text into a colour code
    stringToHslColor: function (str: string, s = 100) {
      let hash = 0;
      for (let i = 0; i < str.length; i++) {
        hash = str.charCodeAt(i) + ((hash << 5) - hash);
      }

      const h = hash % 360;
      const l = Math.abs((h * 100) % 40) + 20;

      return 'hsl(' + h + ', ' + s + '%, ' + l + '%)';
    },
    //global Darkmode toggle
    toggleDarkMode() {
      this.$q.dark.set(this.darkMode);
    },
  },
  data: function () {
    return {
      darkMode: false,
    };
  },
});
</script>
