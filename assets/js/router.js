import Vue from 'vue'
import VueRouter from 'vue-router'

import Home from './components/HomeComponent.vue'
import TaskList from './components/pages/TaskListPage.vue'
import TaskAdd from './components/pages/TaskAddPage.vue'

Vue.use(VueRouter)

// パスとコンポーネントのマッピング
const routes = [
  {
    path: '/',
    component: Home
  },
  {
    path: '/task/list',
    component: TaskList
  },
  {
    path: '/task/add',
    component: TaskAdd
  }
]

// VueRouterインスタンスを作成する
const router = new VueRouter({
  mode: 'history',
  routes
})

// VueRouterインスタンスをエクスポートする
// app.jsでインポートするため
export default router
