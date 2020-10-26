<template>
    <div>
        <div class="post-wrap">
            <div class="post-image">
                <img :src="'http://127.0.0.1:8000/storage/' + post.data.slug_image" alt="slug image"> 
            </div>
            <div class="post-info flex">
                <p>by {{ post.data.user.name }}</p>
                <p>{{ post.data.created_at }}</p>
            </div>
            <div class="post-text">
                <router-link :to="this.postPath + post.links.self">
                    <h2>{{ post.data.title }}</h2>
                </router-link>
                <p>{{ post.data.slug }}</p>
            </div>

            <div class="post-comments flex">
                <div class="post-border"></div>
                <div class="comment flex">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="281" height="323.336" viewBox="0 0 281 323.336"><defs><clipPath id="a"><rect width="281" height="323.336" transform="translate(580 159)" fill="#fff"/></clipPath></defs><g transform="translate(-580 -159)" clip-path="url(#a)"><g transform="translate(580 200.241)"><path d="M262.183,93.091q-18.816-23.127-51.118-36.536T140.5,43.148q-38.261,0-70.564,13.407T18.817,93.091Q0,116.219,0,143.5q0,23.52,14.19,44.066T53,222.068a100.091,100.091,0,0,1-4.079,11.918q-2.352,5.644-4.233,9.253a63.64,63.64,0,0,1-5.1,7.994q-3.212,4.393-4.86,6.2t-5.41,5.958q-3.761,4.153-4.86,5.411a11.043,11.043,0,0,0-1.255,1.414q-1.1,1.331-1.1,1.329l-.941,1.411c-.523.78-.758,1.278-.707,1.485a4.166,4.166,0,0,1-.313,1.568,2.067,2.067,0,0,0,.078,1.883v.158a7.991,7.991,0,0,0,2.508,4.312A6.281,6.281,0,0,0,26.969,284h.785a118.237,118.237,0,0,0,17.876-3.449A171.364,171.364,0,0,0,117.763,242.6a214.411,214.411,0,0,0,22.736,1.254q38.261,0,70.564-13.409t51.118-36.533Q281,170.789,281,143.5T262.183,93.091Zm-17.641,90.4q-16.391,18.5-44.222,29.4a162.678,162.678,0,0,1-59.823,10.9,177.039,177.039,0,0,1-20.384-1.256l-8.938-.938-6.743,5.96A154.611,154.611,0,0,1,61.31,254.369,112.5,112.5,0,0,0,72.287,227.4l4.233-15.055-13.642-7.838q-20.385-11.61-31.6-27.524T20.071,143.505q0-21.483,16.386-39.986t44.221-29.4a162.607,162.607,0,0,1,59.822-10.9,162.6,162.6,0,0,1,59.819,10.9q27.832,10.9,44.222,29.4T260.927,143.5Q260.927,164.984,244.541,183.491Z" transform="translate(0 -43.148)" fill="#fff"/></g></g></svg>
                    <p>{{ post.data.comments.length }}</p>
                </div>
            </div>
            <div class="post-categories flex">
                <svg xmlns="http://www.w3.org/2000/svg" width="151.425" height="153.987" viewBox="0 0 151.425 153.987"><path d="M151.172.752a2.564,2.564,0,0,0-3.629,0l-9.514,9.514H78.272L3.15,86.007a9.059,9.059,0,0,0,0,12.807l52.526,52.526a9.071,9.071,0,0,0,12.833-.026L141.658,76.19V13.9l9.514-9.514A2.564,2.564,0,0,0,151.172.752ZM136.525,74.106l-71.67,73.605a3.928,3.928,0,0,1-5.549,0L6.779,95.185a3.931,3.931,0,0,1,.008-5.557L80.413,15.4H132.9l-12.4,12.4a12.871,12.871,0,1,0,3.629,3.629l12.4-12.4ZM121.126,38.5a7.7,7.7,0,1,1-7.7-7.7,7.61,7.61,0,0,1,3.3.773l-5.113,5.113a2.566,2.566,0,1,0,3.629,3.629l5.113-5.113A7.573,7.573,0,0,1,121.126,38.5Z" transform="translate(-0.499 0)" fill="#818181"/></svg>
                <div v-for="category in post.data.categories" :key="category.name">
                    <p>{{ category.name }}</p>
                </div>
            </div>
            <div class="showed flex">
                <svg xmlns="http://www.w3.org/2000/svg" width="207.688" height="114.897" viewBox="0 0 207.688 114.897"><g transform="translate(0 -9.669)"><path d="M204.6,60.061C202.372,58,149.417,9.669,94.245,9.669c-56.477,0-91.13,49.917-92.579,52.043a9.585,9.585,0,0,0,0,10.8c1.449,2.121,36.1,52.053,92.579,52.053,55.171,0,108.126-48.339,110.353-50.392a9.6,9.6,0,0,0,0-14.112ZM81.448,46.319A15.993,15.993,0,1,1,65.455,62.312,15.991,15.991,0,0,1,81.448,46.319Zm12.8,59.044c-36.223,0-62.638-26.588-72.484-38.267,5.811-6.924,17.437-19.03,33.483-27.773A40.732,40.732,0,1,0,124.5,34.184c24.87,8.162,47.081,23.809,58.646,32.936C167.027,79.85,130.252,105.363,94.245,105.363Z" transform="translate(0 0)" fill="#818181"/></g></svg>
                <p>{{post.data.views}}</p>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "PostComponent",
        props: [
            'post', 'postPath'
        ]
    }
</script>

<style scoped>
    .flex {
        display: flex;
    }
    a {
        text-decoration: none;
    }

    .post-wrap {
        box-shadow: 0px 5px 30px 0px rgba(0,0,0,0.2);
        margin-bottom: 30px;
        position: relative;
    }

    .post-image img {
        width: 100%;
        height: auto;
    }

    .post-info {
        color: #00CEFF;
    }
    .post-info p {
        margin-right: 10%;
    }
    .post-info, .post-text {
        width: 90%;
        margin: auto;
    }

    .post-text p {
        font-size: 0.9em;
        color: #818181;
    }
    .post-text a {
        color: #464646;
        transition: color .3s;
    }
    .post-text a:hover {
        color: #00CEFF;
    }


    .post-comments {
        align-items: center;
    }
    .post-border {
        width: 70%;
        height: 1px;
        background: #D3D3D3;
        margin-right: 10px;
    }
    .comment {
        background: #00CEFF;
        align-items: center;
        border-radius: 30px;
        padding: 8px 20px;
    }
    .comment svg, .post-categories svg {
        width: 25px;
        height: auto;
    }
    .comment p {
        padding-left: 8px;
        color: white;
        font-size: 1.1em;
        margin: 0;
    }

    .post-categories {
        width: 90%;
        margin: auto;
        padding-bottom: 20px;
    }
    .post-categories p {
        color: #818181;
        padding-left: 10px;
        font-size: 0.9em;
    }
    .showed {
        width: fit-content;
        margin: auto;
        position: absolute;
        bottom: 5px;
        right: 20px;

    }
    .showed svg {
        width: 30px;
        height: auto;
        padding: 0 5px;
    }
    .showed p {
        font-weight: bold;
        color: #818181;
    }


</style>