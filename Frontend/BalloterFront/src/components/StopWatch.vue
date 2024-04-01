<template>
  <q-card
    flat
    bordered
    :dark="
      speach == 'APrep' || speach == 'NPrep'
        ? $q.dark.isActive
          ? false
          : true
        : $q.dark.isActive
        ? true
        : false
    "
    class="q-ma-xs q-mx-sm"
    :class="
      speach == 'APrep' || speach == 'NPrep'
        ? $q.dark.isActive
          ? 'bg-black'
          : 'bg-dark'
        : $q.dark.isActive
        ? 'bg-dark'
        : ''
    "
    :style="{ borderColor: outOfTime }"
  >
    <q-card-section horizontal>
      <q-card-actions horizontal class="justify-around">
        <!--Start Button -->
        <q-btn
          :dense="dense"
          outline
          round
          icon="play_arrow"
          @click="startCounting()"
        />
      </q-card-actions>

      <q-space />

      <q-item :dense="dense">
        <q-item-section>
          <q-item-label style="cursor: pointer">
            <!--Time Display -->
            {{ formattedTime }}

            <q-tooltip> {{ $t('ballotF.stopwatch.tooltip') }} </q-tooltip>
            <!--Kliknutím nastavte časovač ručně -->

            <!--The Time Picker popup-->
            <q-popup-proxy
              @before-show="updateProxy"
              cover
              transition-show="scale"
              transition-hide="scale"
            >
              <q-time
                v-model="proxyTime"
                :color="timerMode?.color"
                text-color="black"
                with-seconds
                mask="HH:mm:ss"
              >
                <div class="row items-center justify-end q-gutter-sm">
                  <q-btn
                    :label="$t('ballotF.stopwatch.timePicker.cancel')"
                    color="light-blue-13"
                    flat
                    v-close-popup
                  /><!--Zrušit-->
                  <q-btn
                    :label="$t('ballotF.stopwatch.timePicker.ok')"
                    color="light-blue-13"
                    flat
                    @click="save"
                    v-close-popup
                  /><!--Ok-->
                </div>
              </q-time>
            </q-popup-proxy>
          </q-item-label>

          <!--The label of the timer -->
          <q-item-label caption :class="'text-' + colorAdjust()">
            {{ timerMode?.title }}
          </q-item-label>
        </q-item-section>
      </q-item>

      <q-space />

      <q-card-actions horizontal class="justify-around items-center">
        <!--Pause button -->
        <q-btn
          :dense="dense"
          outline
          round
          icon="pause"
          @click="stopCounting()"
        />
      </q-card-actions>
    </q-card-section>
  </q-card>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { SpeachTime, TimerData } from './models';
