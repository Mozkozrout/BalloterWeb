<template>
  <div id="Profile Page Skeleton">
    <q-page
      class="row justify-center items-center"
      style="background: linear-gradient(#f3f3f5, #b4b4b4)"
    >
      <div :class="{ 'q-pa-lg': !$q.platform.is.mobile }">
        <div class="row">
          <q-card
            square
            :style="{ minWidth: mobileW + 'px', minHeight: mobileH + 'px' }"
          >
            <!--Header -->
            <q-card-section style="height: 140px">
              <div class="row justify-center">
                <q-skeleton type="rect" width="250px" />
              </div>
              <!--Icon-->
              <br />
              <div class="profile-photo row justify-center">
                <div class="default-user-image">
                  <q-skeleton type="QAvatar" size="120px" />
                </div>
              </div>
            </q-card-section>

            <q-card-section>
              <!--Text Fields-->
              <br />
              <div class="q-px-sm q-pt-xl">
                <div class="row justify-center">
                  <q-skeleton type="rect" width="200px" />
                </div>

                <!--Left-->
                <q-separator spaced inset />
                <div class="row">
                  <div
                    class="col-auto q-px-md width"
                    style="overflow: auto; width: 300px"
                  >
                    <q-skeleton type="rect" width="200px" class="q-my-md" />

                    <div class="row">
                      <q-skeleton type="QChip" width="160px" class="q-my-xs" />
                    </div>

                    <div class="row">
                      <q-skeleton type="QChip" width="160px" class="q-my-xs" />
                    </div>

                    <div class="row">
                      <q-skeleton type="QChip" width="160px" class="q-my-xs" />
                    </div>
                  </div>

                  <!--Right-->
                  <div
                    class="col-auto q-px-md width"
                    style="overflow: auto; width: 300px"
                  >
                    <q-skeleton type="rect" width="200px" class="q-my-md" />

                    <div class="row">
                      <q-skeleton type="QChip" width="160px" class="q-my-xs" />
                    </div>

                    <div class="row">
                      <q-skeleton type="QChip" width="160px" class="q-my-xs" />
                    </div>

                    <div class="row">
                      <q-skeleton type="QChip" width="160px" class="q-my-xs" />
                    </div>
                  </div>
                </div>

                <!--Comment-->
                <div class="col-auto q-px-md self-end" style="overflow: auto">
                  <q-separator spaced inset />
                  <p class="q-py-md text-center">
                    <q-skeleton type="text" />
                    <q-skeleton type="text" />
                    <q-skeleton type="text" />
                  </p>
                </div>
              </div>
            </q-card-section>

            <q-card-actions class="q-py-lg">
              <!--Profile Edit button-->
              <q-skeleton
                type="circle"
                size="60px"
                class="absolute"
                style="bottom: 0; right: 18px; transform: translateY(-18px)"
              />
            </q-card-actions>
          </q-card>
        </div>
      </div>
    </q-page>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
export default defineComponent({
  name: 'ProfilePageSkeleton',
  computed: {
    //function that returns screen width when on mobile
    mobileW() {
      if (this.$q.platform.is.mobile) {
        return this.$q.screen.width;
      }
      return 0;
    },
    //function that returns screen height when on mobile
    mobileH() {
      if (this.$q.platform.is.mobile) {
        return this.$q.screen.height - 50;
      }
      return 0;
    },
  },
});
</script>
