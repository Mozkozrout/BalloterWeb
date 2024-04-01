<template>
  <div id="Motion Page Skeleton">
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
            <!--Header - This needs better responsive behaviour, where the title would move to the right -->
            <q-card-section>
              <div
                :class="{
                  'row justify-center': $q.screen.width >= 650,
                  'row justify-start': $q.screen.width <= 650,
                }"
              >
                <!--Title -->
                <div class="row justify-center">
                  <q-skeleton type="rect" width="100px" height="50px" />
                </div>

                <!--Search Bar - Should do something-->
                <q-skeleton
                  type="rect"
                  width="200px"
                  height="50px"
                  class="q-ml-md absolute"
                  style="bottom: 0; right: 18px; transform: translateY(-15px)"
                />
              </div>
            </q-card-section>

            <q-card-section>
              <!--Infinite Scroll yeah i know i am not really using it like infinite scroll - could be utilised if i was loading motions in more efficient way - per parts-->
              <q-infinite-scroll
                :offset="250"
                style="max-width: 1000px; overflow: auto"
                :style="{
                  height: $q.screen.height / 2.2 + 'px',
                }"
                class="q-pa-md"
              >
                <q-list separator bordered class="rounded-borders">
                  <!--Placeholder text when there are no motions available-->
                  <q-skeleton type="QInput" class="q-ma-sm" />
                  <q-skeleton type="QInput" class="q-ma-sm" />
                  <q-skeleton type="QInput" class="q-ma-sm" />
                  <q-skeleton type="QInput" class="q-ma-sm" />
                  <q-skeleton type="QInput" class="q-ma-sm" />
                </q-list>
              </q-infinite-scroll>
            </q-card-section>

            <q-card-actions>
              <!--My motions toggle button-->
              <q-skeleton type="QToggle" width="100px" class="q-ma-md" />

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
  name: 'MotionPageSkeleton',
  computed: {
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
        return this.$q.screen.height - 50;
      }
      return 250;
    },
  },
});
</script>
