<template>
  <div class="login-page">
    <div class="illustration">
      <div class="text">
        <div class="title">
          Welcome to Onega Cashier
        </div>
        <div class="subtitle">
          The ultimate project boilerplate for next generation web apps.
        </div>
      </div>
      <div class="image">
        <img src="@/assets/illustration/take-away.svg" width="100%">
      </div>
    </div>
    <div class="form">
      <div class="title mb-2">
        Sign in
      </div>
      <div class="subtitle mb-2">
        Enter your Email and password
      </div>
      <div class="wrap-form">
        <input
          type="text"
          name="email"
          id="email"
          placeholder="Email"
          class="mb-2 input"
        >
        <div class="d-flex">
          <input
            type="text"
            name="password"
            id="password"
            placeholder="Password"
            class="mb-2 input"
          >
          <img :src="eyeOpenLogo" :style="'margin-left: -30px; margin-top: -7px'" @click="togglePassword()" id="toggle-password">
        </div>
        <input
          type="text"
          name="cashier"
          id="cashier"
          placeholder="Cashier"
          class="mb-2 input"
          :readonly="'isReadOnly'"
        >
        <div class="d-flex align-items-center">
          <div class="time d-flex align-items-center">
            00:00:00
          </div>
          <div class="ms-auto login-button-wrap" :style="'height=60px'">
            <ButtonField 
              text='Login'
              @click="login()"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

import ButtonField from '@/components/form/ButtonField.vue'

export default {
  components: {
    ButtonField
  },
  methods: {
    login: async function() {
      this.email = document.getElementById('email').value;
      this.password = document.getElementById('password').value;
      let validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
      if (!this.email.match(validRegex)) {
        alert("Invalid email address!");
        return 
      }
      
      let loginData = {
        email: this.email,
        password: this.password
      }

      // login
      let token = null
      await axios.post('login', loginData).then(response => {
        localStorage.setItem('token', response.data.access_token)
        token = response.data.access_token
        this.$store.dispatch('user', response.data.data)
        this.$router.push('/')
      }).catch((error) => {
        alert('Username atau password salah!')
        console.log(error)
        return
      });

      // get products
      await axios.get('products', {
        headers: {
          Authorization: 'Bearer ' + token
        }
      }).then(response => {
        let products = response.data.data
        this.$store.dispatch('products', products)
      }).catch(error => {
        console.log(error);
        return
      });
    },
    togglePassword: function() {
      let password = document.getElementById('password')
      let togglePassword = document.getElementById('toggle-password')
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password'
      password.setAttribute('type', type)
      const eyeLogo = togglePassword.getAttribute('src') === this.eyeOpenLogo ? this.eyeClosedLogo : this.eyeOpenLogo
      togglePassword.setAttribute('src', eyeLogo)
    }
  },
  props: [
    'dataButton'
  ],
  data() {
    return {
      email: '',
      password: '',
      cashier: '',
      eyeOpenLogo: require('@/assets/icon/eye-open.svg'),
      eyeClosedLogo: require('@/assets/icon/eye-closed.svg')
    }
  }
}
</script>

<style scoped>
.login-page {
  display: flex;
  width: 100vw;
  height: 100vh;
}
.illustration {
  background-color: #047E92;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  width: 30%;
}
.illustration .text {
  padding: 0 2rem;
}
.illustration .title {
  color: white;
  font-style: italic;
  font-size: 24px;
  font-weight: 600;
}
.illustration .subtitle {
  color: white;
  font-size: 13px;
  font-weight: 300;
  margin-top: 1rem;
}
.illustration .image {
  width: 80%;
  margin-top: 1.5rem;
}
.form {
  width: 70%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}
.form .title {
  font-size: 28px;
  font-weight: 500;
}
.form .subtitle {
  font-size: 12px;
  color: rgba(0, 0, 0, 0.4);
}
.form .wrap-form {
  width: 300px;
}
.form .time {
  font-size: 13px;
  font-weight: 500;
}
.form .login-button-wrap {
  height: 40px;
  width: 100px;
}

#cashier {
  background-color: rgba(0,0,0,0.1);
}


.input {
  border: 1px solid rgba(0, 0, 0, 0.1);
  padding: 0.8vh 0.3vw 0.8vh 0.3vw;
  font-size: 12px;
  width: 100%
}
.input::-webkit-input-placeholder {
  font-size: 11px;
  padding-left: 8px;
}
.disabled {
  background-color: rgba(0,0,0,0.5)
}
</style>