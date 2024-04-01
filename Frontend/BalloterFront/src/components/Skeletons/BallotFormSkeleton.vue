<template>
  <div id="Ballot Form Skeleton">
    <q-page
      class="row justify-center items-center"
      style="background: linear-gradient(#f3f3f5, #b4b4b4)"
    >
      <div :class="{ 'q-pa-lg': !$q.platform.is.mobile }">
        <div class="row">
          <q-card
            square
            style="min-width: 816px; overflow: auto"
            :style="{
              maxHeight: mobileH + 'px',
              minWidth: mobileW + 'px',
            }"
          >
            <!--Header -->
            <q-card-section>
              <div class="row justify-center">
                <q-skeleton type="rect" width="200px" class="q-ma-sm q-py-sm" />
              </div>
            </q-card-section>

            <q-card-section>
              <!--Ballot info-->
              <q-skeleton type="rect" width="250px" class="q-ma-sm q-py-sm" />
              <q-form class="q-px-sm">
                <div class="row">
                  <!--Tournament-->
                  <div class="col-grow">
                    <q-skeleton
                      type="QInput"
                      class="q-ma-sm"
                      v-if="!$q.platform.is.mobile"
                    />
                    <q-skeleton
                      type="QInput"
                      width="350px"
                      class="q-ma-sm"
                      v-else
                    />
                  </div>

                  <!--Motion-->
                  <div class="col-grow">
                    <q-skeleton
                      type="QInput"
                      class="q-ma-sm"
                      v-if="!$q.platform.is.mobile"
                    />
                    <q-skeleton
                      type="QInput"
                      width="350px"
                      class="q-ma-sm"
                      v-else
                    />
                  </div>
                </div>

                <div class="row">
                  <!--Date-->
                  <div class="col-grow">
                    <q-skeleton
                      type="QInput"
                      class="q-ma-sm"
                      v-if="!$q.platform.is.mobile"
                    />
                    <q-skeleton
                      type="QInput"
                      width="350px"
                      class="q-ma-sm"
                      v-else
                    />
                  </div>

                  <!--Place-->
                  <div class="col-grow">
                    <q-skeleton
                      type="QInput"
                      class="q-ma-sm"
                      v-if="!$q.platform.is.mobile"
                    />
                    <q-skeleton
                      type="QInput"
                      width="350px"
                      class="q-ma-sm"
                      v-else
                    />
                  </div>
                </div>

                <!--Adjudicator-->
                <div class="row">
                  <!--Adjudicator name-->
                  <div class="col-grow">
                    <q-skeleton
                      type="QInput"
                      class="q-ma-sm"
                      v-if="!$q.platform.is.mobile"
                    />
                    <q-skeleton
                      type="QInput"
                      width="350px"
                      class="q-ma-sm"
                      v-else
                    />
                  </div>

                  <!--Adjudicator surname-->
                  <div class="col-grow">
                    <q-skeleton
                      type="QInput"
                      class="q-ma-sm"
                      v-if="!$q.platform.is.mobile"
                    />
                    <q-skeleton
                      type="QInput"
                      width="350px"
                      class="q-ma-sm"
                      v-else
                    />
                  </div>
                </div>

                <div class="row">
                  <!--Team Aff.-->
                  <div class="col-grow">
                    <q-skeleton
                      type="QInput"
                      class="q-ma-sm"
                      v-if="!$q.platform.is.mobile"
                    />
                    <q-skeleton
                      type="QInput"
                      width="350px"
                      class="q-ma-sm"
                      v-else
                    />
                  </div>

                  <!--Team Neg.-->
                  <div class="col-grow">
                    <q-skeleton
                      type="QInput"
                      class="q-ma-sm"
                      v-if="!$q.platform.is.mobile"
                    />
                    <q-skeleton
                      type="QInput"
                      width="350px"
                      class="q-ma-sm"
                      v-else
                    />
                  </div>
                </div>

                <q-separator spaced inset />
                <q-skeleton type="rect" width="200px" class="q-ma-sm q-py-sm" />
                <!--Speakers-->

                <div class="row">
                  <div class="col-grow q-pa-sm">
                    <q-list bordered class="rounded-borders">
                      <q-skeleton type="QInput" class="q-ma-sm" />
                      <q-skeleton type="QInput" class="q-ma-sm" />
                      <q-skeleton type="QInput" class="q-ma-sm" />
                      <q-skeleton type="QInput" class="q-ma-sm" />
                      <q-skeleton type="QInput" class="q-ma-sm" />
                      <q-skeleton type="QInput" class="q-ma-sm" />
                    </q-list>
                  </div>
                </div>

                <q-separator spaced inset />
                <q-skeleton type="rect" width="150px" class="q-ma-sm q-py-sm" />
                <!--Decision Part-->

                <!--Decision-->
                <div class="row">
                  <div class="col-grow">
                    <q-skeleton
                      type="QInput"
                      class="q-ma-sm"
                      height="200px"
                      v-if="!$q.platform.is.mobile"
                    />
                    <q-skeleton
                      type="QInput"
                      width="350px"
                      height="200px"
                      class="q-ma-sm"
                      v-else
                    />
                  </div>
                </div>
                <div class="row">
                  <!--Adj. Winning Team-->
                  <div class="col-grow">
                    <q-skeleton
                      type="QInput"
                      class="q-ma-sm"
                      v-if="!$q.platform.is.mobile"
                    />
                    <q-skeleton
                      type="QInput"
                      width="350px"
                      class="q-ma-sm"
                      v-else
                    />
                  </div>

                  <!--Winning Team-->
                  <div class="col-grow">
                    <q-skeleton
                      type="QInput"
                      class="q-ma-sm"
                      v-if="!$q.platform.is.mobile"
                    />
                    <q-skeleton
                      type="QInput"
                      width="350px"
                      class="q-ma-sm"
                      v-else
                    />
                  </div>
                </div>

                <!--Adjudications-->
                <div class="row">
                  <div class="col-grow">
                    <q-skeleton
                      type="QInput"
                      class="q-ma-sm"
                      v-if="!$q.platform.is.mobile"
                    />
                    <q-skeleton
                      type="QInput"
                      width="350px"
                      class="q-ma-sm"
                      v-else
                    />
                  </div>
                </div>

                <!--Best Speaker-->
                <div class="row">
                  <div class="col-grow">
                    <q-skeleton
                      type="QInput"
                      class="q-ma-sm"
                      v-if="!$q.platform.is.mobile"
                    />
                    <q-skeleton
                      type="QInput"
                      width="350px"
                      class="q-ma-sm"
                      v-else
                    />
                  </div>
                </div>

                <!--Sum of Speaker Points-->
                <div class="row">
                  <!--Neg.-->
                  <div class="col-grow">
                    <q-skeleton
                      type="QInput"
                      class="q-ma-sm"
                      v-if="!$q.platform.is.mobile"
                    />
                    <q-skeleton
                      type="QInput"
                      width="350px"
                      class="q-ma-sm"
                      v-else
                    />
                  </div>
                  <!--Aff.-->
                  <div class="col-grow">
                    <q-skeleton
                      type="QInput"
                      class="q-ma-sm"
                      v-if="!$q.platform.is.mobile"
                    />
                    <q-skeleton
                      type="QInput"
                      width="350px"
                      class="q-ma-sm"
                      v-else
                    />
                  </div>
                </div>
              </q-form>
            </q-card-section>

            <q-separator spaced inset />

            <q-card-actions>
              <!--Submit Button-->
              <div class="col-auto q-pa-sm">
                <q-skeleton type="QBtn" height="60px" class="q-pa-sm" />
              </div>
              <!--Cancel Button-->
              <div class="col-auto q-pa-sm">
                <q-skeleton type="QBtn" height="60px" class="q-pa-sm" />
              </div>
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
  name: 'BallotFormSkeleton',
  computed: {
    //function that returns screen width when on mobile
    mobileW() {
      if (this.$q.platform.is.mobile) {
        return this.$q.screen.width;
      }
      return this.$q.screen.width / 2.3;
    },
    //function that returns screen height when on mobile
    mobileH() {
      if (this.$q.platform.is.mobile) {
        return this.$q.screen.height - 50;
      }
      return this.$q.screen.height / 1.2;
    },
  },
});
</script>
