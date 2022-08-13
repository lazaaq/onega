<template>
  <div>
    <div class="header">
      <div class="onega-symbol">
        <img :src="onegaLogo">
      </div>
      <div class="sales-order">
        <span>Sales Order</span>
      </div>
    </div>

    <div class="description">
      <div class="yth">
        <div>Kepada</div>
        <div class="font-bold">PT ONEGA</div>
        <div>Amartha Safira C10/11, Krajan, Sepande,</div>
        <div>Kec. Candi, Sidoarjo</div>
        <div>+62 8123456789</div>
      </div>
      <div class="invoice-detail">
        <table>
          <tr class="id-transaksi">
            <td>ID Transaksi</td>
            <td class="px-2">:</td>
            <td class="font-bold font-italic">{{ invoice ? invoice.id : '' }}</td>
          </tr>
          <tr class="id-transaksi">
            <td>Date Issued</td>
            <td class="px-2">:</td>
            <td class="font-bold font-italic">{{ invoice ? getDateFromTimestamps(invoice.created_at) : '' }}</td>
          </tr>
          <tr class="id-transaksi">
            <td>Invoice No</td>
            <td class="px-2">:</td>
            <td class="font-bold font-italic">{{ invoice ? getInvoiceNumber(invoice.created_at) : '' }}</td>
          </tr>
        </table>
      </div>
    </div>

    <div class="invoice-items">
      <table class="table-white">
        <tr class="bg-white font-black border-bottom">
          <th>No</th>
          <th>SKU Code</th>
          <th>Item</th>
          <th>Price</th>
          <th>Qty</th>
          <th>Diskon</th>
          <th>Subtotal</th>
        </tr>
        <tr v-for="(item, index) in invoiceItems" :key="index" class="border-bottom">
          <td>{{ index + 1 }}</td>
          <td>{{ item.product ? (item.product.sku_code ? item.product.sku_code : 'null') : 'null' }}</td>
          <td>
            {{ item.product ? (item.product.product_name ? item.product.product_name : 'null') : 'null' }}
            <br><span class="font-bold font-italic">{{ item.product ? (item.product.discount ? item.product.discount.name : '') : '' }}</span>
          </td>
          <td>{{ item.product ? (item.product.unit_price ? formatRupiah(item.product.unit_price) : 'null') : 'null' }}</td>
          <td>{{ item.quantity }}</td>
          <td>{{ getDiscount(item) }}</td>
          <td>{{ item.subtotal ? formatRupiah(item.subtotal) : formatRupiah(0) }}</td>
        </tr>
        <tr class="border-bottom">
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>Subtotal :</td>
          <td>{{ invoice ? formatRupiah(invoice.subtotal) : 0 }}</td>
        </tr>
        <tr class="total-price">
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="font-italic">Total(IDR) : </td>
          <td class="font-italic">{{ invoice ? formatRupiah(invoice.total_price) : 0 }}</td>
        </tr>
      </table>
    </div>

    <div class="footer">
      <div>
        Terbilang:
      </div>
      <div class="terbilang-value">
        {{ invoice ? terbilang(invoice.total_price) : '' }} Rupiah
      </div>
      <div class="syarat">
        *Syarat syarat dan ketentuan lainnya dalam pelaksanaan pekerjaan tertuang dalam lampiran order kerja ini yang merupakan satu kesatuan yang tidak terpisahkan.
      </div>
      <hr class="my-1">
      <div class="notes">
        <div>
          Notes:
        </div>
        <div class="notes-value">
          {{ invoice ? invoice.notes : 'null' }}
        </div>
      </div>
      <hr class="my-1">
    </div>

    <div class="ttd pt-4">
      <div class="rekanan me-5">
        <div>
          Order disetujui oleh Rekanan:
        </div>
        <div>
          Vendor 1
        </div>
        <div class="line border-bottom">
        </div>
      </div>
      <div class="floo ms-5">
        <div>
          PT. FLoo Integra Digital
        </div>
        <div class="line border-bottom">
          Iqbal Permana
        </div>
      </div>
    </div>

    <div class="copyright">
      <div class="thanks-logo">
        <img :src="thanksLogo">
      </div>
      <div class="contact">
        onega@mail.com  |  +62 1234567891  |  onega.com
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'PrintView',
  async mounted() {
    await axios.get('invoices/' + this.id, {
      headers: {
        Authorization: 'Bearer ' + localStorage.getItem('token')
      }
    }).then(response => {
      this.invoice = response.data.data;
      this.invoiceItems = this.invoice.invoice_items
    });
  },
  methods: {
    getDiscount: function(item) {
      if(item && item.product && item.product.discount) {
        if(item.product.discount.type == 'percent' && item.product.discount.discount_percent) {
          let discount = (item.product.discount.discount_percent * item.product.unit_price / 100) * item.quantity
          return this.formatRupiah(discount)
        } else if (item.product.discount.type == 'amount' && item.product.discount.discount_amount) {
          let discount = (item.product.discount.discount_amount) * item.quantity
          return this.formatRupiah(discount)
        }
      }
      return this.formatRupiah(0)
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
    terbilang: function(angka) {
      var bilne=["","Satu","Dua","Tiga","Empat","Lima","Enam","Tujuh","Delapan","Sembilan","Sepuluh","Sebelas"];

			if(angka < 12){
				return bilne[angka];
			} else if (angka < 20){
				return this.terbilang(angka-10)+" Belas";
			} else if (angka < 100){
				return this.terbilang(Math.floor(parseInt(angka)/10))+" Puluh "+this.terbilang(parseInt(angka)%10);
			} else if (angka < 200){
				return "Seratus "+this.terbilang(parseInt(angka)-100);
			} else if (angka < 1000){
				return this.terbilang(Math.floor(parseInt(angka)/100))+" Ratus "+this.terbilang(parseInt(angka)%100);
			} else if (angka < 2000){
				return "Seribu "+this.terbilang(parseInt(angka)-1000);
			} else if (angka < 1000000){
				return this.terbilang(Math.floor(parseInt(angka)/1000))+" Ribu "+this.terbilang(parseInt(angka)%1000);
			} else if (angka < 1000000000){
				return this.terbilang(Math.floor(parseInt(angka)/1000000))+" Juta "+this.terbilang(parseInt(angka)%1000000);
			} else if (angka < 1000000000000){
				return this.terbilang(Math.floor(parseInt(angka)/1000000000))+" Milyar "+this.terbilang(parseInt(angka)%1000000000);
			} else if (angka < 1000000000000000){
				return this.terbilang(Math.floor(parseInt(angka)/1000000000000))+" Trilyun "+this.terbilang(parseInt(angka)%1000000000000);
			}
    }
  },
  data() {
    return {
      id: this.$route.query.id,
      invoice: null,
      invoiceItems: null,
      onegaLogo: require('@/assets/icon/onega-logo.png'),
      thanksLogo: require('@/assets/icon/thanks-logo.png'),
    }
  }
}
</script>

