<template>
  <div id="auth Skeleton">
    <q-page
      class="row justify-center items-center"
      style="background: linear-gradient(#f3f3f5, #b4b4b4)"
    >
      <div :class="{ 'q-pa-lg': !$q.platform.is.mobile }">
        <div class="row">
          <q-card
            square
            :style="{ width: mobileW + 'px', height: mobileH + 'px' }"
          >
            <!--Name of the form - either Login or Register -->
            <q-card-section>
              <div class="row justify-center">
                <q-skeleton type="rect" width="100px" class="q-ma-sm q-py-sm" />
              </div>
            </q-card-section>

            <q-card-section>
              <!--Button for switching between register and login form-->
              <q-skeleton
                type="circle"
                size="60px"
                class="absolute"
                style="bottom: 0; right: 12px; transform: translateY(-200px)"
              />

              <!--Email input field-->
              <q-form class="q-px-sm q-pt-xl">
                <q-skeleton type="QInput" class="q-ma-sm" />

                <br />

                <!--Password input field-->
                <q-skeleton type="QInput" class="q-ma-sm" />
              </q-form>
            </q-card-section>
            <br />
            <q-card-actions class="q-px-lg">
              <!--Submit Button-->
              <q-skeleton type="QBtn" height="60px" class="full-width" />
            </q-card-actions>

            <!--Forgot password prompt-->
            <q-card-section class="text-center q-pa-sm">
              <div class="row justify-center">
                <q-skeleton type="text" width="200px" class="q-ma-sm" />
              </div>
            </q-card-section>
          </q-card>
        </div>
      </div>
    </q-page>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
export default defineComponent({
  name: 'AuthPageSkeleton',
  computed: {
    //function that returns screen width when on mobile
    mobileW() {
      if (this.$q.platform.is.mobile) {
        return this.$q.screen.width;
      }
      return 340;
    },
    //function that returns screen height when on mobile
    mobileH() {
      if (this.$q.platform.is.mobile) {
        return this.$q.screen.height - 50;
      }
      return 500;
    },
  },
});
</script>
