<template>
  <div class="col-grow">
    <q-card flat bordered class="q-ma-sm">
      <q-tabs
        v-model="tab"
        dense
        active-color="light-blue-13"
        indicator-color="light-blue-13"
        mobile-arrows
        stretch
      >
        <q-btn-dropdown auto-close flat>
          <q-list dense>
            <q-item clickable @click="toggleCategory('Cont')">
              <q-item-section>{{
                $t('bota.category.content.title')
              }}</q-item-section>
            </q-item>
            <q-item clickable @click="toggleCategory('Str')">
              <q-item-section>{{
                $t('bota.category.strategy.title')
              }}</q-item-section></q-item
            >
            <q-item clickable @click="toggleCategory('Style')">
              <q-item-section>{{
                $t('bota.category.style.title')
              }}</q-item-section></q-item
            >
          </q-list>
        </q-btn-dropdown>
        <q-tab name="1" :label="getCategory.title[0]">
          <q-tooltip v-if="category != 'Style'">{{
            category == 'Cont'
              ? $t('bota.tooltips.content.analysis')
              : $t('bota.tooltips.strategy.structure')
          }}</q-tooltip>
        </q-tab>
        <q-tab name="2" :label="getCategory.title[1]">
          <q-tooltip v-if="category != 'Style'">{{
            category == 'Cont'
              ? $t('bota.tooltips.content.proving')
              : $t('bota.tooltips.strategy.timeWork')
          }}</q-tooltip>
        </q-tab>
        <q-tab name="3" :label="getCategory.title[2]">
          <q-tooltip v-if="category == 'Str'">{{
            category == 'Cont' ? '' : $t('bota.tooltips.strategy.teamWork')
          }}</q-tooltip>
        </q-tab>
        <q-tab name="4" :label="getCategory.title[3]">
          <q-tooltip v-if="category != 'Style'">{{
            category == 'Cont'
              ? $t('bota.tooltips.content.reactions')
              : $t('bota.tooltips.strategy.roleFulfillment')
          }}</q-tooltip>
        </q-tab>
        <q-tab icon="close" @click="toggleCategory(null)">
          <q-tooltip>{{ $t('bota.tooltips.close') }}</q-tooltip>
        </q-tab>
      </q-tabs>

      <q-separator />

      <q-tab-panels v-model="tab" animated>
        <q-tab-panel name="1">
          <q-table
            hide-pagination
            flat
            :rows="getCategory.rows[0]"
            row-key="name"
            auto-width
            table-header-style=""
            wrap-cells
            separator="vertical"
          >
            <template v-slot:header-cell="props">
              <q-th>
                <q-btn
                  flat
                  :color="
                    category == 'Style'
                      ? pointToggle1 == props.col.name + 'S'
                        ? 'orange-13'
                        : 'light-blue-13'
                      : pointToggle1 == props.col.name
                      ? 'orange-13'
                      : 'light-blue-13'
                  "
                  @click="onColCLick(props.col.name, 1)"
                  :label="props.col.label"
                />
              </q-th>
            </template>
          </q-table>
        </q-tab-panel>

        <q-tab-panel name="2">
          <q-table
            hide-pagination
            flat
            :rows="getCategory.rows[1]"
            row-key="name"
            auto-width
            table-header-style=""
            wrap-cells
            separator="vertical"
          >
            <template v-slot:header-cell="props">
              <q-th>
                <q-btn
                  flat
                  :color="
                    category == 'Style'
                      ? pointToggle2 == props.col.name + 'S'
                        ? 'orange-13'
                        : 'light-blue-13'
                      : pointToggle2 == props.col.name
                      ? 'orange-13'
                      : 'light-blue-13'
                  "
                  @click="onColCLick(props.col.name, 2)"
                  :label="props.col.label"
                />
              </q-th>
            </template>
            ></q-table
          >
        </q-tab-panel>

        <q-tab-panel name="3">
          <q-table
            hide-pagination
            flat
            :rows="getCategory.rows[2]"
            row-key="name"
            auto-width
            table-header-style=""
            wrap-cells
            separator="vertical"
          >
            <template v-slot:header-cell="props">
              <q-th>
                <q-btn
                  flat
                  :color="
                    category == 'Style'
                      ? pointToggle3 == props.col.name + 'S'
                        ? 'orange-13'
                        : 'light-blue-13'
                      : pointToggle3 == props.col.name
                      ? 'orange-13'
                      : 'light-blue-13'
                  "
                  @click="onColCLick(props.col.name, 3)"
                  :label="props.col.label"
                />
              </q-th> </template
          ></q-table>
        </q-tab-panel>
        <q-tab-panel name="4">
          <q-table
            hide-pagination
            flat
            :rows="getCategory.rows[3]"
            row-key="name"
            auto-width
            table-header-style=""
            wrap-cells
            separator="vertical"
          >
            <template v-slot:header-cell="props">
              <q-th>
                <q-btn
                  flat
                  :color="
                    category == 'Style'
                      ? pointToggle4 == props.col.name + 'S'
                        ? 'orange-13'
                        : 'light-blue-13'
                      : pointToggle4 == props.col.name
                      ? 'orange-13'
                      : 'light-blue-13'
                  "
                  @click="onColCLick(props.col.name, 4)"
                  :label="props.col.label"
                />
              </q-th> </template
          ></q-table>
        </q-tab-panel>
      </q-tab-panels>
    </q-card>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { DataRow, Result, CategoryResult } from './models';