export default defineComponent({
  name: 'StopWatch',

  props: ['speach', 'dense', 'stopWatch', 'toggle', 'innitData'],

  emits: ['tick'],

  data: function () {
    return {
      time: 0,
      proxyTime: '',
      speaches: {} as Record<
        | 'APrep'
        | 'NPrep'
        | 'A1'
        | 'A2'
        | 'A3'
        | 'N1'
        | 'N2'
        | 'N3'
        | 'N3xA1'
        | 'A3xN1'
        | 'N1xA2'
        | 'A1xN2',
        SpeachTime
      >,
      timerMode: null as SpeachTime | null,
      timer: undefined as undefined | NodeJS.Timeout,
      started: false,
      SWMode: false,
    };
  },

  created() {
    this.loadValues();
    this.setTimerMode();
    this.setStopWatchMode();

    //loading data from autosave in case ther are any, it can possibly act messed up when switching stopwatch modes
    if (this.innitData != null) this.time = this.innitData;
  },

  methods: {
    //function that prepares all needed values
    loadValues(): void {
      let minute = 60;
      //setting the time limits for different types of speaches
      const timeLimits = {
        Speach: 6 * minute,
        NPrep: 7 * minute,
        CQ: 3 * minute,
        APrep: 5 * minute,
        ThirdSpeach: 5 * minute,
      };

      //setting the two colours for each team
      let AColor = 'lime-6';
      let NColor = 'orange-13';

      //setting the objects with all the infor for different kind of timers possible
      this.speaches = {
        APrep: {
          title: this.$t('ballotF.stopwatch.prepA'), //Přípravný čas - A
          limit: timeLimits.APrep,
          color: AColor,
        },
        NPrep: {
          title: this.$t('ballotF.stopwatch.prepN'), //Přípravný čas - N
          limit: timeLimits.NPrep,
          color: NColor,
        },
        A1: {
          title: this.$t('ballotF.stopwatch.A1'), //První řeč - A1
          limit: timeLimits.Speach,
          color: AColor,
        },
        A2: {
          title: this.$t('ballotF.stopwatch.A2'), //Druhá řeč - A2
          limit: timeLimits.Speach,
          color: AColor,
        },
        A3: {
          title: this.$t('ballotF.stopwatch.A3'), //Třetí řeč - A3
          limit: timeLimits.ThirdSpeach,
          color: AColor,
        },
        N1: {
          title: this.$t('ballotF.stopwatch.N1'), //První řeč - N1
          limit: timeLimits.Speach,
          color: NColor,
        },
        N2: {
          title: this.$t('ballotF.stopwatch.N2'), //Druhá řeč - N2
          limit: timeLimits.Speach,
          color: NColor,
        },
        N3: {
          title: this.$t('ballotF.stopwatch.N3'), ////Třetí řeč - N3
          limit: timeLimits.ThirdSpeach,
          color: NColor,
        },
        N3xA1: {
          title: this.$t('ballotF.stopwatch.N3xA1'), //Křížový výslech - N3 → A1
          limit: timeLimits.CQ,
          color: AColor,
        },
        A3xN1: {
          title: this.$t('ballotF.stopwatch.A3xN1'), //Křížový výslech - A3 → N1
          limit: timeLimits.CQ,
          color: NColor,
        },
        N1xA2: {
          title: this.$t('ballotF.stopwatch.N1xA2'), //Křížový výslech - N1 → A2
          limit: timeLimits.CQ,
          color: AColor,
        },
        A1xN2: {
          title: this.$t('ballotF.stopwatch.A1xN2'), //Křížový výslech - A1 → N2
          limit: timeLimits.CQ,
          color: NColor,
        },
      };
    },

    //function that sets proper time limits and labels for the timer based on the input prop
    setTimerMode(): void {
      if (this.speach != null) {
        switch (this.speach) {
          case 'APrep':
            this.timerMode = this.speaches.APrep;
            break;
          case 'NPrep':
            this.timerMode = this.speaches.NPrep;
            break;
          case 'A1':
            this.timerMode = this.speaches.A1;
            break;
          case 'A2':
            this.timerMode = this.speaches.A2;
            break;
          case 'A3':
            this.timerMode = this.speaches.A3;
            break;
          case 'N1':
            this.timerMode = this.speaches.N1;
            break;
          case 'N2':
            this.timerMode = this.speaches.N2;
            break;
          case 'N3':
            this.timerMode = this.speaches.N3;
            break;
          case 'N3xA1':
            this.timerMode = this.speaches.N3xA1;
            break;
          case 'A3xN1':
            this.timerMode = this.speaches.A3xN1;
            break;
          case 'N1xA2':
            this.timerMode = this.speaches.N1xA2;
            break;
          case 'A1xN2':
            this.timerMode = this.speaches.A1xN2;
            break;
        }
      }
    },

    //function that sets the starting values in case this is in timer or stopwatch mode
    setStopWatchMode() {
      this.SWMode = this.stopWatch;

      if (this.SWMode) {
        this.time = 0;
      } else if (this.timerMode != null) this.time = this.timerMode.limit;
    },

    //function that starts the stopwatch
    startCounting(): void {
      if (!this.started) {
        this.timer = setInterval(() => {
          //switching between timer and countdown mode
          if (!this.SWMode) {
            this.time--;
          } else this.time++;
        }, 1000);
      }
      this.started = true;
    },

    //function that stops the stopwatch
    stopCounting(): void {
      clearInterval(this.timer);
      this.started = false;
      this.emitTime(); //emitting stopped values once
    },

    //function that emits the data to the parent
    emitTime(): void {
      let timeVar = this.time;
      if (this.SWMode && this.outOfTime != '') timeVar = timeVar * -1; //this is done because the timer flips into counter mode once it reaches zero
      if (this.timerMode != null) {
        const result: TimerData = {
          limit: this.timerMode.limit,
          time: timeVar,
          speach: this.speach,
          color: this.timerMode.color,
          running: this.started,
        };

        this.$emit('tick', result);
      }
    },

    //function that updates the time for the time picker (initial value)
    updateProxy(): void {
      const date = new Date();
      date.setMinutes(0);
      date.setHours(0);
      date.setSeconds(this.time);
      //it needs HH:mm:ss so i am doing this
      const formatter = new Intl.DateTimeFormat('cs', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
      });
      this.proxyTime = formatter.format(date);
    },

    //function that saves the chosen time from the time picker to the time variable
    save(): void {
      let result =
        Number(this.proxyTime.split(':')[0]) * 60 * 60 +
        Number(this.proxyTime.split(':')[1]) * 60 +
        Number(this.proxyTime.split(':')[2]);
      this.time = result;
    },

    //function that adjusts the colour based on the type of stopwatch used
    colorAdjust(): string | undefined {
      let color = this.timerMode?.color;
      if (
        color == 'lime-6' &&
        this.$q.dark.isActive == false &&
        this.dense == true
      ) {
        return 'light-blue-13';
      } else return color;
    },
  },

  computed: {
    //function that returns formatted time values out of amount of seconds
    formattedTime(): string {
      const date = new Date();
      let result = '';
      date.setMinutes(0);
      date.setHours(0);
      date.setSeconds(this.time);
      if (date.getHours() > 0) {
        result =
          date.getHours() +
          ' : ' +
          date.getMinutes() +
          ' : ' +
          date.getSeconds();
      }
      if (date.getMinutes() > 0) {
        result = date.getMinutes() + ' : ' + date.getSeconds();
      } else result = date.getSeconds().toString();
      if (this.SWMode && this.outOfTime != '') result = '-' + result;
      return result;
    },

    //function that returns the colour for the case when the timer runs over the limit
    outOfTime(): string {
      let result = '';
      if (this.speach != 'APrep' && this.speach != 'NPrep') {
        result = 'silver';
      }
      if (!this.stopWatch) {
        if (this.time <= 0) {
          result = '#C10015';
        }
      } else if (this.timerMode != null && this.time >= this.timerMode.limit) {
        result = '#C10015';
      }
      return result;
    },

    //function that tracks changes in language
    langChange() {
      return this.$i18n.locale;
    },

    //function that tracks changes in toggling the timer
    toggleTimer() {
      return this.toggle;
    },
  },

  watch: {
    //function that flips the stopwatch into stop watch mode when it reaches the zero and emits the time every second
    time(newTime): void {
      if (!this.SWMode) {
        if (newTime == 0) {
          this.SWMode = true;
        }
      }

      this.emitTime();
    },

    //function that updates form each time the language changes
    langChange(): void {
      this.loadValues();
      this.setTimerMode();
    },

    //function that starts or stops the timer based on input
    toggleTimer() {
      if (this.started) {
        this.stopCounting();
      } else this.startCounting();
    },
  },
});
</script>
