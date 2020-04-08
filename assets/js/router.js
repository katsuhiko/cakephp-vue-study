import Vue from 'vue'
import VueRouter from 'vue-router'

import Home from './components/HomeComponent.vue'
import TaskList from './components/pages/TaskListPage.vue'
import TaskAdd from './components/pages/TaskAddPage.vue'
import TaskEdit from './components/pages/TaskEditPage.vue'

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
  },
  {
    path: '/task/edit/:id',
    component: TaskEdit
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
