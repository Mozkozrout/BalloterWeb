<template>
  <ProfileFormSkeleton v-if="authStore.loading" />
  <div id="Profile Form" v-if="!authStore.loading">
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
            >
              <h4 class="text-h5 text-white text-center q-my-md">
                {{ $t('profileF.title') }}
              </h4>
              <!--Úprava Profilu -->
            </q-card-section>

            <q-card-section>
              <h6 class="text-h8 q-my-xs">
                {{ $t('profileF.account.title') }}
              </h6>
              <!--Informace o účtu-->

              <!--Text Fields-->
              <q-form class="q-px-sm">
                <div class="row">
                  <!--Name-->
                  <div class="col-grow">
                    <q-input
                      class="q-pa-sm"
                      ref="name"
                      outlined
                      clearable
                      v-model="name"
                      type="text"
                      :label="$t('profileF.account.label.name')"
                      lazy-rules
                      :rules="[$rules.required, $rules.noNumbers]"
                      ><!--Jméno-->

                      <template v-slot:prepend>
                        <q-icon name="badge" />
                      </template>
                    </q-input>
                  </div>

                  <!--Surname-->
                  <div class="col-grow">
                    <q-input
                      class="q-pa-sm"
                      ref="surname"
                      outlined
                      clearable
                      v-model="surname"
                      type="text"
                      :label="$t('profileF.account.label.surname')"
                      lazy-rules
                      :rules="[$rules.required, $rules.noNumbers]"
                      ><!--Příjmení-->

                      <template v-slot:prepend>
                        <q-icon name="badge" />
                      </template>
                    </q-input>
                  </div>
                </div>

                <div class="row">
                  <!--Email-->
                  <div class="col-grow">
                    <q-input
                      class="q-pa-sm"
                      ref="email"
                      outlined
                      clearable
                      v-model="email"
                      type="text"
                      :label="$t('profileF.account.label.email')"
                      lazy-rules
                      :rules="[
                        $rules.required,
                        $rules.isEmail,
                        $rules.shortEmail,
                      ]"
                      ><!--Email-->

                      <template v-slot:prepend>
                        <q-icon name="mail" />
                      </template>
                    </q-input>
                  </div>

                  <!--Preferred Locale-->
                  <div class="col-grow">
                    <q-select
                      style="min-width: 285px"
                      class="q-pa-sm"
                      ref="locale"
                      outlined
                      v-model="locale"
                      :label="$t('profileF.account.label.locale')"
                      :options="['cs', 'en']"
                      ><!--Jazyk-->

                      <template v-slot:prepend>
                        <q-icon name="language" />
                      </template>
                    </q-select>
                  </div>
                </div>

                <q-separator spaced inset />
                <h6 class="text-h7 q-my-xs">
                  {{ $t('profileF.person.title') }}
                </h6>
                <!--Osobní Informace-->

                <div class="row">
                  <!--Personal info - First Column-->
                  <div class="col-grow self-start">
                    <!--Birthdate - This could also be set to some sort of a minimal and maximal date as well as a default-->
                    <div class="row">
                      <div class="col-grow">
                        <q-input
                          class="q-pa-sm"
                          outlined
                          v-model="birthdate"
                          lazy-rules
                          :rules="[$rules.isBirthdate]"
                          :label="$t('profileF.person.label.birthdate')"
                          ><!--Datum Narození-->

                          <template v-slot:prepend>
                            <q-icon name="event" class="cursor-pointer">
                              <q-popup-proxy
                                cover
                                transition-show="scale"
                                transition-hide="scale"
                              >
                                <q-date
                                  v-model="birthdate"
                                  color="lime-6"
                                  text-color="black"
                                  mask="YYYY-MM-DD"
                                >
                                  <div class="row items-center justify-end">
                                    <q-btn
                                      v-close-popup
                                      label="Close"
                                      color="primary"
                                      flat
                                    />
                                  </div>
                                </q-date>
                              </q-popup-proxy>
                            </q-icon>
                          </template>
                        </q-input>
                      </div>
                    </div>

                    <!--Institution-->
                    <div class="row">
                      <div class="col-grow">
                        <q-select
                          style="min-width: 250px"
                          class="q-pa-sm"
                          ref="institution"
                          outlined
                          v-model="institution"
                          :label="$t('profileF.person.label.institution')"
                          :options="institutions"
                          ><!--Instituce-->

                          <template v-slot:prepend>
                            <q-icon name="school" />
                          </template>
                        </q-select>
                      </div>
                    </div>

                    <!--Note-->
                    <div class="row">
                      <div class="col-grow">
                        <q-input
                          class="q-pa-sm"
                          ref="note"
                          outlined
                          clearable
                          v-model="note"
                          type="textarea"
                          :label="$t('profileF.person.label.note')"
                          ><!--Poznámka-->

                          <template v-slot:prepend>
                            <q-icon name="edit_note" />
                          </template>
                        </q-input>
                      </div>
                    </div>
                  </div>

                  <!--Address - Second Column-->
                  <div class="col-grow self-start">
                    <!--Street-->
                    <div class="row">
                      <div class="col-grow">
                        <q-input
                          class="q-pa-sm"
                          ref="street"
                          outlined
                          clearable
                          v-model="street"
                          type="text"
                          :label="$t('profileF.person.label.street')"
                          lazy-rules
                          :rules="[$rules.noNumbers]"
                          ><!--Ulice-->

                          <template v-slot:prepend>
                            <q-icon name="home" />
                          </template>
                        </q-input>
                      </div>
                    </div>

                    <!--House Number-->
                    <div class="row">
                      <div class="col-grow">
                        <q-input
                          class="q-pa-sm"
                          ref="house_nmr"
                          outlined
                          clearable
                          v-model="house_nmr"
                          type="number"
                          :label="$t('profileF.person.label.number')"
                          lazy-rules
                          :rules="[$rules.noLetters]"
                          ><!--Číslo Popisné-->

                          <template v-slot:prepend>
                            <q-icon name="home" />
                          </template>
                        </q-input>
                      </div>
                    </div>

                    <!--City-->
                    <div class="row">
                      <div class="col-grow">
                        <q-input
                          class="q-pa-sm"
                          ref="city"
                          outlined
                          clearable
                          v-model="city"
                          type="text"
                          :label="$t('profileF.person.label.city')"
                          lazy-rules
                          :rules="[$rules.noNumbers]"
                          ><!--Město-->

                          <template v-slot:prepend>
                            <q-icon name="home" />
                          </template>
                        </q-input>
                      </div>
                    </div>

                    <!--State-->
                    <div class="row">
                      <div class="col-grow">
                        <q-input
                          class="q-pa-sm"
                          ref="state"
                          outlined
                          clearable
                          v-model="state"
                          type="text"
                          :label="$t('profileF.person.label.state')"
                          lazy-rules
                          :rules="[$rules.noNumbers]"
                          ><!--Stát-->

                          <template v-slot:prepend>
                            <q-icon name="home" />
                          </template>
                        </q-input>
                      </div>
                    </div>

                    <!--Zip-->
                    <div class="row">
                      <div class="col-grow">
                        <q-input
                          class="q-pa-sm"
                          ref="zip"
                          outlined
                          clearable
                          v-model="zip"
                          type="number"
                          :label="$t('profileF.person.label.zip')"
                          lazy-rules
                          :rules="[$rules.isZip, $rules.noLetters]"
                          ><!--Zip-->

                          <template v-slot:prepend>
                            <q-icon name="home" />
                          </template>
                        </q-input>
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
                <q-btn
                  class="q-pa-sm"
                  elevated
                  size="lg"
                  color="light-blue-13"
                  text-color="grey-1"
                  @click="submit"
                  :label="$t('profileF.button.save')"
                /><!--Uložit-->
              </div>
              <!--Cancel Button-->
              <div class="col-auto q-pa-sm">
                <q-btn
                  class="q-pa-sm"
                  elevated
                  size="lg"
                  color="orange-13"
                  text-color="grey-1"
                  :label="$t('profileF.button.cancel')"
                  :to="{ name: 'profile' }"
                /><!--Zrušit-->
              </div>

              <!--Delete Button-->
              <q-fab
                class="absolute"
                style="bottom: 0; right: 18px; transform: translateY(-15px)"
                v-model="fab"
                :label="$t('profileF.button.delete.label')"
                label-position="top"
                color="negative"
                icon="keyboard_arrow_up"
                direction="up"
                ><!--Smazat-->

                <!--Delete Button sub action (for person removal)-->
                <q-fab-action
                  color="deep-orange-14"
                  @click="alertPerson"
                  icon="person_remove"
                  :label="$t('profileF.button.delete.person')"
                /><!--Údaje-->

                <!--Delete Button sub action (for account removal)-->
                <q-fab-action
                  color="red-14"
                  @click="alertUser"
                  icon="delete"
                  :label="$t('profileF.button.delete.account')"
                /><!--Účet-->
              </q-fab>
            </q-card-actions>
          </q-card>
        </div>
      </div>
    </q-page>
  </div>
