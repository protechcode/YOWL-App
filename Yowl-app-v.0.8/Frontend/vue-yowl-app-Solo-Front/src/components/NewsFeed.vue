<template>
  <div class="wrapper">
    
    <div @click.prevent="showReview">
    <h1>News Feed</h1>
      <ul id="array-rendering">
        <li v-for="(info, id) in infos" :key="id" class="item-container">
          ID: "{{ info.id }}" Title: "{{ info.title }}" Content: "{{
            info.content
          }}"
          providerId: "{{ info.provider_id }}"
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
      infos: {

      },
    };
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
