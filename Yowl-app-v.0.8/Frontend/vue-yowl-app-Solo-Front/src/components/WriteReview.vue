<template>
  <div>
    <div class="wrapper" v-if="user">
      <div class="container">
        <AddComment />
        <h1>new review</h1>
        <form @submit.prevent="sendReview">
          <div class="form-group">
            <label>Title for review</label>
            <input
              type="text"
              class="form-control"
              v-model="title"
              placeholder="Title of review"
              required
            />
          </div>
          <div class="form-group">
            <label>Content</label>
            <input
              type="text"
              class="form-control"
              v-model="content"
              placeholder="Content of review"
              required
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
              required
            />
          </div>
          <button class="btn btn-primary btn-block">Send Review</button>
        </form>
      </div>
      <!-- <div class="container-1">
        
        <div @click.prevent="showComments" class="container">
          <h3>Comments</h3>
          <ul id="array-rendering">
            <li
              v-for="(comentario, id) in comment"
              :key="id"
              class="item-container"
            >
              ID: "{{ comentario.id }}" Title: "{{ comentario.title }}" Content:
              "{{ comentario.content }}"
            </li>
          </ul>
        </div>
      </div> -->
    </div>
    <h3 v-else>Hello, please log in to your account</h3>
  </div>
</template>

<script>
import axios from "axios";
import { mapGetters } from "vuex";
/* import AddComment from './AddComment.vue'
 */ export default {
  name: "WriteReview",
  components: {
    /* AddComment */
  },
  data() {
    return {
      userId: localStorage.getItem("userId"),
      providerId: "",
      infos: {},
      title: "",
      id: "",
      content: "",
      comment: {}, //new line to try to bind comments to review all changes from here may break the app.
      comment_title: "",
      comment_review_id: "",
      //end of new changes
    };
  },
  methods: {
    //new line to try to bind comments to review all changes from here may break the app.
    async showComments() {
      try {
        const headers = {
          "Content-Type": "application/json",
        };
        const responses = await axios.get("/v1/comment/index", {
          headers: headers,
        });
        this.comment = responses.data;
      } catch (error) {
        console.log(error);
      }
    },
    //end of new changes

    async sendReview() {
      const headers = {
        "Content-Type": "application/json",
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
    ...mapGetters(["user"]),
  },
};
</script>

<style scoped>
.wrapper {
  display: flex;
  grid-template-columns: 140px 140px;
  align-content: center;
  justify-content: center;
  gap: 20px;
  min-width: 900px;
  max-height: 340px;
}
.container {
  min-width: fit-content;
  overflow-wrap: break-word;
  align-content: center;
  justify-content: center;
  height: fit-content;
}
.container-1 {
  width: 850px;
}
.item-container {
  margin: 10px;
  padding: 5px;
  align-content: space-between;
}
.form-control {
  width: fit-content;
}
</style>