<template>
    <div id="container">
        <button draggable="true" id="button_1" class="btn btn-outline-primary">
            <router-link to="/register" class="nav-link">User</router-link>
        </button>
        <button draggable="true" id="button_2" class="btn btn-outline-primary">
            <router-link to="/provider/register" class="nav-link">Provider</router-link>
        </button>
    </div>
</template>

<script>
export default {
    name: 'Button',
}
</script>
<style scoped>
#container{
   border: double 3px rgb(187, 187, 239);
   border-radius: 4px;
}
#buttton_1{
    float: left;
    
}
#button_2{
    float: right;
}
</style>