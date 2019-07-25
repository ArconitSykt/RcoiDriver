<template>
  <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
    <v-card>
      <v-app-bar>
        <v-btn icon @click="close">
          <v-icon>mdi-close</v-icon>
        </v-btn>
        <v-toolbar-title>Редактирование</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn class icon @click="save">
          <v-icon>mdi-content-save-outline</v-icon>
        </v-btn>
      </v-app-bar>
      <v-card-text>
        <v-container grid-list-xs>
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
          <v-layout row wrap>
            <v-flex xs12 sm12 md6 lg6 xl6>
              <v-text-field
                v-model.number="fuel.start_odd"
                label="Начальные показатели одометра"
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
        </v-container>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  props: {
    dialog: Boolean,
    fuel: Object
  },
  methods: {
    close() {
      Event.$emit("closeDialog", 0);
    },
    save() {
      axios
        .post("fuel/update", {
          fuel: this.fuel
        })
        .then(response => {
          Event.$emit("closeDialog", "success", "Успешно изменено");
        })
        .catch(() => {
          Event.$emit("closeDialog", "error", "Ошибка при изменении");
        });
    }
  }
};
</script>