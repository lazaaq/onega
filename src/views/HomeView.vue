<template>
  <div class="home">
    <MyNavbar/>

    <div class="body row mx-0" style="margin-right: 0;">
      <div class="wrap col-9 pl-0 pr-2">
        <CashierTab 
          :activeTab="activeTab" 
          @changetab="updateActiveTab($event)" 
          @addtab="addTab($event)"
          @closetab="closeTab($event)"
        />
        <div class="left-card">
          <div class="card-title mb-2">
            Customer
          </div>
          <div class="d-flex w-100">
            <div class="pr-2" style="width: 100%;">
              <div>
                <TextField 
                  name="search" 
                  id="search" 
                  placeholder="Nama, Nomor, ID" 
                  @focus="focusInput()"
                  @keyup="keyupSearchCustomer('search')"  
                />
              </div>
              <div class="search-customer" id="search-customer">
                <ul>
                  <li 
                    class="py-1"
                    v-for="(customer, index) in customers"
                    :key="'customer_' + index"
                    @click="selectCustomer(customer)"
                >
                    <div class="d-flex align-items-center">
                      <div class="customer-name me-5">
                        {{ customer.name }}
                      </div>
                      <div class="ms-auto customer-code">
                        code : {{ customer.code }}
                      </div>
                    </div>
                    <div class="customer-id">
                      id : {{ customer.id }}
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <hr class="my-2">
          <div class="d-flex mb-2 align-items-center">
            <div class="card-title" style="margin-top: auto; margin-bottom: auto;">
              List Order
            </div>
            <div class="scan-wrap" style="margin-left:auto">
              <TextField 
                placeholder="Input or Scan items" 
                name="scan" 
                id="scan"
              />
            </div>
          </div>
          <ListTable
            :thead="thead"
            :items="tbody[activeTab-1].items"
            :trashIcon="trashIcon"
            @deleteItem="deleteItem($event)"
            @addNewItem="addNewItem($event)"
          />
          <div class="d-flex">
            <div>
              <SimpleButton
                :text="'Add On Item'"
                :srcImage="plusIcon"
                @click="addOnItem()"
              />
            </div>
            <div style="margin-left:auto">
              <SimpleButton
                text="Delete All"
                :srcImage="deleteIcon"
                @click="deleteAll()"
                style="color:red"
              />
            </div>
          </div>
        </div>
      </div>
      <div class="wrap col-3 pl-2" style="padding-top: 27.78px">
        <div class="right-card">
          <div class="card-title">
            Detail Order
          </div>
          <hr class="mt-4">
          <div class="d-flex">
            <div class="detail-name">
              Subtotal
            </div>
            <div class="detail-value">
              {{ formatRupiah(detailOrder.subtotal) }}
            </div>
          </div>
          <hr class="my-2">
          <div class="d-flex">
            <div class="detail-name">
              Discount
            </div>
            <div class="detail-value">
              -{{ formatRupiah(detailOrder.discount) }}
            </div>
          </div>
          <hr class="my-2">
          <div class="d-flex">
            <div class="detail-name">
              PPN 11%
            </div>
            <div class="detail-value">
              {{ formatRupiah(detailOrder.tax) }}
            </div>
          </div>
          <hr class="my-2">
          <div class="d-flex">
            <div class="total-name"> 
              Total
            </div>
            <div class="total-value">
              {{ formatRupiah(detailOrder.totalPrice) }}
            </div>
          </div>
          <button 
            class="checkout-btn" 
            type="button" 
            data-bs-toggle="modal" 
            :data-bs-target="'#' + idCheckoutModal" 
            @click="checkout()"
            > Checkout
          </button>
        </div>
        <CheckoutModal 
          :idModal="idCheckoutModal"
          :thead="thead"
          :items="tbody[activeTab-1].items"
          :detailOrder="detailOrder"
          :subtotalItems="subtotalItems"
          :invoice="invoice"
          @print="print($event)"
        />
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import jQuery from "jquery";
const $ = jQuery;
window.$ = $;

import { mapGetters } from 'vuex';

import MyNavbar from '@/components/MyNavbar.vue'
import TextField from '@/components/form/TextField.vue'
import ListTable from '@/components/ListTable.vue'
import SimpleButton from '@/components/SimpleButton.vue'
import CashierTab from '@/components/CashierTab.vue'
import CheckoutModal from '@/components/CheckoutModal.vue'

