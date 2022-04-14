<template>
    <q-page>
        <div class="outer-box">
        <div style="display:flex; max-width:90%;">
            <div class="row product_list" >
                <div class="my-card col-sm-2" v-for="(data_product, index) in data_product" :key="index">
                    <q-card>
                        <img class="responsive_img fit-content" width="100" :src="data_product.gambar" alt="">
                        <q-card-section>
                            <div class="text-h6">{{data_product.productName}}</div>
                            <div class="text-subtitle2">Quantity: {{data_product.qty}}</div>
                            <div class="text-subtitle2 currency">{{convertToRupiah(data_product.price)}}</div>
                        </q-card-section>
                        <q-card-section class="q-pt-none">
                            <q-btn>
                                See Detail
                            </q-btn>
                        </q-card-section>
                    </q-card>
                </div>
            </div>
        </div>
        </div>
    </q-page>
</template>

<script>
/* eslint-disable */
import { getDataProduct, getDataCategories } from '../Js/service'
export default {
    name: 'PageIndex',
    data () {
    return {
      data_product: [],
      data_categories:[],
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
      this.convertToRupiah();
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
              this.data_categories = response.data.data_categories;
             console.log(this.data_categories);
          })
      },
    convertToRupiah (angka) {
        var rupiah = ''
        if (angka !== null) {
        var angkarev = Math.ceil(angka).toString().split('').reverse().join('')
        for (var i = 0; i < angkarev.length; i++) if (i % 3 === 0) rupiah += angkarev.substr(i, 3) + '.'
        return 'Rp ' + rupiah.split('', rupiah.length - 1).reverse().join('')
        }
        else {
        return ''
        }
    },
  }
}
</script>
<style>
.product_list{
    padding-top:2rem; 
    gap:3.5rem; 
    padding-left:2rem;
}
.outer-box{
    max-width: 100%;
    display: flex;
    justify-content: center;
}
 @media (max-width:485px){
    .product_list{
        padding-right: 2rem;
    }
}
</style>