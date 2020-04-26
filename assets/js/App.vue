<script>
</script>

<template>
  <div>
    <div class="card-body">
      <RouterLink class="navbar" to="/">トップ</RouterLink>
      |
      <RouterLink class="navbar" to="/task/list">タスク一覧</RouterLink>
      |
      <RouterLink class="navbar" to="/task/add">タスク追加</RouterLink>
      |
      <a href="/users/logout" class="navbar">ログアウト</a>
    </div>
    <RouterView />
  </div>
</template>
