<template>
  <ProfilePageSkeleton v-if="authStore.loading" />
  <div id="Profile Page" v-if="!authStore.loading">
    <q-page
      class="row justify-center items-center"
      style="background: linear-gradient(#f3f3f5, #b4b4b4)"
      :class="{ 'bg-grey-9': $q.dark.isActive }"
    >
      <div
        :class="{ 'q-pa-lg': !$q.platform.is.mobile }"
        v-if="authStore.user != null"
      >
        <div class="row">
          <q-card
            square
            :class="{ 'shadow-24': !$q.dark.isActive }"
            :style="{
              minWidth: mobileW + 'px',
              minHeight: mobileH + 'px',
            }"
          >
            <!--Header -->
            <q-card-section
              class="bg-dark"
              :class="{ 'bg-black': $q.dark.isActive }"
              style="height: 140px"
            >
              <h4 class="text-h5 text-white text-center q-my-md">
                {{ $t('profile.title') }}
              </h4>
              <!--Uživatelský Profil -->

              <!--Icon-->
              <div class="profile-photo text-center">
                <div class="default-user-image">
                  <q-avatar
                    v-if="$q.dark.isActive"
                    round="round"
                    color="light-blue-13"
                    icon="person"
                    font-size="100px"
                    size="120px"
                    text-color="white"
                  />
                  <q-avatar
                    v-else
                    round="round"
                    color="lime-6"
                    icon="person"
                    font-size="100px"
                    size="120px"
                    text-color="dark"
                  />
                </div>
              </div>
            </q-card-section>

            <q-card-section>
              <!--Text Fields-->
              <br />
              <div class="q-px-sm q-pt-xl">
                <!--Showing name or username based on user login-->
                <p
                  v-if="authStore.user.person == null"
                  class="text-h6 text-bold text-center"
                >
                  {{ authStore.user.username }}
                </p>

                <p v-else class="text-h5 text-bold text-center">
                  {{ authStore.user.person.name }}
                  {{ authStore.user.person.surname }}
                </p>

                <q-separator spaced inset />
                <div class="row">
                  <!--General account info-->
                  <div
                    class="col-auto q-px-md width"
                    style="overflow: auto; max-width: 300px"
                  >
                    <h6 class="text-h8 q-my-md">
                      {{ $t('profile.account.title') }}
                    </h6>
                    <!--Informace o účtu-->

                    <!--Email-->
                    <div class="row">
                      <q-chip :class="{ 'bg-white': !$q.dark.isActive }">
                        <q-avatar
                          v-if="$q.dark.isActive"
                          icon="mail"
                          color="light-blue-13"
                        />
                        <q-avatar v-else icon="mail" color="lime-6" />
                        {{ $t('profile.account.email')
                        }}{{ authStore.user.username }}
                      </q-chip>
                      <!--Email: -->
                    </div>

                    <!--Role-->
                    <div class="row" v-if="authStore.user.role != null">
                      <q-chip :class="{ 'bg-white': !$q.dark.isActive }">
                        <q-avatar
                          v-if="$q.dark.isActive"
                          icon="star"
                          color="light-blue-13"
                        />
                        <q-avatar v-else icon="star" color="lime-6" />
                        {{ $t('profile.account.role')
                        }}{{ authStore.user.role.name }}
                      </q-chip>
                      <!--Role: -->
                    </div>

                    <!--Language-->
                    <div class="row">
                      <q-chip :class="{ 'bg-white': !$q.dark.isActive }">
                        <q-avatar
                          v-if="$q.dark.isActive"
                          icon="language"
                          color="light-blue-13"
                        />
                        <q-avatar v-else icon="language" color="lime-6" />
                        {{ $t('profile.account.locale') }}
                        {{ authStore.user.preferred_locale }}
                      </q-chip>
                      <!--Preferovaný jazyk: -->
                    </div>
                  </div>

                  <!--Personal info-->
                  <div
                    v-if="authStore.user.person != null"
                    class="col-auto q-px-md self-start"
                    style="overflow: auto; max-width: 300px"
                  >
                    <h6 class="text-h7 q-my-md">
                      {{ $t('profile.person.title') }}
                    </h6>
                    <!--Osobní Informace-->

                    <!--Birthdate-->
                    <div class="row">
                      <q-chip :class="{ 'bg-white': !$q.dark.isActive }">
                        <q-avatar
                          v-if="$q.dark.isActive"
                          icon="cake"
                          color="light-blue-13"
                        />
                        <q-avatar v-else icon="cake" color="lime-6" />
                        {{ $t('profile.person.birthdate') }}
                        {{
                          new Date(
                            authStore.user.person.birthdate
                          ).toLocaleDateString()
                        }}
                      </q-chip>
                      <!--Datum narození: -->
                    </div>

                    <!--Institution-->
                    <div
                      class="row"
                      v-if="authStore.user.person.institution != null"
                    >
                      <q-chip :class="{ 'bg-white': !$q.dark.isActive }">
                        <q-avatar
                          v-if="$q.dark.isActive"
                          icon="school"
                          color="light-blue-13"
                        />
                        <q-avatar v-else icon="school" color="lime-6" />
                        {{ $t('profile.person.institution') }}
                        {{ authStore.user.person.institution.name }}
                      </q-chip>
                      <!--Instituce: -->
                    </div>

                    <!--Address-->
                    <div
                      class="row"
                      v-if="authStore.user.person.address != null"
                    >
                      <q-chip :class="{ 'bg-white': !$q.dark.isActive }">
                        <q-avatar
                          v-if="$q.dark.isActive"
                          icon="home"
                          color="light-blue-13"
                        />
                        <q-avatar v-else icon="home" color="lime-6" />
                        {{ $t('profile.person.address') }}
                      </q-chip>
                      <!--Adresa:-->
                      <p>
                        {{ authStore.user.person.address.street }}
                        {{ authStore.user.person.address.house_nmr }},
                        {{ authStore.user.person.address.city }},
                        <br />
                        {{ authStore.user.person.address.state }} -
                        {{ authStore.user.person.address.zip }}
                      </p>
                    </div>
                  </div>
                </div>

                <!--Label for when user has no personal info attached-->
                <div
                  v-if="authStore.user.person == null"
                  class="col-auto q-px-md self-end"
                  style="overflow: auto; max-width: 300px"
                >
                  <q-separator spaced inset />
                  <p class="q-py-md">
                    {{ $t('profile.person.noInfo') }}
                  </p>
                  <!--Je to tu nějaké prázdné, pokud chcete, můžete o sobě doplnit
                    více údajů.-->
                </div>

                <!--Comment-->
                <div
                  v-else-if="
                    authStore.user.person.note != null &&
                    authStore.user.person.note != ''
                  "
                  class="col-auto q-px-md self-end"
                  style="overflow: auto"
                >
                  <q-separator spaced inset />
                  <p class="q-py-md text-center">
                    " {{ authStore.user.person.note }} "
                  </p>
                </div>
              </div>
            </q-card-section>

            <q-card-actions class="q-py-lg">
              <!--Profile Edit button-->
              <q-btn
                :to="{ name: 'profileEdit' }"
                class="absolute"
                style="bottom: 0; right: 18px; transform: translateY(-18px)"
                fab
                icon="edit"
                color="orange-13"
              />
            </q-card-actions>
          </q-card>
        </div>
      </div>
    </q-page>
  </div>
</template>

<script lang="ts">
import { useAuthStore } from 'src/stores/AuthStore';
import { mapStores } from 'pinia';
import ProfilePageSkeleton from 'src/components/skeletons/ProfilePageSkeleton.vue';

export default {
  name: 'ProfilePage',

  components: {
    ProfilePageSkeleton,
  },

  mounted() {
    if (this.authStore.user === null) this.$router.push({ path: '/auth/0' });
  },

  computed: {
    ...mapStores(useAuthStore),

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
};
</script>
