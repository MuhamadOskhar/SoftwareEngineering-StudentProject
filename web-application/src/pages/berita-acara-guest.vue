<template>
  <VRow style="margin-block: 70px;">
    <VCol cols="11" md="9" lg="9" class="mx-auto mt-5">
      <VCard>
        <VCardItem>
          <img class="mt-5" style="width: 100%; object-fit: cover" :src="imagePath + dataBerita.gambar" alt="" />
          <h2 class="text-h2 text-center">{{ dataBerita.judul }}</h2>
          <p class="text-center text-secondary">{{ dataBerita.tanggal }}</p>
          <p style="white-space: pre-line;">{{ dataBerita.deskripsi }}</p>
          <p>Penulis Berita: <span class="text-primary">{{ dataBerita.nama_lengkap }}</span></p>
          <p>
            <VIcon>bx-calendar</VIcon>
            Acara dilaksanakan pada {{ dataBerita.tanggal_pelaksanaan }}
          </p>
          <RouterLink to="./">
            <div>
              <v-icon>bx-chevron-left</v-icon>
              Halaman Depan
            </div>
          </RouterLink>
        </VCardItem>
      </VCard>
    </VCol>
  </VRow>
</template>
<script>
import axios from 'axios';
import config from '@/@core/config.vue';

export default {
  data() {
    return {
      dataBerita: {},
      imagePath: config.imagePath,
    }
  },
  methods: {
    async fetchData() {

      // Membuat objek URLSearchParams dari query string
      const queryString = window.location.search;
      const queryParams = new URLSearchParams(queryString);

      // Mendapatkan nilai dari parameter tertentu
      if (queryParams.get("id_berita")) {
        const idBerita = atob(queryParams.get("id_berita"));
        const response = await axios.get(`${config.urlServer}/api/berita?id_berita=${idBerita}`);
        this.dataBerita = response.data;
      } else {
        window.location.href = "./";
      }
    }
  },
  mounted() {
    this.fetchData();
  }
}
</script>