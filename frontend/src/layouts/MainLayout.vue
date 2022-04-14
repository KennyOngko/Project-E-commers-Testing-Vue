<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="leftDrawerOpen = !leftDrawerOpen"
        />

        <q-toolbar-title>
         <div @click="changePage('/')"> Product </div>
        </q-toolbar-title>
        <div dark dense standout id="search" placeholder="Input Product Name" name="search" class="q-ml-md inputan" >
        </div>
        <div v-if="help.isDataEmpty(LocalStorage.getItem('Kenny') && LocalStorage.getItem('Kenny').access_token)" style="display:flex; max-width:100%;">
          <div @click="changePage('/login')" style="padding-right:10px;">Login</div>
          <div @click="changePage('/register')">Register</div>
        </div>
        <div v-else style="display:flex; max-width:100%;">
            <q-btn-dropdown color="primary" :label="LocalStorage.getItem('Kenny').user.name">
              <q-list>
                <div v-if="LocalStorage.getItem('Kenny').user.role == 2">
                  <q-item clickable v-close-popup @click="changePage('/admin/AddCategory')">
                    <q-item-section>
                      <q-item-label>Admin</q-item-label>
                    </q-item-section>
                  </q-item>
                </div>
                <q-item clickable v-close-popup @click="doLogout()">
                  <q-item-section>
                    <q-item-label>Logout</q-item-label>
                  </q-item-section>
                </q-item>
              </q-list>
            </q-btn-dropdown>
        </div>
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      bordered
      content-class="bg-grey-1"
    >
      <q-list>
        <q-item-label
          header
          class="text-grey-8"
        >
          Menu
        </q-item-label>
        <EssentialLink
          v-for="link in essentialLinks"
          :key="link.title"
          v-bind="link"
        />
      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
/* eslint-disable */
import EssentialLink from 'components/EssentialLink.vue'
import help from '../js/help'
const linksData = [
  {
    title: 'Product',
    caption: 'Product list',
    icon: 'fas fa-clipboard-list',
    link: 'http://localhost:8080/#/'
  },
]
import { LocalStorage } from 'quasar'
import Auth from '../Js/AuthValidation'
export default {
  name: 'MainLayout',
  components: {
    EssentialLink,
    LocalStorage
  },
  // created (){
  //   LocalStorage.set('Project_Dharja',)
  // },
  data () {
    return {
      leftDrawerOpen: false,
      essentialLinks: linksData,
      data_user: {},
      help,
      LocalStorage,
      search:"",
    }
  },
  methods: {
    changePage (url) {
      this.$router.push(url)
    },
    doLogout () {
      if(!Auth.doUserLogout()){
        this.data_user = {}
        this.isLogin = false
        this.changePage('/login')
      } else {
        Swal.fire({
          title: 'Error',
          text: '-',
        })
      }
    },
  },

  mounted () {
    if(url.includes('/admin')){
    if(!Auth.isUserLogin()){
      this.forLoad = false
        this.changePage('/login')
        setTimeout(() => {
          this.forLoad = true
        }, 500)
      }
    }
    console.log(Auth.isUserLogin());
    if(Auth.isUserLogin()){
      this.isLogin = true
      this.data_user = LocalStorage.getItem('Kenny')
      console.log(this.data_user);
    } else {
      this.isLogin = false
    }
      if(Auth.userRoleType == "admin"){
      this.forLoad = false;
      this.changePage('/');
      setTimeout(() => {
          this.forLoad = true
      }, 2000)
    }
  },
}

</script>
<style>
.q-toolbar__title{
  display: flex;
  flex: none !important;
}
.inputan{
  padding-right:10rem; 
  padding-left:10rem; 
  width:80%
}

 @media (max-width:485px){
.inputan{
  padding-right:0.5rem !important; 
  padding-left:0 !important;
  width:80%
}
 }
</style>
