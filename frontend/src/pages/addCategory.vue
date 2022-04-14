<template>
    <q-page>
        <div class="container bg-white shadow-lg p-3 mb-5 bg-white rounded" style="padding-bottom:50px">
            <q-form style="text-align:center" @submit="doInsertCategory">
                <h3 class="tile-title">Add Category</h3>
                <hr>
                <div style="display:flex; justify-content:center; padding-bottom:10px;">
                    <q-input style="width:50%;"
                        clearable
                        clear-icon="close"
                        filled
                        color="purple-12"
                        label="Masukan Category Product baru"
                        v-model="form.name"
                    />
                </div>
                <q-btn type="submit" color="primary">Add Category</q-btn>
            </q-form>
            <div style="display:flex; justify-content:center; padding-top:1rem;">
                <q-markup-table style="width:30%; max-height:50%; overflow:hidden">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Name</th>
                            <th>Action</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody v-for="(data_categories, index) in data_categories" :key="index">
                        <tr>
                            <td class="text-center">{{index+1}}</td>
                            <td class="text-center">{{data_categories.name}}</td>
                            <td class="text-center"><q-btn @click="doDeleteCategory(data_categories.id)">Delete</q-btn></td>
                            <td class="text-center"><q-input v-model="data_categories.updated"  style="padding-bottom:10px"/> <q-btn label="Update" @click="doUpadateCategory(data_categories)" /> </td>
                        </tr>
                    </tbody>
                </q-markup-table>

            </div>
        </div>
    </q-page>
</template>
<script>
/* eslint-disable */
import { getDataProduct, getDataCategories,insertDataCategory, deleteDataCategory, updateCategory } from '../Js/service'
export default {
    name: 'PageIndex',
    data () {
        return {
        data_product: [],
        data_categories:[],
        form: {
            name: '',
        },
        window: {
            width: 0,
            height: 0,
            heightAltered: 0
        }
        }
    },
    created (){
      this.doGetProduct();
      this.doGetCategory();
    },
    methods:{
      doGetProduct (){
          getDataProduct(this.data_product).then(response =>{
              this.data_product = response.data.data_product;
             console.log(this.data_product);
          })
      },
    doGetCategory (){
          getDataCategories(this.data_category).then(response =>{
              response.data.data_categories.forEach(el1 => {
                  let tempObject = {
                      id: el1.id,
                      name: el1.name,
                      updated: '',
                  }
                  this.data_categories.push(tempObject)
              });
             console.log('data_categori',this.data_categories);
          })
      },
    doInsertCategory (){
        insertDataCategory(this.form).then(response =>{
            console.log(this.form);
            this.showNotif('Berhasil');
            this.changePage('/admin/AddCategory');
            this.doGetCategory();
          }).catch(error =>{
        console.log(error.response.data.message.name[0]);
        this.showNotif(error.response.data.message.name[0]);
        })
      },
    doUpadateCategory (data_categories){
        updateCategory(data_categories).then(response =>{
            console.log(data_categories);
            this.data_categories=[];
            this.doGetCategory();
          }).catch(error =>{
        console.log(error.response.data.message.name[0]);
        this.showNotif(error.response.data.message.name[0]);
        })
      },
        showNotif (message) {
        this.$q.notify({
        message: message,
        color: 'purple'
      })
      },
    doDeleteCategory (id){
        deleteDataCategory(id).then(response =>{
            console.log(id);
            this.doGetCategory();
          }).catch(error =>{
        console.log(error.response.data.message.name[0]);
        this.showNotif(error.response.data.message.name[0]);
        })
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