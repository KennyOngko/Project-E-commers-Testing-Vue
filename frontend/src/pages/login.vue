<template>
  <q-page class="flex" style="justify-content:center;">
    <div class="q-pa-md" style="width: 500px">
      <h3 style="text-align:center;">Login</h3>
      <q-form
        @submit="doLogin"
        @reset="onReset"
        class="q-gutter-md"
      >
        <q-input
          v-model="form.email"
          label="Email *"
          hint="email@gmail.com"
          :rules="rules.email_r" lazy-rules="ondemand"
        />

        <q-input v-model="form.password" :type="isPwd ? 'password' : 'text'" label="Password *" :rules="rules.password_r" lazy-rules="ondemand">
            <template v-slot:append>
            <q-icon
                :name="isPwd ? 'visibility_off' : 'visibility'"
                class="cursor-pointer"
                @click="isPwd = !isPwd"
            />
            </template>
        </q-input>

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
        email: '',
        password: '',
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
      },
      window: {
        width: 0,
        height: 0,
        heightAltered: 0
      }
    }
  },
  
  methods:{
    doLogin (){
      loginToWebsite(this.form).then(response =>{
        console.log(response);
        LocalStorage.set('Kenny', response.data)
        this.showNotif('Berhasil');
        this.changePage('/');
      }).catch(error =>{
        console.log(error.response.data.error);
        this.showNotif(error.response.data.error);
      })
    },

    // doRegister (){
    //   registerToWebsite(this.form).then(response =>{
    //     console.log(response);
    //     this.showNotif('Berhasil');
    //     this.changePage('/');
    //   }).catch(error =>{
    //     console.log(error.response.data.error.email[0]);
    //     this.showNotif(error.response.data.error.email[0]);
    //   })
    // },
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
