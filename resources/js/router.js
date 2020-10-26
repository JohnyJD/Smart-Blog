import Vue from 'vue';
import VueRouter from 'vue-router';
import AllPostsIndex from "./views/AllPostsIndex";
import UserPostsIndex from "./views/UserPostsIndex";
import AllPostsShow from "./views/AllPostsShow";
import UserPostsShow from "./views/UserPostsShow";
import UserPostsEdit from "./views/UserPostsEdit";
import UserPostsCreate from "./views/UserPostsCreate";
import Logout from "./components/Logout";
import AllCategoryFilterIndex from "./views/AllCategoryFilterIndex";
import TestAxios from "./components/TestAxios";

Vue.use(VueRouter);


export default new VueRouter({
    routes: [
        { path: '/' , component: AllPostsIndex },
        { path: '/posts/:id' , component: AllPostsShow },
        { path: '/myPosts' , component: UserPostsIndex },
        { path: '/myPosts/create' , component: UserPostsCreate },
        { path: '/myPosts/:id' , component: UserPostsShow },
        { path: '/myPosts/:id/edit' , component: UserPostsEdit },
        { path: '/logout' , component: Logout },
        { path: '/category/:name' , component: AllCategoryFilterIndex },
        { path: '/test' , component: TestAxios }

    ],
    mode: 'history'
});