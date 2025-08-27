<template>
  <div class="min-h-dvh bg-gray-100 p-6">

    <!-- HEADER -->
    <header class="relative bg-blue-400 text-white rounded-lg py-4 mb-6 shadow-lg px-4 flex items-center">
      <!-- Logo esquerdo -->
      <a href="https://amttdetra.com/painel.php" class="mr-4">
        <img src="/logomarca_negativa.png" alt="Carregando..." class="w-12 h-12 rounded-3xl transition-shadow duration-200 hover:shadow-xl" />
      </a>

      <!-- Título central -->
      <h1 class="absolute left-1/2 transform -translate-x-1/2 text-3xl font-bold">Validação de Fotos</h1>

      <!-- Ícone direito -->
      <a href="https://amttdetra.com/questionario/interno" class="ml-auto text-3xl hover:underline">
        📋
      </a>
    </header>

    <!-- FILTROS E HISTÓRICO -->
    <section class="flex flex-nowrap justify-between items-center mb-6 gap-2">
      <div class="flex items-end gap-4 flex-1 m-0 p-0">

        <!-- Status resumo -->
        <div @click="getStatus()" class="py-2 w-6 hover:text-blue-700" title="Resumo dos status">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z"/>
          </svg>
        </div>

        <!-- Pesquisa -->
        <div @click="abrirModalPesquisa()" class="py-2 w-6 hover:text-blue-700" title="Pesquisar Dado Específico">
          <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11h2v5m-2 0h4m-2.592-8.5h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
          </svg>
        </div>

        <!-- Beneficiário -->
        <div class="w-44">
          <label class="block text-sm font-medium text-gray-700 mb-1">Benificiário:</label>
          <select v-model="beneficiarioSelecionado" class="w-full border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 hover:border-blue-700">
            <option selected value="todos_benificiarios">TODOS</option>
            <option value="MEIA-PASSAGEM">MEIA PASSAGEM</option>
            <option value="IDOSO-60">IDOSO 60-64</option>
            <option value="IDOSO-65">IDOSO 65+</option>
          </select>
        </div>

        <!-- Status -->
        <div class="w-44">
          <label class="block text-sm font-medium text-gray-700 mb-1">Status:</label>
          <select v-model="statusSelecionado" class="w-full border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 hover:border-blue-700">
            <option value="todos">Todos</option>
            <option value="pendente">Pendentes</option>
            <option value="regular_com_email">Regulares C/ email</option>
            <option value="regular_sem_email">Regulares S/ email</option>
            <option value="irregular_com_email">Irregulares C/ Email</option>
            <option value="irregular_sem_email">Irregulares S/ Email</option>
            <option value="bloqueado_com_email">Bloqueados C/ Email</option>
            <option value="bloqueado_sem_email">Bloqueados S/ Email</option>
          </select>
        </div>

        <!-- Campo de pesquisa -->
        <div class="w-60">
          <label class="block text-sm font-medium text-gray-700 mb-1">Campo de pesquisa:</label>
          <input v-model="filtroPesquisa" type="text" class="w-full rounded-xl border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Pesquise aqui..." />
        </div>

        <!-- Datas -->
        <div class="flex items-end gap-4">
          <div class="w-44">
            <div class="flex items-center justify-between mb-1">
              <label class="text-sm text-gray-700">Selecionar Data 1:</label>
              <div class="flex gap-1">
                <button type="button" class="px-2 text-blue-600 hover:text-blue-800 font-semibold" @click="mudarData('dataInicial', -1)">&lt;</button>
                <button type="button" class="px-2 text-blue-600 hover:text-blue-800 font-semibold" @click="mudarData('dataInicial', 1)">&gt;</button>
              </div>
            </div>
            <input type="date" v-model="dataInicial" class="w-full text-center rounded-xl border border-gray-300 bg-white py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
          </div>

          <div @click="alternarDatas()" class="flex items-center justify-center cursor-pointer">
            <span v-if="!mostraDataFinal" class="text-4xl font-bold">+</span>
            <span v-else class="text-4xl font-bold">-</span>
          </div>
        </div>

        <div v-if="mostraDataFinal" class="w-44">
          <div class="flex items-center justify-between mb-1">
            <label class="block text-sm font-medium text-gray-700">Selecionar Data 2</label>
            <div class="flex gap-1">
              <button type="button" class="px-2 text-blue-600 hover:text-blue-800 font-semibold" @click="mudarData('dataFinal', -1)">&lt;</button>
              <button type="button" class="px-2 text-blue-600 hover:text-blue-800 font-semibold" @click="mudarData('dataFinal', 1)">&gt;</button>
            </div>
          </div>
          <input type="date" v-model="dataFinal" class="w-full text-center rounded-xl border border-gray-300 bg-white py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
        </div>

        <!-- Botão Buscar -->
        <div class="w-48">
          <button @click="buscarDados()" class="flex bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-5 rounded-2xl shadow-lg transition duration-200">
            <svg class="w-6 h-6 text-gray-800 dark:text-white mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
            </svg>
            Buscar
          </button>
        </div>

      </div>
    </section>

    <!-- INFORMAÇÕES DE RESULTADOS -->
    <section class="flex items-center gap-2 mb-2">
      <h2 class="text-lg font-semibold text-gray-800">
        Quantidade de Resultados ({{ formatarData(dataInicial) }}<span v-if="dataFinal != null"> - {{ formatarData(dataFinal) }}</span>): {{ alunos.length }} / {{ alunosOrdenados.length }}
      </h2>
    </section>

    <!-- TABELA DE DADOS -->
    <main>
      <transition name="slide-fade">
        <div class="overflow-x-auto bg-white shadow-xl border border-gray-200">
          <table class="min-w-full table-auto border-collapse text-sm">
            <thead>
              <tr class="bg-blue-300 text-gray-800 uppercase tracking-wide">
                <!-- Cabeçalho completo com os SVGs de ordenação -->
                <th class="w-[5%] px-4 py-1 text-left border border-black">
                  <div class="flex justify-between items-center">
                    <span>ID</span>
                    <OrdenacaoSetas coluna="id" v-model:colunaAtiva="colunaOrdenada" v-model:direcao="direcaoOrdenacao" />
                  </div>
                </th>

                <th class="w-[33%] px-4 py-1 text-left border border-black">
                  <div class="flex justify-between items-center">
                    <span>Nome</span>
                    <OrdenacaoSetas coluna="nome" v-model:colunaAtiva="colunaOrdenada" v-model:direcao="direcaoOrdenacao" />
                  </div>
                </th>

                <th class="w-[10%] px-4 py-1 text-left border border-black">
                  <div class="flex justify-between items-center">
                    <span>CPF</span>
                    <OrdenacaoSetas coluna="cpf" v-model:colunaAtiva="colunaOrdenada" v-model:direcao="direcaoOrdenacao" />
                  </div>
                </th>

                <th class="w-[22%] px-4 py-1 text-left border border-black">
                  <div class="flex justify-between items-center">
                    <span>Status</span>
                    <OrdenacaoSetas coluna="status" v-model:colunaAtiva="colunaOrdenada" v-model:direcao="direcaoOrdenacao" />
                  </div>
                </th>

                <th class="w-[15%] px-4 py-1 text-left border border-black">
                  <div class="flex justify-between items-center">
                    <span>Tipo</span>
                    <OrdenacaoSetas coluna="tipo" v-model:colunaAtiva="colunaOrdenada" v-model:direcao="direcaoOrdenacao" />
                  </div>
                </th>

                <th class="w-[10%] px-4 py-1 text-left border border-black">
                  <div class="flex justify-between items-center">
                    <span>Data</span>
                    <OrdenacaoSetas coluna="respondido_em" v-model:colunaAtiva="colunaOrdenada" v-model:direcao="direcaoOrdenacao" />
                  </div>
                </th>

                <th class="w-[10%] px-4 py-1 text-left border border-black">Ações</th>
              </tr>
            </thead>

            <tbody>
              <!-- Conteúdo dinâmico da tabela -->
            </tbody>
          </table>
        </div>
      </transition>
    </main>
  </div>
