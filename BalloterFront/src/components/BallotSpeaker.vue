<template>
  <q-expansion-item
    :label="$t('ballotF.speakers.' + speaker)"
    :caption="person == null ? '' : person?.name + ' ' + person?.surname"
    header-class="text-h6"
  >
    <div class="row justify-center">
      <!--Speaker select-->
      <div class="col-grow">
        <q-select
          style="min-width: 250px"
          class="q-pa-sm"
          ref="person"
          outlined
          v-model="person"
          :label="
            $t('ballotF.speakers.speaker') +
            ' ' +
            $t('ballotF.speakers.' + speaker)
          "
          :options="team?.team_members"
          :option-label="
            (speakerOpt) =>
              speakerOpt == null
                ? ''
                : speakerOpt.name + ' ' + speakerOpt.surname
          "
          @update:model-value="emitValues()"
          ><!--Mluvčí...-->

          <template v-slot:prepend>
            <q-icon name="badge" />
          </template>
        </q-select>
      </div>

      <!--Stop watch for the N2 and A2 gets shown on the same line as speaker select-->
      <div
        class="col-grow justify-center text-center"
        v-if="speaker == 'A2' || speaker == 'N2'"
      >
        <StopWatch
          class="q-mt-sm q-pb-xs"
          :dense="true"
          :speach="speaker"
          :toggle="toggleTimer"
          :innitData="timerData"
          @tick="(timer) => $emit('timer-tick', timer)"
        />
      </div>
    </div>

    <div class="row justify-center" v-if="speaker != 'A2' && speaker != 'N2'">
      <!--Speach Timer for Speaker-->
      <div class="col-grow justify-center text-center">
        <StopWatch
          class="q-mt-sm q-pb-xs"
          :dense="true"
          :speach="speaker"
          :toggle="toggleTimer"
          :innitData="timerData"
          @tick="(timer) => $emit('timer-tick', timer)"
        />
      </div>
      <!--Speach Timer for Speaker for CQ-->
      <div class="col-grow justify-center text-center">
        <StopWatch
          class="q-mt-sm q-pb-xs"
          :dense="true"
          :speach="getCQRole()"
          :toggle="toggleCQTimer"
          :innitData="timerCQData"
          @tick="(timer) => $emit('timer-CQ-tick', timer)"
        />
      </div>
    </div>

    <div class="row">
      <!--Comment-->
      <div class="col-grow">
        <q-input
          class="q-pa-sm q-mb-md"
          ref="comment"
          outlined
          bottom-slots
          v-model="comment"
          type="textarea"
          :label="$t('ballotF.speakers.comment')"
          :shadow-text="comment.length == 0 ? comment_hint : ''"
          lazy-rules
          :rules="[$rules.required]"
          :debounce="text_refresh_rate"
          @update:model-value="emitValues()"
          ><!--Komentář-->

          <template v-slot:prepend>
            <q-icon name="comment" />
          </template>

          <!--Comment Icons based on amount of characters filled-->
          <template v-slot:hint>
            <q-icon
              v-if="comment.length < comment_char_goal && comment.length > 0"
              name="more_horiz"
              size="50px"
              style="transform: translateY(-20px)"
            />
            <q-icon
              v-if="comment.length == 0"
              name="close"
              size="25px"
              style="transform: translateY(-8px)"
              color="negative"
            />
            <q-icon
              v-if="comment.length >= comment_char_goal"
              name="done"
              size="25px"
              style="transform: translateY(-8px)"
              color="positive"
            />
          </template>

          <!--Comment Character Counter-->
          <template v-slot:counter>
            <p
              :class="{
                'text-negative': comment.length < comment_char_goal,
                'text-positive': comment.length >= comment_char_goal,
              }"
            >
              {{ comment.length - comment_char_goal }}
            </p>
          </template>
        </q-input>
      </div>
    </div>

    <div class="row">
      <!--Content Points-->
      <div class="col-grow">
        <q-input
          class="q-pa-sm"
          style="max-width: 150px"
          ref="cont_points"
          :class="hasError('cont_points') ? 'q-pb-xl' : ''"
          outlined
          v-model="cont_points"
          type="number"
          :label="$t('ballotF.speakers.content')"
          lazy-rules
          :rules="[$rules.noLetters, $rules.contPoints]"
          :debounce="num_refresh_rate"
          @update:model-value="
            (sum_points = getSpeakerPointSum()),
              !loading ? (cont_bool = true) : void 0,
              cqCalculation(),
              emitValues()
          "
          ><!--Obsah-->

          <template v-slot:append>
            <q-btn
              @click="toggleBotaCategories('Cont')"
              icon="help"
              flat
              round
              dense
              ><q-tooltip>
                {{ $t('ballotF.speakers.tooltip.content') }}
              </q-tooltip>
              <!--Prohlédněte si BOTA o Obsahu a naklikejte body-->
            </q-btn>
          </template>
        </q-input>
      </div>

      <!--Strategy Points-->
      <div class="col-grow">
        <q-input
          class="q-pa-sm"
          :class="hasError('str_points') ? 'q-pb-xl' : ''"
          style="max-width: 150px"
          ref="str_points"
          outlined
          v-model="str_points"
          type="number"
          :label="$t('ballotF.speakers.strategy')"
          lazy-rules
          :rules="[$rules.noLetters, $rules.strPoints]"
          :debounce="num_refresh_rate"
          @update:model-value="
            (sum_points = getSpeakerPointSum()),
              !loading ? (str_bool = true) : void 0,
              cqCalculation(),
              emitValues()
          "
          ><!--Strategie-->

          <template v-slot:append>
            <q-btn
              @click="toggleBotaCategories('Str')"
              icon="help"
              flat
              round
              dense
              ><q-tooltip>
                {{ $t('ballotF.speakers.tooltip.strategy') }}
              </q-tooltip>
              <!--Prohlédněte si BOTA o Strategii a naklikejte body-->
            </q-btn>
          </template>
        </q-input>
      </div>

      <!--Style Points-->
      <div class="col-grow">
        <q-input
          class="q-pa-sm"
          :class="hasError('style_points') ? 'q-pb-xl' : ''"
          style="max-width: 150px"
          ref="style_points"
          outlined
          v-model="style_points"
          type="number"
          :label="$t('ballotF.speakers.style')"
          lazy-rules
          :rules="[$rules.noLetters, $rules.stylePoints]"
          :debounce="num_refresh_rate"
          @update:model-value="
            (sum_points = getSpeakerPointSum()),
              !loading ? (style_bool = true) : void 0,
              cqCalculation(),
              emitValues()
          "
          ><!--Styl-->

          <template v-slot:append>
            <q-btn
              @click="toggleBotaCategories('Style')"
              icon="help"
              flat
              round
              dense
              ><q-tooltip>
                {{ $t('ballotF.speakers.tooltip.style') }}
              </q-tooltip>
              <!--Prohlédněte si BOTA o Stylu a naklikejte body-->
            </q-btn>
          </template>
        </q-input>
      </div>

      <!--Cross Question Points-->
      <div class="col-grow">
        <q-input
          class="q-pa-sm"
          :class="hasError('cq_points') ? 'q-pb-xl' : ''"
          style="max-width: 150px"
          ref="cq_points"
          outlined
          v-model="cq_points"
          type="text"
          :label="$t('ballotF.speakers.cq')"
          lazy-rules
          :rules="[$rules.isCq, $rules.cqPoints]"
          :debounce="num_refresh_rate"
          @update:model-value="cqCalculation(), emitValues()"
          ><!--Křížový výslech-->

          <template v-slot:append>
            <q-btn icon="help" flat round dense>
              <q-tooltip> {{ $t('ballotF.speakers.tooltip.cq') }} </q-tooltip>
              <!--Uh oh, křížové otázky-->
            </q-btn>
          </template>
        </q-input>
      </div>

      <!--Sum of Points-->
      <div class="col-grow">
        <q-input
          class="q-pa-sm"
          :class="hasError('sum_points') ? 'q-pb-xl' : ''"
          style="max-width: 150px"
          ref="sum_points"
          outlined
          readonly
          v-model="sum_points"
          type="number"
          :label="$t('ballotF.speakers.sum')"
          lazy-rules
          :rules="[]"
          ><!--Součet bodů A1-->
        </q-input>
      </div>
    </div>
    <div class="row justify-center" v-if="botaToggle != null">
      <BotaView
        :category="botaToggle"
        @toggle-category="toggleBotaCategories"
        @get-points="getBotaPoints"
        @get-standout-categories="commentAdvice"
      />
    </div>
  </q-expansion-item>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { Result, Person, Speaker, Sentence } from './models';
