<script setup>
import { ref, provide, onMounted } from 'vue';
import axios from 'axios';
import GerenciamentoFotos from './components/gerenciamentoFotos.vue';

// Base URL via env (vite)
axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL || '/api';

// Provide para os filhos
const nivelAcesso = ref(null);
const usuario = ref(null);
provide('nivelAcesso', nivelAcesso);
provide('usuario', usuario);

// Checagem de sessão (usa rota demo — troque para /check-session real no deploy)
async function checaSessao() {
  try {
    const resp = await axios.get('/demo/check-session', { withCredentials: true });
    // API demo: { logado: true, session: { nivel_acesso: 'X', nomeServidor: 'Fulano' } }
    if (!resp.data.logado) {
      window.location.href = import.meta.env.VITE_LOGIN_URL || '/login';
      return;
    }
    nivelAcesso.value = resp.data.session?.nivel_acesso ?? null;
    usuario.value = resp.data.session?.nomeServidor ?? null;
  } catch (err) {
    console.error('Erro ao verificar sessão:', err);
    window.location.href = import.meta.env.VITE_LOGIN_URL || '/login';
  }
}

onMounted(() => {
  //checaSessao();
});
</script>

<template>
  <div class="h-dvh bg-gray-100">
    <GerenciamentoFotos />
  </div>
</template>