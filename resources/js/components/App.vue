<template>
    <div>
        <div id="arrow" class="toggle-menu" @click="toggleMenu">
            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><path style="fill:#84DBFF;" d="M512,256.001c0,20.361-11.68,37.862-30.491,45.662L68.412,473.08
    c-17.036,7.068-36.766,4.295-51.312-8.29C2.859,452.46-3.101,433.449,1.559,415.198L38.33,271.002l3.82-15.001L38.33,241
    L1.559,96.805c-4.66-18.251,1.3-37.262,15.541-49.592c14.084-12.185,33.727-15.586,51.312-8.29L481.509,210.34
    C500.32,218.14,512,235.641,512,256.001z"/><path style="fill:#54C9EB;" d="M38.331,271.002L1.559,415.198c-4.66,18.251,1.3,37.261,15.541,49.592
    c14.546,12.586,34.276,15.359,51.312,8.29l413.097-171.417c18.811-7.8,30.491-25.301,30.491-45.662H42.151L38.331,271.002z"/><path style="fill:#EFEFEF;" d="M233.349,256.001c0,8.28-6.71,15.001-15.001,15.001H38.331l3.82-15.001L38.331,241h180.017
    C226.638,241.001,233.349,247.721,233.349,256.001z"/><path style="fill:#C5D8DF;" d="M38.331,271.002h180.017c8.29,0,15.001-6.72,15.001-15.001H42.151L38.331,271.00z"/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
        </div>
        <div class="top flex-justify-align">

                <div class="logo">
                    <router-link to="/" class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" width="218" height="227.161" viewBox="0 0 218 227.161"><g transform="translate(-9.8)"><path d="M144.694,198.509v6.637a10.527,10.527,0,0,1-8.928,10.423l-1.636,6.03a7.5,7.5,0,0,1-7.245,5.562H110.667a7.5,7.5,0,0,1-7.245-5.562l-1.589-6.03a10.574,10.574,0,0,1-8.974-10.47v-6.637a6.383,6.383,0,0,1,6.4-6.4h39.029A6.453,6.453,0,0,1,144.694,198.509Zm30.054-89.462a55.68,55.68,0,0,1-15.7,38.842A51.318,51.318,0,0,0,145.3,175.746a9.253,9.253,0,0,1-9.161,7.806H101.412a9.164,9.164,0,0,1-9.114-7.759,51.887,51.887,0,0,0-13.835-27.951,55.956,55.956,0,1,1,96.286-38.8ZM125.11,75.16a6.314,6.314,0,0,0-6.31-6.31,40.425,40.425,0,0,0-40.384,40.384,6.31,6.31,0,1,0,12.62,0A27.8,27.8,0,0,1,118.8,81.47,6.284,6.284,0,0,0,125.11,75.16ZM118.8,34.729a6.313,6.313,0,0,0,6.31-6.31V6.31a6.31,6.31,0,1,0-12.62,0V28.419A6.314,6.314,0,0,0,118.8,34.729ZM44.529,109a6.314,6.314,0,0,0-6.31-6.31H16.11a6.31,6.31,0,0,0,0,12.62H38.219A6.284,6.284,0,0,0,44.529,109Zm176.961-6.31H199.381a6.31,6.31,0,0,0,0,12.62H221.49a6.31,6.31,0,1,0,0-12.62ZM57.382,161.537,41.724,177.2a6.3,6.3,0,0,0,8.881,8.928l15.658-15.658a6.3,6.3,0,1,0-8.881-8.928Zm118.395-103.2a6.3,6.3,0,0,0,4.44-1.823l15.658-15.658a6.313,6.313,0,0,0-8.928-8.928L171.29,47.582a6.291,6.291,0,0,0,0,8.928A6.409,6.409,0,0,0,175.777,58.333ZM57.382,56.463a6.3,6.3,0,0,0,8.881-8.928L50.6,31.877A6.313,6.313,0,0,0,41.677,40.8ZM180.218,161.537a6.313,6.313,0,1,0-8.928,8.928l15.658,15.658a6.3,6.3,0,0,0,8.881-8.928Z" fill="#00ceff"/></g></svg>
                        <h1 class="blue-color">SMART BLOG</h1>
                    </router-link>
                </div>


                <nav v-if="user" class="top-navigation">
                    <router-link to="/myPosts" class="blue-color">
                        My posts
                    </router-link>
                    <router-link to="/myPosts/create" class="blue-color">
                        Create post
                    </router-link>
                    <router-link to="/logout" class="blue-color">
                        Logout
                    </router-link>
                </nav>
                <nav v-else class="top-navigation">
                    <a href="/login" class="blue-color">Login</a>
                    <a href="/register" class="blue-color">Register</a>
                </nav>


                <div v-if="this.user != null" class="user-info">
                    <p>Welcome : {{this.user.name}}</p>
                </div>

        </div>

        <div class="main-content flex">
            <div id="menu" class="left-side">
                <!-- Search bar -->


                <div class="categories">
                    <h2 class="blue-color">Categories</h2>
                    <CategoryComponent @posts:category="posts = $event"></CategoryComponent>
                </div>

                <!--<div class="filters">
                    <h2 class="blue-color">Sort</h2>
                    <p>by date</p>
                    <p>by views</p>
                    <p>by comments</p>
                </div>-->

            </div>


            <div class="right-side">
                <router-view :user="this.user" :postsUpdate="this.posts"></router-view>
            </div>
        </div>

        <div class="footer blue-color-bg">
            <div class="logo-white">
                <router-link to="/" class="flex-justify-align">
                    <svg xmlns="http://www.w3.org/2000/svg" width="218" height="227.16" viewBox="0 0 218 227.16"><g transform="translate(-9.8)"><path d="M144.694,198.508v6.637a10.527,10.527,0,0,1-8.928,10.423l-1.636,6.03a7.5,7.5,0,0,1-7.245,5.562H110.667a7.5,7.5,0,0,1-7.245-5.562l-1.589-6.03a10.574,10.574,0,0,1-8.974-10.47v-6.637a6.383,6.383,0,0,1,6.4-6.4h39.029A6.453,6.453,0,0,1,144.694,198.508Zm30.054-89.462a55.68,55.68,0,0,1-15.7,38.842A51.317,51.317,0,0,0,145.3,175.745a9.253,9.253,0,0,1-9.161,7.806H101.412a9.164,9.164,0,0,1-9.114-7.759,51.887,51.887,0,0,0-13.835-27.951,55.956,55.956,0,1,1,96.286-38.795ZM125.11,75.159a6.314,6.314,0,0,0-6.31-6.31,40.424,40.424,0,0,0-40.384,40.384,6.31,6.31,0,0,0,12.62,0A27.8,27.8,0,0,1,118.8,81.469,6.284,6.284,0,0,0,125.11,75.159ZM118.8,34.728a6.313,6.313,0,0,0,6.31-6.31V6.31a6.31,6.31,0,0,0-12.62,0V28.418A6.313,6.313,0,0,0,118.8,34.728ZM44.529,109a6.313,6.313,0,0,0-6.31-6.31H16.11a6.31,6.31,0,1,0,0,12.62H38.219A6.284,6.284,0,0,0,44.529,109Zm176.961-6.31H199.381a6.31,6.31,0,1,0,0,12.62H221.49a6.31,6.31,0,1,0,0-12.62ZM57.382,161.536,41.724,177.194a6.3,6.3,0,0,0,8.881,8.928l15.658-15.658a6.3,6.3,0,0,0-8.881-8.927Zm118.395-103.2a6.3,6.3,0,0,0,4.44-1.823l15.658-15.658a6.313,6.313,0,0,0-8.928-8.927L171.29,47.582a6.291,6.291,0,0,0,0,8.927A6.409,6.409,0,0,0,175.777,58.332ZM57.382,56.463a6.3,6.3,0,1,0,8.881-8.927L50.6,31.877A6.313,6.313,0,0,0,41.677,40.8ZM180.218,161.536a6.313,6.313,0,1,0-8.928,8.927l15.658,15.658a6.3,6.3,0,1,0,8.881-8.928Z" transform="translate(0)" fill="#fff"/></g></svg>
                    <h1 class="white">SMART BLOG</h1>
                </router-link>
            </div>
            <div class="border-white"></div>
            <h3 class="white">Powered by <b>Laravel</b> and <b>Vue.js</b></h3>
            <h3 class="white">© Copyright by <b>Ján Dunaj</b></h3>
        </div>
    </div>
