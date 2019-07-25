<template>
  <v-app>
    <v-app-bar color="white" app>
      <v-img
        :src="`images/logo.png`"
        :lazy-src="`images/logo.png`"
        max-width="160px"
        max-height="40px"
        class="logo"
        @click="navigateTo({name: 'AddForm'})"
      ></v-img>
      <v-spacer></v-spacer>
      <v-btn text @click="navigateTo({name: 'EditFuel'})">Список путевых листов</v-btn>
    </v-app-bar>
    <v-content>
      <v-container fluid>
        <router-view></router-view>
      </v-container>
    </v-content>
    <v-footer app></v-footer>
  </v-app>
</template>

<script>
export default {
  name: "App",
  components: {},
  methods: {
    navigateTo(route) {
      this.$router.push(route);
    }
  },
  mounted() {}
};
</script>

<style>
#app {
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}
.logo:hover {
  cursor: pointer;
}
</style>
