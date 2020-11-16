<template>
  <div>
    <button class="btn btn-primary" @click="mostrarForm()">
      Vincular Cuenta
    </button>

    <div class="container">
      <form @submit.prevent="agregar" v-if="activarForm">
        <div class="container">
          <h3 class="mt-2">Vincule cuenta</h3>
        </div>
        <div class="row">
          <div class="col-4">
            <label for="summoner_name">Summoner</label>
            <input
              v-model="cuenta.summoner_name"
              type="text"
              class="form-control"
              id="summoner_name"
              placeholder="Nombre de invocador"
            />
          </div>
          <div class="col-4">
            <label for="region">Región</label>
            <select class="form-control" id="region" v-model="cuenta.region">
              <option value="" selected disabled hidden>Elige tu región</option>
              <option value="br1">br1 --- Brasil 1</option>
              <option value="eun1">eun1 --- Europa Norte</option>
              <option value="euw1">euw1 --- Europa Oeste</option>
              <option value="jp1">jp1 --- Japon</option>
              <option value="kr">kr --- Korea</option>
              <option value="la1">la1 --- LatinoAmerica 1</option>
              <option value="la2">la2 --- LatinoAmerica 2</option>
              <option value="na1">na1 --- NorteAmerica</option>
              <option value="oc1">oc1 --- Oceania</option>
              <option value="ru">ru --- Rusia</option>
              <option value="tr1">tr1 --- Turquia</option>
            </select>
          </div>
          <div class="col-4">
            <hr />
            <button id="btn-vincular" class="btn btn-primary" type="submit">
              Vincular ahora
            </button>
            <button class="btn btn-danger" type="reset" @click="cancelarForm()">
              Cancelar
            </button>
          </div>
        </div>
      </form>

      <div
        class="alert alert-success alert-dismissible fade show mt-3"
        role="alert"
        v-if="invocadorCorrecto"
      >
        <strong>Se ha vinculado correctamente la cuenta.</strong>
        <button
          @click="cerrarMensaje()"
          type="button"
          class="close"
          data-dismiss="alert"
          aria-label="Close"
        >
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div
        class="alert alert-danger alert-dismissible fade show mt-3"
        role="alert"
        v-if="invocadorNoEncontrado"
      >
        <strong> El nombre de invocador no se encuentra en esta región.</strong>
        <button
          @click="cerrarMensaje()"
          type="button"
          class="close"
          data-dismiss="alert"
          aria-label="Close"
        >
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div
        class="alert alert-warning alert-dismissible fade show mt-3"
        role="alert"
        v-if="invocadorSinPartidas"
      >
        Se ha vinculado la cuenta,<strong
          >pero es un invocador sin partidas clasificatorias.</strong
        >
        <button
          @click="cerrarMensaje()"
          type="button"
          class="close"
          data-dismiss="alert"
          aria-label="Close"
        >
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    </div>
    <!--······························DE USER.BLADE.PHP······································ -->
    <div
      _ngcontent-cxn-c66=""
      fxlayoutalign="center center"
      class="login-separator"
      style="
        place-content: center;
        align-items: center;
        flex-direction: row;
        box-sizing: border-box;
        display: flex;
      "
    >
      <div
        _ngcontent-cxn-c66=""
        fxflex=""
        class="line-gradient-lr-primary"
        style="flex: 1 1 0%; box-sizing: border-box"
      ></div>
      <span>o</span>
      <div
        _ngcontent-cxn-c66=""
        fxflex=""
        class="line-gradient-rl-primary"
        style="flex: 1 1 0%; box-sizing: border-box"
      ></div>
    </div>
    <div class="container">
      <div class="text-center">
        <h2 class="white">Accede a tus cuentas</h2>
        <p>
          Puedes acceder de una manera rapida a la vista general de las cuentas
          vinculadas
        </p>
      </div>
    </div>
    <!--FIN PARTE USER.BLADE.PHP -->
    <!-- INICIO MOSTRARCUENTASCOMPONENT.VUE-->
    <div>
      <button class="btn btn-primary" @click="mostrar()">Cuentas</button>
      <button class="btn btn-danger" @click="ocultar()" v-if="activarOcultar">
        Ocultar
      </button>
      <div class="container mt-3" v-if="activarContenedor">
        <div class="card mb-3" v-for="(item, index) in cuentas" :key="index">
          <div class="row no-gutters">
            <div class="col-md-4 mb-2 mt-2">
              <span>Clasificatoria duo queue</span>
              <p>
                <strong>{{ item.tier_duo }}</strong
                >&nbsp;&nbsp;{{ item.rank_duo }}
              </p>

              <img v-bind:src="item.img_duo" class="card-img" alt="#" />
            </div>
            <hr />
            <div class="col-md-4">
              <div class="card-body">
                <h4 class="card-title">
                  {{ item.summoner_name.replace(/[%20]/g, " ") }}
                </h4>
                <br />
                <span>Region:&nbsp;&nbsp;{{ item.region.toUpperCase() }}</span>
                <hr />
                <p class="card-text">Summoner Level:&nbsp;{{ item.level }}</p>

                <hr />
                <h5>Duo Queue</h5>
                <span
                  >Puntos de liga:&nbsp;&nbsp;{{ item.league_points_duo }}</span
                >
                <br />
                <span>Partidas Ganadas:&nbsp;&nbsp;{{ item.wins_duo }}</span>
                <br />
                <span>Partidas Perdidas:&nbsp;&nbsp;{{ item.losses_duo }}</span>
                <br />
                <span
                  >WinRatio:&nbsp;&nbsp;{{
                    Math.round(
                      (item.wins_duo * 100) / (item.wins_duo + item.losses_duo)
                    )
                  }}&nbsp;%</span
                >
                <hr />
                <h5>Flex 5 x 5</h5>
                <span
                  >Puntos de liga:&nbsp;&nbsp;{{
                    item.league_points_flex
                  }}</span
                >
                <br />
                <span>Partidas Ganadas:&nbsp;&nbsp;{{ item.wins_flex }}</span>
                <br />
                <span
                  >Partidas Perdidas:&nbsp;&nbsp;{{ item.losses_flex }}</span
                >
                <br />
                <span
                  >WinRatio:&nbsp;&nbsp;{{
                    Math.round(
                      (item.wins_flex * 100) /
                        (item.wins_flex + item.losses_flex)
                    )
                  }}&nbsp;%</span
                >
              </div>
            </div>
            <div class="col-md-4 mb-2 mt-2">
              <span>clasificatoria flex 5x5</span>
              <p>
                <strong>{{ item.tier_flex }}</strong
                >&nbsp;&nbsp;{{ item.rank_flex }}
              </p>

              <img v-bind:src="item.img_flex" class="card-img" alt="#" />
            </div>
            <div class="container mb-4">
              <a class="btn btn-primary" href="#">Ir a Partidos</a>
              <button
                class="btn btn-danger"
                @click="eliminarCuenta(item, index)"
              >
                Eliminar Cuenta
              </button>
              <button
                class="btn btn-warning"
                @click="actualizarCuenta(item, index)"
              >
                Actualizar
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--FIN MOSTRARCUENTASCOMPONENT.VUE -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      cuentas: [],
      cuenta: { summoner_name: "", region: "" },
      activarForm: false,
      invocadorNoEncontrado: false,
      invocadorSinPartidas: false,
      invocadorCorrecto: false,
      /*INICIO RETURN MOSTRARCUENTASCOMPONENT.VUE*/
      activarContenedor: false,
      activarOcultar: false,
      /*FIN MOSTRARCUENTASCOMPONENT.VUE*/
    };
  },
  /*FUNCION DE MOSTRARCUENTASCOMPONENT.VUE*/
  created() {
    axios.get("User/Account").then((res) => {
      this.cuentas = res.data;
    });
  },
  /*FIN DE FUNCION MOSTRARCUENTASCOMPONENT.VUE*/
  methods: {
    agregar() {
      if (
        this.cuenta.summoner_name.trim() === "" ||
        this.cuenta.region.trim() === ""
      ) {
        return alert("Completa todos los campos para poder vincular la cuenta");
      }
      const cuentaNueva = this.cuenta;
      this.cuenta = { summoner_name: "", region: "" };
      axios.post("User/Account/Add", cuentaNueva).then((res) => {
        const respuestaServer = res.data;
        if (res.data.id_flex === undefined && res.data.id_duo === undefined) {
          this.activarForm = false;
          this.invocadorNoEncontrado = true;
        } else if (
          res.data.id_flex === "unranked" &&
          res.data.id_duo === "unranked"
        ) {
          this.activarForm = false;
          this.invocadorSinPartidas = true;
          this.cuentas.push(respuestaServer);
        } else if (
          res.data.id_flex === "unranked" &&
          res.data.id_duo !== "unranked" &&
          res.data.id_duo !== undefined
        ) {
          this.activarForm = false;
          this.invocadorCorrecto = true;
          this.cuentas.push(respuestaServer);
        } else if (
          res.data.id_duo === "unranked" &&
          res.data.id_flex !== "unranked" &&
          res.data.id_flex !== undefined
        ) {
          this.activarForm = false;
          this.invocadorCorrecto = true;
          this.cuentas.push(respuestaServer);
        } else if (
          res.data.id_duo !== "unranked" &&
          res.data.id_duo !== undefined &&
          res.data.id_flex !== "unranked" &&
          res.data.id_flex !== undefined
        ) {
          this.activarForm = false;
          this.invocadorCorrecto = true;
          this.cuentas.push(respuestaServer);
        }
      });
    },
    mostrarForm() {
      this.invocadorNoEncontrado = false;
      this.invocadorSinPartidas = false;
      this.invocadorCorrecto = false;
      this.activarForm = true;
    },
    cancelarForm() {
      this.invocadorNoEncontrado = false;
      this.invocadorSinPartidas = false;
      this.activarForm = false;
    },
    cerrarMensaje() {
      this.invocadorCorrecto = false;
      this.invocadorSinPartidas = false;
      this.invocadorNoEncontrado = false;
    },
    /*INICIO METODOS MOSTRARCUENTASCOMPONENT.VUE*/
    mostrar() {
      this.$forceUpdate();
      this.activarContenedor = true;
      this.activarOcultar = true;
    },
    ocultar() {
      this.activarContenedor = false;
      this.activarOcultar = false;
    },
    /*FIN METODOS MOSTRARCUENTASCOMPONENT.VUE*/
    eliminarCuenta(item, index) {
      const confirmacion = confirm(`Eliminar Cuenta ${item.summoner_name}?`);
      if (confirmacion) {
        axios.delete(`User/DeleteAccount/${item.id}`).then(() => {
          this.cuentas.splice(index, 1);
        });
      }
    },
    actualizarCuenta(item, index) {
      axios.put(`User/EditAccount/${item.id}`).then((res) => {
        const indice = this.cuentas.findIndex(
          (item) => item.id === res.data.id
        );
        this.cuentas.splice(indice, 1, res.data);
      });
    },
  },
};
</script>
