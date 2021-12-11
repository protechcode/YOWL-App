<template>
  <div @click="showReview">
    <h2>click</h2>
    <div>
      <ul id="array-rendering">
        <li v-for="(info, id) in infos" :key="id">
          {{ info}}
        </li>
    
      </ul>
      <p :title="title">{{title}}</p>
      <p :content="content">{{content}}</p>
    </div>
  </div>
</template>
<script>
import axios from "axios";
export default {
  name: "WriteReview",
  data() {
    return {
      infos:{},
      title:"",
      content:''
    };
  },
  methods: {
    async showReview() {
      try {
        const responses = await axios.get("/v1/review/index");
        const data = responses.data;
        
        const title = data.review.title;
        this.infos = data.review;
        this.title = title

        const content = data.review.content;
        this.content = content;

      
       console.log(title);
        
      } catch (error) {
        console.log(error);
      }
    },
  },
};
</script>