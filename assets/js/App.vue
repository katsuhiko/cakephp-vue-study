<script>
</script>

<template>
  <div>
      <div class="card-body">
        <RouterLink class="navbar" to="/">ホーム</RouterLink>
        |
        <RouterLink class="navbar" to="/tasks">タスク一覧</RouterLink>
        |
        <RouterLink class="navbar" to="/tasks">タスク追加</RouterLink>
      </div>
    <RouterView />
  </div>
</template>
