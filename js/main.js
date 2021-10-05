Vue.config.devtools = true

Vue.component('gallery', {
    props: {
        id_gallery: String,
        gallery: Object,
        images: Array,
        cols: Object,
        loading: Boolean
    },
    created() {
        this.getPhotos()
    },
    methods: {
        async getPhotos() {
            this.$parent.loading = true
            const response = await axios.get('./controllers/pageController.php?action=getPhotos&id_gallery=' + this.id_gallery)
            let cookies = this.getCookies()
            let images = response.data.images
            images.forEach((image) => {
                image.thumbnail = "img/gallery/thumbnails/" + image.id + "." + image.extension
                image.link = "img/gallery/" + image.id + "." + image.extension
                image.liked = cookies[image.id] == "1" ? true : false
            });
            this.$parent.gallery = response.data
            this.$parent.images = this.$parent.gallery.images.map(i => i.link)
            this.$parent.cols = {
                default: response.data.columns,
                700: 2,
                400: 1
            }
            this.$parent.loading = false
        },
        async like(image_id, like) {
            let params = new FormData()
            params.append('like', like)
            params.append('gallery_id', this.id_gallery)
            params.append('image_id', image_id)
            let index = this.$parent.gallery.images.indexOf(this.$parent.gallery.images.find(i => i.id == image_id))
            await axios.post('./controllers/like.php?action=like', params)
            this.$parent.gallery.images[index].liked = like
            if(like){
                this.$parent.gallery.images[index].likes = parseInt(this.$parent.gallery.images[index].likes) + 1
            }else{
                this.$parent.gallery.images[index].likes = parseInt(this.$parent.gallery.images[index].likes) - 1
            }
        },
        getCookies() {
            var cookies = {}
            if (document.cookie && document.cookie != '') {
                var split = document.cookie.split(';')
                for (var i = 0; i < split.length; i++) {
                    var name_value = split[i].split("=")
                    name_value[0] = name_value[0].replace(/^ /, '')
                    cookies[decodeURIComponent(name_value[0])] = decodeURIComponent(name_value[1])
                }
            }
            return cookies
        },
    },
    template: `
    <div v-if="!loading">
        <div class="container">
            <div class="grid">
                <masonry :cols="cols">
                    <div v-for="image in gallery.images">
                        <div class="overflow-hidden grid-item">
                            <div class="change-icon" :id="image.id" :name="id_gallery">
                                <i v-if="image.liked" class="fas fa-heart fa-lg pulse text-danger" @click="like(image.id,!image.liked)"></i>
                                <i v-else class="far fa-heart fa-lg" @click="like(image.id,!image.liked)"></i>
                            </div>
                            <span class="like-text">{{image.likes}}</span>
                            <a :href="image.link" class="lightbox" data-fancybox="gallery">
                                <img class="rounded" :src="image.thumbnail" alt="img_gallery">
                            </a>
                        </div>
                    </div>
                </masonry>
            </div>
        </div>
    </div>
    `
})

