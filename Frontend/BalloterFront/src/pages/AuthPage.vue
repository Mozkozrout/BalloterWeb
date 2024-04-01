<template>
  <AuthPageSkeleton v-if="authStore.isLoading" />
  <div id="auth">
    <q-page
      class="row justify-center items-center"
      style="background: linear-gradient(#f3f3f5, #b4b4b4)"
      :class="{ 'bg-grey-9': $q.dark.isActive }"
    >
      <div :class="{ 'q-pa-lg': !$q.platform.is.mobile }">
        <div class="row">
          <q-card
            square
            :class="{ 'shadow-24': !$q.dark.isActive }"
            :style="{
              minWidth: mobileW + 'px',
              minHeight: mobileH + 'px',
            }"
          >
            <!--Name of the form - either Login or Register -->
            <q-card-section
              class="bg-dark"
              :class="{ 'bg-black': $q.dark.isActive }"
            >
              <h4 class="text-h5 text-white text-center q-my-md">
                {{ title }}
              </h4>
            </q-card-section>

            <q-card-section>
              <!--Button for switching between register and login form-->
              <q-btn
                fab
                ref="switchButton"
                color="orange-13"
                @click="switchTypeForm"
                icon="add"
                class="absolute"
                style="top: 0; right: 12px; transform: translateY(-50%)"
              >
                <q-tooltip v-if="!registerForm">
                  {{ $t('auth.tooltip.register')
                  }}<!--Registrace nového uživatele-->
                </q-tooltip>
                <q-tooltip v-else>
                  {{ $t('auth.tooltip.login') }}
                  <!--Přihlášení stávajícího uživatele--></q-tooltip
                >
              </q-btn>

              <!--Email input field-->
              <q-form class="q-px-sm q-pt-xl">
                <q-input
                  ref="email"
                  outlined
                  clearable
                  v-model="email"
                  type="email"
                  lazy-rules
                  :rules="[$rules.required, $rules.isEmail, $rules.shortEmail]"
                  :label="$t('auth.label.email')"
                >
                  <!--Email-->

                  <template v-slot:prepend>
                    <q-icon name="email" />
                  </template>
                </q-input>

                <br />

                <!--Password input field-->
                <q-input
                  ref="password"
                  outlined
                  clearable
                  v-model="password"
                  :type="passwordFieldType"
                  lazy-rules
                  :rules="[$rules.required, $rules.shortPWD, $rules.isValidPWD]"
                  :label="$t('auth.label.password')"
                >
                  <!--Heslo-->

                  <!--Button for password readibility toggle-->
                  <template v-slot:prepend>
                    <q-icon name="lock" />
                  </template>
                  <template v-slot:append>
                    <q-icon
                      :name="visibilityIcon"
                      @click="switchVisibility()"
                      class="cursor-pointer"
                    />
                  </template>
                </q-input>

                <br v-if="register" />

                <!--Confirm password input field that shows up only when this is a register form mode-->
                <q-input
                  ref="repassword"
                  v-if="registerForm"
                  outlined
                  clearable
                  v-model="repassword"
                  :type="passwordFieldType"
                  lazy-rules
                  :rules="[
                    $rules.required,
                    $rules.shortPWD,
                    $rules.isValidPWD,
                    diffPassword,
                  ]"
                  :label="$t('auth.label.repassword')"
                >
                  <!--Zopakujte Heslo-->

                  <!--Button for password readibility toggle for confirm password-->
                  <template v-slot:prepend>
                    <q-icon name="lock" />
                  </template>
                  <template v-slot:append>
                    <q-icon
                      :name="visibilityIcon"
                      @click="switchVisibility()"
                      class="cursor-pointer"
                    />
                  </template>
                </q-input>
              </q-form>
            </q-card-section>

            <q-card-actions class="q-px-lg">
              <!--Submit Button-->
              <q-btn
                elevated
                size="lg"
                color="light-blue-13"
                text-color="grey-1"
                @click="submit"
                class="full-width"
                :label="btnLabel"
              />
            </q-card-actions>

            <!--Forgot password prompt-->
            <q-card-section class="text-center q-pa-sm">
              <br v-if="!register" />
              <p class="text-grey-6" v-if="!registerForm">
                <a
                  href="#"
                  style="text-decoration: none; color: inherit"
                  @click="alert"
                  >{{ $t('auth.forgotpwd.label') }}</a
                ><!--Zapomněli jste heslo ?-->
              </p>
            </q-card-section>
          </q-card>
        </div>
      </div>
    </q-page>
  </div>
</template>

