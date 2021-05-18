<template>
  <div class="loading">
    <div class="spinner-border" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>
</template>

<script>
export default {
  name: "Loading",
};
</script>

<style>
.loading {
  display: flex;
  justify-content: center;
  padding-top: 50px;
}
</style>