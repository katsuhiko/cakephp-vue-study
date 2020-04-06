<script>
import TaskAddTemplate from "../templates/TaskAddTemplate.vue";

export default {
  components: {
    TaskAddTemplate
  },
  methods: {
    async onSave(event) {
      const response = await axios.post(`/api/ca-task/create.json`, event.task);
      if (response.status !== 200) {
        alert('保存に失敗しました。');
        return;
      }

      alert('保存しました。');
      this.$router.push({ path: '/task/list' });
    }
  }
};
</script>

<template>
  <task-add-template @save="onSave($event)"></task-add-template>
</template>
