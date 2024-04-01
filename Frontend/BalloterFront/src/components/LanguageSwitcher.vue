<template>
  <q-select
    v-model="locale"
    :options="languages"
    :option-label="
      (language) =>
        $q.screen.width > 650
          ? Object(language) === language
            ? language.native
            : '- Null -'
          : ''
    "
    borderless
    class="language-selector q-px-md"
    @update:model-value="switchLocale()"
  >
    <template v-slot:prepend>
      <q-avatar size="25px" text-color="white">
        <q-icon
          :name="locale?.flag"
          size="36px"
          style="transform: translateY(-10px)"
        />
      </q-avatar>
    </template>
    <!-- Displaying the options -->
    <template v-slot:option="scope">
      <q-item v-bind="scope.itemProps">
        <q-item-section avatar>
          <!-- Flag Icon -->
          <q-icon :name="scope.opt.flag" />
        </q-item-section>
        <q-item-section>
          <!-- Label -->
          <q-item-label>{{ scope.opt.native }}</q-item-label>
        </q-item-section>
      </q-item>
    </template>
  </q-select>
</template>

<style>
.language-selector {
  .q-field__native {
    color: white;
    text-transform: uppercase;
    font-weight: 450;
  }
  .q-field__append {
    color: white;
  }
}
</style>

<script lang="ts">
import { defineComponent } from 'vue';
import { useAuthStore } from 'src/stores/AuthStore';
import { mapStores } from 'pinia';
import { Language } from './models';
import { langList } from 'src/i18n';

export default defineComponent({
  name: 'LanguageSwitcher',

  mounted() {
    this.loadLocale();
  },

  data() {
    return {
      languages: [
        { en: 'English', native: 'English', short: 'en', flag: '🇬🇧' },
        { en: 'Czech', native: 'Čeština', short: 'cs', flag: '🇨🇿' },
      ],
      locale: null as null | Language,
    };
  },

  methods: {
    //function for seting up the starting value with user preferences
    loadLocale(): void {
      //default value is english
      var result = this.languages[0];

      this.languages.forEach((lang) => {
        //changing to users preferred language
        if (
          this.authStore.user != null &&
          this.authStore.user.preferred_locale == lang.short
        ) {
          result = lang;
          //when none is found the global one set from browser is used if it's supported
        } else if (lang.short == this.$i18n.locale) {
          result = lang;
        }
      });
      this.locale = result;
      //value is returned and set
      this.switchLocale();
    },

    //function for switching the languages in app
    async switchLocale(): Promise<void> {
      //changing the english to us english cause that's the framework's default option for english
      if (this.locale?.short == 'en') this.locale.short = 'en-US';

      //setting the translation
      if (this.locale != null) this.$i18n.locale = this.locale.short;

      //loading and setting the translation list for quasar components
      const lang = await langList[
        `../../node_modules/quasar/lang/${this.locale?.short}.mjs`
      ]();
      this.$q.lang.set(lang.default);
      this.$forceUpdate();
    },
  },

  computed: {
    ...mapStores(useAuthStore),
  },
});
</script>
