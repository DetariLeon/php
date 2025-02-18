<script setup>
import axios from 'axios'
import Diak from './classes/Diak.js'
import { ref } from 'vue';

const SOR = 5
const OSZLOP = 5
const ulesrend = ref(new Array(SOR).fill(null).map(() => new Array(OSZLOP).fill(null)))
// console.log(ulesrend.value)

const setUlesrend = async () => {
  for (let i = 0; i < ulesrend.value.length; i++) {
    for (let j = 0; j < ulesrend.value[i].length; j++) {
      await axios.get("http://localhost/ulesrend/api/get_tanulo.php?sor=" + i + "&oszlop=" + j)
        .then(response => {
          if (response.data.id != undefined) {
            ulesrend.value[i][j] = new Diak(response.data.id, response.data.nev, i, j);
          } else {
            ulesrend.value[i][j] = new Diak(-1, "", i, j);

          }
        })
        .catch(error => {
          console.error("Display classroom error: " + error)
        })
    }
  }
}
setUlesrend()

const del = async (did) => {
  await axios.delete("http://localhost/ulesrend/api/index.php", {
    params: {
      id: parseInt(did)
    }
  })
    .then(response => {
      setUlesrend()
    })
    .catch(error => {
      console.error("Delete error: " + error)
    })
}

const set = async (did) => {
  var ujNev = prompt("Diák átnevezése:")

  await axios.put("http://localhost/ulesrend/api/index.php", {
    id: parseInt(did),
    nev: ujNev
  })
    .then(response => {
      setUlesrend()
    })
    .catch(error => {
      console.error("Set new name error: " + error)
    })
}

const add = async (i, j) => {
  var ujNev = prompt("Új diák neve:")

  await axios.post("http://localhost/ulesrend/api/index.php", {
    nev: ujNev,
    sor: i,
    oszlop: j
  })
    .then(response => {
      setUlesrend()
    })
    .catch(error => {
      console.error("Set new name error: " + error)
    })
}
</script>

<template>
  <main>
    <h1>Ülésrend</h1>
    <section>
      <div class="rows df" v-for="(sor, i) in ulesrend">
        <div class="cols" v-for="(oszlop, j) in sor">
          <div>
            <p @click="set(oszlop.getId())">{{ oszlop.getNev() }}</p>
            <p v-if="oszlop.getId() == -1" @click="add(i, j)"><i class="bi bi-plus-circle-fill"></i></p>
            <p><i class="bi bi-trash-fill" @click="del(oszlop.getId())"></i></p>
          </div>
        </div>
      </div>
    </section>
  </main>
</template>

<style scoped>
@import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css");
  h1{
    text-align: center;
  }
  .df{
    display: flex;
    justify-content: space-evenly;
    align-items: center;
  }
  .df .cols{
    background-color: rgb(140, 0, 255);
    width: 200px;
    padding-top: 20px;
    font-weight: 800;
    cursor: pointer;
    text-align: center;
  }
  .df div:hover{
    background-color: aqua;
    color: #000;
  }
  .cols{
    margin: 20px;
    padding: 20px;
  }
</style>