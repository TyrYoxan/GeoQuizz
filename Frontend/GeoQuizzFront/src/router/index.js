import { createRouter, createWebHistory } from 'vue-router';
import Home from '@/components/Home.vue';
import Login from '@/components/Login.vue';
import CreateGame from '@/components/CreateGame.vue';
import PublicSequences from '@/components/PublicSequences.vue';

const routes = [
  { path: '/', component: Home },
  { path: '/home', name: 'Home', component: Home },
  { path: '/login', name: 'Login', component: Login },
  { path: '/create-game', name: 'CreateGame', component: CreateGame },
  { path: '/public-sequences', name: 'PublicSequences', component: PublicSequences },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;