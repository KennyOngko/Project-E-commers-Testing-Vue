/* eslint-disable */
import moment from 'moment'
import { LocalStorage } from 'quasar'
import help from '../js/help'

export default {
    isUserLogin () {
        if(LocalStorage.has('Kenny')){
            console.log();
            if(!help.isDataEmpty(LocalStorage.getItem('Kenny').access_token)){
                return true
            } 
            return false
        } 
        return false
    },
    userRoleType () {
        const user = LocalStorage.getItem('Kenny').user
        if(user.role == 1){
            return 'customer'
        } else if (user.role == 2) {
            return 'admin'
        }
    },
    getAccessToken () {
        if(LocalStorage.has('Kenny') && !help.isDataEmpty(LocalStorage.getItem('Kenny').access_token)){
            return LocalStorage.getItem('Kenny').access_token
        }
        return null
    },
    getUserDetails () {
        if(LocalStorage.has('Kenny') && !help.isDataEmpty(LocalStorage.getItem('Kenny').user)){
            return LocalStorage.getItem('Kenny').user
        }
        return {}
    },
    doUserLogout () {
        LocalStorage.remove('Kenny')
        return LocalStorage.has('Kenny')
    }
}