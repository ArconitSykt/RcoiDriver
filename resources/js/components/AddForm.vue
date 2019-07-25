<template>
  <v-container grid-list-xs>
    <v-card>
      <v-card-title>Добавление показателей нового путевого листа</v-card-title>
      <v-card-text>
        <v-layout row wrap>
          <v-flex xs12 sm12 md12 lg12 xl12>
            <v-menu
              :close-on-content-click="false"
              :nudge-right="40"
              transition="scale-transition"
              offset-y
              full-width
              max-width="290px"
              min-width="290px"
            >
              <template v-slot:activator="{ on }">
                <v-text-field
                  v-model="fuel.date"
                  label="Дата"
                  v-on="on"
                  prepend-icon="mdi-calendar"
                  clearable
                ></v-text-field>
              </template>
              <v-date-picker v-model="fuel.date" locale="ru" :first-day-of-week="1"></v-date-picker>
            </v-menu>
          </v-flex>
        </v-layout>
        <v-layout row wrap>
          <v-flex xs12 sm12 md6 lg6 xl6>
            <v-text-field
              v-model.number="fuel.start_odd"
              label="Начальные показатели одометра"
              disabled
              prepend-icon="mdi-speedometer"
            ></v-text-field>
          </v-flex>
          <v-flex xs12 sm12 md6 lg6 xl6 pl-2>
            <v-text-field
              v-model.number="fuel.end_odd"
              label="Конечные показатели одометра"
              :rules="[() => fuel.start_odd<fuel.end_odd || 'Проверьте правильность заполнения поля']"
              required
              prepend-icon="mdi-speedometer"
            ></v-text-field>
          </v-flex>
        </v-layout>
        <v-layout row wrap>
          <v-flex xs12 sm12 md6 lg6 xl6>
            <v-text-field v-model="fuel.fuel" label="Топлива при выезде" prepend-icon="mdi-fuel"></v-text-field>
          </v-flex>
          <v-flex xs12 sm12 md6 lg6 xl6 pl-2>
            <v-text-field v-model="fuel.fueling" label="Заправлено" prepend-icon="mdi-gauge"></v-text-field>
          </v-flex>
        </v-layout>
        <v-layout row wrap>
          <v-flex xs12 sm12 md6 lg6 xl6>
            <v-text-field
              v-model="fuel.waiting"
              label="Часов ожидания"
              prepend-icon="mdi-account-clock"
            ></v-text-field>
          </v-flex>
          <v-flex xs12 sm12 md6 lg6 xl6 pl-2>
            <v-switch
              v-model="fuel.check"
              color="success"
              :label="`Лист подписан: ${(fuel.check === true)?'Да':'Нет'}`"
            ></v-switch>
          </v-flex>
        </v-layout>
      </v-card-text>
      <v-card-actions>
        <v-btn
          color="success"
          :disabled="!formValidator"
          @click="saveData"
          prepend-icon="mdi-content-save-outline"
        >
          <v-icon>mdi-content-save-outline</v-icon>Сохранить
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-container>
</template>
<script>
export default {
  data() {
    return {
      fuel: {
        date: null,
        start_odd: null,
        end_odd: null,
        fuel: null,
        fueling: "0",
        waiting: "0",
        check: false
      }
    };
  },
  computed: {
    formValidator() {
      if (this.fuel.start_odd > this.fuel.end_odd) {
        return false;
      }
      if (this.fuel.date === null) {
        return false;
      } else {
        return true;
      }
    }
  },
  methods: {
    saveData() {
      this.fuel.fuel = this.fuel.fuel.replace(/,/g, `.`);
      this.fuel.fueling = this.fuel.fueling.replace(/,/g, `.`);
      this.fuel.waiting = this.fuel.waiting.replace(/,/g, `.`);
      axios
        .post("fuel/create", {
          fuel: this.fuel
        })
        .then(response => {
          alert("Успешно сохранено");
          this.fuel.end_odd = "0";
          this.fuel.fueling = "0";
          this.fuel.waiting = "0";
          this.fuel.check = false;
          this.getLast();
        })
        .catch(() => {
          alert("SAVE ERROR!");
        });
    },
    getLast() {
      axios
        .get("fuel/last")
        .then(response => {
          this.fuel.start_odd = response.data.end_odd;
          this.fuel.fuel = response.data.afterFuel;
        })
        .catch(() => {
          this.getLast();
        });
    }
  },
  mounted() {
    this.getLast();
  }
};
</script>
