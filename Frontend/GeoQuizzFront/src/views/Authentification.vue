<script setup>
import { ref } from 'vue'
const connexion = ref(false)
</script>

<template>
  <div class="wrapper fadeInDown">
    <div id="formContent">
      <!-- Tabs Titles -->
      <h2 class="active underlineHover" @click="connexion = false">Sign In</h2>
      <h2 class="active underlineHover" @click="connexion = true">Sign Up</h2>

      <!-- Login Form -->
      <form v-if="!connexion">
        <input type="text" id="login" class="fadeIn second" name="login" placeholder="email">
        <input type="text" id="password" class="fadeIn third" name="login" placeholder="password">
        <input type="submit" class="fadeIn fourth" value="Log In">
      </form>

      <!-- Sign Up Form -->
      <form v-if="connexion">
        <input type="text" id="signup-email" class="fadeIn second" name="signup-email" placeholder="email">
        <input type="text" id="signup-password" class="fadeIn third" name="signup-password" placeholder="password">
        <input type="text" id="signup-password-confirm" class="fadeIn third" name="signup-password-confirm" placeholder="confirm password">
        <input type="submit" class="fadeIn fourth" value="Sign Up">
      </form>
    </div>
  </div>
</template>

<style scoped>
/* BASIC */
html {
  background-color: #56baed;
}

body {
  font-family: "Poppins", sans-serif;
  height: 100vh;
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



input[type=text] {
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

input[type=text]:focus {
  background-color: #fff;
  border-bottom: 2px solid #5fbae9;
}

input[type=text]::placeholder {
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
</style>