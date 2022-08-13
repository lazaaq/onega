<template>
  <div class="wrap-tabs d-flex">
    <div v-for="(val, index) in tabs" :key="index" class="wrap-tab" :class="index+1 == activeTab ? 'active' : ''">
      <button @click="updateActiveTab(index)" class="tab">Tab {{ index + 1 }}</button>
      <button type="button" class="x-button ms-1" @click="closeTab(index)" v-if="tabs > 1">
        <img src="@/assets/icon/delete-black.png" style="width: 7px;">
      </button>
    </div>
    <div class="d-flex align-items-center px-2" v-if="plusButton"><button class="plus-button" @click="addTab()">+</button></div>
  </div>
</template>

<script>
export default {
  name: "CashierTab",
  props: [
    'activeTab'
  ],
  methods: {
    addTab: function() {
      this.tabs += 1;
      if (this.tabs >= 15) {
        this.plusButton = false
      }
      this.$emit('addtab', this.tabs);
    },
    updateActiveTab: function (index) {
      this.$emit('changetab', index+1);
    },
    closeTab: function (index) {
      if (this.tabs == 15) {
        this.plusButton = true
      }
      this.tabs -= 1;
      this.$emit('closetab', index);
    }
  },
  data() {
    return {
      tabs: 1,
      plusButton: true,
    }
  }
}
</script>

<style>
.wrap-tab {
  background-color: rgba(255, 255, 255, 0.6);
  font-size: 10px;
  font-weight: 500;
  width: fit-content;
  padding: 0.4rem 0.8rem;
}
.wrap-tab.active {
  background-color: white!important;
}
.wrap-tab .tab {
  border: 0;
  background-color: transparent;
  padding: 0;
}
.wrap-tab.active .tab {
  color:#047E92;
}
.wrap-tabs .x-button {
  border: 0;
  background-color: transparent;
  padding: 0;
  color: rgba(0, 0, 0, 0.2);
}

.wrap-tabs .plus-button {
  color: #047E92;
  border: 0;
  background-color: transparent;
  padding: 0;
}
</style>