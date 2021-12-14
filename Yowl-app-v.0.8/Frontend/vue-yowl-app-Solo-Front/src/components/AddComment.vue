<template>
  <div class="comment-wrapper">
    <h1>Add a comment</h1>
    <div class="container">
      <form @submit.prevent="addComment">
        <div class="form-group">
          <label>Title for comment</label>
          <input
            type="text"
            class="form-control"
            v-model="title"
            placeholder="Title of comment"
            required
          />
        </div>
        <div class="form-group">
          <label>Content of comment</label>
          <input
            type="text"
            class="form-control"
            v-model="content"
            placeholder="content of comment"
            required
          />
        </div>
        <div class="form-group">
          <label>Attached to review id:</label>
          <input
            type="text"
            class="form-control"
            v-model="review_id"
            placeholder="Insert Id"
            required
          />
        </div>
        <div class="form-group">
          <input class="form-control" type="text" v-model="userId" disabled />
        </div>
        <button class="btn btn-primary btn-block">Send comment</button>
      </form>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import axios from "axios";

export default {
  name: "AddComment",
  data() {
    return {
      title: "",
      content: "",
      review_id: "",
      userId: localStorage.getItem("userId"),
    };
  },
  methods: {
    async addComment() {
      const response = await axios.post("v1/comment", {
        title: this.title,
        content: this.content,
        review_id: this.review_id,
        user_id: this.userId,
      });
      console.log(response)
    },
  },
    computed: {
    ...mapGetters(['user'])
  }
};
</script>

<style scoped>
.comment-wrapper {
  border: orange solid 4px;
}
.container {
  border: solid 3px green;
  min-width: fit-content;
  overflow-wrap: break-word;
}
.form-control {
  width: fit-content;
}
</style>