<template>
  <button class="cari-btn">{{ text }}</button>
</template>

<script>
export default {
  name: "ButtonField",
  props: [
    'text'
  ]
}
</script>

<style>
.cari-btn {
  border-style: none!important;
  background-color: #079FB7;
  color: white;
  font-size: 11px;
  font-weight: 600;
  font-style: italic;
  padding: 5px 15px 5px 15px;
  width: 100%;
  height: 100%;
  border-radius: 4px;
}
</style>