<style scoped>
  .header {
    display: flex;
    align-items: center;
    padding: 3vh 5vw;
  }
  .header .sales-order {
    font-weight: 700;
    font-size: 20px;
    margin-left: auto;
    font-style: italic;
  }

  .description {
    display: flex;
    padding: 2vh 5vw 3vh 5vw;
    font-size: 12px;
  }
  .description .invoice-detail {
    margin-left: auto;
  }

  .invoice-items {
    padding: 1vh 5vw;
  }
  .table-white {
    font-size: 11px;
    margin-bottom: 0.5vh;
    width: 100%;
  }
  .table-white th {
    font-weight: 400;
    background: white!important;
    color: black;
  }
  .table-white td {
    padding: 0.5vh 0
  }
  .table-white .total-price td {
    font-weight: 700;
    font-size: 14px;
  }
  .footer {
    padding: 1vh 5vw;
    font-size: 12px;
  }
  .footer .terbilang-value {
    font-weight: 700;
    font-size: 14px;
  }
  .footer .notes-value {
    font-weight: 700;
  }
  .ttd {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    text-align: center;
  }
  .ttd .line {
    margin-top: 5rem;
  }

  .copyright {
    padding: 5vh 5vw 3vh 5vw;
    display: flex;
    align-items: center;
  }
  .copyright .thanks-logo {
    width: 60%;
  }
  .copyright .contact {
    margin-left: auto;
    font-size: 12px;
    color: rgba(0,0,0,0.3);
  }

  .font-bold {
    font-weight: 700;
  }
  .font-italic {
    font-style: italic;
  }
  .bg-white {
    background-color: white!important;
  }
  .font-black {
    color: black!important;
  }
  .border-bottom {
    border-bottom: 1px solid black;
  }
</style>