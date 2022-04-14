<template>
  <q-page class="flex" style="justify-content:center;">
    <div class="q-pa-md" style="width: 500px">
      <h3 style="text-align:center;">Register</h3>
      <q-form
        @submit="doRegister"
        @reset="onReset"
        class="q-gutter-md"
      >
        <q-input
          v-model="form.name"
          label="Your name *"
          hint="Name and username"
          lazy-rules="ondemand"
          :rules="[ val => val && val.length > 0 || 'Please type something']"
        />

        <q-input
          v-model="form.email"
          label="Email *"
          hint="email@gmail.com"
          :rules="rules.email_r" lazy-rules="ondemand"
        />

        <q-input
          type="password"
          v-model="form.password"
          label="Password *"
          :rules="rules.password_r" lazy-rules="ondemand"
        />

        <q-input
          type="password"
          v-model="form.password_confirmation"
          label="password confirmation *"
          :rules="rules.password_r" lazy-rules="ondemand"
        />

        <div>
          <q-btn label="Submit" type="submit" color="primary"/>
          <q-btn label="Reset" type="reset" color="primary" flat class="q-ml-sm" />
        </div>
      </q-form>

    </div>
    <!-- <q-btn @click="doLogin()">
      KONTOL
    </q-btn> -->
  </q-page>
</template>

<script>
/* eslint-disable */
import { LocalStorage } from 'quasar'
import { loginToWebsite,registerToWebsite } from '../Js/service'
export default {
  name: 'PageIndex',
    data () {
    return {
      form: {
        name: '',
        email: '',
        password: '',
        password_confirmation:''
      },
      isPwd: true,
      rules: {
        email_r: [
          v => !!v || 'Email is required',
          v => /^\w+([.+-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'Wrong email format'
        ],
        password_r: [
          v => !!v || 'Password is required',
          v => v.length >= 8 || 'Password min 8 characters',
        ],
        password_confirmation_r: [
          v => !!v || 'Password is required',
          v => v.length >= 8 || 'Password min 8 characters',
          v => v === this.form.password || 'Password is not the same'
          
        ]
      },
      window: {
        width: 0,
        height: 0,
        heightAltered: 0
      }
    }
  },
  methods:{
    // doLogin (){
    //   loginToWebsite(this.form).then(response =>{
    //     console.log(response);
    //   })
    // }

    doRegister (){
      registerToWebsite(this.form).then(response =>{
        console.log(response);
        this.showNotif('Berhasil');
        this.changePage('/login');
      }).catch(error =>{
        console.log(error.response.data.error.email[0]);
        this.showNotif(error.response.data.error.email[0]);
      })
    },
    onReset () {
      this.form.name = null
      this.form.password_confirmation = null
      this.form.password = null
      this.form.email = null
      
    },
     showNotif (message) {
      this.$q.notify({
        message: message,
        color: 'purple'
      })
    },
      changePage (url) {
      this.$router.push(url)
    },
  }

}
</script>
