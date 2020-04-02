<script>
import TaskListTemplate from "../templates/TaskListTemplate.vue";

export default {
  components: {
    TaskListTemplate
  },
  data() {
    return {
      tasks: []
    };
  },
  methods: {
    async fetchTasks() {
      const response = await axios.get(`/api/ca-task/search.json`);
      if (response.status !== 200) {
        return false;
      }
      this.tasks = response.data.data;
    }
  },
  watch: {
    $route: {
      async handler() {
        await this.fetchTasks();
      },
      immediate: true
    }
  }
};
</script>

<template>
  <task-list-template :tasks="tasks"></task-list-template>
</template>
