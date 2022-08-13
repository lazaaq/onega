<template>
  <div
    v-show="this.$store.state.layout !== 'landing'"
    class="card card-plain shadow-none"
    id="sidenavCard">
    <div class="p-3 card-body text-center w-100 pt-0">
    </div>
  </div>
</template>
<script>

export default {
  name: "sidenav-card",
  props: ["textPrimary", "textSecondary", "iconClass"],
  data() {
    return {
      
    };
  }
};
</script>