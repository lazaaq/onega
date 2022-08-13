import { createRouter, createWebHistory } from "vue-router";
import Teams from "../views/Teams.vue";
import Task from "../views/Task.vue";
import Recruitment from "../views/Recruitment.vue";
import Term from "../views/Term.vue";
import Profile from "../views/Profile.vue";
import Signup from "../views/Signup.vue";
import Signin from "../views/Signin.vue";

const routes = [
  {
    path: "/",
    name: "/",
    redirect: "/teams",
  },
  {
    path: "/teams",
    name: "Teams",
    component: Teams,
  },
  {
    path: "/task",
    name: "Task",
    component: Task,
  },
  {
    path: "/recruitment",
    name: "Recruitment",
    component: Recruitment,
  },
  {
    path: "/term",
    name: "Term and Conditions",
    component: Term,
  },
  {
    path: "/profile",
    name: "Profile",
    component: Profile,
  },
  {
    path: "/signin",
    name: "Signin",
    component: Signin,
  },
  {
    path: "/signup",
    name: "Signup",
    component: Signup,
  },
  
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
  linkActiveClass: "active",
});

export default router;
