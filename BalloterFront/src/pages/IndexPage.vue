<template>
  <IndexPageSkeleton v-if="authStore.loading" />
  <q-page
    v-if="!authStore.loading"
    class="row justify-center items-center"
    style="background: linear-gradient(#ffffff, #bbbbbb)"
    :class="{ 'bg-grey-9': $q.dark.isActive }"
  >
    <!--ADK logo in the middle of the page-->
    <div class="row full-width text-center">
      <img
        v-if="!$q.dark.isActive"
        class="q-mx-auto"
        alt="ADK Logo"
        src="../assets/logo_text.png"
        style="max-width: 100%; height: auto"
      />
      <!--dark variant of logo-->
      <img
        v-if="$q.dark.isActive"
        class="q-mx-auto"
        alt="ADK Logo"
        src="../assets/logo_text_white.png"
        style="max-width: 100%; height: auto"
      />
    </div>

    <!--DashBoard Quick Navigation Cards-->
    <div class="column q-pa-xl self-center">
      <div class="row">
        <IndexDashBoard />
      </div>
    </div>
  </q-page>
</template>

<script lang="ts">
import { useAuthStore } from 'src/stores/AuthStore';
import { mapStores } from 'pinia';
import IndexDashBoard from 'components/IndexDashBoard.vue';
import IndexPageSkeleton from 'src/components/skeletons/IndexPageSkeleton.vue';

export default {
  name: 'IndexPage',

  components: {
    IndexDashBoard,
    IndexPageSkeleton,
  },

  computed: {
    ...mapStores(useAuthStore),
  },
};
</script>
