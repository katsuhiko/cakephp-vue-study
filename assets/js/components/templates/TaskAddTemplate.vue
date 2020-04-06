<script>
export default {
  data() {
    return {
      task: {
        description: ''
      }
    };
  },
  methods: {
    onSave() {
      this.$emit("save", { task: this.task });
    }
  }
};
</script>

<template>
  <div class="task-add">
    <form @submit.prevent="onSave">
      <div>タスク概要</div>
      <textarea v-model="task.description"></textarea>
      <div class="form__button">
        <button type="submit">保存</button>
      </div>
    </form>
  </div>
</template>

<style scoped>
</style>
