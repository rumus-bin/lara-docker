<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <pie-chart :chart-data="data" :height="100" :options="{responsive: true, maintainAspectRation: true}"></pie-chart>
            </div>
        </div>
    </div>
</template>

<script>
    import PieChart from "../chartsjs/PieChart";
export default {
    components: {
        PieChart,
    },
    data: function() {
      return {
          data: []
      };
    },
    methods: {
        update: function () {
            axios.get('/charts/pie-chart').then(response => {
                this.data = response.data;
            })
        }
    },
    mounted() {
        this.update();
    }
}
</script>
