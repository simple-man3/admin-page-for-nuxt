export default {
  ssr: false,

  head: {
    title: 'front',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
    ]
  },

  css: [
    '~assets/css/style.css',
    '~assets/font/Noto_Sans_JP/font.css'
  ],

  plugins: [
  ],

  components: true,

  buildModules: [
  ],

  modules: [
    '@nuxtjs/axios',
    '@nuxtjs/auth-next',
    '@nuxtjs/dotenv'
  ],

  axios:{
    baseURL:process.env.BASE_URL
  },

  auth:{
    redirect:{
      login:'/admin/auth/login',
      logout:'/',
      home:'/admin111'
    },
    strategies:{
      'laravelPassport':{
        provider:'laravel/passport',
        url:process.env.BASE_URL,
        endpoints:{
          userInfo:process.env.OAUTH_USER_INFO
        },
        clientId:process.env.OAUTH_CLIENT_ID,
        clientSecret:process.env.OAUTH_CLIENT_SECRET,
        grantType:'password'
      }
    }
  },

  router:{
    middleware:[
      'auth',
    ],
  },

  build: {
  },
}
