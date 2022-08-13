<template>
  <div class="pt-4 container-fluid">
    <div class="row py-0">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-3 col-md-6 col-12">
            <card
              :title="stats.karyawan.title"
              :value="stats.karyawan.value"
              :percentage="stats.karyawan.percentage"
              :iconClass="stats.karyawan.iconClass"
              :iconBackground="stats.karyawan.iconBackground"
              :detail="stats.karyawan.detail"
              directionReverse
            ></card>
          </div>
          <div class="col-lg-3 col-md-6 col-12">
            <card
              :title="stats.hadir.title"
              :value="stats.hadir.value"
              :percentage="stats.hadir.percentage"
              :iconClass="stats.hadir.iconClass"
              :iconBackground="stats.hadir.iconBackground"
              :detail="stats.hadir.detail"
              directionReverse
            ></card>
          </div>
          <div class="col-lg-3 col-md-6 col-12">
            <card
              :title="stats.recruitment.title"
              :value="stats.recruitment.value"
              :percentage="stats.recruitment.percentage"
              :iconClass="stats.recruitment.iconClass"
              :iconBackground="stats.recruitment.iconBackground"
              :percentageColor="stats.recruitment.percentageColor"
              :detail="stats.recruitment.detail"
              directionReverse
            ></card>
          </div>
          <div class="col-lg-3 col-md-6 col-12">
            <card
              :title="stats.project.title"
              :value="stats.project.value"
              :percentage="stats.project.percentage"
              :iconClass="stats.project.iconClass"
              :iconBackground="stats.project.iconBackground"
              :detail="stats.project.detail"
              directionReverse
            ></card>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <authors-table/>
      </div>
    </div>
  </div>
</template>

<script>
import Card from "@/examples/Cards/Card.vue";
import AuthorsTable from "./components/AuthorsTable.vue";
// import GradientLineChart from "@/examples/Charts/GradientLineChart.vue";
// import Carousel from "./components/Carousel.vue";
// import CategoriesCard from "./components/CategoriesCard.vue";


export default {
  name: "teams",
  data() {
    return {
      stats: {
        karyawan: {
          title: "Total Karyawan",
          value: "17",
          iconClass: "ni ni-money-coins",
          iconBackground: "bg-gradient-primary",
        },
        hadir: {
          title: "Hadir Hari Ini",
          value: "16",
          iconClass: "ni ni-world",
          iconBackground: "bg-gradient-danger",
        },
        recruitment: {
          title: "Total Recruitment",
          value: "21",
          iconClass: "ni ni-paper-diploma",
          percentageColor: "text-danger",
          iconBackground: "bg-gradient-success",
        },
        project: {
          title: "Total Project",
          value: "5",
          iconClass: "ni ni-cart",
          iconBackground: "bg-gradient-warning",
        }
      }
    };
  },
  components: {
    Card,
    AuthorsTable
  },
};
</script>
