<template>
  <q-page
    class="row justify-center items-center"
    style="background: linear-gradient(#ffffff, #bbbbbb)"
  >
    <div class="column q-pa-xl self-center">
      <div class="row" style="transform: translateY(160px)">
        <!--The card for quick navigation to Ballots for logged in users-->
        <q-card class="q-ma-lg" style="min-width: 340px; height: 370px">
          <!--info button-->
          <q-skeleton type="circle" class="q-ma-md" size="20px" />

          <!--The Icon-->
          <q-card-section class="row justify-center">
            <div class="col-auto">
              <q-skeleton type="QAvatar" size="50px" class="q-ma-md" />
            </div>
          </q-card-section>

          <!--Headings-->
          <q-card-section>
            <div class="row justify-center">
              <q-skeleton type="rect" class="q-py-md" width="200px" />
            </div>
            <div class="row justify-center">
              <q-skeleton type="text" class="q-ma-md" width="150px" />
            </div>
          </q-card-section>

          <!--Buttons-->
          <q-card-actions class="q-px-lg justify-center">
            <div class="q-pa-sm q-gutter-sm">
              <q-skeleton
                type="QBtn"
                class="absolute"
                height="50px"
                width="125px"
                style="bottom: 0; left: 50px; transform: translateY(-25px)"
              />
              <q-skeleton
                type="circle"
                size="60px"
                class="absolute"
                style="bottom: 0; right: 50px; transform: translateY(-25px)"
              />
            </div>
          </q-card-actions>
        </q-card>

        <!--The card for quick navigation to Motions for logged in users-->
        <q-card class="q-ma-lg" style="min-width: 340px; height: 370px">
          <!--info button-->
          <q-skeleton type="circle" class="q-ma-md" size="20px" />

          <!--The Icon-->
          <q-card-section class="row justify-center">
            <div class="col-auto">
              <q-skeleton type="QAvatar" size="50px" class="q-ma-md" />
            </div>
          </q-card-section>

          <!--Headings-->
          <q-card-section>
            <div class="row justify-center">
              <q-skeleton type="rect" class="q-py-md" width="200px" />
            </div>
            <div class="row justify-center">
              <q-skeleton type="text" class="q-ma-md" width="150px" />
            </div>
          </q-card-section>

          <!--Buttons-->
          <q-card-actions class="q-px-lg justify-center">
            <div class="q-pa-sm q-gutter-sm">
              <q-skeleton
                type="QBtn"
                class="absolute"
                height="50px"
                width="125px"
                style="bottom: 0; left: 50px; transform: translateY(-25px)"
              />
              <q-skeleton
                type="circle"
                size="60px"
                class="absolute"
                style="bottom: 0; right: 50px; transform: translateY(-25px)"
              />
            </div>
          </q-card-actions>
        </q-card>

        <!--The card for quick navigation to Autosaved ballot for logged in users-->
        <q-card class="q-ma-lg" style="min-width: 340px; height: 370px">
          <!--info button-->
          <q-skeleton type="circle" class="q-ma-md" size="20px" />

          <!--The Icon-->
          <q-card-section class="row justify-center">
            <div class="col-auto">
              <q-skeleton type="QAvatar" size="50px" class="q-ma-md" />
            </div>
          </q-card-section>

          <!--Headings-->
          <q-card-section>
            <div class="row justify-center">
              <q-skeleton type="rect" class="q-py-md" width="200px" />
            </div>
            <div class="row justify-center">
              <q-skeleton type="text" class="q-ma-md" width="150px" />
            </div>
          </q-card-section>

          <!--Buttons-->
          <q-card-actions class="q-px-lg justify-center">
            <div class="q-pa-sm q-gutter-sm">
              <q-skeleton
                type="QBtn"
                class="absolute"
                height="50px"
                width="125px"
                style="bottom: 0; left: 50px; transform: translateY(-25px)"
              />
              <q-skeleton
                type="circle"
                size="60px"
                class="absolute"
                style="bottom: 0; right: 50px; transform: translateY(-25px)"
              />
            </div>
          </q-card-actions>
        </q-card>
      </div>
    </div>
  </q-page>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
export default defineComponent({
  name: 'IndexPageSkeleton',
});
</script>
