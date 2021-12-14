<template>
    <div id="container">
        <button draggable="true" id="button_1" class="btn-check">
            <router-link to="/login" class="nav-link">User</router-link>
        </button>
        <button draggable="true" id="button_2" class="btn-check">
            <router-link to="/provider/login" class="nav-link">Provider</router-link>
        </button>
    </div>
</template>

<script>
export default {
    name: 'ButtonLogin',
}
</script>


<style scoped>
#button_1 {
  float: left;
  border-radius: 40px;
}
#button_2 {
  float: right;
  border-radius: 40px;
}
</style>