export default {
  name: 'HomeView',
  components: {
    MyNavbar,
    TextField,
    ListTable,
    SimpleButton,
    CashierTab,
    CheckoutModal
  },
  mounted() {
    // adding bootstrap javascript to the page (inside tag head)
    let bootstrapJS = document.createElement('script')
    bootstrapJS.setAttribute('src', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js')
    document.head.appendChild(bootstrapJS)

    // jquery
    window.onclick = function() {
      if (document.getElementById('search') != document.activeElement) {
        document.querySelectorAll(".search-customer").forEach(
          a => a.style.display = "none"
        );
      }
    }
  },
  methods: {
    updateActiveTab: function (newActiveTab) {
      this.activeTab = newActiveTab
    },
    addTab: function (tabs) {
      let newCart = {
        id: null,
        customer_id: null,
        subtotal: 0,
        discount: 0,
        tax: 0,
        total_price: 0,
        notes: 'notes',
        items: [],
      }
      this.tbody.push(newCart)
      this.activeTab = tabs
    },
    closeTab: function (index) {
      if (index + 1 <= this.activeTab) {
        this.activeTab -= 1
      }
      this.tbody.splice(index, 1)
    },
    addOnItem: function () {
      // create new cart item data
      const newItem = {
        product: {},
        quantity: 1,
      }
      this.tbody[this.activeTab - 1].items.push(newItem)
    },
    deleteAll: function () {
      this.tbody[this.activeTab - 1].cartId = 0
      this.tbody[this.activeTab - 1].items = []
    },
    deleteItem: function (index) {
      this.tbody[this.activeTab - 1].items.splice(index, 1)
    },
    addNewItem: function(param) {
      let product = param.product
      let index = param.index
      this.tbody[this.activeTab - 1].items[index].product = {
        id: product.id,
        skuCode: product.sku_code,
        productName: product.product_name,
        description: product.description,
        unitPrice: product.unit_price,
        discount: {
          id: product.discount ? product.discount.id : 0,
          name: product.discount ? product.discount.name : '',
          discountAmount: product.discount ? product.discount.discount_amount : 0,
          discountPercent: product.discount ? product.discount.discount_percent : 0,
          type: product.discount ? product.discount.type : '',
        }
      }
    },
    checkout: async function() {
      // store to make_invoice 
      let items = []
      let i = 0
      this.tbody[this.activeTab - 1].items.forEach(item => {
        items.push({
          product_id: item.product ? item.product.id : 0,
          quantity: item.quantity,
          subtotal: this.subtotalItems[i],
        })
        i += 1
      })
      let invoice = {
        customer_id: this.selectedCustomer ? this.selectedCustomer.id : 1,
        subtotal: this.detailOrder.subtotal,
        discount: this.detailOrder.discount,
        tax: this.detailOrder.tax,
        total_price: this.detailOrder.totalPrice,
        notes: '',
        items: items,
      }
      await axios.post('invoices/make_invoice', invoice, {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      }).then((response) => {
        this.invoice = response.data.data
      }).catch(error => {
        console.log(error)
      })
    },
    // save: async function (notes) {
    //   // cart
    //   let cart = {
    //     customer_id: this.selectedCustomer.id,
    //     subtotal: this.detailOrder.subtotal,
    //     discount: this.detailOrder.discount,
    //     tax: this.detailOrder.tax,
    //     total_price: this.detailOrder.totalPrice,
    //     notes: notes,
    //   }
    //   // cart items
    //   let cartItems = []
    //   let i = 0
    //   this.tbody[this.activeTab - 1].items.forEach(item => {
    //     let cartItem = {
    //       cart_id: response.data.data.id,
    //       product_id: item.product ? item.product.id : 0,
    //       quantity: item.quantity,
    //       subtotal: this.subtotalItems[i],
    //     }
    //     cartItems.push(cartItem)
    //     i += 1
    //   })

    //   // store to db cart
    //   const response = await axios.post('carts', cart, {
    //     headers: {
    //       Authorization: 'Bearer ' + localStorage.getItem('token')
    //     }
    //   }).catch(error => {
    //     console.log(error)
    //   })
    //   // store to db cartitems
    //   for(i = 0; i < cartItems.length; i++) {
    //     await axios.post('cart_items', cartItems[0], {
    //       headers: {
    //         Authorization: 'Bearer ' + localStorage.getItem('token')
    //       }
    //     }).catch(error => {
    //       console.log(error)
    //     })
    //   }
    // },
    print: async function (notes) {
      // change notes in invoice
      if(notes) {
        let param = {
          notes: notes
        }
        await axios.put('invoices/' + this.invoice.id, param, {
          headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token')
          }
        }).then((response) => {
          console.log(response)
        }).catch(error => {
          console.log(error)
        })
      }
      // redirect
      let routeData = this.$router.resolve({name: 'print', query: {id: this.invoice.id}});
      window.open(routeData.href, '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');

      // remove all list items from cart
      let newCart = {
        id: null,
        customer_id: null,
        subtotal: 0,
        discount: 0,
        tax: 0,
        total_price: 0,
        notes: 'notes',
        items: [],
      }
      this.tbody[this.activeTab - 1] = newCart
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
    focusInput: function () {
      document.getElementById('search-customer').style.display = 'block'
    },
    keyupSearchCustomer: async function (id) {
      this.searchCustomerQuery = $('#' + id).val()
      await this.getCustomer(this.searchCustomerQuery)
    },
    selectCustomer: async function (customer) {
      this.selectedCustomer = customer
      $('#search').val(this.selectedCustomer.name)

      await axios.get('carts/by_customer/' + this.selectedCustomer.id, {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      }).then(response => {
        let data = response.data.data
        if(data == null) {
          let cart = {
            id: 0,
            customer_id: this.selectedCustomer.id,
            notes: '',
            items: []
          }
          this.tbody[this.activeTab - 1] = cart
        } else {
          let cart = {
            id: data.id,
            customer_id: data.customer_id,
            notes: data.notes,
            items: []
          }
          data.cart_items.forEach(item => {
            let newItem = {
              product: {
                id: item.product.id,
                skuCode: item.product.sku_code,
                productName: item.product.product_name,
                description: item.product.description,
                unitPrice: item.product.unit_price,
                discount: {
                  id: item.product.discount ? item.product.discount.id : 0,
                  name: item.product.discount ? item.product.discount.name : '',
                  discountAmount: item.product.discount ? item.product.discount.discount_amount : 0,
                  discountPercent: item.product.discount ? item.product.discount.discount_percent : 0,
                  type: item.product.discount ? item.product.discount.type : '',
                }
              },
              quantity: item.quantity
            }
            cart.items.push(newItem)
          })
          this.tbody[this.activeTab - 1] = cart
        }
      }).catch(error => {
        console.log(error)
      })
    },
    getCustomer: async function(query) {
      await axios.get('customers/search/' + query, {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      }).then((response) => {
        this.customers = response.data
      }).catch(error => {
        console.log(error)
      })
    },
    getDateFromTimestamps: function(timestamps) {
      let date = new Date(timestamps)
      let bulanArray = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Des']
      let tanggal = date.getDate()
      let bulan = bulanArray[date.getMonth()]
      let tahun = date.getFullYear()
      return tanggal + ' ' + bulan + ' ' + tahun
    },
    getInvoiceNumber: function(timestamps) {
      let date = new Date(timestamps)
      let tanggal = date.getDate()
      if(tanggal < 10) {
        tanggal = '0' + tanggal
      }
      let bulan = date.getMonth() + 1
      if(bulan < 10) {
        bulan = '0' + bulan
      }
      let tahun = date.getFullYear().toString().slice(-2)
      let invoiceId = this.invoice.id
      return `${invoiceId}${tanggal}${bulan}${tahun}`
    },
  },
  computed: {
    ...mapGetters(['user']),
    detailOrder() {
      let detailOrder = {
        subtotal: 0,
        discount: 0,
        tax: 0,
        totalPrice: 0,
      }
      let cartItems = this.tbody[this.activeTab - 1].items
      cartItems.forEach(item => {
        // accumulate subtotal
        detailOrder.subtotal += item.quantity * (item.product.unitPrice ? item.product.unitPrice : 0)
        // accumulate discount
        if (item.product && item.product.discount && item.product.discount.type == 'amount') {
          detailOrder.discount += item.quantity * (item.product.discount.discountAmount ? item.product.discount.discountAmount : 0)
        } else if (item.product && item.product.discount && item.product.discount.type == 'percent') {
          detailOrder.discount += item.quantity * ((item.product.discount.discountPercent ? item.product.discount.discountPercent : 0) * (item.product.unitPrice ? item.product.unitPrice : 0) / 100)
        }
      })
      detailOrder.tax = detailOrder.subtotal * 0.11
      detailOrder.totalPrice = detailOrder.subtotal - detailOrder.discount + detailOrder.tax
      // if detailOrder.totalPrice is negative, set it to 0
      if(detailOrder.totalPrice < 0) {
        detailOrder.totalPrice = 0
      }
      return detailOrder
    },
    subtotalItems() {
      let subtotal = [];
      this.tbody[this.activeTab - 1].items.forEach(item => {
        let discount = 0
        if (item.product.discount) {
          if (item.product.discount.type == 'percent') {
            discount = item.product.unitPrice * item.product.discount.discountPercent / 100
          } else if (item.product.discount.type == 'amount') {
            discount = item.product.discount.discountAmount
          }
        }
        let subtotalItem = (item.product.unitPrice - discount) * item.quantity
        // if discount is bigger than the price, set total to 0
        if(subtotalItem < 0) {
          subtotalItem = 0
        }
        subtotal.push(subtotalItem);
      });
      return subtotal;
    },
    
  },
  data() {
    return {
      thead: [
        'SKU Code',
        'Item',
        'Price',
        'Qty',
        'Diskon',
        'Subtotal'
      ],
      tbody: [
        {
          id: 0,
          customer_id: 0,
          notes: '',
          items: [],
        }
      ],
      activeTab: 1,
      idCheckoutModal: 'idCheckoutModal',
      searchCustomerQuery: '',
      customers: [],
      selectedCustomer: null,
      invoice: null,
      trashIcon: require('@/assets/icon/trash.png'),
      plusIcon: require('@/assets/icon/plus.png'),
      deleteIcon: require('@/assets/icon/delete-red.png'),
    }
  }
}
</script>

<style scoped>
.body {
  background-color: #EBEFF4;
  height: 100vh;
  padding: 10vh 3vw 6vh 3vw;
  z-index: 1;
}
.body .left-card {
  background-color: white;
  padding: 0.75rem 1.5rem 0.75rem 1.5rem;
}
.body .left-card .card-title {
  font-weight: 600;
  font-style: italic;
  font-size: 16px;
}
.body .right-card {
  background-color: white;
  padding: 1.5rem;
}
.body .right-card .card-title {
  font-size: 14px;
  font-weight: 600;
  font-style: italic;
}
.body .right-card .detail-name {
  font-weight: 400;
  font-size: 14px;
  color: #202020;
  opacity: 50%;
}
.body .right-card .detail-value {
  font-weight: 400;
  font-size: 14px;
  margin-left: auto;
}
.body .right-card .total-name {
  font-weight: 400;
  font-size: 14px;
}
.body .right-card .total-value {
  font-weight: 700;
  font-size: 20px;
  margin-left: auto;
  color: #079FB7;
}
.body .right-card .checkout-btn {
  width: 100%;
  border: none;
  background: #079FB7;
  color: white;
  padding: 10px;
  border-radius: 6px;
  margin-top: 14px;
  font-size: 14px;
  font-weight: 600;
  font-style: italic;
}
.body .ringkasan-order {
  font-size: 12px;
}
#search-customer {
  display: none;
  position: absolute;
  z-index: 100;
  background: white;
}
.search-customer ul {
  list-style: none;
  padding: 0;
  margin: 0;
}
.search-customer ul li {
  cursor: pointer;
  padding: 0 1vw;
  background: white;
  border-bottom: 1px solid rgba(0,0,0,0.1);
}
.search-customer ul li:hover {
  background: grey;
}
.search-customer .customer-name {
  font-weight: 700;
  font-size: 12px;
}
.search-customer .customer-code {
  font-size: 10px;
}
.search-customer .customer-id {
  font-size: 10px;
}
.total-checkout {
  font-size: 16px;
  font-weight: 700;
  color: #079FB7;
  font-style: italic;
}
</style>
