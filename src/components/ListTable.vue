<template>
  <div class="overflow-auto">
    <table class="table">
      <thead>
        <tr>
          <th v-for="(val, index) in thead" :key="index" scope="col">{{ val }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(val, index) in items" :key="index">
          <td>
            <div class="w-100">
              <input
                class="input search-sku-code"
                :id="'search-sku-code-' + index"
                @focus="focusSearchSkuCode(index)"
                @keyup="setSearchSkuCode(index)"
                v-model="val.product.skuCode"
              />
            </div>
            <div :id="'search_sku_' + index" class="search-item1">
              <ul>
                <li 
                  v-for="(product, productIndex) in filteredProductsSku" 
                  :key="productIndex"
                  @click="addNewItem(product, index)"
                  >{{ product.sku_code }}
                </li>
              </ul>
            </div>
          </td>
          <td>
            <div class="w-100 d-flex">
              <input
                class="input search-product-name"
                :id="'search-product-name-' + index"
                @focus="focusSearchProductName(index)"
                @keyup="setSearchProductName(index)"
                v-model="val.product.productName"
              />
              <span class="item-promo">
                {{ val.product ? (val.product.discount ? val.product.discount.name : '') : '' }}
              </span>
            </div>
            <div :id="'search_item_' + index" class="search-item2">
              <ul>
                <li 
                  v-for="(product, productIndex) in filteredProductsItem" 
                  :key="productIndex"
                  @click="addNewItem(product, index)"
                  >{{ product.product_name }}
                </li>
              </ul>
            </div>
          </td>
          <td>
            <span id="price">{{ val.product ? (val.product.unitPrice ? formatRupiah(val.product.unitPrice) : 0) : 0 }}</span>
          </td>
          <td>
            <div class="qty-wrap">
              <input 
                class="input qty" 
                :id="'qty_' + index" 
                role="textbox"
                type="number"
                v-model="val.quantity"
              >
            </div>
          </td>
          <td>
            <div class="diskon">
              {{ formatRupiah(discountItem[index]) }}
            </div>
          </td>
          <td class="d-flex align-items-center">
            <span>{{ subtotalItems[index] ? formatRupiah(subtotalItems[index]) : 0 }}</span>
            <button class="trash-btn" @click="deleteItem(index)">
              <img :src="trashIcon">
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios'
import jQuery from "jquery";
const $ = jQuery;
window.$ = $;

import { mapGetters } from 'vuex';

export default {
  name: 'ListTable',
  async mounted() {
    if(this.products.length == 0) {
      this.getProducts()
    }

    let i = 0
    this.products.forEach((product) => { 
      $('#search-sku-code-' + i).value = product.sku_code
      $('#search-product-name-' + i).value = product.product_name
      i += 1
    })

    let itemsLength = this.items.length
    window.onclick = function() {
      let checkFocusSkuCode = false
      let checkFocusProductName = false
      for (let i = 0; i < itemsLength; i++) {
        if (document.getElementById("search-sku-code-" + i) == document.activeElement) {
          checkFocusSkuCode = true
          break
        }
      }
      for (let i = 0; i < itemsLength; i++) {
        if (document.getElementById("search-product-name-" + i) == document.activeElement) {
          checkFocusProductName = true
          break
        }
      }
      if(!checkFocusSkuCode) {
        document.querySelectorAll(".search-item1").forEach(
          a => a.style.display = "none"
        );
      }
      if(!checkFocusProductName) {
        document.querySelectorAll(".search-item2").forEach(
          a => a.style.display = "none"
        );
      }
    }
    
  },
  methods: {
    getProducts: async function() {
      await axios.get('products', {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      }).then(response => {
        this.$store.commit('products', response.data.data)
      }).catch(error => {
        console.log(error)
      })
    },
    deleteItem: function (index) {
      this.$emit('deleteItem', index)
    },
    changeQty: function (index) {
      let value = parseInt($('#qty_' + index).text())
      this.$emit('changeQty', {index, value})
    },
    focusSearchSkuCode: function (index) {
      document.getElementById('search_sku_' + index).style.display = 'block'
    },
    focusSearchProductName: function (index) {
      document.getElementById('search_item_' + index).style.display = 'block'
    },
    addNewItem: function (product, index) {
      document.getElementById('search_sku_' + index).style.display = 'none'
      document.getElementById('search_item_' + index).style.display = 'none'
      this.$emit('addNewItem', {product, index})
    },
    formatRupiah: function (angka) {
      angka = angka.toString()
      
      let number_string = angka.replace(/[^,\d]/g, '').toString()
      let split   		= number_string.split(',')
      let sisa     		= split[0].length % 3
      let rupiah     		= split[0].substr(0, sisa)
      let ribuan     		= split[0].substr(sisa).match(/\d{3}/gi)
    
      // tambahkan titik jika yang di input sudah menjadi angka ribuan
      if(ribuan){
        let separator = sisa ? '.' : ''
        rupiah += separator + ribuan.join('.')
      }
    
      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah
      return rupiah ? 'Rp' + rupiah : 'Rp0'
    },
    setSearchSkuCode: function (index) {
      this.searchSkuCode = this.items[index].product.skuCode
    },
    setSearchProductName: function (index) {
      this.searchProductName = this.items[index].product.productName
    },
  },
  computed: {
    ...mapGetters(['products']),
    discountItem() {
      let discounts = []
      this.items.forEach((item) => {
        if (item.product && item.product.discount && item.product.discount.type == 'amount') {
          let discount = item.product.discount.discountAmount * item.quantity
          discounts.push(discount)
        } else if (item.product && item.product.discount && item.product.discount.type == 'percent') {
          let discount = (item.product.discount.discountPercent * item.product.unitPrice / 100) * item.quantity
          discounts.push(discount)
        } else {
          discounts.push(0)
        }
      })
      return discounts
    },
    subtotalItems() {
      let subtotal = [];
      this.items.forEach(item => {
        let discount = 0
        if (item.product.discount) {
          if (item.product.discount.type == 'percent') {
            discount = item.product.unitPrice * item.product.discount.discountPercent / 100
          } else if (item.product.discount.type == 'amount') {
            discount = item.product.discount.discountAmount
          }
        }
        let subtotalItem = (item.product.unitPrice - discount) * item.quantity
        subtotal.push(subtotalItem);
      });
      return subtotal;
    },
    filteredProductsSku() {
      let query = this.searchSkuCode.toLowerCase()
      if (this.searchSkuCode == '') {
        return this.products
      }
      return this.products.filter(function(el) {
        return el.sku_code.toLowerCase().includes(query)
      });
    },
    filteredProductsItem() {
      let query = this.searchProductName.toLowerCase()
      if (this.searchProductName == '') {
        return this.products
      }
      return this.products.filter(function(el) {
        return el.product_name.toLowerCase().includes(query)
      });
    },
  },
  props: [
    'thead',
    'items',
    'trashIcon'
  ],
  data() {
    return {
      searchSkuCode: '',
      searchProductName: '',
    }
  }
}
</script>

<style>
.overflow-auto {
  max-height: 60vh;
  overflow-y: auto;
}
.table {
  font-size: 11px;
  margin-bottom: 0.5vh;
}
.table th {
  font-weight: 400;
  background: #079FB7!important;
  color: white;
  padding: 1vh 1vw;
}
.table td {
  padding: 0.65vh 1vw!important;
}
.table .input {
  border: none;
  border-bottom: 1px solid rgba(0,0,0,0.3);
  outline: none;
  width: 100%;
}
.table .search-product-name {
  min-width: 100px;
  width: fit-content!important;
}
.table .item-promo {
  background: #EBEFF4;
  border-radius: 4px;
  font-size: 8px;
  font-weight: 700;
  padding: 4px 6px;
}
.table .search-item1,
.table .search-item2 {
  display: none;
  position: absolute;
  background-color: white;
  border: 1px solid grey;
  border-radius: 6px;
}
.table .search-item1 ul,
.table .search-item2 ul {
  list-style-type: none;
  padding: 0;
  margin: 0;
}
.table .search-item1 ul li,
.table .search-item2 ul li {
  border: none;
  background-color: white;
  width: 100%;
  text-align: left;
  padding: 0.5vh 1vw;
  margin: 0;
  cursor: pointer;
}
.table .search-item1 ul li:hover,
.table .search-item2 ul li:hover {
  background-color: rgba(0,0,0,0.2);
}
.table .qty-wrap {
  padding: 0!important;
  border-bottom: 1px solid rgba(0,0,0,0.3);
  text-align: center;
  margin: 0;
}
.table .diskon {
  background: #3BB06A;
  width: fit-content;
  padding: 3px 6px;
  font-size: 10px;
  border-radius: 4px;
  color: white;
  display: flex;
  align-items: center;
}
.table .trash-btn {
  border: none;
  background: none;
  padding: 0;
  color: red;
  display: block;
}
.trash-btn img{
  width: 10px;
  margin-left: 4px;
}


input[type=number]::-webkit-outer-spin-button,
input[type=number]::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
.input.qty {
  width: 20px;
}
</style>