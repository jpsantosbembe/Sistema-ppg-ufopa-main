<script setup >
import Logo from '@/Layouts/full/logo/Logo.vue';
/* Login form */
import LoginForm from '@/Components/auth/LoginForm.vue';
</script>

<template>
    <div class="login-app-wrapper custom-background">
      <v-container fluid class="pa-3">

        <v-row class="h-100vh d-flex justify-center align-center">
          <v-col cols="12" class="d-flex align-center">
              <div class="auth-login d-flex align-center justify-content-center px-lg-24 px-sm-8 px-3">
                  <div class="auth-login-wrapper position-relative rounded-xl mx-lg-16 mx-4 mx-auto w-100">
                      <v-card elevation="10" class="overflow-hidden px-sm-3 position-relative z-index-2">
                          <v-card-item class="px-sm-8 px-3">
                              <Logo />
                              <v-row class="justify-md-space-around align-center py-md-8">
                                  <v-col cols="12" lg="5" md="6" class="d-md-flex d-none">
                                      <img src="/assets/images/backgrounds/business.gif" class="w-100"
                                          alt="login-background" />
                                  </v-col>
                                  <v-col cols="12" lg="5" md="6">
                                      <div class="mt-xl-0 mt-5 mw-100">
                                          <h2 class="text-h2 font-weight-bold mb-2">Posgraduate University-Level System Explorator</h2>
                                          <div class="text-h6 mb-6 font-weight-medium mt-3 mb-8"></div>
                                          <LoginForm />
                                          <h6 class="text-subtitle-1  text-grey100 d-flex align-center mt-6 font-weight-medium">
                                              Quer ser um membro Pulse?
                                              <v-btn class="pl-0 text-primary text-body-1 opacity-1 pl-2 font-weight-medium"
                                                  height="auto" :href="route('register')" variant="plain">Crie uma conta</v-btn>
                                          </h6>
                                      </div>
                                  </v-col>
                              </v-row>
                          </v-card-item>
                      </v-card>
                  </div>
              </div>
          </v-col>
        </v-row>
      </v-container>
    </div>
</template>

<style>
.custom-background {
  background-color: #f0f0f0; /* Alterar para a cor de fundo desejada */
}
</style>
