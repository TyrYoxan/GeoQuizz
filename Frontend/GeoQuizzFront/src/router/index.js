import {createRouter, createWebHistory} from "vue-router";
import Home from '../views/Home.vue'
import Partie from '../views/Partie.vue'
import Auth from '../views/Authentification.vue'
import Profile from "../views/Profile.vue";
import Stats from "../views/Stats.vue";
import { inject } from 'vue'

const routes = [
  {path: '/', redirect: '/home'},
  { path: '/home', component: Home },
  { path: '/partie', component: Partie },
  { path: '/Authentification', component: Auth },
  { path: '/profile', component: Profile },
  { path: '/stats', component: Stats },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;