Vue.component('about', {
    props: {
        services: Array,
        loading: Boolean
    },
    created() {
        this.getServices()
    },
    methods: {
        async getServices() {
            this.$parent.loading = true
            const response = await axios.get('./controllers/pageController.php?action=getServices')
            this.$parent.services = response.data
            this.$parent.loading = false
        },
        changePage(page) {
            this.$parent.changePage(page)
        }
    },
    template: `
    <div id="about" v-if="!loading">
        <div class="container mt-5">
            <div class="row m-0 d-flex justify-content-center">
                <div class="col-md-10">
                    <div class="text-center">
                        <div class="photoContainer">
                            <img class="picMax" src="img/accueil/max_pic.jpg" alt="picture_profil">
                        </div>
                    </div>
                    <div class="info text-center mt-3"> <span class="bg-secondary p-1 px-4 rounded">Grenoble</span>
                        <h5 class="mt-2 mb-0">Maxime Brisson</h5>
                        <span>Photographe</span>
                        <div class="px-4 mt-4">
                            <p class="fonts">Je m'appelle Maxime et je suis photographe amateur. Diplômé d'une Licence d'art du Spectacle
                                à Grenoble en 2019 je me lance dans la production multimédia.
                                Passionné de photographie depuis 2016, je vous propose de me suivre dans mon périple.
                                Tout a commencé par des paysages et quelques expérimentations pour parvenir à comprendre
                                et à m'approprier cet art. Le portrait s'est ainsi rapidement imposé à moi mais je reste
                                évidemment ouvert à toutes sortes de projets, avide de découvertes et de rencontres.</p>
                            <p>Bon visionnage,</p>
                            <p class="signature">Catchin' Light</p>
                        </div>
                        <button class="btn btn-primary" @click="changePage('contact')">Contact</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid text-white">
            <div class="row">
                <div class="col-lg-12">
                    <hr>
                    <div class="timeline">
                        <div class="timeline-body">
                            <div class="hori-timeline" dir="ltr">
                                <ul class="list-inline events flex-center">
                                    <li v-for="service in services" class="list-inline-item event-list mb-5">
                                        <div class="px-4">
                                            <div class="event-date">
                                                <i :class="'fas '+service.icon"></i>
                                            </div>
                                            <h5>{{service.titre}}</h5>
                                            <p class="desc" v-html="service.description"></p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    `
})

Vue.component('galleries', {
    props: {
        galleries: Array,
        sub_galleries: Array,
        sub_galleries_chunks: Array,
        loading: Boolean,
        mobile: Boolean
    },
    created() {
        this.getGalleries()
    },
    updated() {
        this.squareMenu()
    },
    methods: {
        async getGalleries() {
            this.$parent.loading = true
            const response = await axios.get('./controllers/pageController.php?action=getGalleries')           
            this.$parent.galleries = response.data.galleries
            this.$parent.sub_galleries = response.data.sub_galleries
            this.$parent.sub_galleries_chunks = response.data.sub_galleries_chunks
            this.$parent.loading = false           
        },
        changePage(page, id_gallery) {
            this.$parent.id_gallery = id_gallery
            this.$parent.changePage(page, true);
        },
        squareMenu() {
            let imgs = document.getElementsByClassName('square-img')
            if (imgs.length > 0) {
                let width = imgs[imgs.length-1].clientWidth + 'px'
                for (let img of imgs) {
                    img.style.height = width
                    img.style.width = width
                }
            }
        },
    },
    template: `
    <div class="container" v-if="!loading">
        <div id="carousel" class="carousel slide" data-bs-ride="carousel">
            <div v-if="mobile" class="carousel-inner">
                <div v-for="(sub_gallery, index) in sub_galleries" :class="index==0 ? 'carousel-item active' : 'carousel-item'">
                    <a class="profile-card-2" @click="changePage('gallery',sub_gallery.id)">
                        <img :src="sub_gallery.lien" class="img img-responsive square-img" :alt="sub_gallery.Nom">
                        <div class="profile-name centerImage">{{(sub_gallery.Nom).toUpperCase()}}</div>
                        <div class="profile-username">{{sub_gallery.description}}</div>
                    </a>
                </div>
            </div>
            <div v-else class="carousel-inner">
                <div v-for="(chunk, index) in sub_galleries_chunks" :class="index==0 ? 'carousel-item active' : 'carousel-item'">
                    <div class="multi-items-carousel row">
                        <div v-for="sub_gallery in chunk" class="profile-card-2 col-sm-4">
                            <a @click="changePage('gallery',sub_gallery.id)">
                                <img :src="sub_gallery.lien" class="img img-responsive square-img" :alt="sub_gallery.Nom">
                                <div class="profile-name centerImage">{{(sub_gallery.Nom).toUpperCase()}}</div>
                                <div class="profile-username">{{sub_gallery.description}}</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="(sub_galleries.length / 3) > 1">
                <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <div class="row m-0 conteneurMenu">
            <div v-for="gallery in galleries" class="profile-card-2 col-sm-4">
                <div @click="changePage('gallery',gallery.id)">
                    <img :src="gallery.lien" class="img img-responsive square-img" :alt="gallery.Nom">
                    <div class="profile-name centerImage">{{(gallery.Nom).toUpperCase()}}</div>
                    <div class="profile-username"{{gallery.description}}</div>
                </div>
            </div>
        </div>
    </div>
    `
})

