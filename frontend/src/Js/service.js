/* eslint-disable */
import axios from 'axios'
var URL = "http://127.0.0.1:8000"
export default
  function kosong() {
  return true
}

export function loginToWebsite(userCredentials) {
  return axios.post(URL + '/api/login', userCredentials)
}
export function registerToWebsite(userCredentials) {
    return axios.post(URL + '/api/register', userCredentials)
  }

export function getDataProduct(userCredentials) {
  return axios.get(URL + '/api/getAllProduct', userCredentials)
}

export function getDataCategories(userCredentials) {
  return axios.get(URL + '/api/getAllCategories', userCredentials)
}

export function insertDataCategory(userCredentials) {
  return axios.post(URL + '/api/storeCategory', userCredentials)
}

export function deleteDataCategory(userCredentials) {
  console.log(userCredentials);
  return axios.post(URL + '/api/DeleteDataCategory?id='+ userCredentials)
}

export function updateCategory(userCredentials) {
  console.log('usercredential',userCredentials);
  return axios.post(URL + '/api/updateDataCategory', userCredentials)
}

export function insertImage(gambar, id) {
  return axios.post(URL + '/api/uploadImage?id='+id, gambar)
}

export function insertProduct(userCredentials) {
  console.log('usercredential',userCredentials);
  return axios.post(URL + '/api/storeProduct', userCredentials)
}

export function getDataProductAdmin(userCredentials) {
  console.log('usercredential',userCredentials);
  return axios.get(URL + '/api/dataProductAdmin', userCredentials)
}

export function deleteDataProduct(userCredentials) {
  console.log('usercredential',userCredentials);
  return axios.post(URL + '/api/deleteDataProduct?id='+ userCredentials)
}

export function updateDataProduct(userCredentials,id) {
  console.log('usercredential',userCredentials);
  return axios.post(URL + '/api/updateDataProduct?id='+ id,userCredentials)
}

