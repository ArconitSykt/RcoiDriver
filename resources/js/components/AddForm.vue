<template>
  <v-container grid-list-xs>
    <v-card flat raised>
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
              :rules="[() => fuel.start_odd < fuel.end_odd || 'Проверьте правильность заполнения поля']"
              required
              prepend-icon="mdi-speedometer"
            ></v-text-field>
          </v-flex>
        </v-layout>
        <v-layout row wrap>
          <v-flex xs12 sm12 md6 lg6 xl6>
            <v-text-field
              v-model="fuel.fuel"
              label="Топлива при выезде"
              :rules="[() => fuel.fuel > 0 || 'Проверьте правильность заполнения поля']"
              required
              prepend-icon="mdi-fuel"
            ></v-text-field>
          </v-flex>
          <v-flex xs12 sm12 md6 lg6 xl6 pl-2>
            <v-text-field
              v-model="fuel.fueling"
              label="Заправлено"
              :rules="[() => fuel.fueling >= 0 || 'Проверьте правильность заполнения поля']"
              required
              prepend-icon="mdi-gauge"
            ></v-text-field>
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
        <v-spacer></v-spacer>
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
    <v-snackbar v-model="snackbar" right bottom :color="colorValue">
      {{ message }}
      <v-btn text @click="snackbar = false">
        <v-icon>mdi-close</v-icon>
      </v-btn>
    </v-snackbar>
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
      },
      snackbar: false,
      message: "",
      colorValue: "info"
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
          this.notification("Успешно сохранено", "success");
          this.fuel.date = null;
          this.fuel.end_odd = "0";
          this.fuel.fueling = "0";
          this.fuel.waiting = "0";
          this.fuel.check = false;
          this.getLast();
        })
        .catch(() => {
          this.notification("Ошибка сохранения", "error");
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
          this.notification(
            "Попытка получить данные последнего путевого листа",
            "warning"
          );
          this.getLast();
        });
    },
    notification(text, colorValue) {
      this.message = text;
      this.colorValue = colorValue;
      this.snackbar = true;
    }
  },
  mounted() {
    this.getLast();
  }
};
</script>