import { QInput } from 'quasar';
import BotaView from './BotaView.vue';
import StopWatch from './StopWatch.vue';

export default defineComponent({
  name: 'BallotSpeaker',

  components: {
    BotaView,
    StopWatch,
  },

  props: [
    'speaker',
    'team',
    'id',
    'innitData',
    'toggleTimer',
    'toggleCQTimer',
    'timerData',
    'timerCQData',
  ],

  emits: ['get-values', 'timer-tick', 'timer-CQ-tick'],

  data: function () {
    return {
      num_refresh_rate: 500,
      text_refresh_rate: 1000,
      botaToggle: null as string | null,
      person: null as Person | null,
      comment_char_goal: 150,
      comment: '',
      comment_hint: '',
      cont_points: 20,
      cont_bool: false,
      cq_points: '0',
      sum_points: 0,
      str_points: 15,
      str_bool: false,
      style_points: 15,
      style_bool: false,
      loading: true,
      commentArr: [] as Sentence[],
    };
  },

  created() {
    //loading initial values
    this.loadInitValues();
    //emiting loaded values so the parent catches them and saves them
    this.emitValues();
  },

  methods: {
    //function that loads initial values passed from the parent
    loadInitValues(): void {
      this.loading = true;
      if (this.innitData != null) {
        if (this.innitData.role == this.speaker) {
          this.person = this.innitData.person_id;
          this.comment = this.innitData.comment;
          this.cont_points = Number(this.innitData.cont_points);
          this.str_points = Number(this.innitData.str_points);
          this.style_points = Number(this.innitData.style_points);
          this.sum_points =
            Number(this.innitData.cont_points) +
            Number(this.innitData.str_points) +
            Number(this.innitData.cq_points) +
            Number(this.innitData.style_points);
          //If the CQ points are over 0, plus gets added
          if (Number(this.innitData.cq_points) > 0) {
            this.cq_points = '+' + this.innitData.cq_points;
          } else this.cq_points = this.innitData.cq_points;
        }
      }
      this.loading = false;
    },

    //Function that emits all the important values to the parent
    emitValues(): void {
      if (Number(this.cq_points) > 100) this.cq_points = '100';
      let person = undefined;
      if (this.person != null) person = this.person;
      const values: Partial<Speaker> = {
        person_id: person,
        id: this.person?.id,
        role: this.speaker,
        comment: this.comment,
        cont_points: this.cont_points,
        str_points: this.str_points,
        style_points: this.style_points,
        cq_points: Number(this.cq_points),
        author: 0,
        best_speaker: 0,
      };

      this.$emit('get-values', values);
    },

    //function that adds or converts the points for Cross Examination based on the input type
    cqCalculation(): void {
      if (
        this.cq_points.includes('+') ||
        this.cq_points.includes('-') ||
        this.cq_points == '0'
      ) {
        this.sum_points = this.getSpeakerPointSum();
      } else {
        //CQ points conversion - the logic in this might not be the best, can be changed
        if (this.cont_bool && this.str_bool && this.style_bool) {
          //this gets calculated only when all other values have been filled
          let sum = //sum of points apart from cq
            Number(this.cont_points) +
            Number(this.str_points) +
            Number(this.style_points);
          sum = Math.round(sum / 5 - 10); //adapting the sum of points to the range of 1 - 10
          let sum_diff = sum - 5; //comparing the sum againsts the middle value
          let cq_diff = Number(this.cq_points) - 5; //comparing the CQ score against the middle value
          if (sum_diff - cq_diff < 0) {
            //if the difference is negative it means the CQ was better than the speach
            this.cq_points =
              '+' + Math.round(Math.abs(sum_diff - cq_diff) / 2).toString(); //we are returning half of the difference on the > 0 side (adding points)
          }
          if (sum_diff - cq_diff > 0) {
            //if the difference is positive it means the CQ was worse than the speach
            this.cq_points =
              '-' + Math.round(Math.abs(sum_diff - cq_diff) / 2).toString(); //we are returning half of the difference on the < 0 side (deducting points)
          } //it's a half cause we are operating on 1 - 10 scale but we need to adjust to -5 - 5 scale
          if (sum_diff - cq_diff == 0) {
            //zero means the speach and CQ averaged out and the speaker gets a 0
            this.cq_points = '0';
          }
          this.sum_points = this.getSpeakerPointSum();
        }
      }
    },

    //functions that hides or shows and switches between different BOTA categories
    toggleBotaCategories(category: string): void {
      if (this.botaToggle == category) {
        this.botaToggle = null;
      } else this.botaToggle = category;
    },

    //function that gets the points the user chose when browsing BOTA and saves them into the form into the right category
    getBotaPoints(points: number): void {
      switch (this.botaToggle) {
        case 'Cont':
          this.cont_points = points;
          this.cont_bool = true;
          break;
        case 'Str':
          this.str_points = points;
          this.str_bool = true;
          break;
        case 'Style':
          this.style_points = points;
          this.style_bool = true;
          break;
      }

      //calling the sum calculation after each points change
      this.getSpeakerPointSum();
    },

    //Function that advices the adjudicator what to write into personal comments if they didn't write anything
    commentAdvice(results: Result[]): void {
      let result = '';
      let category = '';
      let content = '';
      let subcontent = '';

      if (this.comment.length == 0 && results.length != 0) {
        result = this.$t('ballotF.speakers.advice.title'); //Můžete zmínit třeba něco z kategorie

        switch (this.botaToggle) {
          case 'Cont':
            category = 'Cont';
            content = this.$t('ballotF.speakers.advice.content.title'); //Obsah, o řečníkově
            results.forEach((res: Result) => {
              switch (res.category) {
                case 1:
                  if (subcontent.length != 0) subcontent += ', ';
                  subcontent +=
                    this.$t('ballotF.speakers.advice.content.analysis') +
                    res.points +
                    this.$t('ballotF.speakers.advice.points'); //analýze. (uděleno ' + res.points + ' bodů)
                  break;
                case 2:
                  if (subcontent.length != 0) subcontent += ', ';
                  subcontent +=
                    this.$t('ballotF.speakers.advice.content.proving') +
                    res.points +
                    this.$t('ballotF.speakers.advice.points'); //dokazování. (uděleno ' + res.points + ' bodů)
                  break;
                case 3:
                  if (subcontent.length != 0) subcontent += ', ';
                  subcontent +=
                    this.$t('ballotF.speakers.advice.content.impacts') +
                    res.points +
                    this.$t('ballotF.speakers.advice.points'); //dopadech. (uděleno ' + res.points + ' bodů)
                  break;
                case 4:
                  if (subcontent.length != 0) subcontent += ', ';
                  subcontent +=
                    this.$t('ballotF.speakers.advice.content.reactions') +
                    res.points +
                    this.$t('ballotF.speakers.advice.points'); //reakcích. (uděleno ' + res.points + ' bodů)
                  break;
              }
            });
            this.sentenceInsert(category, content, subcontent);
            category = '';
            content = '';
            subcontent = '';
            break;
          case 'Str':
            category = 'Str';
            content = this.$t('ballotF.speakers.advice.strategy.title'); //Strategie, o řečníkově
            results.forEach((res: Result) => {
              switch (res.category) {
                case 1:
                  if (subcontent.length != 0) subcontent += ', ';
                  subcontent +=
                    this.$t('ballotF.speakers.advice.strategy.structure') +
                    res.points +
                    this.$t('ballotF.speakers.advice.points'); //struktuře. (uděleno ' + res.points + ' bodů)
                  break;
                case 2:
                  if (subcontent.length != 0) subcontent += ', ';
                  subcontent +=
                    this.$t('ballotF.speakers.advice.strategy.timeWork') +
                    res.points +
                    this.$t('ballotF.speakers.advice.points'); //práci s časem. (uděleno ' + res.points + ' bodů)
                  break;
                case 3:
                  if (subcontent.length != 0) subcontent += ', ';
                  subcontent +=
                    this.$t('ballotF.speakers.advice.strategy.teamWork') +
                    res.points +
                    this.$t('ballotF.speakers.advice.points'); //týmové práci. (uděleno ' + res.points + ' bodů)
                  break;
                case 4:
                  if (subcontent.length != 0) subcontent += ', ';
                  subcontent +=
                    this.$t(
                      'ballotF.speakers.advice.strategy.roleFulfillment'
                    ) +
                    res.points +
                    this.$t('ballotF.speakers.advice.points'); //naplnění role. (uděleno ' + res.points + ' bodů)
                  break;
              }
            });
            this.sentenceInsert(category, content, subcontent);
            category = '';
            content = '';
            subcontent = '';
            break;
          case 'Style':
            category = 'Style';
            content = this.$t('ballotF.speakers.advice.style.title');
            results.forEach((res: Result) => {
              switch (res.category) {
                case 1:
                  if (subcontent.length != 0) subcontent += ', ';
                  subcontent +=
                    this.$t('ballotF.speakers.advice.style.language') +
                    res.points +
                    this.$t('ballotF.speakers.advice.points'); //jazyku. (uděleno ' + res.points + ' bodů)
                  break;
                case 2:
                  if (subcontent.length != 0) subcontent += ', ';
                  subcontent +=
                    this.$t('ballotF.speakers.advice.style.voice') +
                    res.points +
                    this.$t('ballotF.speakers.advice.points'); //hlasu a dikce. (uděleno ' + res.points + ' bodů)
                  break;
                case 3:
                  if (subcontent.length != 0) subcontent += ', ';
                  subcontent +=
                    this.$t('ballotF.speakers.advice.style.gestures') +
                    res.points +
                    this.$t('ballotF.speakers.advice.points'); //gestech. (uděleno ' + res.points + ' bodů)
                  break;
                case 4:
                  if (subcontent.length != 0) subcontent += ', ';
                  subcontent +=
                    this.$t('ballotF.speakers.advice.style.eyeContact') +
                    res.points +
                    this.$t('ballotF.speakers.advice.points'); //očním kontaktu a emocích. (uděleno ' + res.points + ' bodů)
                  break;
              }
            });
            this.sentenceInsert(category, content, subcontent);
            category = '';
            content = '';
            subcontent = '';
            break;
        }
        this.comment_hint = result;
        this.commentArr.forEach((sentence) => {
          this.comment_hint += sentence.content + sentence.subcontent;
        });
      }
    },

    //function that inserts proper value into sommentArray, used by commentAdvice function
    sentenceInsert(
      category: string,
      content: string,
      subcontent: string
    ): void {
      let included = false;

      this.commentArr.forEach((sentence) => {
        if (sentence.category == category) {
          sentence.content = '\n- ' + content;
          sentence.subcontent = subcontent;
          included = true;
        }
      });

      if (!included) {
        const sentence = {
          category: category,
          content: '\n- ' + content,
          subcontent: subcontent,
        };

        this.commentArr.push(sentence);
      }
    },

    //function that returns the sum of points for speakers
    getSpeakerPointSum() {
      return (
        Number(this.cont_points) +
        Number(this.str_points) +
        Number(this.cq_points) +
        Number(this.style_points)
      );
    },

    //function that returns the error state of the given qinput element
    hasError(element: keyof typeof QInput) {
      let result = false;
      if (!this.loading)
        try {
          result = (this.$refs[element] as typeof QInput).hasError;
        } catch {}
      return result;
    },

    //function that returns proper type of CQ for the speaker
    getCQRole(): string | undefined {
      switch (this.speaker) {
        case 'A1':
          return 'A1xN2';
        case 'N1':
          return 'N1xA2';
        case 'A3':
          return 'A3xN1';
        case 'N3':
          return 'N3xA1';
      }
      return undefined;
    },
  },
});
</script>
