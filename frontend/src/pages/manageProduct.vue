<template>
    <q-page>
        <div class="container bg-white shadow-lg p-3 mb-5 bg-white rounded" style="padding-bottom:50px">
            <q-form @submit="doInsertProduct" action="addproduct" enctype="multipart/form-data" method="POST" role="form" style="text-align:center">
                <h3 class="tile-title">Add Product</h3>
                <hr>
                <div style="display:flex; width:100%; justify-content:center; padding-top:10px;">
                    <q-input style="width:40%" label="Masukan Nama Product" v-model="form.name"  />
                </div>
                <div style="display:flex; width:100%; justify-content:center">
                    <q-select style="width:40%" @change="doConsole(Selector_category)" stack-label v-model="Selector_category" :options="data_category" label="Pilih Category">
                     <template v-slot:selected>
                        <template v-if="Selector_category.label">
                            {{ Selector_category.label }}
                        </template>
                        <template v-else>
                            <span class="placeholder-text"></span>
                        </template>
                    </template>
                    </q-select>
                </div>
                <div style="display:flex; width:100%; justify-content:center; padding-top:10px;">
                       <q-input style="width:40%"
                       label ="Masukan Deskripsi Product"
                        filled
                        type="textarea"
                        v-model="form.description"
                        />
                </div>
                <div style="display:flex; width:100%; justify-content:center; padding-top:10px;">
                    <q-input style="width:40%"  label="Masukan Price untuk Product" v-model="form.price" />
                </div>
                <div style="display:flex; width:100%; justify-content:center; padding-top:10px;">
                    <q-input style="width:40%"  label="Masukan QTY untuk Product" v-model="form.qty"  />
                </div>
                <div style="display:flex; width:100%; justify-content:center; padding-top:15px;">
                    <label style="padding-right:5%;" for="">Masukan Gambar: </label>
                    <input class="cursor-pointer" type="file" accept=".png,.jpg,.jpeg" id="uploadProductImage" @change="doUpload($event)">
                </div>
                <div style="padding-top:20px;">
                    <q-btn type="submit" label="Add Product"/>
                </div>
            </q-form>
        </div>
        <div style="display:flex; width:100%; justify-content:center; padding-top:10px;">
        <q-markup-table flat bordered style="width:80%;">
            <thead>
                <tr>
                    <th class="text-center">Nama Product</th>
                    <th class="text-center">Category</th>
                    <th class="text-center">Price</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-center">Description</th>
                    <th class="text-center">Gambar</th>
                    <th class="text-center">action</th>
                    <th class="text-center">update</th>
                </tr>
            </thead>
            <tbody v-for="(data_product_admin, index) in data_product_admin" :key="index">
                <tr v-if="data_product_admin.toggle == false">
                    <td class="text-center">{{data_product_admin.productName}}</td>
                    <td class="text-center">{{data_product_admin.name}}</td>
                    <td class="text-center">{{data_product_admin.price}}</td>
                    <td class="text-center">{{data_product_admin.qty}}</td>
                    <td class="text-center"><div style="max-width:70%; white-space:pre-line; margin:auto;">{{data_product_admin.description}}</div></td>
                    <td class="text-center"><img class="responsive_img fit-content" width="100" :src="data_product_admin.gambar" alt=""></td>
                    <td class="text-center"><q-btn color="red" @click="doDeleteProduct(data_product_admin.id)" disabled="">Delete</q-btn></td>
                    <td class="text-center">
                        <q-btn color="red" @click="doClick(data_product_admin)"
                        :disabled="test.id != ''
                        ? !(test.id == data_product_admin.id)
                        : false">
                        Update
                        </q-btn></td>
                </tr>
                <tr v-else>
                    <td class="text-center"><q-input v-model="updateDataProduct.productName" :placeholder="data_product_admin.productName"></q-input></td>
                    <td class="text-center">
                        <q-select style="width:150%" @change="doConsole(Selector_category)" stack-label v-model="Selector_category" :options="data_category" label="Category">
                        <template v-slot:selected>
                        <template v-if="Selector_category.label">
                            {{ Selector_category.label }}
                        </template>
                        <template v-else>
                            <span class="placeholder-text"></span>
                        </template>
                        </template>
                        </q-select>
                    </td>
                    <td class="text-center"><q-input v-model="updateDataProduct.price" :placeholder="data_product_admin.price"></q-input></td>
                    <td class="text-center"><q-input v-model="updateDataProduct.qty" :placeholder="data_product_admin.qty"></q-input></td>
                    <td class="text-center"><div style="max-width:70%; white-space:pre-line; margin:auto;"><q-input v-model="updateDataProduct.description" type="textarea" :placeholder="data_product_admin.description"></q-input></div></td>
                    <td class="text-center">
                        <div style="display:grid"><img class="responsive_img fit-content" width="100" :src="data_product_admin.gambar" alt="">
                            <input class="cursor-pointer" type="file" accept=".png,.jpg,.jpeg" id="updateProductImage" @change="doUploadUpdate($event)">
                        </div>
                    </td>
                    <td class="text-center"><q-btn color="red" @click="doDeleteProduct(data_product_admin.id)">Delete</q-btn></td>
                    <td class="text-center" style="gap:1rem;"><q-btn color="blue" @click="doUpdateProduct(data_product_admin.id)" >Submit</q-btn>
                    <q-btn color="blue" @click="doCancleUpdate(); data_product_admin.toggle = false">cancle</q-btn></td>
                </tr>
            </tbody>
        </q-markup-table>
        </div>
    </q-page>
