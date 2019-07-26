<template>
  <v-card>
    <v-card-title>
      Список путевых листов
      <v-spacer></v-spacer>
      <v-text-field
        v-model="search"
        prepend-icon="mdi-table-search"
        label="Поиск"
        single-line
        hide-details
        clearable
      ></v-text-field>
      <v-btn text @click="navigateTo({name: 'Excel'})">Формирование Excel документа</v-btn>
    </v-card-title>
    <v-data-table
      :headers="headers"
      :items="items"
      class="elevation-1"
      :items-per-page="10"
      :search="search"
    >
      <template v-slot:item.check="{ item }">
        <td v-if="item.check === 1">Да</td>
        <td v-if="item.check === 0">Нет</td>
      </template>
      <template v-slot:item.action="{ item }">
        <v-icon @click="editItem(item)">mdi-playlist-edit</v-icon>
      </template>

      <template v-slot:footer>
        <v-app-bar flat>
          <v-spacer></v-spacer>
          <v-btn text small @click="getItems">
            <v-icon>mdi-reload</v-icon>
          </v-btn>
        </v-app-bar>
      </template>
    </v-data-table>

    <Fuel :dialog="dialog" :fuel="editedItem"></Fuel>
    <v-snackbar v-model="snackbar" right bottom :color="colorValue">
      {{ message }}
      <v-btn text @click="snackbar = false">
        <v-icon>mdi-close</v-icon>
      </v-btn>
    </v-snackbar>
  </v-card>
</template>

<script>
import Fuel from "./modals/Fuel";
import { setTimeout } from "timers";
export default {
  data() {
    return {
      headers: [
        {
          text: "ID",
          value: "id"
        },
        {
          text: "Дата",
          value: "date"
        },
        {
          text: "Начальный пробег",
          value: "start_odd"
        },
        {
          text: "Конечный пробег",
          value: "end_odd"
        },
        {
          text: "Топлива в баке",
          value: "fuel"
        },
        {
          text: "Заправлено",
          value: "fueling"
        },
        {
          text: "Ожидания",
          value: "waiting",
          sortable: false
        },
        {
          text: "Подпись",
          value: "check",
          sortable: false
        },
        {
          text: "Функции",
          align: "center",
          value: "action",
          sortable: false
        }
      ],
      items: [],
      editedIndex: -1,
      editedItem: {
        id: 0,
        date: "",
        start_odd: null,
        end_odd: null,
        fuel: null,
        fueling: null,
        waiting: null,
        check: null
      },
      dialog: false,
      search: "",
      snackbar: false,
      message: "",
      colorValue: "info"
    };
  },
  methods: {
    getItems() {
      axios
        .get("fuel")
        .then(response => {
          this.items = response.data;
        })
        .catch(() => {
          this.notification(
            "Попытка получить данные путевых листов",
            "warning"
          );
          this.getItems();
        });
    },
    editItem(item) {
      this.editedIndex = this.items.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },
    notification(text, colorValue) {
      this.message = text;
      this.colorValue = colorValue;
      this.snackbar = true;
    },
    navigateTo(route) {
      this.$router.push(route);
    }
  },
  mounted() {
    this.getItems();
    Event.$on("closeDialog", (item, response) => {
      this.notification(response, item);
      this.dialog = false;
      setTimeout(this.getItems, 500);
      this.getItems();
    });
  },
  components: {
    Fuel
  }
};
</script>