<script lang="ts">
import { useAuthStore } from 'src/stores/AuthStore';
import { mapStores } from 'pinia';
import AuthPageSkeleton from 'src/components/skeletons/AuthPageSkeleton.vue';
import { QInput } from 'quasar';

export default {
  name: 'AuthPage',

  components: {
    AuthPageSkeleton,
  },

  props: ['register'],

  data: function () {
    return {
      title: this.$t('auth.title.login'), //Přihlásit se
      email: '',
      password: '',
      repassword: '',
      registerForm: false,
      passwordFieldType: 'password' as 'password' | 'text',
      btnLabel: this.$t('auth.label.button.login'), //Přihlásit
      visibility: false,
      visibilityIcon: 'visibility',
    };
  },

  created() {
    //switching the form type based on the link user came from passed through props
    if (this.register == 1) this.switchTypeForm();
  },

  methods: {
    //rule for checking if the password and password confirm match (idk how to get the value of password if i put this rule to the rules file)
    diffPassword(val: string) {
      const val2 = this.password;
      return (val && val === val2) || this.$t('menu.prompt.diffPassword'); //Hesla se neshodují
    },

    //submit function for filled out form
    async submit() {
      //Input data validations (idk what to do with those typescript errors but it works)
      if (this.registerForm) {
        (this.$refs.email as typeof QInput).validate();
        (this.$refs.password as typeof QInput).validate();
        (this.$refs.repassword as typeof QInput).validate();
      } else {
        (this.$refs.email as typeof QInput).validate();
        (this.$refs.password as typeof QInput).validate();
      }

      if (!this.registerForm) {
        //login functionality
        if (
          !(this.$refs.email as typeof QInput).hasError &&
          !(this.$refs.password as typeof QInput).hasError
        ) {
          if (await this.authStore.login(this.email, this.password)) {
            this.$q.notify({
              icon: 'done',
              color: 'positive',
              message: this.$t('auth.login.success'), //Přihlášeno
            });
            this.$router.push({ path: '/' });
          } else {
            this.$q.notify({
              icon: 'warning',
              color: 'negative',
              message: this.$t('auth.login.failure'), //Neplatné přihlašovací údaje
            });
            this.$router.push({ path: '/auth/0' });
          }
        }
      } else {
        //register functionality
        if (
          //input error checks on registering
          !(this.$refs.email as typeof QInput).hasError &&
          !(this.$refs.password as typeof QInput).hasError &&
          this.password == this.repassword
        ) {
          if (
            await this.authStore.register(
              this.email,
              this.password,
              this.repassword
            )
          ) {
            this.$q.notify({
              icon: 'done',
              color: 'positive',
              message: this.$t('auth.register.success'), //Registrováno
            });
            this.switchTypeForm();
          } else {
            this.$q.notify({
              icon: 'warning',
              color: 'negative',
              message: this.$t('auth.register.failure'), //Někde se stala chyba
            });
          }
        }
      }
    },
    switchTypeForm() {
      //switching of the labels and functions of the form
      this.registerForm = !this.registerForm;
      this.title = this.registerForm
        ? this.$t('auth.title.register') //Registrovat
        : this.$t('auth.title.login'); // Přihlásit se
      this.btnLabel = this.registerForm
        ? this.$t('auth.label.button.register') //Registrovat
        : this.$t('auth.label.button.login'); //Přihlásit
    },
    switchVisibility() {
      //switching of the password fields visibility
      this.visibility = !this.visibility;
      this.passwordFieldType = this.visibility ? 'text' : 'password';
      this.visibilityIcon = this.visibility ? 'visibility_off' : 'visibility';
    },
    alert() {
      this.$q.dialog({
        title: this.$t('auth.forgotpwd.title'), //Zapomenuté heslo
        message: this.$t('auth.forgotpwd.message'), //Bohužel, obnovování hesla nic nedělá ¯_(ツ)_/¯
        ok: {
          flat: true,
          color: 'light-blue-13',
        },
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
      return 350;
    },
    //function that returns screen height when on mobile
    mobileH() {
      if (this.$q.platform.is.mobile) {
        return this.$q.screen.height - 50;
      }
      return 0;
    },
    //function that tracks changes in language
    langChange() {
      return this.$i18n.locale;
    },
  },

  watch: {
    //function that updates form each time the language changes
    langChange() {
      if (this.registerForm) {
        this.title = this.$t('auth.title.register');
        this.btnLabel = this.$t('auth.label.button.register');
      } else {
        this.title = this.$t('auth.title.login');
        this.btnLabel = this.$t('auth.label.button.login');
      }
    },
  },
};
</script>