</template>
<script>
/* eslint-disable */
import { getDataProduct, getDataCategories, insertImage,insertProduct, getDataProductAdmin, deleteDataProduct, updateDataProduct} from '../Js/service'
import help from '../js/help'
export default {
    name: 'PageIndex',
    data () {
        return {
        data_product_admin: [],
        data_category:[],
        update_product:[],
        Selector_category:[],
        test: {
            id:'',
            toggle2: false
        },
        form: {
            name: '',
            categoriesID: '',
            price:'',
            gambar:'',
            qty:'',
            description:''
        },
        updateDataProduct: {
            productName: '',
            price: '',
            categoriesID: '',
            qty:'',
            gambar:'',
            description:''
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
      this.doGetdataProductAdmin();
    },
    methods:{
    doCancleUpdate (){
        this.test.id = ''
        this.test.toggle2 = false
        this.updateDataProduct.productName = ''
        this.updateDataProduct.price = ''
        this.updateDataProduct.categoriesID = ''
        this.updateDataProduct.qty=''
        this.updateDataProduct.gambar = ''
        this.updateDataProduct.description =''
        this.doGetdataProductAdmin()
    },
    doClick (data_admin){
        this.updateDataProduct.productName = data_admin.productName
        this.updateDataProduct.price = data_admin.price
        this.updateDataProduct.categoriesID = data_admin.categoriesID
        this.updateDataProduct.qty= data_admin.qty
        this.updateDataProduct.gambar = data_admin.gambar
        this.updateDataProduct.description = data_admin.description
        data_admin.toggle = true;
        this.test.toggle2 = true;
        this.test.id = data_admin.id
    },
    doUpdateProduct (id){
        this.updateDataProduct.categoriesID =  this.Selector_category.value
        updateDataProduct(this.updateDataProduct,id).then(response =>{
            console.log(response);
            this.goUpload(id ,this.updateDataProduct.gambar);
            this.updateDataProduct.productName = ''
            this.updateDataProduct.price = ''
            this.updateDataProduct.categoriesID = ''
            this.updateDataProduct.qty=''
            this.updateDataProduct.gambar = ''
            this.updateDataProduct.description =''
            this.data_product_admin.toggle = false;
            this.test.id = ''
            this.test.toggle2 = false
            this.doGetdataProductAdmin();
        })
    },
    doDeleteProduct (id){
        deleteDataProduct(id).then(response =>{
            this.test.id = ''
            this.test.toggle2 = false
            console.log(id);
            this.doGetdataProductAdmin();
        })
    },
    doGetdataProductAdmin (){
        getDataProductAdmin().then(response =>{
            this.data_product_admin = response.data.data_product_admin
        })
    },
    doGetProduct (){
          getDataProduct().then(response =>{
              this.data_product = response.data.data_product;
             console.log(this.data_product);
          })
      },
    doGetCategory (){
          getDataCategories(this.data_category).then(response =>{
            response.data.data_categories.forEach(el1 => {
                  let tempObject = {
                      value: el1.id,
                      label: el1.name,
                  }
                  this.data_category.push(tempObject)
              });  
             console.log('data_categori',this.data_category);
          })
      },
    doInsertProduct (){
        this.form.categoriesID =  this.Selector_category.value
        console.log(this.form)
        console.log(this.Selector_category);
        insertProduct(this.form).then(response =>{
            console.log(this.form);
            this.goUpload(response.data.id ,this.form.gambar);
          }).catch(error =>{
              console.log('ERROR TOT',error);
        
        })
      },

    goUpload (id , gambar){
        insertImage(gambar,id).then(response =>{
            console.log('ini gambar',this.form.gambar);
            this.showNotif('Berhasil');
            this.doGetdataProductAdmin();
        }).catch(error =>{
        console.log(error.response.data.message.gambar[0]);
        this.showNotif(error.response.data.message.gambar[0]);
        })
    },

    // goUploadUpdate (id){
    //     insertImage(this.updateDataProduct.gambar, id).then(response =>{
    //         this.showNotif('Berhasil');
    //         this.changePage('/admin/manageProduct');
    //     }).catch(error =>{
    //         console.log(error);
    //     })
    // },

    doUploadUpdate (event){
        var inputFile = event.target.files || event.dataTransfer.files
        if(!inputFile.length) return null

        var inputFileType = inputFile[0].type
        if(!help.isValidImageType(inputFileType)){
            document.getElementById('updateProductImage').value = ''
        } else {
            var reader = new FileReader() // Creating reader instance from FileReader() API

            var preview = document.getElementById('myImg') // Image reference
            var file = inputFile[0] // File refrence

            const formData = new FormData
            formData.set('gambar', file)
            this.updateDataProduct.gambar = formData
        }
    },
    doUpload (event){
        var inputFile = event.target.files || event.dataTransfer.files
        if(!inputFile.length) return null

        var inputFileType = inputFile[0].type
        if(!help.isValidImageType(inputFileType)){
            document.getElementById('uploadProductImage').value = ''
        } else {
            var reader = new FileReader() // Creating reader instance from FileReader() API

            var preview = document.getElementById('myImg') // Image reference
            var file = inputFile[0] // File refrence

            const formData = new FormData
            formData.set('gambar', file)
            this.form.gambar = formData

        }
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