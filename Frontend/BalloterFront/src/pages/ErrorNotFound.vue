<template>
  <div
    class="fullscreen bg-light-blue-13 text-white text-center q-pa-md flex flex-center"
  >
    <div>
      <div style="font-size: 30vh">404</div>

      <div class="text-h2" style="opacity: 0.4">
        {{ $t('404.message') }}
      </div>
      <!--Hupsík dupsík. Nic tu není...-->

      <q-btn
        class="q-mt-xl"
        color="white"
        text-color="light-blue-13"
        unelevated
        to="/"
        :label="$t('404.button')"
        no-caps
      /><!--Domů-->
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'ErrorNotFound',
});
</script>
