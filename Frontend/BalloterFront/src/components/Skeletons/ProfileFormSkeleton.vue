<template>
  <div id="Profile Form Skeleton">
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
            <q-card-section>
              <div class="row justify-center">
                <q-skeleton type="rect" width="250px" />
              </div>
            </q-card-section>

            <q-card-section>
              <q-skeleton type="rect" width="300px" />
              <br />
              <!--Text Fields-->
              <q-form class="q-px-sm">
                <div class="row">
                  <!--Name-->
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

                  <!--Surname-->
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
                  <!--Email-->
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

                  <!--Preferred Locale-->
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
                <q-skeleton type="rect" width="250px" class="q-my-lg" />

                <div class="row">
                  <!--Personal info - First Column-->
                  <div class="col-grow self-start">
                    <!--Birthdate - This could also be set to some sort of a minimal and maximal date as well as a default-->
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

                    <!--Institution-->
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

                    <!--Note-->
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
                  </div>

                  <!--Address - Second Column-->
                  <div class="col-grow self-start">
                    <!--Street-->
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

                    <!--House Number-->
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

                    <!--City-->
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

                    <!--State-->
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

                    <!--Zip-->
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
              <q-skeleton
                type="circle"
                size="60px"
                class="absolute"
                style="bottom: 0; right: 18px; transform: translateY(-15px)"
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
  name: 'ProfileFormSkeleton',
  computed: {
    //function that returns screen width when on mobile
    mobileW() {
      if (this.$q.platform.is.mobile) {
        return this.$q.screen.width;
      }
      return 620;
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
