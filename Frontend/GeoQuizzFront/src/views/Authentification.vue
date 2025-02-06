<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const router = useRouter()
const connexion = ref(false)
const email = ref('')
const password = ref('')
const passwordConfirm = ref('')
const isLoading = ref(false)

// Fonction pour se connecter
const signin = async () => {
  isLoading.value = true
  try {
    const response = await axios.post('http://localhost:40000/signin', {
      email: email.value,
      password: password.value,
    })

    // Sauvegarde du token dans localStorage
    const accessToken = response.headers.access_token
    localStorage.setItem('authToken', accessToken)

    alert('Connexion réussie !')
    router.push('/home')
  } catch (error) {
    alert('Erreur lors de la connexion : mot de passe ou email incorrect')
  } finally {
    isLoading.value = false
  }
}

// Fonction pour s'inscrire
const signup = async () => {
  if (password.value !== passwordConfirm.value) {
    alert('Les mots de passe ne correspondent pas !')
    return
  }

  isLoading.value = true
  try {
    await axios.post('http://localhost:40000/signup', {
      email: email.value,
      password: password.value,
    })
    alert('Inscription réussie ! Vous pouvez maintenant vous connecter.')
    connexion.value = false
  } catch (error) {
    console.log(error);
    alert('Erreur lors de l’inscription : utilisateur déjà existant ')
  } finally {
    isLoading.value = false
  }
}

</script>

<template>
  <div class="wrapper fadeInDown">
    <div id="formContent">
      <!-- Spinner -->
      <div v-if="isLoading" class="spinner-container">
        <div class="spinner"></div>
      </div>

      <!-- Tabs Titles -->
      <h2 class="active underlineHover" @click="connexion = false">Sign In</h2>
      <h2 class="active underlineHover" @click="connexion = true">Sign Up</h2>

      <!-- Login Form -->
      <form v-if="!connexion && !isLoading" @submit.prevent="signin">
        <input
          type="text"
          id="login"
          class="fadeIn second"
          v-model="email"
          placeholder="email"
        />
        <input
          type="password"
          id="password"
          class="fadeIn third"
          v-model="password"
          placeholder="password"
        />
        <input type="submit" class="fadeIn fourth" value="Log In" />
      </form>

      <!-- Sign Up Form -->
      <form v-if="connexion && !isLoading" @submit.prevent="signup">
        <input
          type="text"
          id="signup-email"
          class="fadeIn second"
          v-model="email"
          placeholder="email"
        />
        <input
          type="password"
          id="signup-password"
          class="fadeIn third"
          v-model="password"
          placeholder="password"
        />
        <input
          type="password"
          id="signup-password-confirm"
          class="fadeIn third"
          v-model="passwordConfirm"
          placeholder="confirm password"
        />
        <input type="submit" class="fadeIn fourth" value="Sign Up" />
      </form>
    </div>
  </div>
</template>




<style scoped>

.spinner-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 500%;
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  background-color: rgba(255, 255, 255, 0.7);
  z-index: 10;
}

.spinner {
  border: 4px solid rgba(0, 0, 0, 0.1);
  border-left-color: #000;
  border-radius: 50%;
  width: 50px;
  height: 50px;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}




a {
  color: #92badd;
  display:inline-block;
  text-decoration: none;
  font-weight: 400;
}

h2 {
  text-align: center;
  font-size: 16px;
  font-weight: 600;
  text-transform: uppercase;
  display:inline-block;
  margin: 40px 8px 10px 8px;
  color: #cccccc;
}



/* STRUCTURE */

.wrapper {
  display: flex;
  align-items: center;
  flex-direction: column;
  justify-content: center;
  width: 100%;
  min-height: 100%;
  padding: 20px;
}

#formContent {
  border-radius: 10px 10px 10px 10px;
  background: #fff;
  width: 90%;
  max-width: 450px;
  position: relative;

  box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
  text-align: center;
}




/* TABS */

h2.active {
  color: #0d0d0d;
  border-bottom: 2px solid #5fbae9;
}



/* FORM TYPOGRAPHY*/

input[type=button], input[type=submit], input[type=reset]  {
  background-color: #56baed;
  border: none;
  color: white;
  padding: 15px 80px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  text-transform: uppercase;
  font-size: 13px;
  box-shadow: 0 10px 30px 0 rgba(95,186,233,0.4);
  border-radius: 5px 5px 5px 5px;
  margin: 5px 20px 40px 20px;
}



input {
  background-color: #f6f6f6;
  color: #0d0d0d;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 5px;
  width: 85%;
  border: 2px solid #f6f6f6;
  border-radius: 5px 5px 5px 5px;
}

input:focus {
  background-color: #fff;
  border-bottom: 2px solid #5fbae9;
}

input::placeholder {
  color: #cccccc;
}


/*Underline*/
.underlineHover:after {
  display: block;
  left: 0;
  bottom: -10px;
  width: 0;
  height: 2px;
  background-color: #56baed;
  content: "";
  transition: width 0.2s;
}

.underlineHover:hover {
  color: #0d0d0d;
}

.underlineHover:hover:after{
  width: 100%;
}



/* OTHERS */

*:focus {
  outline: none;
}

* {
  box-sizing: border-box;
}

body {
  background-image: url("../assets/statueGold.jpg");
  background-size: cover; /* Adapte l'image à la taille de l'écran */
  background-position: center; /* Centre l'image */
  background-repeat: no-repeat; /* Pas de répétition */
}
</style>