</template>


<script>
import Swal from "sweetalert2";
import OrdenacaoSetas from "./OrdenacaoSetas.vue";
import { useToast } from "vue-toastification";
import { JsonExcel } from "vue3-json-excel";
import axios from "axios";

/**
 * Segurança aplicada:
 * - Usa axios.defaults.baseURL via VITE_API_BASE_URL (configure no seu .env do Vite)
 * - Remove senha fixa do cliente (backend deve retornar URLs assinadas)
 * - Máscara de identificador/CPF para nomes de arquivos
 * - Não injeta HTML cru: constrói tabela com DOM (evita XSS)
 * - Tratamento seguro de download: suporta dataURI e URLs (fetch -> blob)
 */

axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL || "/api";

export default {
  name: "TabelaCondutores",
  components: {
    OrdenacaoSetas,
    JsonExcel,
  },

  data() {
    return {
      mostrarModal: false,
      alunoSelecionado: {},
      alunos: [],
      paginaAtual: 1,
      itensPorPagina: 50,

      statusSelecionado: "regular_sem_email",
      beneficiarioSelecionado: "todos_benificiarios",
      filtroPesquisa: "",
      dadosStatus: [],
      colunaOrdenada: "id_respondente",
      direcaoOrdenacao: "desc",

      dataInicial: null,
      dataFinal: null,
      mostraDataFinal: false,

      loadingTabela: true,
      loadingFoto: true,
      loadingIdentidade: true,

      dados: [],
      campos: {
        id_respondente: "ID",
        nome: "Nome",
        email: "E-mail",
        cpf: "Identificador",
        respostas: "Respostas",
      },
    };
  },

  methods: {
    // --- UTILIDADES ---
    maskIdentifier(val = "") {
      // Máscara simples: mantém últimos 4 caracteres, substitui resto por *
      const s = String(val || "");
      if (s.length <= 4) return s.replace(/./g, "*");
      return s.slice(0, -4).replace(/./g, "*") + s.slice(-4);
    },

    safeFilename(name) {
      // Remove caracteres perigosos do filename
      return String(name || "file").replace(/[^a-z0-9_\-\.]/gi, "_");
    },

    async safeFetchAndDownload(url, filename) {
      try {
        // Se for data URI, baixa diretamente
        if (url.startsWith("data:")) {
          const link = document.createElement("a");
          link.href = url;
          link.download = filename;
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);
          return;
        }

        // Caso contrário, busca como blob (suporta URLs assinadas)
        const resp = await fetch(url, { credentials: "include" });
        if (!resp.ok) throw new Error("Falha no fetch da imagem");

        const blob = await resp.blob();
        const blobUrl = URL.createObjectURL(blob);
        const link = document.createElement("a");
        link.href = blobUrl;
        link.download = filename;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(blobUrl);
      } catch (err) {
        console.error("Erro ao baixar arquivo:", err);
        const toast = useToast && typeof useToast === "function" ? useToast() : null;
        if (toast) toast.error("Erro ao baixar arquivo");
        else Swal.fire("Erro", "Não foi possível baixar o arquivo.", "error");
      }
    },

    formatarStatus(status) {
      switch (Number(status)) {
        case 0:
          return "Pendente";
        case 1:
          return "OK";
        case 2:
          return "Irregular";
        case 3:
          return "OK + Email";
        case 4:
          return "Irregular + Email";
        case 5:
          return "Bloqueado";
        case 6:
          return "Bloqueado + Email";
        default:
          return "Desconhecido";
      }
    },

    // --- AÇÕES PRINCIPAIS ---
    async confirmarTipo() {
      const result = await Swal.fire({
        title: "Escolha o Tipo",
        text: "Como deseja gerar a tabela?",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Crédito Direto",
        cancelButtonText: "Gerenciamento Total",
        reverseButtons: true,
      });

      if (result.isConfirmed) {
        await this.montarTabelaEmpresas(1);
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        await this.montarTabelaEmpresas(2);
      }
    },

    async montarTabelaEmpresas(tipo) {
      try {
        const resp = await axios.get("/demo/tabela-excel", {
          params: { dataInicial: this.dataInicial, tipo },
        });
        this.dados = resp.data.dados || [];
        await this.$nextTick();
        if (this.$refs.excelExport && this.$refs.excelExport.generate) {
          this.$refs.excelExport.generate();
        }
      } catch (err) {
        console.error("Erro montarTabelaEmpresas:", err);
        Swal.fire("Erro", "Não foi possível gerar a tabela.", "error");
      }
    },

    async abrirModal(aluno) {
      // Mapeia dados mas não expõe CPF cru nem senhas
      this.alunoSelecionado = {
        id_respondente: aluno.id_respondente,
        nome: aluno.nome,
        identifier_masked: this.maskIdentifier(aluno.cpf || aluno.identifier || ""),
        email_masked: aluno.email ? aluno.email.replace(/(.{2}).+(@.+)/, "$1***$2") : null,
        telefone: aluno.telefone,
        status: aluno.status,
        foto: null,
        identidade: null,
        baixado_por: aluno.baixado_por,
        baixado_em: aluno.baixado_em,
        tipo: aluno.tipo,
        instituicao: aluno.instituicao,
      };

      this.mostrarModal = true;
      this.loadingFoto = true;
      this.loadingIdentidade = true;

      try {
        // Backend seguro deve retornar URLs assinadas: { foto_url, identidade_url }
        const resp = await axios.get(`/demo/foto-por-id/${aluno.id_respondente}`);
        if (this.alunoSelecionado.id_respondente !== aluno.id_respondente) return; // segurança contra race

        this.alunoSelecionado.foto = resp.data.foto_url || null;
        this.alunoSelecionado.identidade = resp.data.identidade_url || null;
      } catch (err) {
        console.error("Erro ao buscar fotos:", err);
        // Não vaza detalhes pro usuário
      } finally {
        this.loadingFoto = false;
        this.loadingIdentidade = false;
      }
    },

    fecharModal() {
      this.mostrarModal = false;
      this.alunoSelecionado = {};
    },

    alternarDatas() {
      this.mostraDataFinal = !this.mostraDataFinal;
      if (!this.mostraDataFinal) {
        this.dataFinal = null;
        this.puxarDados();
      }
    },

    formatarData(dateString) {
      if (!dateString) return "";
      const [year, month, day] = dateString.split("-");
      if (!year || !month || !day) return "";
      return `${day}/${month}/${year}`;
    },

    mudarData(dataTipo, dias) {
      if (!["dataInicial", "dataFinal"].includes(dataTipo)) return;
      let dataAtualStr = this[dataTipo] || new Date().toISOString().substr(0, 10);
      const [y, m, d] = dataAtualStr.split("-");
      const dataAtual = new Date(y, m - 1, d);
      dataAtual.setDate(dataAtual.getDate() + dias);
      const ano = dataAtual.getFullYear();
      const mes = String(dataAtual.getMonth() + 1).padStart(2, "0");
      const dia = String(dataAtual.getDate()).padStart(2, "0");
      this[dataTipo] = `${ano}-${mes}-${dia}`;
    },

    formatarDateLocal(date) {
      const day = String(date.getDate()).padStart(2, "0");
      const month = String(date.getMonth() + 1).padStart(2, "0");
      const year = date.getFullYear();
      return `${year}-${month}-${day}`;
    },

    formatarDateTime(datetime) {
      const date = new Date(datetime);
      const day = String(date.getDate()).padStart(2, "0");
      const month = String(date.getMonth() + 1).padStart(2, "0");
      const year = date.getFullYear();
      const hours = String(date.getHours()).padStart(2, "0");
      const minutes = String(date.getMinutes()).padStart(2, "0");
      return `${day}/${month}/${year} - ${hours}:${minutes}`;
    },

    formatarCPF(cpf) {
      const numeros = String(cpf).replace(/\D/g, "");
      if (numeros.length !== 11) return cpf;
      return `${numeros.slice(0,3)}.${numeros.slice(3,6)}.${numeros.slice(6,9)}-${numeros.slice(9,11)}`;
    },

    async getStatus() {
      try {
        const resp = await axios.get("/demo/resumo-status");
        const categorias = resp.data.resumo || [];
        const totalGeral = resp.data.total_registros || 0;

        // Construir DOM seguro (evita injeção)
        const container = document.createElement("div");
        categorias.forEach((cat) => {
          const h3 = document.createElement("h3");
          h3.style.color = "blue";
          h3.textContent = cat.categoria_nome || "Categoria";
          container.appendChild(h3);

          (cat.status || []).forEach((s) => {
            const p = document.createElement("p");
            p.innerHTML = `<b>${this.escapeText(s.descricao)}:</b> ${this.escapeText(String(s.quantidade))}`;
            container.appendChild(p);
          });

          const totalP = document.createElement("p");
          totalP.innerHTML = `<b>Total da categoria:</b> ${this.escapeText(String(cat.total_categoria || 0))}`;
          container.appendChild(totalP);

          const hr = document.createElement("hr");
          container.appendChild(hr);
        });

        const totalFooter = document.createElement("div");
        totalFooter.style.marginTop = "12px";
        totalFooter.innerHTML = `<b>Total geral:</b> ${this.escapeText(String(totalGeral))}`;
        container.appendChild(totalFooter);

        Swal.fire({
          title: "Resumo dos Status",
          html: container.outerHTML,
          icon: "info",
          confirmButtonText: "Fechar",
          width: "600px",
        });
      } catch (err) {
        console.error("Erro ao buscar status:", err);
        Swal.fire("Erro", "Não foi possível buscar os dados.", "error");
      }
    },

    escapeText(t) {
      // Garante que o texto seja tratado como texto, não HTML
      const div = document.createElement("div");
      div.textContent = t;
      return div.innerHTML;
    },

    async abrirModalPesquisa() {
      const { isConfirmed, value } = await Swal.fire({
        title: "Pesquisar Respondente",
        input: "text",
        inputLabel: "Digite o nome ou identificador",
        showCancelButton: true,
        confirmButtonText: "Pesquisar",
        cancelButtonText: "Cancelar",
        inputValidator: (v) => (v ? null : "Você precisa digitar algo!"),
      });

      if (!isConfirmed) return;

      try {
        const resp = await axios.get("/demo/pesquisar", { params: { termo: value } });
        const dados = resp.data || [];
        if (!dados.length) {
          Swal.fire("Nenhum resultado encontrado.", "", "info");
          return;
        }
        const htmlTabela = this.gerarTabelaHtml(dados);
        Swal.fire({
          title: `Encontrado(s): ${dados.length}`,
          html: htmlTabela,
          width: "90%",
          scrollbarPadding: false,
          customClass: { popup: "swal-tabela" },
        });
      } catch {
        Swal.fire("Erro", "Ocorreu um erro ao buscar os dados.", "error");
      }
    },

    async getDadoEspecifico(termo) {
      try {
        const resp = await axios.get("/demo/pesquisar", { params: { termo } });
        const dados = resp.data || [];
        if (!dados.length) {
          Swal.fire("Nenhum resultado encontrado.", "", "info");
          return;
        }
        const htmlTabela = this.gerarTabelaHtml(dados);
        Swal.fire({
          title: `Encontrado(s): ${dados.length}`,
          html: htmlTabela,
          width: "90%",
          customClass: { popup: "swal-tabela" },
        });
      } catch {
        Swal.fire("Erro", "Erro ao buscar os dados.", "error");
      }
    },

    gerarTabelaHtml(dados) {
      // Constrói tabela via DOM (mais seguro que concatenar strings)
      const container = document.createElement("div");
      container.style.overflowX = "auto";
      container.style.maxHeight = "60vh";

      const table = document.createElement("table");
      table.style.width = "100%";
      table.style.borderCollapse = "collapse";
      table.style.fontSize = "14px";
      table.border = 1;

      const thead = document.createElement("thead");
      thead.style.background = "#f2f2f2";
      const trHead = document.createElement("tr");
      ["ID", "Nome", "Identificador", "Email", "Respondido em", "Resposta em", "Status"].forEach((h) => {
        const th = document.createElement("th");
        th.textContent = h;
        th.style.padding = "6px";
        trHead.appendChild(th);
      });
      thead.appendChild(trHead);
      table.appendChild(thead);

      const tbody = document.createElement("tbody");
      dados.forEach((d) => {
        const tr = document.createElement("tr");
        const pushCell = (value) => {
          const td = document.createElement("td");
          td.style.padding = "6px";
          td.textContent = value ?? "-";
          tr.appendChild(td);
        };

        pushCell(d.id_respondente);
        pushCell(d.nome);
        pushCell(this.maskIdentifier(d.cpf || d.identifier || ""));
        pushCell(d.email ? d.email.replace(/(.{2}).+(@.+)/, "$1***$2") : "-");
        pushCell(d.respondido_em ?? "-");
        pushCell(d.baixado_em ?? "-");
        pushCell(this.formatarStatus(d.status));

        tbody.appendChild(tr);
      });

      table.appendChild(tbody);
      container.appendChild(table);
      return container.outerHTML;
    },

    async puxarDados() {
      this.loadingTabela = true;
      try {
        const resp = await axios.get("/demo/todos", {
          params: { dataInicial: this.dataInicial, dataFinal: this.dataFinal },
        });
        this.loadingTabela = false;
        this.alunos = resp.data.dados || [];
        this.dataInicial = resp.data.dataUsada || this.dataInicial;
        this.alunos = this.atribuirCoresFixas(this.alunos);
      } catch (err) {
        this.loadingTabela = false;
        console.error("Erro puxarDados:", err);
      }
    },

    buscarDados() {
      this.puxarDados();
      this.statusSelecionado = "todos";
      this.filtroPesquisa = "";
      this.paginaAtual = 1;
    },

    async atualizarStatusAluno(id, status) {
      try {
        await axios.patch("/demo/atualizar-status", { id, status });
        this.alunoSelecionado.status = status;
        Swal.fire({
          icon: "success",
          title: "Atualizado!",
          text: "Status atualizado com sucesso.",
          timer: 1500,
          showConfirmButton: false,
        });
      } catch (err) {
        console.error("Erro ao atualizar status:", err);
        Swal.fire({ icon: "error", title: "Erro", text: "Falha ao atualizar status." });
      }
    },

    async escreverMensagemIrregular() {
      const { value: texto } = await Swal.fire({
        title: "Escreva a mensagem para o email irregular",
        input: "textarea",
        inputLabel: "Mensagem",
        inputPlaceholder: "Digite aqui a mensagem personalizada...",
        showCancelButton: true,
        confirmButtonText: "Enviar",
        cancelButtonText: "Cancelar",
        inputValidator: (v) => (v ? null : "Você precisa escrever alguma mensagem."),
      });

      if (texto) {
        await this.enviarEmail(20, texto);
      }
    },

    async enviarEmail(e, textoCustomizado = null) {
      const { id_respondente, nome, email } = this.alunoSelecionado;
      if (!email) {
        Swal.fire("Erro", "E-mail não encontrado.", "error");
        return;
      }

      let rota = "/demo/enviar-email";
      let novoStatus = null;
      let mensagemConfirmacao = "";

      if (e === 1) {
        rota = "/demo/enviar-email-regular";
        novoStatus = 3;
        mensagemConfirmacao = `Deseja enviar o e-mail de confirmação para ${nome}?`;
      } else if (e === 2) {
        rota = "/demo/enviar-email";
        novoStatus = 4;
        mensagemConfirmacao = `Deseja enviar o e-mail de erro para ${nome}?`;
      } else if (e === 20) {
        rota = "/demo/enviar-email-com-texto";
        novoStatus = 4;
      } else if (e === 5) {
        rota = "/demo/enviar-email-bloqueado";
        novoStatus = 6;
        mensagemConfirmacao = `Deseja enviar o e-mail de bloqueio para ${nome}?`;
      } else {
        Swal.fire("Erro", "Tipo de e-mail desconhecido.", "error");
        return;
      }

      if (e === 20) {
        try {
          await axios.patch(rota, {
            id: id_respondente,
            nome,
            email,
            texto_extra: textoCustomizado,
          });
          this.alunoSelecionado.status = novoStatus;
          Swal.fire("Sucesso", "E-mail enviado com sucesso!", "success").then(() => this.puxarDados());
        } catch (err) {
          console.error(err);
          Swal.fire("Erro", "Não foi possível enviar o e-mail.", "error");
        }
        return;
      }

      const result = await Swal.fire({
        title: "Confirmar envio",
        text: mensagemConfirmacao,
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Sim, enviar",
        cancelButtonText: "Cancelar",
      });

      if (!result.isConfirmed) return;

      try {
        await axios.patch(rota, { id: id_respondente, nome, email });
        this.alunoSelecionado.status = novoStatus;
        Swal.fire("Sucesso", "E-mail enviado com sucesso!", "success").then(() => this.puxarDados());
      } catch (err) {
        console.error(err);
        Swal.fire("Erro", "Não foi possível enviar o e-mail.", "error");
      }
    },

    async baixarImagem(tipo, nomeFoto) {
      const url = this.alunoSelecionado[tipo];
      if (!url) return;

      const identifierMasked = this.alunoSelecionado.identifier_masked || "anon";
      const safeName = this.safeFilename(`${identifierMasked}_${nomeFoto}_${this.alunoSelecionado.id_respondente}.jpg`);
      await this.safeFetchAndDownload(url, safeName);
    },

    async baixarImagemComprimida(tipo, nomeFoto) {
      const url = this.alunoSelecionado[tipo];
      if (!url) return;

      // Se for data URI, tenta compactar no client; se for URL, baixa direto (backend pode entregar já compactado)
      if (url.startsWith("data:")) {
        const img = await this.carregarImagem(url);
        const dataUrl = this.comprimirImagem(img, 0.7);
        const safeName = this.safeFilename(`${nomeFoto}_${this.alunoSelecionado.id_respondente}.jpg`);
        await this.safeFetchAndDownload(dataUrl, safeName);
        return;
      }

      // Para URLs externas, busca e baixa (backend deve prover versão adequada)
      const safeName = this.safeFilename(`${nomeFoto}_${this.alunoSelecionado.id_respondente}.jpg`);
      await this.safeFetchAndDownload(url, safeName);
    },

    carregarImagem(base64) {
      return new Promise((resolve, reject) => {
        const img = new Image();
        img.onload = () => resolve(img);
        img.onerror = (e) => reject(e);
        img.src = base64;
      });
    },

    comprimirImagem(imagem, qualidade = 0.7) {
      const canvas = document.createElement("canvas");
      const maxLado = 2000;
      let { width, height } = imagem;
      if (width > maxLado || height > maxLado) {
        const proporcao = Math.min(maxLado / width, maxLado / height);
        width = Math.round(width * proporcao);
        height = Math.round(height * proporcao);
      }
      canvas.width = width;
      canvas.height = height;
      const ctx = canvas.getContext("2d");
      ctx.drawImage(imagem, 0, 0, width, height);
      return canvas.toDataURL("image/jpeg", qualidade);
    },

    copiarTexto(texto) {
      const toast = useToast && typeof useToast === "function" ? useToast() : null;
      navigator.clipboard
        .writeText(texto)
        .then(() => {
          if (toast) toast.info(`Texto copiado`);
        })
        .catch(() => {
          if (toast) toast.error("Erro ao copiar texto");
          else Swal.fire("Erro", "Não foi possível copiar o texto.", "error");
        });
    },

    atribuirCoresFixas(alunos) {
      const cores = [
        "bg-blue-300",
        "bg-green-300",
        "bg-pink-200",
        "bg-yellow-200",
        "bg-sky-200",
        "bg-purple-300",
        "bg-orange-200",
        "bg-gray-300",
      ];

      const validos = alunos.filter((a) => ![2, 4, 5, 6].includes(Number(a.status)));
      const tamanhoGrupo = Math.ceil(validos.length / cores.length) || 1;
      let validIndex = 0;

      return alunos.map((aluno) => {
        if ([2, 4, 5, 6].includes(Number(aluno.status))) {
          return { ...aluno, cor: "" };
        } else {
          const grupo = Math.floor(validIndex / tamanhoGrupo);
          validIndex++;
          return { ...aluno, cor: cores[grupo] || "" };
        }
      });
    },
  },

  mounted() {
    this.puxarDados();
  },

  computed: {
    alunosOrdenados() {
      let resultado = this.alunos.slice();

      if (this.statusSelecionado !== "todos") {
        const mapaStatus = {
          pendente: [0],
          regular_com_email: [3],
          regular_sem_email: [1],
          irregular_com_email: [4],
          irregular_sem_email: [2],
          bloqueado_sem_email: [5],
          bloqueado_com_email: [6],
        };
        const filtros = mapaStatus[this.statusSelecionado];
        if (filtros) {
          resultado = resultado.filter((aluno) => filtros.includes(Number(aluno.status)));
        }
      }

      if (this.beneficiarioSelecionado !== "todos_benificiarios") {
        resultado = resultado.filter((aluno) => aluno.tipo === this.beneficiarioSelecionado);
      }

      if (this.filtroPesquisa && this.filtroPesquisa.trim() !== "") {
        const busca = this.filtroPesquisa.trim().toLowerCase();
        resultado = resultado.filter(
          (aluno) =>
            String(aluno.id_respondente).includes(busca) ||
            String((aluno.nome || "").toLowerCase()).includes(busca) ||
            String(aluno.cpf || aluno.identifier || "").includes(busca) ||
            String(aluno.respondido_em || "").includes(busca)
        );
      }

      if (!this.direcaoOrdenacao || !this.colunaOrdenada) return resultado;

      const camposNumericos = ["id", "id_respondente", "status"];
      return resultado.sort((a, b) => {
        let va = a[this.colunaOrdenada];
        let vb = b[this.colunaOrdenada];

        if (camposNumericos.includes(this.colunaOrdenada)) {
          va = Number(va || 0);
          vb = Number(vb || 0);
        } else {
          va = String(va || "").toLowerCase();
          vb = String(vb || "").toLowerCase();
        }

        if (va === vb) return 0;
        const ord = va > vb ? 1 : -1;
        return this.direcaoOrdenacao === "asc" ? ord : -ord;
      });
    },

    alunosPaginados() {
      const inicio = (this.paginaAtual - 1) * this.itensPorPagina;
      return this.alunosOrdenados.slice(inicio, inicio + this.itensPorPagina);
    },

    indiceInicio() {
      return (this.paginaAtual - 1) * this.itensPorPagina;
    },
    indiceFim() {
      let fim = this.paginaAtual * this.itensPorPagina;
      if (fim > this.alunosOrdenados.length) fim = this.alunosOrdenados.length;
      return fim;
    },
    totalPaginas() {
      return Math.max(1, Math.ceil(this.alunosOrdenados.length / this.itensPorPagina));
    },
    paginasVisiveis() {
      const total = this.totalPaginas;
      const atual = this.paginaAtual;
      let inicio = Math.max(1, atual - 2);
      let fim = inicio + 4;
      if (fim > total) {
        fim = total;
        inicio = Math.max(1, fim - 4);
      }
      const paginas = [];
      for (let i = inicio; i <= fim; i++) paginas.push(i);
      return paginas;
    },
  },

  watch: {
    filtroPesquisa() {
      this.paginaAtual = 1;
    },
    statusSelecionado() {
      this.paginaAtual = 1;
    },
  },
};
</script>


<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.slide-fade-enter-active {
  transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.3s ease-in;
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateX(20px);
  opacity: 0;
}

button,
a,
[role="button"],
input[type="button"],
input[type="submit"],
input[type="reset"] {
  cursor: pointer;
}
</style>