</template>

<script>
    import CategoryComponent from "./CategoryComponent"
    export default {
        name: "App",
        props: [
            'user'
        ],
        data: function() {
            return {
                'posts' : []
            }
        },
        components: {
            CategoryComponent
        },
        created() {
            if(this.user) {
                window.axios.interceptors.request.use(
                    (config) => {
                        if(config.method === 'get') {
                            config.url = config.url + '?api_token=' + this.user.api_token;
                        }
                        if(config.method === 'patch') {
                            alert("patch");
                        }
                        return config;
                    }
                )
            }
        },
        methods: {
            toggleMenu: function() {
                let menu = document.getElementById('menu');
                let arrow = document.getElementById('arrow');
                if(menu.classList.contains("open")) {
                    menu.classList.remove("open");
                    arrow.classList.remove("open");

                } else {
                    menu.classList.add("open");
                    arrow.classList.add("open");
                }


            }
        }

    }
</script>

<style scoped>
    .flex, .flex-justify, .flex-align, .flex-justify-align  {
        display: flex;
    }
    .flex-justify, .flex-justify-align {
        justify-content: center;
    }
    .flex-align, .flex-justify-align {
        align-items: center;
    }
    a {
        text-decoration: none;
    }
    .blue-color {
        color: #00CEFF;
    }
    .blue-color-bg {
        background: #00CEFF;
    }
    .white {
        color: white;
    }


    .toggle-menu {
        position: fixed;
        top: 20px;
        left: 5px;
        cursor: pointer;
        z-index: 20;
        -webkit-transition: transform .3s;
        -moz-transition: transform .3s;
        -ms-transition: transform .3s;
        -o-transition: transform .3s;
        transition: transform .3s;
        display: none;
    }
    .toggle-menu svg {
        width: 20px;
        height: auto;
    }
    #arrow.open {
        transform: rotate(180deg);
    }
    .top {
        border-bottom: 1px solid #D8D8D8;
        padding: 10px 0;
        position: relative;
    }
    .logo, .top-navigation {
        width: 45%;
    }
    .logo {
        position: relative;
        z-index: 1;
    }
    .logo svg {
        width: 70px;
        height: auto;
    }
    .logo h1 {
        font-size: 2em;
        padding: 0 10px;
    }
    .top-navigation {
        text-align: right;
    }
    .top-navigation a {
        font-size: 1.3em;
        padding-left: 15px;
        font-weight: bold;
        -webkit-transition: color .3s;
        -moz-transition: color .3s;
        -ms-transition: color .3s;
        -o-transition: color .3s;
        transition: color .3s;
    }
    .top-navigation a:hover {
        color: #0081ff;
    }
    .user-info {
        position: absolute;
        width: 90%;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        text-align: right;
        color: #009eff;
        font-size: .9em;
        margin-top: 5px;
    }
    .user-info p {
        padding: 0;
        margin: 0;
    }


    .main-content {
        width: 90%;
        margin: 30px auto;
    }
    .left-side {
        width: 25%;
        padding-right: 30px;
    }
    .right-side {
        width: 75%;
    }
    .filters {
        margin-top: 50px;
    }
    .categories h2 {
        margin-top: 0;
    }
    .filters {
        color: #717171;
    }
    .filters p {
        border-top: 1px solid rgba(112, 112, 112, 0.51);
        padding: 15px 0;
        margin: 0;
    }
    .filters p:first-of-type {
        border-top: none;
    }

    @media only screen and (max-width: 900px) {
        .toggle-menu {
            display: block;
        }
        .left-side {
            position: fixed;
            background: white;
            left: -280px;
            top: 0;
            padding-left: 20px;
            height: 100vh;
            overflow-y: scroll;
            z-index: 5;
            width: 230px;
            transition: left .3s;
            padding-top: 50px;
        }
        .left-side.open {
            left: 0;
        }
        .right-side {
            width: 100%;
        }
        .logo svg {
            width: 60px;
            height: auto;
        }
        .logo h1 {
            font-size: 1.4em;
            padding: 0 10px;
        }
        .top-navigation a {
            font-size: 1em;
        }
        .user-info {
            font-size: .8em;
        }
    }


    .footer {
        padding: 30px 0;
    }
    .logo-white {
        margin: auto;
    }
    .logo-white svg {
        width: 50px;
        height: auto;
    }
    .logo-white h1 {
        font-size: 2em;
        padding: 0 10px;
    }

    .border-white {
        width: 40%;
        height: 2px;
        background: white;
        margin: 20px auto;
    }
    .footer h3 {
        font-weight: normal;
        font-size: 1em;
        text-align: center;
    }



</style>