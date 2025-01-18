<template>
  <q-item v-if="motionList.length == 0">
    <q-item-section class="text-subtitle1">{{
      $t('motion.list.empty')
    }}</q-item-section> </q-item
  ><!--Žádné výsledky-->

  <q-expansion-item
    v-for="(motion, index) in motionList"
    :key="index"
    :label="motion.name"
    :header-class="{
      'text-subtitle2': motion.added_by.id !== authStore.user?.person.id,
      'text-subtitle2 text-light-blue-13':
        motion.added_by.id === authStore.user?.person.id,
      'text-subtitle2 text-lime-6':
        $q.dark.isActive && motion.added_by.id === authStore.user?.person.id,
    }"
  >
    <!--Body for the accordion motion-->
    <q-card>
      <q-card-section>
        <div class="row">
          <!--Added by name and surname-->
          <q-chip :class="{ 'bg-white': !$q.dark.isActive }">
            <q-avatar
              v-if="$q.dark.isActive"
              icon="person"
              color="light-blue-13"
            />
            <q-avatar v-else icon="person" color="lime-6" />
            {{ $t('motion.list.addedBy') }}
            {{ motion.added_by.name }}
            {{ motion.added_by.surname }} </q-chip
          ><!--Přidal/a:-->

          <!--Edited by name and surname-->
          <q-chip
            :class="{ 'bg-white': !$q.dark.isActive }"
            v-if="motion.edited_by !== null"
          >
            <q-avatar
              v-if="$q.dark.isActive"
              icon="engineering"
              color="light-blue-13"
            />
            <q-avatar v-else icon="engineering" color="lime-6" />
            {{ $t('motion.list.editedBy') }}
            {{ motion.edited_by.name }}
            {{ motion.edited_by.surname }} </q-chip
          ><!--Upravil/a:-->

          <!--Created at date-->
          <q-chip :class="{ 'bg-white': !$q.dark.isActive }">
            <q-avatar
              v-if="$q.dark.isActive"
              icon="calendar_month"
              color="light-blue-13"
            />
            <q-avatar v-else icon="calendar_month" color="lime-6" />
            {{ $t('motion.list.createdAt') }}
            {{ new Date(motion.created_at).toLocaleDateString() }} </q-chip
          ><!--Vytvořeno:-->

          <!--Updated at date-->
          <q-chip
            :class="{ 'bg-white': !$q.dark.isActive }"
            v-if="
              motion.updated_at != null &&
              motion.updated_at !== motion.created_at
            "
          >
            <q-avatar
              v-if="$q.dark.isActive"
              icon="edit_calendar"
              color="light-blue-13"
            />
            <q-avatar v-else icon="edit_calendar" color="lime-6" />
            {{ $t('motion.list.editedAt') }}
            {{ new Date(motion.updated_at).toLocaleDateString() }} </q-chip
          ><!--Upraveno:-->
        </div>
      </q-card-section>

      <q-separator inset />

      <q-card-actions
        v-if="
          authStore.user?.person != null &&
          authStore.user?.person.id === motion.added_by.id
        "
      >
        <!--Edit button-->
        <q-btn
          flat
          class="q-pa-sm"
          color="orange-13"
          :label="$t('motion.list.button.edit')"
          @click="onEditClick(motion)"
        /><!--Upravit-->

        <!--Delete button-->
        <q-btn
          flat
          class="q-pa-sm"
          color="negative"
          :label="$t('motion.list.button.delete')"
          @click="onDeleteClick(motion)"
        /><!--Smazat-->
      </q-card-actions>
    </q-card>
  </q-expansion-item>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { useAuthStore } from 'src/stores/AuthStore';
import { useBallotStore } from 'src/stores/BallotStore';
import { mapStores } from 'pinia';
import { Motion } from 'components/models';

export default defineComponent({
  name: 'MotionList',

  props: ['motionList'],

  methods: {
    //function that shows dialog for editing the motion name after clicking the add button
    onEditClick(motion: Motion) {
      this.$q
        .dialog({
          title: this.$t('motion.list.edit.title'), //Upravit tezi
          message: this.$t('motion.list.edit.message'), //Tezi upravte, dle vaší libosti:
          prompt: {
            model: motion.name,
            type: 'text',
          },
          persistent: false,
          ok: {
            flat: true,
            color: 'light-blue-13',
            label: this.$t('motion.list.edit.button.ok'), //Uložit
          },
          cancel: {
            flat: true,
            color: 'orange-13',
            label: this.$t('motion.list.edit.button.cancel'), //Zrušit
          },
        })
        .onOk(async (data) => {
          if (
            //Only logged in users with personal info that created the Motion can edit it
            this.authStore.user != null &&
            this.authStore.user.person != null &&
            this.authStore.user.person.id != motion.added_by.id
          ) {
            this.$dialogs.unauthorized(); //Na tuto akci nemáte dostatečná oprávnění
          } else {
            //The balloter Store is getting called here
            if (!(await this.ballotStore.editMotion(motion, data))) {
              this.$q.notify({
                icon: 'warning',
                color: 'negative',
                message: this.$t('motion.list.edit.failure'), //Při ukládání teze došlo k chybě
              });
            } else {
              this.$q.notify({
                icon: 'done',
                color: 'positive',
                message: this.$t('motion.list.edit.success'), //Uloženo
              });
            }
          }
        });
    },

    //function that shows warning after clicking the delete button
    onDeleteClick(motion: Motion) {
      this.$q
        .dialog({
          title: this.$t('motion.list.delete.title'), //Upozornění
          message: this.$t('motion.list.delete.message'), //Tato akce smaže tuto tezi. Jste si jisti, že chcete pokračovat ?
          persistent: true,
          ok: {
            flat: true,
            color: 'negative',
            label: this.$t('motion.list.delete.button.ok'), //Ano
          },
          cancel: {
            flat: true,
            color: 'light-blue-13',
            label: this.$t('motion.list.delete.button.cancel'), //Zrušit
          },
        })
        .onOk(async () => {
          if (
            //Only logged in users with personal info that created the Motion can delete it
            this.authStore.user != null &&
            this.authStore.user.person != null &&
            this.authStore.user.person.id != motion.added_by.id
          ) {
            this.$dialogs.unauthorized(); //Na tuto akci nemáte dostatečná oprávnění
            //The balloter Store is getting called here
          } else {
            if (!(await this.ballotStore.deleteMotion(motion))) {
              this.$q.notify({
                icon: 'warning',
                color: 'negative',
                message: this.$t('motion.list.delete.failure'), //Tezi se nepodařilo smazat
              });
            } else {
              this.$q.notify({
                icon: 'done',
                color: 'positive',
                message: this.$t('motion.list.delete.warning.success'), //Úspěšně smazáno
              });
            }
          }
        });
    },
  },

  computed: {
    ...mapStores(useAuthStore, useBallotStore),
  },
});
</script>