Vue.component('videos', {
    props: {
        videos: Array,
        loading: Boolean
    },
    created() {
        this.getVideos()
    },
    methods: {
        async getVideos() {
            this.$parent.loading = true
            const response = await axios.get('./controllers/pageController.php?action=getVideos')
            this.$parent.videos = response.data
            this.$parent.loading = false
        }
    },
    template: `
    <div class="row" v-if="!loading">
        <div v-for="video in videos" class="col-sm-6 col-md-3 my-1">
            <div class="modal fade" :id="'modal'+video.id" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content bg-dark">
                        <div class="modal-body mb-0 p-0">
                            <div class="embed-responsive embed-responsive-16by9 z-depth-1-half">
                                <iframe class="embed-responsive-item" :src="video.url_video" allowfullscreen></iframe>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn-outline-primary btn-rounded btn-md ml-4" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <img class="thumbnail_vid img-fluid z-depth-1" :src="'http://img.youtube.com/vi/'+video.video_id+'/hqdefault.jpg'" alt="video"
            data-toggle="modal" :data-target="'#modal'+video.id">
        </div>
    </div>
    `
})

Vue.component('pages', {
    props: {
        pages: Array,
        loading: Boolean
    },
    methods: {
        changePage(page) {
            this.$parent.changePage(page)
        }
    },
    template: `
    <div class="container" v-if="!loading">
        <div v-for="page in pages" class="col-md-11 mx-auto p-0 mb-4 section_main">
            <a style="cursor: pointer;" @click="changePage(page.titre_lien)">
                <div class="hovereffect1 center-block">
                    <img class="img-responsive centerImage" :src="page.image" alt="">
                    <h2 class="section_title">{{page.nom.toUpperCase()}}</h2>
                    <div class="overlay align-items-center">
                        <h2 class="textMenu my-auto">{{page.nom.toUpperCase()}}</h2>
                    </div>
                </div>
            </a>
        </div>
    </div>
    `
})

Vue.component('contact', {
    props: {
        loading: Boolean,
        success: Boolean,
        form: Object
    },
    created() {
        this.getcaptcha()
    },
    methods: {
        changePage(page) {
            this.$parent.changePage(page)
        },
        async getcaptcha() {
            this.$parent.loading = true
            const response = await axios.get('./controllers/pageController.php?action=getcaptcha')
            this.$parent.loading = false
        },
        async sendMail() {
            if (this.form.robot) {
                let name = document.querySelector('#name').value
                let email = document.querySelector('#email').value
                let subject = document.querySelector('#subject').value
                let message = document.querySelector('#message').value
                let params = new FormData()
                params.append('name', name)
                params.append('email', email)
                params.append('subject', subject)
                params.append('message', message)
                const response = await axios.post('./controllers/mail.php?action=send', params)
                this.$parent.success = response.data == 1 ? true : false
            }
        },
        onVerify(response) {
            if (response) this.form.robot = true;
        },
    },
    components: {
        'vue-recaptcha': VueRecaptcha
    },
    template: `
    <div class="row m-0">
        <div v-if="!loading" class="mb-4 text-light m-auto py-4">
            <h2 class="h1-responsive font-weight-bold text-center">Contactez Nous !</h2>
            <p class="text-center w-responsive mx-auto mb-5">Vous avez des questions ? N'hésitez pas à nous contacter directement par mail ou avec le formulaire ci-dessous.</p>
            <div v-if="success" class="alert alert-success mx-auto text-center w-50" role="alert">
                <h4 class="alert-heading">Bravo !</h4>
                <p class="alert-success">Votre message sera pris en compte très prochainement !</p>
                <hr>
                <p class="mb-0 alert-success">N'hésitez pas à visiter les <a class="alert-success link font-weight-bold" href="photos">Galleries de photos</a></p>
            </div>
            <div class="row">
                <form class="col-md-9" v-if="!success" :model="form" @submit.prevent="sendMail" ref="contactForm">
                    <div class="row">
                        <div class="col-md-6 mt-2">
                            <div class="md-form">
                                <input type="text" id="name" class="form-control" placeholder="Your Name" required>
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class="md-form">
                                <input type="email" id="email" class="form-control" placeholder="Your Email" required>
                            </div>
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-md-12">
                            <div class="md-form">
                                <input type="text" id="subject" class="form-control" placeholder="Your subject" required>
                            </div>
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-md-12">
                            <div class="md-form">
                                <textarea type="text" id="message" rows="2" class="form-control md-textarea" placeholder="Write something !" required></textarea>
                            </div>
                        </div>
                    </div>
                    <label for="robot" class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <vue-recaptcha ref="recaptcha" @verify="onVerify" sitekey="6Lcns6wZAAAAAEYUMOuDoUY9q1TO63ITb7TurzW5"></vue-recaptcha>
                    </div>
                    <div class="text-center text-md-left">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane" @click="sendMail"></i> Send</button>
                    </div>
                    <div class="status"></div>
                </form>
                <div class="col-md-3 text-center">
                    <ol class="list-unstyled mb-0">
                        <li>
                            <a class="link" href="mailto:catchin.light@gmail.com?subject=Demande d'informations" target="_self" data-content="catchin.light@gmail.com" data-type="mail">
                            <i class="fas fa-envelope mx-auto fa-3x"></i><br>catchin.light@gmail.com</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    `
})

