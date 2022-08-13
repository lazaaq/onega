<template>
  <div class="textfield" style="width: 100%">
    <input
      :name="name" 
      :id="id" 
      :type="type ? type : 'text'"
      :placeholder="placeholder" 
      style="width: 100%;" 
      @focus="focusInput()"
      @keyup="keyupInput()"
    />
  </div>
</template>

<script>
import jQuery from "jquery";
const $ = jQuery;
window.$ = $;

export default {
  name: "TextField",
  props: [
    'placeholder',
    'name',
    'id',
    'disabled',
    'type'
  ],
  methods: {
    focusInput() {
      this.$emit('focus');
    },
    keyupInput() {
      this.$emit('keyup');
    } 
  },
  data() {
    return {
      
    }
  }
}
</script>

<style>
.textfield input::-webkit-input-placeholder {
  font-size: 11px;
  padding-left: 8px;
}
.textfield input {
  border: 1px solid rgba(0, 0, 0, 0.1);
  padding: 0.8vh 0.3vw 0.8vh 0.3vw;
  font-size: 12px;
}
.disabled {
  background-color: rgba(0,0,0,0.5)
}
</style>