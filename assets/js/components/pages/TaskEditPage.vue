<script>
import TaskEditTemplate from "../templates/TaskEditTemplate.vue";

export default {
  components: {
    TaskEditTemplate
  },
  data() {
    return {
      task: {}
    }
  },
  async mounted() {
    const response = await axios.get(`/api/ca-task/view/${this.$route.params.id}.json`);
    if (response.status !== 200) {
      alert('取得に失敗しました。');
       return;
     }

    this.task = response.data.data;
  },
  methods: {
    async onSave(event) {
      const response = await axios.put(`/api/ca-task/update/${this.$route.params.id}.json`, event.task);
      if (response.status !== 200) {
        alert('保存に失敗しました。');
        return;
      }

      alert('保存しました。');
      this.$router.push({ path: '/task/list' });
    },
    async onDelete(event) {
      const response = await axios.delete(`/api/ca-task/delete/${this.$route.params.id}.json`);
      if (response.status !== 204) {
        alert('削除に失敗しました。');
        return;
      }

      alert('削除しました。');
      this.$router.push({ path: '/task/list' });
    },
    onCancel(event) {
      this.$router.push({ path: '/task/list' });
    }
  }
};
</script>

<template>
  <task-edit-template :task="task" @save="onSave($event)" @delete="onDelete($event)" @cancel="onCancel($event)"></task-edit-template>
</template>
