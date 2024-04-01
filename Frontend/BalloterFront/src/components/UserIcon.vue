<!--Component for generating custom user avatar based on their name-->
<template>
  <!--Icon that takes uses letter of the person name and random colour based on their surname-->
  <q-avatar
    v-if="authStore.user != null && authStore.user.person != null"
    :style="
      'background-color: ' + stringToHslColor(authStore.user.person.surname)
    "
  >
    <img
      src="https://cdn.quasar.dev/img/avatar.png"
      v-if="!true"
      alt="Avatar"
    />
    <template v-else-if="authStore.user != null"
      >{{ authStore.user.person.name.substring(0, 1).toUpperCase() }}
    </template>
  </q-avatar>

  <!--If the user hasn't a person table attached the app shows their username-->
  <!--Icon that takes uses letter of the person name and random colour based on their surname-->
  <q-avatar
    v-else-if="authStore.user != null"
    :style="'background-color: ' + stringToHslColor(authStore.user.username)"
  >
    <img
      src="https://cdn.quasar.dev/img/avatar.png"
      v-if="!true"
      alt="Avatar"
    />
    <template v-else-if="authStore.user != null"
      >{{ authStore.user.username.substring(0, 1).toUpperCase() }}
    </template>
  </q-avatar>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { useAuthStore } from 'src/stores/AuthStore';
import { mapStores } from 'pinia';

export default defineComponent({
  name: 'UserIcon',
  computed: {
    ...mapStores(useAuthStore),
  },
  methods: {
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
  },
});
</script>
