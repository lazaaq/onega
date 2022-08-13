<template>
  <div class="mynavbar">
    <header class="d-flex">
      <div class="header-left">
        <div class="header-name">{{ user ? user.name : getUser() }}</div>
        <div class="header-date">{{ getTodayDate() }}</div>
      </div>
      <div class="header-right">
        <button class="p-0 border-0 bg-white" id="button-logout" @click="logout()">
          <img :src="logoutLogo" class="logout-image">
          <span class="logout-text">Logout</span>
        </button>
      </div>
    </header>
  </div>
</template>

<script>
import axios from 'axios'
import { mapGetters } from 'vuex'

export default {
  name: 'MyNavbar',
  methods: {
    logout: async function() {
      await axios.post('logout', null, {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      }).then(() => {
        localStorage.removeItem('token');
        this.$router.push('/login');
        this.$store.dispatch('user', null);
      }).catch(error => {
        console.log(error);
      });
    },
    getTodayDate: function () {
      let hariArray = ['Minggu','Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']
      let bulanArray = ['Januari','Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
      let date = new Date()

      let menit = date.getMinutes()
      let jam = date.getHours()
      let hariNumber = date.getDay()
      let hari = hariArray[hariNumber]
      let tanggal = date.getDate()
      let bulanNumber = date.getMonth()
      let bulan = bulanArray[bulanNumber]
      let tahun = date.getFullYear()

      if(tanggal < 10) {
        tanggal = '0' + tanggal
      }
      if(menit < 10) {
        menit = '0' + menit
      }
      return `${hari}, ${tanggal} ${bulan} ${tahun}. ${jam}:${menit} WIB`
    },
    getUser: async function() {
      let token = localStorage.getItem('token')
      await axios.get('user', {
        headers: {
          Authorization: 'Bearer ' + token
        }
      }).then(response => {
        this.$store.dispatch('user', response.data.data)
      }).catch(error => {
        console.log(error)
      })
    }
  },
  computed: {
    ...mapGetters(['user'])
  },
  data() {
    return {
      profileLogo: require('@/assets/icon/profile.png'),
      logoutLogo: require('@/assets/icon/logout.svg')
    }
  }
}
</script>

<style scoped>
.mynavbar {
  position: absolute;
  width: 100%;
  z-index: 2;
}
header {
  background-color: white;
  padding: 0.8rem 3vw;
}

header .header-name {
  font-weight: 600;
  font-size: 12px;
}

header .header-date {
  color: #202020;
  opacity: 40%;
  font-size: 12px;
}

header .header-right {
  margin-left: auto;
  display: flex;
  align-items: center;
}

header .logout-image {
  width: 20px;
}

header .logout-text {
  font-size: 12px;
}
</style>