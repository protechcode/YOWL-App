<template>
  <div class="wrapper">
    <div class="news">
      <h1>News Feed</h1>
      <!-- <button @click.prevent="showReview" class=" btn btn-primary">+</button> -->
      <ul id="array-rendering">
        <li v-for="(info, id) in infos" :key="id" class="item-container">
          <!-- ID: "{{ info.id }}" Title: "{{ info.title }}" Content: "{{
            info.content
          }}"
          providerId: "{{ info.provider_id }}" -->
          <div class="card">
            <div class="container">
              <p>
                Title: "{{ info.title }}" 
              </p>
              <p>Content: "{{ info.content }}"</p>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "NewsFeed",
  data() {
    return {
      infos: {},
    };
  },
  mounted() {
    this.showReview();
  },
  methods: {
    async showReview() {
      try {
        const headers = {
          "Content-Type": "application/json",
        };
        const response = await axios.get("v1/review/index", {
          headers: headers,
        });

        const datas = response.data; // this level equals a For each register entire data
        this.infos = datas;
      } catch (error) {
        console.log(error);
      }
    },
  },
};
</script>

<style scoped>
h1{
  font: 36px "Genos",  "cursive";
  color:white;
}
.news {
  
  font-size: 24px;
}
.wrapper {
  font: 36px "Genos",  "cursive";
  justify-content: center;

}
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
}
.card {
  background: rgba(255, 255, 255, 0.603);
  border-radius: 20px;
}
.card:hover {
  background: rgba(255, 255, 255, 0.932);
  border-radius: 20px;
  box-shadow: 5px black;
}
/* button { 
  width: 100px;
  align-self: center;
  font-size: 50px;
}
button:active {
  background-color: #0004ff;
  box-shadow: 0 5px #666;
  transform: translateY(4px);
}
 */
</style>