new Vue({
    name: 'Index',
    el: '#content-page',
    data: {
        pages: [],
        loading: false,
        id_gallery: null,
        gallery: {},
        images: [],
        cols: {},
        services: [],
        galleries: [],
        sub_galleries: [],
        sub_galleries_chunks: [],
        videos: [],
        pageName: 'index',
        success: false,
        form: {
            robot: false
        },
        mobile: false
    },
    created() {
        this.registerSW()
        this.getPages()
        this.choosePage()
        this.detectMobile()
    },
    updated() {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 50) {
                $('#back-to-top').fadeIn()
            } else {
                $('#back-to-top').fadeOut()
            }
        })
        window.onclick = () => {
            this.closeDropDown()
        }
    },
    methods: {
        async detectMobile() {
            const response = await axios.get('./controllers/phone_detection.php')
            this.mobile = response.data == 1 ? true : false
        },
        async getPages() {
            const response = await axios.get('./controllers/pageController.php?action=getPages')
            this.pages = response.data
        },
        async registerSW() {
            if ('serviceWorker' in navigator) {
                try {
                    await navigator.serviceWorker.register('./sw.js')
                } catch (e) {
                    console.log('SW registration failed')
                }
            }
        },
        closeDropDown() {
            if (!event.target.matches('.navbar')) {
                let dropdown = document.getElementById("navbarSupportedContent")
                if (dropdown.classList.contains('show')) {
                    dropdown.classList.remove('show')
                }
            }
        },
        changePage(page, gallery = false) {
            this.pageName = page
            window.location.hash = gallery ? page + '&id' + this.id_gallery : page
        },
        choosePage() {
            let params = this.parseHash(window.location.hash)
            let page = Object.keys(params)[0] !== "" ? Object.keys(params)[0] : this.pageName
            let gallery = false
            for (const [key, value] of Object.entries(params)) {
                if (key == 'id') {
                    this.id_gallery = value.toString()
                    gallery = true
                }
            }
            this.changePage(page, gallery)
        },
        parseHash(hash) {
            hash = hash.substring(1, hash.length);
            var hashObj = {};
            hash.split('&').forEach(function (q) {
                var prop = q.split(/\d/)[0];
                var val_raw = q.split(/[^\d]/);
                var val = val_raw[val_raw.length - 1]
                if (typeof prop !== 'undefined' && typeof val !== 'undefined') {
                    hashObj[prop] = +val;
                }
            });
            return hashObj;
        },
        scrollTop() {
            $('body,html').animate({
                scrollTop: 0
            }, 400);
        }
    },
})