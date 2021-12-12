<template>
  <div>
    <div class="wrapper" v-if="user">
      <div class="container">
         <AddComment/>
        <h1>new review</h1>
        <form @submit.prevent="sendReview">
          <div class="form-group">
            <label>Title for review</label>
            <input
              type="text"
              class="form-control"
              v-model="title"
              placeholder="Title of review"
            />
          </div>
          <div class="form-group">
            <label>Content</label>
            <input
              type="text"
              class="form-control"
              v-model="content"
              placeholder="Content of review"
            />
          </div>
          <div class="form-group">
            <input class="form-control" type="text" v-model="userId" disabled />
          </div>
          <div class="form-group">
            <label>Provider Id</label>
            <input
              type="text"
              class="form-control"
              v-model="providerId"
              placeholder="Content of review"
            />
          </div>
          <button class="btn btn-primary btn-block">Send Review</button>
        </form>
      </div>
      <div @click="showReview" class="container">
        <h2>click</h2>
        <div>
      
          <ul id="array-rendering">
            <li v-for="(info, id) in infos" :key="id" class="item-container">
              ID: "{{info.id}}"
              Title: "{{ info.title }}"
              Content: "{{info.content}}"
              </li>
          </ul>
          
        </div>
        <div @click="showComments" class="container">
            <h3>Comments</h3>
            
              <ul id="array-rendering">
                <li v-for="(comentario, id) in comment" :key="id" class="item-container">
                  ID: "{{comentario.id}}"
                  Title: "{{ comentario.title }}"
                  Content: "{{comentario.content}}"
                </li>
              </ul>
          </div>
         
      </div>

      
    </div>
       
      


    <h3 v-else>Hello, please log in to your account</h3>
  </div>
</template>
<script>
import axios from "axios";
import { mapGetters } from "vuex";
import AddComment from './AddComment.vue'

export default {
  name: "WriteReview",
  components:{
    AddComment
  },
  data() {
    return {
      userId: localStorage.getItem("userId"),
      providerId: "",
      infos: {},
      title: "",
      id:"",
      content: "",
      comment: {},//new line to try to bind comments to review all changes from here may break the app.
      comment_title: "",
      comment_review_id:"",
      //end of new changes
    };
  },
  methods: {
    //new line to try to bind comments to review all changes from here may break the app.
    async showComments(){
      try{
        const headers = {
        'Content-Type': "application/json",
        
      };
        const responses = await axios.get("/v1/comment/index",{
          headers:headers,
        });
        this.comment = responses.data;

       
      }catch(error){
        console.log(error)
      }
    },
    //end of new changes
    async showReview() {
      try {
         const headers = {
        'Content-Type': "application/json",
        
      };
        const responses = await axios.get("/v1/review/index",{
          headers:headers,
        });
        const datas = responses.data; // this level equals a For each register entire data
        this.infos = datas;
        
        
      

     /*    const title = data.review.title; //this level give us only the title of the register
        this.title = title; */

       /*  const content = data.review.content;
        this.content = content; */

        
      } catch (error) {
        console.log(error);
      }
    },
    async sendReview() {
      const headers = {
        'Content-Type': "application/json",
        
      };
      try {
        const response = await axios.post("/v1/review", {
          headers: headers,
          title: this.title,
          content: this.content,
          user_id: this.userId,
          provider_id: this.providerId,
        });
        console.log(response);
      } catch (error) {
        console.log(error);
      }
    },
  },
   computed: {
    ...mapGetters(['user'])
  }
};
</script>
<style scoped>
.wrapper {
  border: dotted 3px red;
  display: grid;
  grid-template-columns: 140px 140px;
  align-content: space-between;
  justify-content: space-between;
  gap: 20px;
  min-width: 900px;
  max-height: 340px;
  overflow: scroll;
  
}
.container {
  border: solid 3px yellow;
  min-width: fit-content;
  overflow-wrap: break-word;
}
.item-container{
  border: dotted 5px blue;
  margin: 10px;
  padding: 5px;
  align-content: space-between;
}
.form-control{
  width:fit-content;
}
</style>