<template>
  <div class="wrapper">
    <div class="container-1">
      <h3>Hello USER</h3>
      <h3>¿What do you want to do?</h3>
      <div class="”container-3”">
        <button draggable="true" id="button_1" class="btn btn-outline-primary">
          <router-link to="/review" class="nav-link">New Review</router-link>
        </button>
        <button draggable="true" id="button_2" class="btn btn-outline-primary">
          <router-link to="/news" class="nav-link">News Feed</router-link>
        </button>
        <!-- <NewReview />
        <NewsFeed /> -->
      </div>
    </div>
    <!-- <div class="container-2">
      <h3>Your Reviews</h3>
    </div> -->
  </div>
</template>

<script>
export default {
  name: "Profile",
};
</script>


<style scoped>
button {
    background: white;
    margin: 15px;
}
button:hover{
    width: 150px;
    color: white;
    margin: 15px;
}

.wrapper {
  height: 500 px;
/*border: dotted 3px red; */
  display: grid;
  grid-template-columns: 140px 140px;
  align-content: center;
  justify-content: center;
  gap: 20px;
  min-width: 900px;
  max-height: 340px;
  /* overflow: scroll; */
}
.container-1 {
  align-content: space-between;
  gap: 20px;
  /* border: solid 3px yellow; */
  min-width: fit-content;
  overflow-wrap: break-word;
  width: 350px;


}
/* .container-2 {
  border: solid 3px rgb(0, 255, 179);
  min-width: fit-content;
  overflow-wrap: break-word;
} */
.container-1 .container-3 {
    border: solid 3px black;
    display: inline-block;

}

.item-container {
  margin: 10px;
  padding: 5px;
  justify-content: space-between;
}
.form-control {
  width: fit-content;
}
</style>