</template>

<style>
textarea {
  height: 172px;
}
</style>

<script lang="ts">
import { useAuthStore } from 'src/stores/AuthStore';
import { mapStores } from 'pinia';
import ProfileFormSkeleton from 'src/components/skeletons/ProfileFormSkeleton.vue';

export default {
  name: 'ProfileForm',

  components: {
    ProfileFormSkeleton,
  },

  mounted() {
    //Checking if the user is logged in
    if (this.authStore.user === null) this.$router.push({ path: '/auth/0' });

    //loading the available data to the form from user

    if (this.authStore.user !== null) {
      this.getInstitutions();
      this.email = this.authStore.user.username;
      this.locale = this.authStore.user.preferred_locale;
      if (this.authStore.user.person !== null) {
        this.name = this.authStore.user.person.name;
        this.surname = this.authStore.user.person.surname;
        this.birthdate = this.authStore.user.person.birthdate;
        if (this.authStore.user.person.institution !== null) {
          this.institution = this.authStore.user.person.institution.name;
        }
        this.note = this.authStore.user.person.note;
        if (this.authStore.user.person.address !== null) {
          this.street = this.authStore.user.person.address.street;
          this.house_nmr = this.authStore.user.person.address.house_nmr;
          this.city = this.authStore.user.person.address.city;
          this.state = this.authStore.user.person.address.state;
          this.zip = this.authStore.user.person.address.zip;
        }
      }
    }
  },

  data: function () {
    return {
      name: '',
      surname: '',
      email: '',
      locale: '',
      birthdate: '',
      institution: '',
      institutions: [] as string[],
      note: '',
      street: '',
      house_nmr: '',
      city: '',
      state: '',
      zip: '',
      fab: false,
    };
  },
  methods: {
    //functions for submitting the form
    async submit() {
      //this if checks if address is filled fully or its all empty with either empty strings(not filled) or null (value removed)
      //probably could be done in more elegant way without resorting to use the dialog window and checking with ifs like this
      if (this.house_nmr == null) this.house_nmr = '';
      if (this.street == null) this.street = '';
      if (this.state == null) this.state = '';
      if (this.city == null) this.city = '';
      if (this.zip == null) this.zip = '';
      if (
        !(
          (this.state == '' &&
            this.city == '' &&
            this.street == '' &&
            this.house_nmr == '' &&
            this.zip == '') ||
          (this.state != '' &&
            this.city != '' &&
            this.street != '' &&
            this.house_nmr != '' &&
            this.zip != '')
        )
      ) {
        this.$q.dialog({
          title: this.$t('profileF.submit.title'), //Upozornění
          message: this.$t('profileF.submit.message'), //Adresu vyplňte prosím buď celou, a nebo vůbec
          ok: {
            flat: true,
            color: 'light-blue-13',
          },
        });
        return;
      }
      //actual calling of the update function in the store
      if (
        await this.authStore.updateOrCreatePerson(
          this.name,
          this.surname,
          this.birthdate,
          this.institution,
          this.note,
          this.state,
          this.city,
          this.street,
          this.house_nmr,
          this.zip
        )
      ) {
        this.$q.notify({
          icon: 'done',
          color: 'positive',
          message: this.$t('profileF.submit.success'), //Uloženo
        });
        this.$router.push({ path: '/profile' });
      } else {
        this.$q.notify({
          icon: 'warning',
          color: 'negative',
          message: this.$t('profileF.submit.failure'), //Při ukládání informací došlo k chybě.
        });
      }
    },

    //deleting just the person table aka personal data
    async deletePerson() {
      if (await this.authStore.deletePerson()) {
        this.$q.notify({
          icon: 'done',
          color: 'positive',
          message: this.$t('profileF.deletePerson.success'), //Data Smazána
        });
        this.$router.push({ path: '/profile' });
      } else {
        this.$q.notify({
          icon: 'warning',
          color: 'negative',
          message: this.$t('profileF.deletePerson.failure'), //Při mazání dat došlo k chybě
        });
      }
    },

    //deleting the whole user account
    async deleteUser() {
      if (await this.authStore.delete()) {
        this.$q.notify({
          icon: 'done',
          color: 'positive',
          message: this.$t('profileF.deleteUser.success'), //Účet Smazán
        });
        this.$router.push({ path: '/' });
      } else {
        this.$q.notify({
          icon: 'warning',
          color: 'negative',
          message: this.$t('profileF.deleteUser.failure'), //Při mazání účtu došlo k chybě
        });
      }
    },

    //loading the list of institutions
    async getInstitutions() {
      if (!(await this.authStore.getInstitutions())) {
        this.$q.notify({
          icon: 'warning',
          color: 'negative',
          message: 'Při načítání institucí došlo k chybě', //Při načítání institucí došlo k chybě
        });
      } else {
        this.authStore.institutionList.forEach((institution) => {
          this.institutions.push(institution.name);
        });
      }
    },

    alertPerson() {
      this.$q
        .dialog({
          title: this.$t('profileF.deletePerson.title'), //Upozornění
          message: this.$t('profileF.deletePerson.message'), //Tato akce smaže všechna vaše osobní data. Jste si jisti, že chcete pokračovat ?
          persistent: true,
          ok: {
            flat: true,
            color: 'negative',
            label: this.$t('profileF.deletePerson.button.ok'), //Ano
          },
          cancel: {
            flat: true,
            color: 'light-blue-13',
            label: this.$t('profileF.deletePerson.button.cancel'), //Zrušit
          },
        })
        .onOk(() => {
          this.deletePerson();
        });
    },

    alertUser() {
      this.$q
        .dialog({
          title: this.$t('profileF.deleteUser.title'), //Upozornění
          message: this.$t('profileF.deleteUser.message'), //Tato akce smaže vaše data i celý váš uživatelský účet. Pro pokračování zadejte váš email
          prompt: {
            model: '',
            type: 'text',
          },
          persistent: true,
          ok: {
            flat: true,
            color: 'negative',
            label: this.$t('profileF.deleteUser.button.ok'), //Potvrdit
          },
          cancel: {
            flat: true,
            color: 'light-blue-13',
            label: this.$t('profileF.deleteUser.button.cancel'), //Zrušit
          },
        })
        .onOk((data) => {
          if (
            this.authStore.user != null &&
            data === this.authStore.user.username
          ) {
            this.deleteUser();
          }
        });
    },
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
