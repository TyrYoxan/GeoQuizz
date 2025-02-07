import {createRouter, createWebHistory} from "vue-router";
import Home from '../views/Home.vue'
import Partie from '../views/Partie.vue'
import Auth from '../views/Authentification.vue'
import Profile from "../views/Profile.vue";
import Stats from "../views/Stats.vue";
import CreatePartie from "@/views/CreatePartie.vue";

const routes = [
  {path: '/', redirect: '/home'},
  { path: '/home', component: Home },
  { path: '/partie/:id', name: 'partie', component: Partie },
  { path: '/Authentification', component: Auth },
  { path: '/profile', component: Profile },
  { path: '/stats', component: Stats },
  { path: '/createPArtie', component: CreatePartie}
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;