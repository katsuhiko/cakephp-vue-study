<script>
</script>

<template>
  <div>
      <div class="card-body">
        <RouterLink class="navbar" to="/">ホーム</RouterLink>
        |
        <RouterLink class="navbar" to="/task/list">タスク一覧</RouterLink>
        |
        <RouterLink class="navbar" to="/task/add">タスク追加</RouterLink>
      </div>
    <RouterView />
  </div>
</template>