export default defineComponent({
  name: 'BotaView',

  props: ['category'],

  emits: ['toggle-category', 'get-points', 'get-standout-categories'],

  data: function () {
    return {
      tab: '',
      pointToggle1: '',
      pointToggle2: '',
      pointToggle3: '',
      pointToggle4: '',
      points: [] as Result[],
      contentRows: [] as DataRow[][],
      strategyRows: [] as DataRow[][],
      styleRows: [] as DataRow[][],
      cqRows: [] as DataRow[][],
      content: [] as string[],
      strategy: [] as string[],
      style: [] as string[],
      cq: [] as string[],
    };
  },

  mounted() {
    this.loadData();
  },

  methods: {
    //function that collects individual points from subcategories
    onColCLick(value: string, category: number): void {
      //getting the rounded middle number from the selected point range category
      let points = Math.round(
        (Number(value.split('-')[0]) + Number(value.split('-')[1])) / 2
      );
      //going throught the array of selected point categories and if the category is already there, updating its value
      let categoryCheck = true;
      this.points.forEach((val: Result) => {
        if (val.category == category) {
          val.points = points;
          categoryCheck = false;
        }
      });

      //if the category got selected for the first time, adding it to the array
      if (categoryCheck) {
        this.points.push({
          points: points,
          category: category,
        });
      }

      //updating the category in which the button got pressed
      if (this.category == 'Style') value += 'S';
      this.updateCategoryToggle(category, value);

      //the final value gets calculated and emitted after each click (can be changed so it is calculatd only when clicking some confirm button)
      this.emitPoints();
    },

    //function that updates the right toggle based on what button in which category got pressed
    updateCategoryToggle(category: number, value: string): void {
      switch (category) {
        case 1:
          this.pointToggle1 = value;
          break;
        case 2:
          this.pointToggle2 = value;
          break;
        case 3:
          this.pointToggle3 = value;
          break;
        case 4:
          this.pointToggle4 = value;
          break;
      }
    },

    //function that calculates the final points amount from the array and emits the result
    emitPoints(): void {
      let result = 0;
      this.points.forEach((val: Result) => {
        result += val.points;
      });

      //Average of all filled points from subcategories is calculated (that is how we get the number that needs to be added to each missing sub category)
      let difference = Math.round(result / this.points.length);

      //the average of the filled categories is multiplied by the amount of the missing subcategories and then added to the sum of filled points,
      //then divided by 4 making it the average
      result = Math.round((result + difference * (4 - this.points.length)) / 4);

      this.emitStandoutCategories(difference);
      this.$emit('get-points', result);
    },

    //function that finds the point categories that stand out from the average point amount awarded vise and emits them
    emitStandoutCategories(avg: number): void {
      let result = [] as object[];
      let difference = Math.abs(this.points[0].points - avg);
      this.points.forEach((val: Result) => {
        if (Math.abs(val.points - avg) > difference) {
          // this can be fine tuned by being more strict or offering more options
          difference = Math.abs(val.points - avg);
          result.push(val);
        }
      });
      this.$emit('get-standout-categories', result);
    },

    //function that emits the selected category
    toggleCategory(category: string | null): void {
      this.$emit('toggle-category', category);
    },

    //funciton that loads the corrects labels and texts into the arrays
    loadData(): void {
      //titles
      //every category has 4 subcategories which means 4 titles for every category
      this.content = [
        this.$t('bota.category.content.analysis.title'),
        this.$t('bota.category.content.proving.title'),
        this.$t('bota.category.content.impacts.title'),
        this.$t('bota.category.content.reactions.title'),
      ];
      this.strategy = [
        this.$t('bota.category.strategy.structure.title'),
        this.$t('bota.category.strategy.timeWork.title'),
        this.$t('bota.category.strategy.teamWork.title'),
        this.$t('bota.category.strategy.roleFulfillment.title'),
      ];
      this.style = [
        this.$t('bota.category.style.language.title'),
        this.$t('bota.category.style.voice.title'),
        this.$t('bota.category.style.gestures.title'),
        this.$t('bota.category.style.eyeContact.title'),
      ];

      //texts
      //Every category has 4 subcategories and every subcategory has 5 point brackets which means 4 arrays with objects with 5 elements
      this.contentRows = [
        [
          {
            '36-40': this.$t('bota.category.content.analysis.high'),
            '32-35': this.$t('bota.category.content.analysis.midHigh'),
            '28-31': this.$t('bota.category.content.analysis.medium'),
            '24-27': this.$t('bota.category.content.analysis.midLow'),
            '20-23': this.$t('bota.category.content.analysis.low'),
          },
        ],
        [
          {
            '36-40': this.$t('bota.category.content.proving.high'),
            '32-35': this.$t('bota.category.content.proving.midHigh'),
            '28-31': this.$t('bota.category.content.proving.medium'),
            '24-27': this.$t('bota.category.content.proving.midLow'),
            '20-23': this.$t('bota.category.content.proving.low'),
          },
        ],
        [
          {
            '36-40': this.$t('bota.category.content.impacts.high'),
            '32-35': this.$t('bota.category.content.impacts.midHigh'),
            '28-31': this.$t('bota.category.content.impacts.medium'),
            '24-27': this.$t('bota.category.content.impacts.midLow'),
            '20-23': this.$t('bota.category.content.impacts.low'),
          },
        ],
        [
          {
            '36-40': this.$t('bota.category.content.reactions.high'),
            '32-35': this.$t('bota.category.content.reactions.midHigh'),
            '28-31': this.$t('bota.category.content.reactions.medium'),
            '24-27': this.$t('bota.category.content.reactions.midLow'),
            '20-23': this.$t('bota.category.content.reactions.low'),
          },
        ],
      ];

      this.strategyRows = [
        [
          {
            '27-30': this.$t('bota.category.strategy.structure.high'),
            '24-26': this.$t('bota.category.strategy.structure.midHigh'),
            '21-23': this.$t('bota.category.strategy.structure.medium'),
            '18-20': this.$t('bota.category.strategy.structure.midLow'),
            '15-17': this.$t('bota.category.strategy.structure.low'),
          },
        ],
        [
          {
            '27-30': this.$t('bota.category.strategy.timeWork.high'),
            '24-26': this.$t('bota.category.strategy.timeWork.midHigh'),
            '21-23': this.$t('bota.category.strategy.timeWork.medium'),
            '18-20': this.$t('bota.category.strategy.timeWork.midLow'),
            '15-17': this.$t('bota.category.strategy.timeWork.low'),
          },
        ],
        [
          {
            '27-30': this.$t('bota.category.strategy.teamWork.high'),
            '24-26': this.$t('bota.category.strategy.teamWork.midHigh'),
            '21-23': this.$t('bota.category.strategy.teamWork.medium'),
            '18-20': this.$t('bota.category.strategy.teamWork.midLow'),
            '15-17': this.$t('bota.category.strategy.teamWork.low'),
          },
        ],
        [
          {
            '27-30': this.$t('bota.category.strategy.roleFulfillment.high'),
            '24-26': this.$t('bota.category.strategy.roleFulfillment.midHigh'),
            '21-23': this.$t('bota.category.strategy.roleFulfillment.medium'),
            '18-20': this.$t('bota.category.strategy.roleFulfillment.midLow'),
            '15-17': this.$t('bota.category.strategy.roleFulfillment.low'),
          },
        ],
      ];

      this.styleRows = [
        [
          {
            '27-30': this.$t('bota.category.style.language.high'),
            '24-26': this.$t('bota.category.style.language.midHigh'),
            '21-23': this.$t('bota.category.style.language.medium'),
            '18-20': this.$t('bota.category.style.language.midLow'),
            '15-17': this.$t('bota.category.style.language.low'),
          },
        ],
        [
          {
            '27-30': this.$t('bota.category.style.voice.high'),
            '24-26': this.$t('bota.category.style.voice.midHigh'),
            '21-23': this.$t('bota.category.style.voice.medium'),
            '18-20': this.$t('bota.category.style.voice.midLow'),
            '15-17': this.$t('bota.category.style.voice.low'),
          },
        ],
        [
          {
            '27-30': this.$t('bota.category.style.gestures.high'),
            '24-26': this.$t('bota.category.style.gestures.midHigh'),
            '21-23': this.$t('bota.category.style.gestures.medium'),
            '18-20': this.$t('bota.category.style.gestures.midLow'),
            '15-17': this.$t('bota.category.style.gestures.low'),
          },
        ],
        [
          {
            '27-30': this.$t('bota.category.style.eyeContact.high'),
            '24-26': this.$t('bota.category.style.eyeContact.midHigh'),
            '21-23': this.$t('bota.category.style.eyeContact.medium'),
            '18-20': this.$t('bota.category.style.eyeContact.midLow'),
            '15-17': this.$t('bota.category.style.eyeContact.low'),
          },
        ],
      ];
    },
  },

  computed: {
    //function that returns the correct label and data set for the buttons and tables based on the category selected
    getCategory(): CategoryResult {
      let resultTitle = [] as string[];
      let resultRows = [] as DataRow[][];

      switch (this.category) {
        case 'Cont':
          resultTitle = this.content;
          resultRows = this.contentRows;
          break;
        case 'Str':
          resultTitle = this.strategy;
          resultRows = this.strategyRows;
          break;
        case 'Style':
          resultTitle = this.style;
          resultRows = this.styleRows;
          break;
      }
      return { title: resultTitle, rows: resultRows };
    },

    //function that tracks changes in language
    langChange() {
      return this.$i18n.locale;
    },
  },
  watch: {
    //function that updates form each time the language changes
    langChange() {
      this.loadData();
    },
    //function that resets the points array each time category changes
    category(newCategory, oldCategory) {
      if (newCategory != oldCategory) {
        this.points = [];
        this.tab = '1';
      }
    },
  },
});
</script>
