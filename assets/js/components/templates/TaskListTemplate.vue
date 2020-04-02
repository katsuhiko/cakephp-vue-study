<script>
export default {
  props: {
    tasks: {
      type: Array
    }
  },
  data() {
    return {};
  }
};
</script>

<template>
  <div class="task-list">
    <table>
      <thead>
        <tr>
          <th>タスク概要</th>
          <th>アクション</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="task in tasks" :key="task.id">
          <td>{{ task.description }}</td>
          <td>None</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
</style>
