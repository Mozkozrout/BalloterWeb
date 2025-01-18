<template>
  <q-item
    v-if="!external"
    clickable
    v-ripple
    :to="{ path: link }"
    style="text-decoration: none; color: inherit"
  >
    <q-item-section v-if="icon" avatar>
      <q-icon :name="icon" />
    </q-item-section>

    <q-item-section>
      <q-item-label>{{ title }}</q-item-label>
    </q-item-section>
  </q-item>

  <q-item
    v-else
    clickable
    v-ripple
    tag="a"
    target="_blank"
    :href="link"
    style="text-decoration: none; color: inherit"
  >
    <q-item-section v-if="icon" avatar>
      <q-icon :name="icon" />
    </q-item-section>

    <q-item-section>
      <q-item-label>{{ title }}</q-item-label>
    </q-item-section>
  </q-item>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'MenuLink',
  props: {
    title: {
      type: String,
      required: true,
    },

    link: {
      type: String,
      default: '/',
    },

    icon: {
      type: String,
      default: '',
    },

    external: {
      type: Boolean,
      default: false,
    },
  },
});
</script>
