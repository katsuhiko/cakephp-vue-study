<script>
export default {
  props: {
    task: {
      type: Object
    }
  },
  methods: {
    onSave() {
      this.$emit("save", { task: this.task });
    },
    onDelete() {
      if (!confirm('削除します。')) {
        return;
      }

      this.$emit("delete", { task: this.task });
    },
    onCancel() {
      this.$emit("cancel", { task: this.task });
    }
  }
};
</script>

<template>
  <div class="task-add">
    <form @submit.prevent="onSave">

      <div>タスク概要</div>
      <div><textarea v-model="task.description"></textarea></div>

      <div class="form__button">
        <button type="submit">保存</button>
        <button type="button" @click.prevent="onDelete">削除</button>
        <button type="button" @click.prevent="onCancel">キャンセル</button>
      </div>
    </form>
  </div>
</template>

<style scoped>
</style>
