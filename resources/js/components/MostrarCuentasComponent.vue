<template>
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
                >Puntos de liga:&nbsp;&nbsp;{{ item.league_points_flex }}</span
              >
              <br />
              <span>Partidas Ganadas:&nbsp;&nbsp;{{ item.wins_flex }}</span>
              <br />
              <span>Partidas Perdidas:&nbsp;&nbsp;{{ item.losses_flex }}</span>
              <br />
              <span
                >WinRatio:&nbsp;&nbsp;{{
                  Math.round(
                    (item.wins_flex * 100) / (item.wins_flex + item.losses_flex)
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
            <button class="btn btn-primary">Ir a Partidos</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      cuentas: [],
      activarContenedor: false,
      activarOcultar: false,
    };
  },
  created() {
    axios.get("User/Account").then((res) => {
      this.cuentas = res.data;
    });
  },
  methods: {
    mostrar() {
      this.$forceUpdate();
      this.activarContenedor = true;
      this.activarOcultar = true;
    },
    ocultar() {
      this.activarContenedor = false;
      this.activarOcultar = false;
    },
  },
};
</script>
