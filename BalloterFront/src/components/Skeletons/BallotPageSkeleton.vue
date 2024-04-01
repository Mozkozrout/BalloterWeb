<template>
  <div id="Ballot Page Skeleton">
    <q-page
      class="row justify-center items-center"
      style="background: linear-gradient(#f3f3f5, #b4b4b4)"
    >
      <div :class="{ 'q-pa-lg': !$q.platform.is.mobile }">
        <div class="row">
          <q-card
            square
            :style="{
              minWidth: mobileW + 'px',
              minHeight: mobileH + 'px',
            }"
          >
            <!--Header-->
            <q-card-section>
              <div
                :class="{
                  'row justify-center': $q.screen.width >= 1150,
                  'row justify-start': $q.screen.width <= 1150,
                }"
              >
                <!--Title -->
                <q-skeleton type="rect" width="100px" height="50px" />

                <!--Search Bar-->
                <q-skeleton
                  type="rect"
                  width="200px"
                  height="50px"
                  class="q-ml-md absolute"
                  style="bottom: 0; right: 18px; transform: translateY(-15px)"
                />
              </div>
            </q-card-section>

            <!--Nav Tabs-->
            <div class="row justify-center">
              <q-skeleton type="text" width="100px" class="q-ma-sm q-py-sm" />
              <q-skeleton type="text" width="100px" class="q-ma-sm q-py-sm" />
              <q-skeleton type="text" width="100px" class="q-ma-sm q-py-sm" />
              <q-skeleton
                type="text"
                width="100px"
                class="q-ma-sm q-py-sm"
                v-if="!$q.platform.is.mobile"
              />
            </div>

            <q-card-section>
              <q-infinite-scroll
                :offset="250"
                style="max-width: 1000px; overflow: auto"
                :style="{
                  height: $q.screen.height / 2.2 + 'px',
                }"
                class="q-pa-md"
              >
                <q-list separator bordered class="rounded-borders">
                  <q-skeleton type="QInput" class="q-ma-sm" />
                  <q-skeleton type="QInput" class="q-ma-sm" />
                  <q-skeleton type="QInput" class="q-ma-sm" />
                  <q-skeleton type="QInput" class="q-ma-sm" />
                  <q-skeleton type="QInput" class="q-ma-sm" />
                </q-list>
              </q-infinite-scroll>
            </q-card-section>

            <q-card-actions class="row justify-center">
              <!--My ballots toggle button-->
              <q-skeleton
                type="QToggle"
                v-if="!$q.platform.is.mobile"
                width="200px"
                class="q-ma-md absolute"
                style="bottom: 0; left: 18px; transform: translateY(-5px)"
              />
              <q-skeleton
                type="QToggle"
                v-else
                class="q-ma-md absolute"
                style="bottom: 0; left: 18px; transform: translateY(-5px)"
              />

              <!--Saved ballot card-->
              <q-card
                flat
                bordered
                class="q-pa-xs"
                v-if="!$q.platform.is.mobile"
              >
                <q-card-section horizontal>
                  <q-skeleton
                    type="rect"
                    width="50px"
                    height="50px"
                    class="q-ma-sm"
                  />
                  <div class="col">
                    <div class="row justify-center">
                      <q-skeleton
                        type="text"
                        width="200px"
                        height="25px"
                        class="q-mt-sm"
                      />
                    </div>
                    <div class="row justify-center">
                      <q-skeleton type="text" width="200px" height="25px" />
                    </div>
                  </div>

                  <q-card-actions horizontal class="justify-around">
                    <q-skeleton type="QBtn" class="q-ma-sm" />
                    <q-skeleton type="QBtn" class="q-ma-sm" />
                  </q-card-actions>
                </q-card-section>
              </q-card>

              <!--Saved ballot card-->
              <q-card
                flat
                bordered
                class="q-pa-xs absolute"
                style="bottom: 20px"
                v-else
              >
                <q-card-section horizontal>
                  <q-skeleton
                    type="rect"
                    width="30px"
                    height="30px"
                    class="q-ma-sm"
                  />
                  <q-skeleton
                    type="rect"
                    width="40px"
                    height="40px"
                    class="q-ma-sm"
                  />
                  <q-skeleton
                    type="rect"
                    width="30px"
                    height="30px"
                    class="q-ma-sm"
                  />
                </q-card-section>
              </q-card>

              <!--Motion add button-->
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
  name: 'BallotPageSkeleton',
  computed: {
    //function that returns screen width when on mobile
    mobileW() {
      if (this.$q.platform.is.mobile) {
        return this.$q.screen.width;
      }
      return this.$q.screen.width / 1.9;
    },
    //function that returns screen height when on mobile
    mobileH() {
      if (this.$q.platform.is.mobile) {
        return this.$q.screen.height - 50;
      }
      return 350;
    },
  },
});
</script>
