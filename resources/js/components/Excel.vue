<template>
  <v-container grid-list-xs>
    <v-layout row wrap>
      <v-flex xs12 sm12 md12 lg12 xl12>
        <v-card>
          <v-img class="white--text" height="60" src="images/excel-baner.png">
            <v-card-title primary-title>Получить выгрузку в Excel</v-card-title>
          </v-img>
          <v-card-text>
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
                <v-text-field v-model="date" label="Дата" v-on="on" clearable></v-text-field>
              </template>
              <v-date-picker v-model="date" locale="ru" :first-day-of-week="1"></v-date-picker>
            </v-menu>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="success" :disabled="date === null" @click="openLink(`fuel/excel/`)">
              <v-icon>mdi-file-excel</v-icon>Получить Excel документ
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      date: null
    };
  },
  methods: {
    openLink(link) {
      window.open(link + this.date);
    }
  }
};
</script>