<template>
  <aside
    class="overflow-auto sidenav navbar navbar-vertical navbar-expand-xs bg-white"
    id="sidenav-main"
    data-color="success"
  >
    <div class="sidenav-header center">
      <i
        class="top-0 p-3 cursor-pointer fas fa-times text-secondary opacity-5 position-absolute end-0 d-none d-xl-none"
        aria-hidden="true"
        id="iconSidenav"
      ></i>
      <router-link class="m-0 navbar-brand text-center" to="/">
        <img
          :src="logofloo"
          class="navbar-brand-img h-100"
        />
      </router-link>
    </div>
    <hr class="mt-0 horizontal dark" />
    <sidenav-list :cardBg="custom_class" />
  </aside>
</template>
<script>
import SidenavList from "./SidenavList.vue";
import logo from "@/assets/img/logo-ct-dark.png";
import logoWhite from "@/assets/img/logo-ct.png";
import logofloo from "@/assets/img/logo-floo.png";

export default {
  name: "index",
  components: {
    SidenavList
  },
  data() {
    return {
      logo,
      logoWhite,
      logofloo
    };
  },
  props: ["custom_class", "layout"]
};
</script>
